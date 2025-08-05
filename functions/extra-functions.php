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

// Add WooCommerce support if plugin is active
function brightred_add_woocommerce_support() {
    if ( class_exists( 'WooCommerce' ) ) {
        add_theme_support( 'woocommerce' );
    }
}
add_action( 'after_setup_theme', 'brightred_add_woocommerce_support' );


// Hide empty basket icon (#basket-icon)
add_action('wp_head', function() {
    if ( class_exists('WooCommerce') && WC()->cart ) {

        if ( WC()->cart->get_cart_contents_count() === 0 ) {
            echo '<style>#basket-icon { display: none !important; }</style>';
        }

        // Output JS for live toggle on cart update
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
});


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
