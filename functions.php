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

// Basic Info (requires ACF)

$roots_includes = array(
	'/functions/basic-info.php',
);

foreach($roots_includes as $file){
	
	if(!$filepath = locate_template($file)) {
		trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
	}

require_once $filepath;
}

unset($file, $filepath); 

// Add WooCommerce support if plugin is active
function brightred_add_woocommerce_support() {
    if ( class_exists( 'WooCommerce' ) ) {
        add_theme_support( 'woocommerce' );
    }
}
add_action( 'after_setup_theme', 'brightred_add_woocommerce_support' );

// Add LearnDash support if plugin is active
function brightred_add_learndash_support() {
    if ( function_exists( 'learndash_init' ) ) {
        add_theme_support( 'learndash' );
    }
}
add_action( 'after_setup_theme', 'brightred_add_learndash_support' );


// Enable SVG uploads
function brightred_allow_svg_uploads( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'brightred_allow_svg_uploads' );

// Link to developer resources in admin area

function admin_footer_text() {
    return '<a href="https://drive.google.com/drive/folders/1YFO52o1Rych3eJ9mKBTyDQKpo6smOD74?usp=sharing" target="_blank">Developer Reference</a>';
}
add_filter( 'admin_footer_text', 'admin_footer_text' );