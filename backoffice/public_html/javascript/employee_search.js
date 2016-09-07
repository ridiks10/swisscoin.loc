 $(document).ready(function() {
   
    var msg = $("#error_msg").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
        $("#edit_form").validate({
            submitHandler:function(form) {
                SubmittingForm();
            },
              rules: {
               mobile: {
                    minlength: 10,
                    required: true,
                    number:true
                },
               full_name: {
                    minlength: 1,
                    required: true
                },
             
             email:{
                    minlength: 1,
                    required: true,
                    email: true
                      
                }
            },
            messages: {
                    mobile: msg5,
                    full_name:msg,
            email: {
                    required: msg4,
                    email: "Your email address must be in the format of name@domain.com"
                }
            }
        });
    });