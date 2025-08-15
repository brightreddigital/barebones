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


