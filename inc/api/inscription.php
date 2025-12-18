<?php

// Les constantes sont définies dans wp-config.php
// define('SUPABASE_API_URL', '');
// define('SUPABASE_ANON_KEY', '');
// define('SUPABASE_X_API_KEY', '');

if (!defined('SUPABASE_API_URL')) {
	define('SUPABASE_API_URL', 'https://lyprpoferzklgjqupxux.supabase.co/functions/v1/create-trainee');
}

/**
 * Handle inscription form submission
 */
function handle_inscription_submission()
{
	// Verify nonce
	if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'inscription_nonce')) {
		wp_send_json_error(['message' => 'Sécurité invalide. Veuillez rafraîchir la page.'], 403);
	}

	$anon_key = defined('SUPABASE_ANON_KEY') ? SUPABASE_ANON_KEY : '';
	$api_key = defined('SUPABASE_X_API_KEY') ? SUPABASE_X_API_KEY : '';

	if (empty($anon_key) || empty($api_key)) {
		wp_send_json_error(['message' => 'Configuration serveur manquante (Clés API).'], 500);
	}

	// Prepare body
	$fields = [
		'lastname',
		'firstname',

		'mail',
		'phone',
		'company_name',
		'company_street',
		'company_postalcode',
		'company_city',
		'company_siret',
		'company_representative_lastname',
		'company_representative_firstname'
	];

	$body = [];
	foreach ($fields as $field) {
		$body[$field] = isset($_POST[$field]) ? sanitize_text_field($_POST[$field]) : '';
	}

	// Make request
	$response = wp_remote_post(SUPABASE_API_URL, [
		'headers' => [
			'Content-Type' => 'application/json',
			'Authorization' => 'Bearer ' . $anon_key,
			'x-api-key' => $api_key
		],
		'body' => json_encode($body),
		'timeout' => 45
	]);

	if (is_wp_error($response)) {
		wp_send_json_error(['message' => $response->get_error_message()], 500);
	}

	$response_code = wp_remote_retrieve_response_code($response);
	$response_body = wp_remote_retrieve_body($response);

	if ($response_code >= 200 && $response_code < 300) {
		wp_send_json_success(['message' => 'Inscription réussie', 'data' => json_decode($response_body)]);
	} else {
		// Try to get error from Supabase
		$params = json_decode($response_body, true);
		$msg = $params['message'] ?? 'Une erreur est survenue.';
		wp_send_json_error(['message' => $msg, 'debug' => $response_body], $response_code);
	}
}

add_action('wp_ajax_nopriv_submit_inscription', 'handle_inscription_submission');
add_action('wp_ajax_submit_inscription', 'handle_inscription_submission');


/**
 * Localize script to pass Ajax URL and Nonce
 */
function inscription_enqueue_scripts()
{
	?>
	<script>
		window.croixdorParams = {
			ajaxUrl: "<?= admin_url('admin-ajax.php') ?>",
			nonce: "<?= wp_create_nonce('inscription_nonce') ?>"
		};
	</script>
	<?php
}
add_action('wp_head', 'inscription_enqueue_scripts');
