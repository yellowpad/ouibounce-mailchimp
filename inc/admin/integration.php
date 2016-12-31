<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $ouibounce_options, $ouibounce_settings_integration;
?>

<div class="wrap">
	<?php settings_errors(); ?>
	<div id="cb-settings">
		<div id="cb-settings-content">

			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	        <h2 class="nav-tab-wrapper">
	            <a href="?page=ouibounce-settings" class="nav-tab">MailChimp Key</a>         
	            <a href="?page=mailchimp-list" class="nav-tab nav-tab-active">MailChimp List</a>          
	        </h2>  
	        <br>
			<div id="tab_container">
				<form method="post" action="options.php">
					    <?php settings_fields( 'ouibounce_settings_integration' );
						do_settings_sections( 'ouibounce_settings_integration' );
						if($ouibounce_options['mcapi_key']!= ''){
							include_once( WP_OUIBOUNCE_BASE_DIR . '/mailchimp-api-php/MCAPI.class.php' );
							$apikey = $ouibounce_options['mcapi_key'];
							$apiUrl = 'http://api.mailchimp.com/1.3/';
							// create a new api object
							$api = new MCAPI($apikey);
							$retval = $api->lists();
							if ($api->errorCode){
								echo '<span style="border-radius:4px; padding: 5px 8px;background: #E85C41;color: #fff;">Not Connected</span>';
							} else {
								echo '<span style="border-radius:4px; padding: 5px 8px;background: #72C1B0;color: #fff;">Connected</span>';			
								?>	
								<table class="form-table">
									<tbody>
										<tr>
											<th scope="row">
												<label for="ouibounce_settings_integration[mcapi_key]">Select List</label>
											</th>
											<td>
												<select class="regular-text" id="ouibounce_settings_integration[mcapi_listid]" name="ouibounce_settings_integration[mcapi_listid]" required>
													<option value="">Select List</option>
													<?php 
													foreach ($retval['data'] as $list){
														echo '<option value="'.$list['id'].'"';
															if($ouibounce_settings_integration['mcapi_listid']!= '' && $ouibounce_settings_integration['mcapi_listid'] == $list['id']){ echo ' selected ';
															}
														echo '>'.esc_attr($list['name']).'</option>';	
													} ?>
												</select>
												<p class="description">Select the list that you want to subscribe users to.</p>
											</td>
										</tr>
									</tbody>
								</table>
								<?php
								
							}
						} else{
							echo '<span style="padding: 5px 8px;background: #ccc;color: #fff;">Not Connected</span>';
						}
						do_action( 'ouibounce_settings_integration' );
						
						submit_button(); ?>

					</form>
			</div>
		</div>
		<?php if($ouibounce_options['mcapi_key']!= ''){
			
			include_once( WP_OUIBOUNCE_BASE_DIR . '/mailchimp-api-php/MCAPI.class.php' );
			$apikey = $ouibounce_options['mcapi_key'];
			$apiUrl = 'http://api.mailchimp.com/1.3/';
			// create a new api object
			$api = new MCAPI($apikey);
			$retval = $api->lists();
			if ($api->errorCode){
				echo "Unable to load lists";
				//echo "\n\tCode=".esc_attr($api->errorCode);
				echo "\n\tMsg=".esc_attr($api->errorMessage)."\n";
			} else {
				//echo "Lists that matched:".$retval['total']."\n".'<br>';
				//echo "Lists returned:".sizeof($retval['data'])."\n".'<br>';
				echo '<h3>All Lists</h3><table border="1" cellspacing="0" cellpadding="10" style="width:80%;margin:20px 0 20px 0;text-align:left;text-indent: 20px;"><tr><th>List Name</th><th>List ID</th><th>Total Subscribers</th></tr>';
				foreach ($retval['data'] as $list){
					echo '<tr>';
					echo '<td>'.esc_attr($list['name']).'</td>';
					echo '<td>'.esc_attr($list['id']).'</td>';
					echo '<td>'.esc_attr($list['stats']['member_count']).'</td>';
					//echo "\tUnsub=".$list['stats']['unsubscribe_count'].'<br>';
					//echo "\tCleaned=".$list['stats']['cleaned_count']."\n".'<br>';
					echo '</tr>';
				}
				echo '</table>';		
			}
		} ?>

	</div>
</div><!-- .wrap -->