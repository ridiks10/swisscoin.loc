var validate_invite_wallpost = function () {
    
    // function to initiate Validation Sample 1
    
    var runValidateWallpost = function () {
        var msg1=$("#validate_msg1").html();
        var msg2=$("#validate_msg2").html();        
        var msg=$("#errmsg").html();
        var searchform = $('#soial-invite-fb');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#soial-invite-fb').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
				if ($(element).hasClass("date-picker") ) {
				 error.insertAfter($(element).closest('.input-group'));
				}
				else
				{
				 error.insertAfter(element);
				};
                //error.insertAfter(element);
                    // for other inputs, just perform default behavior
             },
            ignore: ':hidden',
            rules: {
                 caption: {
                    minlength: 1,
                    required: true

                },
                description: {
                    minlength: 1,
                    required: true

                }
            },
            messages: {
                
                 caption: msg1,
                description: msg2,
               
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    return {
        //main function to initiate template pages
        init: function () {
            runValidateWallpost();
        }
    };
}();