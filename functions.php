<?php

function brightred_setup() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
}
add_action('after_setup_theme', 'brightred_setup');

function brightred_enqueue_styles() {
	wp_enqueue_style('brightred-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'brightred_enqueue_styles');
