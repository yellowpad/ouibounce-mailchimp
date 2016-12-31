jQuery(function($) {
  "use strict";

  ouibounce($('#js-optin-wrap')[0], {
    // Uncomment the line below if you want the modal to appear every time
    // More options here: https://github.com/carlsednaoui/ouibounce
    aggressive: true,
    sitewide: true,
  });
    
    $("#js-optin-submit").click(function(event) {
        event.preventDefault();
        $(this).val('Loading...').prop('disabled');

        var data = {
          'action': 'process_optin_submission',
          'nonce': window.OuibounceVars.nonce,
          'email': $('#js-optin-email').val()
        };


        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            cache: false,
            dataType: 'json',          
            success: function (data) {
              // Handle the response (take care of error reporting!)
              if (data.success){
                        console.log(data.html);
                $('#js-optin-step1').hide().next('#js-optin-step2').show();
              }
              else{
                $(".errbox").html(data.html);
                console.log(data.html);
              }
            }
        });
    
    });

    console.log('Hmm');
    
    $('.js-optin-close').on('click', function(event) {
        event.preventDefault();
        $('#js-optin-wrap').hide();
    });

});

