<?php

class Optin_Form {

  public function __construct() {
    add_action( 'wp_ajax_process_optin_submission', array( $this, 'process' ) );
    add_action( 'wp_ajax_nopriv_process_optin_submission', array( $this, 'process' ) );
  }

  
  public function process() {


    if( ! wp_verify_nonce( $_POST['nonce'], 'ouibounce' ) ) {
      
      return;
    }

    global $ouibounce_options, $ouibounce_settings_integration;


      if ((isset($_POST['email'])) && (strlen(trim($_POST['email'])) > 0)) {
        $email = trim(stripslashes(strip_tags($_POST['email'])));
      }

      else {
        $email = '';
      }
      

      if (isset( $ouibounce_options['mcapi_key'] )){
          
          include_once( WP_OUIBOUNCE_BASE_DIR . '/mailchimp-api-php/MCAPI.class.php' );
          
          if($email !== '' && is_email($email)) {

            $apikey = $ouibounce_options['mcapi_key'];
            $apiUrl = 'http://api.mailchimp.com/1.3/';
            
            // create a new api object
            $api = new MCAPI($apikey);
            
            $listId = $ouibounce_settings_integration['mcapi_listid'];  
 
            $double_optin   = true;
            $send_welcome   = true;
            $merge_vars     = null;
            //$retval = $api->lists();
            

            $api->listSubscribe( $listId, $email, $merge_vars, '', $double_optin );     

            if ($api->errorCode){
                    
              //echo $api->errorCode; die;
              $response_json = array();
              $response_json = array( 
                'html'      => 'ERROR DANGER WILL ROBINSON!', 
                'success'   => false , 
                'mcapi_key' => $ouibounce_options['mcapi_key'], 
                'list_id'   => $ouibounce_settings_integration['mcapi_listid']
              );   

              
              header("Content-Type: application/json");
              echo json_encode($response_json); exit;

            }


            //response json
            $response_json  = array();
            $response_json  = array( 
              'html'        => 'Hurray!', 
              'success'     => true , 
              'mcapi_key'   => $ouibounce_options['mcapi_key'], 
              'list_id'     => $ouibounce_settings_integration['mcapi_listid']
            );   

            
            header("Content-Type: application/json");
            echo json_encode($response_json); exit;

          }
      }

  }

  public function render() { 
    
    global $ouibounce_options;
?>
    
    <div class="modal-cover" id="js-optin-wrap">
      <div class="modal">
        <div class="oui-close-outer">
          <a class="oui-close-x js-optin-close">X</a>
        </div>
        <div id="js-optin-step1">
          <h1 class="oui-header"><?php echo esc_attr($ouibounce_options['header_text']); ?></h1>
          <p class="oui-body"><?php echo esc_textarea($ouibounce_options['body_text']); ?></p>
          <form class="oui-form">
            <input type="text" name="email" class="oui-input" id="js-optin-email" placeholder="Your email" />
            <input type="submit" id="js-optin-submit" value="Sign me up!" />
            <div class="errbox"></div>
          </form>
          <br />
        </div>
        <div id="js-optin-step2" style="display:none;">
          <div style="text-align:center;" class='contact-success'>
            <img class="success-img" src="<?php echo esc_url( plugins_url('/assets/success.png',__FILE__) ); ?>" width="80" height="80" alt="Confirmation" />   
          </div>
          <h1 class="oui-header-2">You've been subscribed!</h1>
          <p class="oui-body">Please check your inbox and confirm your subscription to our list!</p>
          <br />
        </div>
      </div>
    </div>
    <?php
  }
}