<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action('admin_menu', 'ouibounce_settings_setup');
add_action('admin_menu', 'ouibounce_chimplist_setup');
add_action('admin_init', 'ouibounce_register_settings');
add_action('admin_init', 'ouibounce_register_integration');

function ouibounce_settings_setup() {
    add_menu_page('Ouibounce Settings', 
        'Ouibounce Settings', 
        'manage_options', 
        'ouibounce-settings', 
        'ouibounce_render_options_page', 
        plugins_url('/assets/icon-16x16.png',__FILE__)
    );
}

function ouibounce_chimplist_setup() {
    add_menu_page('Ouibounce Settings', 
        'MailChimp List', 
        'manage_options', 
        'mailchimp-list', 
        'ouibounce_mailchimp_list'
    );
}

function ouibounce_render_options_page() {

        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to view this page.');
        }
        include ( WP_OUIBOUNCE_BASE_DIR . '/inc/admin/admin.php' );
}

function ouibounce_mailchimp_list() {

        if (!current_user_can('manage_options')) {
            wp_die('You do not have permission to view this page.');
        }
        include ( WP_OUIBOUNCE_BASE_DIR . '/inc/admin/integration.php' );
}


function ouibounce_register_settings() {

    register_setting('ouibounce_settings_group', 'ouibounce_settings');
}

function ouibounce_register_integration() {

    register_setting('ouibounce_settings_integration', 'ouibounce_settings_integration');
}