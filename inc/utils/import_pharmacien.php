<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Add submenu page to Pharmacien CPT
 */
add_action('admin_menu', function () {
	add_submenu_page(
		'edit.php?post_type=pharmacien',
		'Importer Pharmaciens',
		'Importer CSV',
		'manage_options',
		'import-pharmaciens',
		'render_pharmacien_import_page'
	);
});

/**
 * Render the import page
 */
function render_pharmacien_import_page()
{
	// Check for form submission
	$message = '';
	if (isset($_POST['submit_csv']) && isset($_FILES['pharmacien_csv'])) {
		$message = process_pharmacien_import();
	}
	?>
	<div class="wrap">
		<h1>Importer des Pharmaciens via CSV</h1>

		<?php if ($message): ?>
			<?= $message ?>
		<?php endif; ?>

		<div class="card" style="max-width: 600px; margin-top: 20px; padding: 20px;">
			<p>Le fichier CSV doit être encodé en <strong>UTF-8</strong>.</p>
			<p>Les colonnes attendues sont (l'ordre n'importe pas si les en-têtes sont présents) :</p>
			<ul style="list-style: disc; padding-left: 20px; margin-bottom: 20px;">
				<li><code>nom</code></li>
				<li><code>prenom</code></li>
				<li><code>points</code> (nombre)</li>
				<li><code>ordre</code> (nombre - détermine l'ordre d'affichage)</li>
				<li><code>medaille</code> (or, argent, bronze)</li>
			</ul>

			<form method="post" enctype="multipart/form-data">
				<?php wp_nonce_field('import_pharmacien_csv', 'import_pharmacien_nonce'); ?>
				<p>
					<label for="pharmacien_csv">Choisir un fichier CSV :</label><br>
					<input type="file" name="pharmacien_csv" id="pharmacien_csv" required accept=".csv">
				</p>
				<p>
					<input type="submit" name="submit_csv" class="button button-primary" value="Importer les données">
				</p>
			</form>
		</div>
	</div>
	<?php
}

/**
 * Process the CSV import
 */
function process_pharmacien_import()
{
	if (!wp_verify_nonce($_POST['import_pharmacien_nonce'], 'import_pharmacien_csv')) {
		return '<div class="notice notice-error"><p>Erreur de sécurité nonce.</p></div>';
	}

	if (!function_exists('update_field')) {
		return '<div class="notice notice-error"><p>ACF n\'est pas activé via PHP (fonction update_field manquante).</p></div>';
	}

	$file = $_FILES['pharmacien_csv']['tmp_name'];

	// Check file extension/type if strictness is needed, but assuming CSV content
	if (($handle = fopen($file, "r")) === FALSE) {
		return '<div class="notice notice-error"><p>Impossible d\'ouvrir le fichier.</p></div>';
	}

	// Detect separator
	$delimiter = ',';
	$line = fgets($handle);
	if (substr_count($line, ';') > substr_count($line, ',')) {
		$delimiter = ';';
	}
	rewind($handle);

	$row_count = 0;
	$success_count = 0;
	$headers = [];

	while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) { // Use detected delimiter
		$row_count++;

		// Detect Map Headers
		if ($row_count === 1) {
			// Remove BOM from first key if present
			$data[0] = remove_utf8_bom($data[0]);
			$headers = array_map('trim', $data);
			$headers = array_map('strtolower', $headers); // Normalize to lowercase
			continue;
		}

		// Map data to headers
		if (count($data) !== count($headers)) {
			// Handle mismatch or empty lines
			continue;
		}
		$row_data = array_combine($headers, $data);

		// Extract expected fields
		// Remove potential BOM or whitespace from keys if array_combine worked but keys are slightly off
		// But headers are already trimmed.
		// Values should use utf8_encode if not utf8? The user said file is utf8.

		$nom = isset($row_data['nom']) ? trim($row_data['nom']) : '';
		$prenom = isset($row_data['prenom']) ? trim($row_data['prenom']) : '';
		$points = isset($row_data['points']) ? trim($row_data['points']) : '';
		$ordre = isset($row_data['ordre']) ? trim($row_data['ordre']) : '';
		$medaille = isset($row_data['medaille']) ? trim($row_data['medaille']) : '';

		// Generate Post Data
		$title = trim($nom . ' ' . $prenom);
		// Basic slug generation
		$slug_raw = $nom . '-' . $prenom;
		$slug = sanitize_title($slug_raw);

		if (empty($title))
			continue;

		// Check if exists
		// Using get_posts to match exact slug to be safe across post types logic
		$existing = get_posts([
			'name' => $slug,
			'post_type' => 'pharmacien',
			'post_status' => 'any',
			'numberposts' => 1
		]);

		$post_id = 0;

		$post_args = [
			'post_title' => $title,
			'post_name' => $slug,
			'post_type' => 'pharmacien',
			'post_status' => 'publish',
			'menu_order' => intval($ordre),
		];

		if ($existing) {
			$post_args['ID'] = $existing[0]->ID;
			$post_id = wp_update_post($post_args);
		} else {
			$post_id = wp_insert_post($post_args);
		}

		// Update ACF Fields
		if ($post_id && !is_wp_error($post_id)) {
			update_field('nom', $nom, $post_id);
			update_field('prenom', $prenom, $post_id);
			update_field('points', $points, $post_id); // ACF should handle type conversion if field is number
			update_field('ordre', $ordre, $post_id);
			update_field('medaille', $medaille, $post_id); // Radio button expects value matching choice
			$success_count++;
		}
	}

	fclose($handle);

	return '<div class="notice notice-success"><p>Importation terminée. ' . $success_count . ' pharmaciens importés/mis à jour (Séparateur détecté : "' . $delimiter . '").</p></div>';
}

function remove_utf8_bom($text)
{
	$bom = pack('H*', 'EFBBBF');
	$text = preg_replace("/^$bom/", '', $text);
	return $text;
}

/**
 * Force order for Pharmacien CPT
 */
add_action('pre_get_posts', function ($query) {
	// Only target the main query on frontend or the admin list table
	if (is_admin() || ($query->is_main_query() && !is_admin())) {
		if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] === 'pharmacien') {
			// Check if user has not explicitly requested another order
			if (empty($query->query_vars['orderby'])) {
				$query->set('orderby', 'menu_order');
				$query->set('order', 'ASC');
			}
		}
	}
});

/**
 * Add customs columns to Pharmacien list
 */
add_filter('manage_pharmacien_posts_columns', function ($columns) {
	$new_columns = [];
	foreach ($columns as $key => $value) {
		$new_columns[$key] = $value;
		if ($key === 'title') {
			$new_columns['points'] = 'Points';
			$new_columns['ordre'] = 'Ordre';
		}
	}
	return $new_columns;
});

/**
 * Populate custom columns for Pharmacien
 */
add_action('manage_pharmacien_posts_custom_column', function ($column, $post_id) {
	if ($column === 'points') {
		echo get_field('points', $post_id);
	}
	if ($column === 'ordre') {
		// Displaying menu_order as it's the real order used
		$post = get_post($post_id);
		echo $post->menu_order;
	}
}, 10, 2);

/**
 * Make columns sortable
 */
add_filter('manage_edit-pharmacien_sortable_columns', function ($columns) {
	$columns['ordre'] = 'menu_order';
	$columns['points'] = 'points';
	return $columns;
});

/**
 * Custom sort logic for 'points' (numeric)
 */
add_action('pre_get_posts', function ($query) {
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}

	if ($query->get('post_type') === 'pharmacien') {
		$orderby = $query->get('orderby');

		if ($orderby === 'points') {
			$query->set('meta_key', 'points');
			$query->set('orderby', 'meta_value_num');
		}
	}
});
