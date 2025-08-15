<?php 

add_action('acf/init', 'checkACFtheme');
function checkACFtheme() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'  => 'Basic Info',
            'menu_title'  => 'Basic Info',
            'menu_slug'   => 'basic-info',
            'capability'  => 'edit_posts',
            'redirect'    => false,
        ));
    }
}

/*--------------------------------------------------------------
# ACF: Local Field Groups (Details, Socials, Redirects)
--------------------------------------------------------------*/
function add_local_field_groups() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    /* -------- Details (unchanged) -------- */
    acf_add_local_field_group(array(
        'key' => 'group_62e7b41297b52',
        'title' => 'Details',
        'fields' => array(
            array(
                'key' => 'field_62e3b113a5bab',
                'label' => 'Company Name',
                'name' => 'company_name',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_62e7b44addb54',
                'label' => 'Address',
                'name' => 'address',
                'aria-label' => '',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_62e7b45f5e567',
                'label' => 'Phone',
                'name' => 'phone',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_62e7b47837256',
                'label' => 'Email Address',
                'name' => 'email_address',
                'aria-label' => '',
                'type' => 'email',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'basic-info',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    /* -------- Socials (unchanged) -------- */
    acf_add_local_field_group(array(
        'key' => 'group_66b4a5d69fdae',
        'title' => 'Socials',
        'fields' => array(
            array(
                'key' => 'field_66b4a5d6cda45',
                'label' => 'Platforms',
                'name' => 'platforms',
                'aria-label' => '',
                'type' => 'checkbox',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'choices' => array(
                    'Facebook' => 'Facebook',
                    'LinkedIn' => 'LinkedIn',
                    'X (Twitter)' => 'X (Twitter)',
                    'Instagram' => 'Instagram',
                    'YouTube' => 'YouTube',
                    'WhatsApp' => 'WhatsApp',
                    'Pinterest' => 'Pinterest',
                    'TikTok' => 'TikTok',
                    'Discord' => 'Discord',
                    'Threads' => 'Threads',
                    'Snapchat' => 'Snapchat',
                    'Tumblr' => 'Tumblr',
                ),
                'default_value' => array(),
                'return_format' => 'value',
                'allow_custom' => 0,
                'layout' => 'horizontal',
                'toggle' => 0,
                'save_custom' => 0,
                'custom_choice_button_text' => 'Add new choice',
            ),
            array(
                'key' => 'field_66b4a668cda46',
                'label' => 'Facebook Link',
                'name' => 'facebook_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Facebook',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a6cecda48',
                'label' => 'LinkedIn Link',
                'name' => 'linkedin_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'LinkedIn',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a6f6cda49',
                'label' => 'X (Twitter) Link',
                'name' => 'x_twitter_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'X (Twitter)',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a715cda4a',
                'label' => 'Instagram Link',
                'name' => 'instagram_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Instagram',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a7efcda4b',
                'label' => 'YouTube Link',
                'name' => 'youtube_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'YouTube',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a806cda4c',
                'label' => 'WhatsApp Link',
                'name' => 'whatsapp_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'WhatsApp',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a857cda4d',
                'label' => 'Pinterest Link',
                'name' => 'pinterest_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Pinterest',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a9a2cda4e',
                'label' => 'TikTok Link',
                'name' => 'tiktok_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'TikTok',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a9c5cda4f',
                'label' => 'Discord Link',
                'name' => 'discord_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Discord',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a9dbcda50',
                'label' => 'Threads Link',
                'name' => 'threads_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Threads',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4a9ffcda51',
                'label' => 'Snapchat Link',
                'name' => 'snapchat_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Snapchat',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
            array(
                'key' => 'field_66b4aa51cda53',
                'label' => 'Tumblr Link',
                'name' => 'tumblr_link',
                'type' => 'url',
                'conditional_logic' => array(array(array(
                    'field' => 'field_66b4a5d6cda45',
                    'operator' => '==',
                    'value' => 'Tumblr',
                ))),
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'basic-info',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    /* -------- Redirects (new) -------- */
    acf_add_local_field_group(array(
        'key' => 'group_br_redirects',
        'title' => 'Redirects',
        'fields' => array(
            array(
                'key' => 'field_br_logout_redirect',
                'label' => 'Logout Redirect URL',
                'name' => 'logout_redirect',
                'type' => 'url',
                'instructions' => 'Where users go after logout (if no redirect_to is provided).',
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => home_url('/'),
                'placeholder' => home_url('/'),
            ),
            array(
                'key' => 'field_br_login_redirect',
                'label' => 'Login Redirect URL',
                'name' => 'login_redirect',
                'type' => 'url',
                'instructions' => 'Where users go after login (if no redirect_to is provided and no role/cap rule matches).',
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => home_url('/'),
                'placeholder' => home_url('/'),
            ),
            array(
                'key' => 'field_br_register_redirect',
                'label' => 'Register Redirect URL',
                'name' => 'register_redirect',
                'type' => 'url',
                'instructions' => 'Where users go after registration (My Account). Checkout registrations are not changed.',
                'wrapper' => array('width' => '', 'class' => '', 'id' => ''),
                'default_value' => home_url('/'),
                'placeholder' => home_url('/'),
            ),

            // Role-based login redirects (repeater)
            array(
                'key' => 'field_br_role_redirects',
                'label' => 'Role-based Login Redirects',
                'name' => 'role_redirects',
                'type' => 'repeater',
                'instructions' => 'Top to bottom; first matching role wins.',
                'layout' => 'row',
                'button_label' => 'Add Role Redirect',
                'sub_fields' => array(
                    array(
                        'key' => 'field_br_role_redirects_role',
                        'label' => 'Role',
                        'name' => 'role',
                        'type' => 'select',
                        'choices' => array(), // populated via acf/load_field below
                        'ui' => 1,
                        'allow_null' => 0,
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_br_role_redirects_url',
                        'label' => 'Redirect URL',
                        'name' => 'url',
                        'type' => 'url',
                        'placeholder' => home_url('/'),
                    ),
                ),
            ),

            // Capability-based login redirects (repeater)
            array(
                'key' => 'field_br_cap_redirects',
                'label' => 'Capability-based Login Redirects',
                'name' => 'cap_redirects',
                'type' => 'repeater',
                'instructions' => 'If no role rule matches, first satisfied capability rule is used.',
                'layout' => 'row',
                'button_label' => 'Add Capability Redirect',
                'sub_fields' => array(
                    array(
                        'key' => 'field_br_cap_redirects_cap',
                        'label' => 'Capability',
                        'name' => 'cap',
                        'type' => 'text',
                        'instructions' => 'e.g. manage_options, edit_posts, read',
                        'placeholder' => 'edit_posts',
                    ),
                    array(
                        'key' => 'field_br_cap_redirects_url',
                        'label' => 'Redirect URL',
                        'name' => 'url',
                        'type' => 'url',
                        'placeholder' => home_url('/'),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'basic-info',
                ),
            ),
        ),
        'menu_order' => 99,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
}
add_action('acf/init', 'add_local_field_groups');