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
    add_action( 'wp_head', 'brightred_toggle_basket_icon' );
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


/* Populate Role choices for the Role-based repeater */
add_filter('acf/load_field/key=field_br_role_redirects_role', function($field) {
    if (function_exists('wp_roles')) {
        $roles = wp_roles()->roles;
        $choices = array();
        foreach ($roles as $role_key => $role_data) {
            $choices[$role_key] = isset($role_data['name']) ? $role_data['name'] : $role_key;
        }
        $field['choices'] = $choices;
    }
    return $field;
});

/*--------------------------------------------------------------
# Secure Instant Logout (nonce-protected custom URL)
--------------------------------------------------------------*/
/**
 * Resolve logout target:
 * Order: ?redirect_to → referrer → ACF (logout_redirect) → home
 */
if (!function_exists('br_logout_target')) {
    function br_logout_target() {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';

        if (!$redirect_to) {
            $ref = wp_get_referer();
            if ($ref && wp_validate_redirect($ref, false)) {
                $redirect_to = $ref;
            }
        }

        if (!$redirect_to && function_exists('get_field')) {
            $acf_redirect = get_field('logout_redirect', 'option');
            if ($acf_redirect) {
                $redirect_to = $acf_redirect;
            }
        }

        if (!$redirect_to) {
            $redirect_to = home_url('/');
        }

        return wp_validate_redirect($redirect_to, home_url('/'));
    }
}

/* Build the logout URL with nonce: ?br_logout=1&_wpnonce=... */
if (!function_exists('br_get_logout_url')) {
    function br_get_logout_url($redirect_to = '') {
        if (!$redirect_to) {
            $redirect_to = br_logout_target();
        }

        $url = add_query_arg(array(
            'br_logout'   => '1',
            'redirect_to' => rawurlencode($redirect_to),
        ), home_url('/'));

        $url = wp_nonce_url($url, 'br_logout');
        return apply_filters('br_logout_url', $url, $redirect_to);
    }
}

/* Catch custom logout requests early */
add_action('init', function() {
    if (!isset($_GET['br_logout'])) {
        return;
    }

    // Verify nonce
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'br_logout')) {
        wp_safe_redirect(home_url('/'));
        exit;
    }

    // Compute target
    $redirect = isset($_GET['redirect_to']) ? rawurldecode($_GET['redirect_to']) : '';
    $redirect = $redirect ? wp_validate_redirect($redirect, home_url('/')) : br_logout_target();

    if (!is_user_logged_in()) {
        wp_safe_redirect($redirect);
        exit;
    }

    wp_logout();
    wp_safe_redirect($redirect);
    exit;
});

/* Convenience: template tag + shortcode for logout link */
if (!function_exists('br_logout_link')) {
    function br_logout_link($text = 'Log out', $atts = array()) {
        $defaults = array(
            'redirect_to' => '',
            'class'       => 'br-logout-link',
            'id'          => '',
        );
        $atts = wp_parse_args($atts, $defaults);

        $url = br_get_logout_url($atts['redirect_to']);
        $id  = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';
        $class = $atts['class'] ? ' class="' . esc_attr($atts['class']) . '"' : '';

        echo '<a href="' . esc_url($url) . '"' . $id . $class . '>' . esc_html($text) . '</a>';
    }
}
add_shortcode('br_logout_link', function($atts = array(), $content = null) {
    $atts = shortcode_atts(array(
        'text'        => $content ?: 'Log out',
        'redirect_to' => '',
        'class'       => 'br-logout-link',
        'id'          => '',
    ), $atts, 'br_logout_link');

    $url = br_get_logout_url($atts['redirect_to']);
    $id  = $atts['id'] ? ' id="' . esc_attr($atts['id']) . '"' : '';
    $class = $atts['class'] ? ' class="' . esc_attr($atts['class']) . '"' : '';

    return '<a href="' . esc_url($url) . '"' . $id . $class . '>' . esc_html($atts['text']) . '</a>';
});

/*--------------------------------------------------------------
# Login / Registration Redirects (Core, WooCommerce, LearnDash)
--------------------------------------------------------------*/
if (!function_exists('br_validate_url')) {
    function br_validate_url($url) {
        if (!$url) return false;
        $v = wp_validate_redirect($url, false);
        return $v ? $v : false;
    }
}

/**
 * Resolve the best login redirect using ACF rules.
 * Order: requested (?redirect_to) → role rules → cap rules → ACF login_redirect → home
 */
if (!function_exists('br_resolve_login_redirect')) {
    function br_resolve_login_redirect($requested_redirect_to, $user) {
    // 1) Honor explicit redirect_to if safe
    if (!empty($requested_redirect_to)) {
        if ($v = br_validate_url($requested_redirect_to)) {
            return $v;
        }
    }

    // *** NEW: Admins always go to /wp-admin ***
    if ($user instanceof WP_User && in_array('administrator', (array) $user->roles, true)) {
        return admin_url();
    }

    if ($user instanceof WP_User) {
        // 2) role-based rules (from ACF)
        if (function_exists('get_field')) {
            $role_rules = get_field('role_redirects', 'option');
            if (is_array($role_rules) && !empty($role_rules)) {
                $user_roles = (array) $user->roles;
                foreach ($role_rules as $rule) {
                    $role = isset($rule['role']) ? $rule['role'] : '';
                    $url  = isset($rule['url'])  ? $rule['url']  : '';
                    if ($role && in_array($role, $user_roles, true)) {
                        if ($v = br_validate_url($url)) {
                            return $v;
                        }
                    }
                }
            }

            // 3) capability-based rules
            $cap_rules = get_field('cap_redirects', 'option');
            if (is_array($cap_rules) && !empty($cap_rules)) {
                foreach ($cap_rules as $rule) {
                    $cap = isset($rule['cap']) ? $rule['cap'] : '';
                    $url = isset($rule['url']) ? $rule['url'] : '';
                    if ($cap && $user->has_cap($cap)) {
                        if ($v = br_validate_url($url)) {
                            return $v;
                        }
                    }
                }
            }

            // 4) global fallback
            $acf_login = get_field('login_redirect', 'option');
            if ($v = br_validate_url($acf_login)) {
                return $v;
            }
        }
    }

    // 5) home
    return home_url('/');
}

}

/* Core WP login (covers most LearnDash logins) */
add_filter('login_redirect', function($redirect_to, $requested_redirect_to, $user) {
    return br_resolve_login_redirect($requested_redirect_to, $user);
}, 10, 3);

/* WooCommerce login (My Account form, Checkout login) */
add_filter('woocommerce_login_redirect', function($redirect, $user) {
    $requested = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
    return br_resolve_login_redirect($requested, $user);
}, 10, 2);

/* Core WP registration (wp-login.php?action=register) */
add_filter('registration_redirect', function($redirect) {
    // Prefer ?redirect_to if provided and safe
    if (!empty($_REQUEST['redirect_to'])) {
        if ($v = br_validate_url($_REQUEST['redirect_to'])) {
            return $v;
        }
    }
    // ACF fallback
    $acf_target = function_exists('get_field') ? get_field('register_redirect', 'option') : '';
    if ($v = br_validate_url($acf_target)) {
        return $v;
    }
    return home_url('/');
}, 10, 1);

/* WooCommerce registration (My Account registration only).
   Does NOT change checkout-created accounts (keeps Order Received page). */
add_filter('woocommerce_registration_redirect', function($redirect, $user) {
    $ref = wp_get_referer();
    if ($ref && strpos($ref, '/checkout') !== false) {
        return $redirect; // keep default Thank You flow
    }

    $requested = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
    if (!empty($requested) && ($v = br_validate_url($requested))) {
        return $v;
    }

    $acf_register = function_exists('get_field') ? get_field('register_redirect', 'option') : '';
    if ($v = br_validate_url($acf_register)) {
        return $v;
    }

    return home_url('/');
}, 10, 2);