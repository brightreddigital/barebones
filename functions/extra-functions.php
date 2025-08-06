<?php

/*---
Global
---*/

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

/*---
Woo
---*/

if ( class_exists( 'WooCommerce' ) ) {

	function brightred_toggle_basket_icon() {

	    if ( ! WC()->cart ) {
	        return;
	    } ?>
	    <!-- Hide basket icon by default -->
	    <style>
	        #basket-icon {
	            display: none !important;
	        }
	    </style>

	    <!-- Toggle visibility based on cart content -->
	    <script>
	    document.addEventListener('DOMContentLoaded', function () {
	        var basketIcon = document.getElementById('basket-icon');
	        if (!basketIcon) return;

	        function updateBasketVisibility() {
	            var emptyMessage = document.querySelector('.woocommerce-mini-cart__empty-message');
	            if (!emptyMessage) {
	                basketIcon.style.display = 'block';
	            } else {
	                basketIcon.style.display = 'none';
	            }
	        }

	        updateBasketVisibility();

	        if (typeof jQuery !== 'undefined') {
	            jQuery(document.body).on('updated_wc_div updated_cart_totals added_to_cart removed_from_cart', updateBasketVisibility);
	        }
	    });
    </script>
    
    <?php }
	
	add_action( 'wp_footer', 'brightred_toggle_basket_icon' );

}

/*---
LearnDash
---*/

// Add LearnDash support if plugin is active
function brightred_add_learndash_support() {
    if ( function_exists( 'learndash_init' ) ) {
        add_theme_support( 'learndash' );
    }
}
add_action( 'after_setup_theme', 'brightred_add_learndash_support' );
