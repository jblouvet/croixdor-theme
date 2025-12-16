<?php

$config = json_decode(file_get_contents(ABSPATH . 'site.config.json'), true);
$theme = basename(get_template_directory());
$vite_url  = 'http://localhost:3000/';
$manifest  = get_theme_file_path('assets/.vite/manifest.json');
$environment = $config['environment'];

function is_vite_running($vite_url)
{
	$response = wp_remote_get($vite_url, ['timeout' => .2, 'sslverify' => false]);
	return !is_wp_error($response) && wp_remote_retrieve_response_code($response) < 500;
}

function get_theme_image($file)
{
	$manifest  = get_theme_file_path('assets/.vite/manifest.json');
	if (!file_exists($manifest) || !is_file($manifest)) {
		return get_template_directory_uri() . '/src/img/' . $file;
	} else {
		$manifest_data = json_decode(file_get_contents($manifest), true);
		$file = $manifest_data['src/img/' . $file]['file'];
		return get_template_directory_uri() . '/assets/' . $file;
	}
}

add_action('wp_enqueue_scripts', function () use ($vite_url, $manifest, $environment) {

	$is_dev = $environment === 'local' && is_vite_running($vite_url);

	if ($is_dev) {
		wp_enqueue_script('vite', $vite_url . '@vite/client', [], null);
		wp_enqueue_script('theme', $vite_url . 'src/js/index.js', ['jquery'], null);
	} elseif (file_exists($manifest)) {
		$manifest_data = json_decode(file_get_contents($manifest), true);
		$js  = $manifest_data['src/js/index.js']['file'] ?? null;
		$css = $manifest_data['src/js/index.js']['css'][0] ?? null;
		if ($js) {
			wp_enqueue_script('theme', get_theme_file_uri('assets/' . $js), ['jquery'], null);
		}
		if ($css) {
			wp_enqueue_style('theme', get_theme_file_uri('assets/' . $css), [], null);
		}
	}
}, 10);

add_filter('script_loader_tag', function ($tag, $handle, $src) {
	if (in_array($handle, ['vite', 'theme'])) {
		return '<script type="module" src="' . esc_url($src) . '" defer></script>';
	}
	return $tag;
}, 99, 3);

add_action('wp_enqueue_scripts', function () {
	wp_deregister_style('dashicons');

	// Keep jQuery for WooCommerce
	if (class_exists('WooCommerce')) {
		wp_enqueue_script('jquery');
	}
});

// Remove JQuery Migrate
function jbl_remove_jquery_migrate($scripts)
{
	if (! is_admin() && isset($scripts->registered['jquery'])) {
		$script = $scripts->registered['jquery'];
		if ($script->deps) {
			$script->deps = array_diff($script->deps, array('jquery-migrate'));
		}
	}
}
add_action('wp_default_scripts', 'jbl_remove_jquery_migrate');

// Remove Gutenberg Block Library CSS from loading on the frontend
function jbl_remove_wp_block_library_css()
{
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style('global-styles');
	remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}
add_action('wp_enqueue_scripts', 'jbl_remove_wp_block_library_css', 100);

add_action('wp_footer', function () {
	wp_dequeue_style('core-block-supports');
});
