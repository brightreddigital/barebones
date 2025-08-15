<?php

function brightred_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

	// Add custom logo support
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
}
add_action('after_setup_theme', 'brightred_setup');

function brightred_enqueue_styles() {
	wp_enqueue_style('brightred-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'brightred_enqueue_styles');

$roots_includes = array(
	'/functions/basic-info.php',
	'/functions/extra-functions.php',
);


foreach($roots_includes as $file){
	
	if(!$filepath = locate_template($file)) {
		trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
	}

require_once $filepath;
}

unset($file, $filepath); 


add_action('check_admin_referer', 'br_logout_without_confirm', 10, 2);

function br_logout_without_confirm($action, $result) {

    if ($action !== 'log-out' || isset($_GET['_wpnonce'])) {
        return;
    }

    $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';

    if (empty($redirect_to)) {
        $referer = wp_get_referer();
        if ($referer && wp_validate_redirect($referer, false)) {
            $redirect_to = $referer;
        }
    }

    if (empty($redirect_to)) {
        $default_fallback = get_theme_mod('logout_redirect', home_url('/'));
        $redirect_to = $default_fallback;
    }

    $logout_url = wp_logout_url($redirect_to);
    $logout_url = str_replace('&amp;', '&', $logout_url);

    $logout_url = apply_filters('br_logout_url', $logout_url, $redirect_to);

    wp_redirect($logout_url);
    exit;
}

add_action('customize_register', function($wp_customize) {

    $wp_customize->add_section('redirect_settings', [
        'title'    => __('Redirect Settings', 'br'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('logout_redirect', [
        'default'           => home_url('/'),
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control('logout_redirect', [
        'label'   => __('Logout Redirect URL', 'br'),
        'section' => 'redirect_settings',
        'type'    => 'url',
        'description' => __('Where users should be sent after logging out (if no redirect_to parameter is provided).', 'br'),
    ]);
});
