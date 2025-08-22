<?php

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
