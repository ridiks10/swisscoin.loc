


var ValidatePassword = function() {


    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg6").html();
    var msg6 = $("#error_msg8").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

        jQuery.validator.addMethod("alpha_dash", function(value, element) {
            return this.optional(element) || /^[a-z0-9A-Z$@$!%*#?& _~\-!@#\$%\^&\*\(\)?,.:<>|\\+\/\[\]{}''"";`~=]*$/i.test(value);
        }, msg6);
        var searchform = $('#change_pass_common');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_pass_common').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name_common: {
                    minlength: 1,
                    required: true
                },
                new_pwd_common: {
                    minlength: 6,
                    required: true,
                    alpha_dash: true
                },
                confirm_pwd_common: {
                    minlength: 6,
                    required: true,
                    equalTo: "#new_pwd_common",
                    alpha_dash: true
                }
            },
            messages: {
                user_name_common: {required: msg1},
                new_pwd_common: {required: msg5,
                    minlength: msg2},
                confirm_pwd_common: {required: msg5,
                    minlength: msg2,
                    equalTo: msg3}

            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };
    var runValidatorAdminSelection = function() {

        var searchform = $('#change_pass_admin');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#change_pass_admin').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior

            },
            ignore: ':hidden',
            rules: {
                current_pwd_admin: {
                    minlength: 6,
                    required: true
                },
                new_pwd_admin: {
                    minlength: 6,
                    required: true,
                    alpha_dash: true
                },
                confirm_pwd_admin: {
                    minlength: 6,
                    required: true,
                    equalTo: "#new_pwd_admin",
                    alpha_dash: true,
                }


            },
            messages: {
                current_pwd_admin: {required: msg1,
                    minlength: msg2},
                new_pwd_admin: {required: msg5,
                    minlength: msg2},
                confirm_pwd_admin: {required: msg4,
                    minlength: msg2,
                    equalTo: msg3}
            },
            invalidHandler: function(event, validator) { //display error alert on form submit
                errorHandler1.show();
            },
            highlight: function(element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function(element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function(label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                //$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $(element).closest('.form-group').removeClass('has-error').addClass('ok');
            }
        });
    };



    return {
        //main function to initiate template pages
        init: function() {
            runValidatorUserSelection();
            runValidatorAdminSelection();
        }
    };
}();
