$(document).ready(function() {
    
 LiveTicker.init();
});

var LiveTicker = {
   
    notification: function () { 
        var base_url = $('#base_url').val();
        var user_type = $('#user_type').val();
        if (user_type == 'distributor') {
            user_type = 'user';
        }
        var get_details = base_url +user_type+ '/purchase/confirm_status';  
        
        $.post(get_details, {}, function (data) {

            if (data == 'yes'){
                 $('#pay_ewallet').attr('disabled',false); 
                 $('#pay_cash').attr('disabled',false); 
                 $('#pay_trading').attr('disabled',false); 
             }
            else{
                 $("#trigger_button").click(); 
                 
                 function mfk_redirect(){
                     window.location.href = base_url +user_type+ '/profile/profile_view';                     
                 }
                 setTimeout(mfk_redirect,5000); 
            }

        });

    },
    init: function () {
        this.notification();
    }
}
