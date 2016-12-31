<?php

/**
 * Represents the view for the administration dashboard.
 *
 * @package    CB
 * @subpackage Views
 * @author     Diggable <http://diggable.co>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* 
 * Get Admin Tabs and label
 * 
 * @since 1.1.1
 * 
 * array( $key => $value )
 * $key is the value that is used when making the setting option
 * $value is the display title of the tab
 * 
 * @return array
 */


global $ouibounce_options;

$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'default';

?>

<div class="wrap">
	<?php settings_errors(); ?>
	<div id="cb-settings">
		<div id="cb-settings-content">

        <h2 class="nav-tab-wrapper">
            <a href="?page=ouibounce-settings" class="nav-tab nav-tab-active">MailChimp Key</a>         
            <a href="?page=mailchimp-list" class="nav-tab">MailChimp List</a>          
        </h2>  
        
			<div id="tab_container">
				<form method="post" action="options.php">
					<?php settings_fields('ouibounce_settings_group'); ?>
					
					<table class="form-table">
						<tbody>
							<tr valign="top">	
								<th scope="row" valign="top">
									<?php _e('MailChimp API Key', 'wp-stripe-payments'); ?>
								</th>
								<td>
									<div class="mailchimp-key">
										<input id="ouibounce_settings[mcapi_key]" name="ouibounce_settings[mcapi_key]" type="text" class="regular-text" value="<?php echo esc_attr($ouibounce_options['mcapi_key']); ?>"/><br>
										<label class="description" for="ouibounce_settings[mcapi_key]">Add your MailChimp API Key to Connect Your Account</label>		
									</div>							
									<br>
								</td>
							</tr>
							<tr valign="top">	
								<th scope="row" valign="top">
									<?php _e('Ouibounce Header Text', 'wp-stripe-payments'); ?>
								</th>
								<td>
									<div class="ouibounce-header">
										<input id="ouibounce_settings[header_text]" name="ouibounce_settings[header_text]" type="text" class="regular-text" value="<?php echo esc_attr($ouibounce_options['header_text']); ?>"/><br>
										<label class="description" for="ouibounce_settings[header_text]">Popup Header Text</label>		
									</div>							
									<br>
								</td>
							</tr>

							<tr valign="top">	
								<th scope="row" valign="top">
									<?php _e('Ouibounce Body Text', 'wp-stripe-payments'); ?>
								</th>
								<td>
									<div class="ouibounce-header">
										<input id="ouibounce_settings[body_text]" name="ouibounce_settings[body_text]" type="text" class="regular-text" value="<?php echo esc_attr($ouibounce_options['body_text']); ?>"/><br>
										<label class="description" for="ouibounce_settings[body_text]">Popup Body Text</label>		
									</div>							
									<br>
								</td>
							</tr>							
						</tbody>
					</table>	

					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save Options', 'wp-stripe-payments'); ?>" />
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
