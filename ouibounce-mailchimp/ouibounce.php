<?php
/*
Plugin Name: WP Ouibounce for MailChimp
Plugin URI: https://example.com
Description: Ouibounce
Author: WP Ouibounce for MailChimp
Author URI: https://example.com
Version: 1.6.13
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*
*
*
* Load Optin form class and let it render just before
*
*
*/

if(!defined('WP_OUIBOUNCE_BASE_DIR')) {
	define('WP_OUIBOUNCE_BASE_DIR', dirname(__FILE__));
}

$ouibounce_options = get_option('ouibounce_settings');
$ouibounce_settings_integration = get_option('ouibounce_settings_integration');

require ( WP_OUIBOUNCE_BASE_DIR . '/inc/admin/admin-menu.php' );
require ( WP_OUIBOUNCE_BASE_DIR . '/inc/class-optin-form.php' );

$optin_form = new Optin_Form();

add_action( 'wp_footer', array( $optin_form, 'render' ) );


/* * * * * * *
 * Enqueue all the necessary scripts and set proper JavaScript variables
 * * * * * * */

function enqueue_ouibounce() {
  wp_enqueue_script( 'ouibounce', '/wp-content/plugins/ouibounce-c-box/js/ouibounce.js', array() );
  wp_enqueue_style( 'ouibounce-style', '/wp-content/plugins/ouibounce-c-box/ouibounce.css', array() );
  wp_enqueue_script( 'ouibounce-config-2', '/wp-content/plugins/ouibounce-c-box/js/ouibounce-config-2.js', array( 'jquery' ), '1.6.13' );
  wp_localize_script( 'ouibounce-config-2', 'OuibounceVars', array('nonce' => wp_create_nonce( 'ouibounce' )) );
  wp_localize_script( 'ouibounce-config-2', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

  //wp_enqueue_script('mailchimp-js', '//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js');
  //wp_enqueue_script('mailchimp-validate', '/wp-content/plugins/ouibounce/js/mailchimp-validate.js');
}

add_action( 'wp_enqueue_scripts', 'enqueue_ouibounce' );
