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

    // Add WooCommerce support
    function brightred_add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    add_action( 'after_setup_theme', 'brightred_add_woocommerce_support' );

    // Remove "has been added to your basket" message but keep other notices
    add_filter( 'wc_add_to_cart_message_html', '__return_empty_string' );
	add_filter( 'woocommerce_add_to_cart_message_html', '__return_empty_string' );


    // Hide empty basket icon (#basket-icon) and output toggle JS in footer
    function brightred_toggle_basket_icon() {
        if ( ! WC()->cart ) {
            return;
        }

        $cart_count = WC()->cart->get_cart_contents_count();

        // Inline CSS to hide basket icon if cart is empty
        if ( $cart_count === 0 ) {
            echo '<style>#basket-icon { display: none !important; }</style>';
        }
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var basketIcon = document.getElementById('basket-icon');
            if (!basketIcon) return;

            function updateBasketVisibility() {
                var emptyMessage = document.querySelector('.woocommerce-mini-cart__empty-message');
                if (emptyMessage) {
                    basketIcon.style.display = 'none';
                } else {
                    basketIcon.style.display = 'block';
                }
            }

            updateBasketVisibility();

            if (typeof jQuery !== 'undefined') {
                jQuery(document.body).on('updated_wc_div', updateBasketVisibility);
            }
        });
        </script>
        <?php
    }
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
