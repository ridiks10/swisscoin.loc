
function trim(s)
{
    return s.replace(/^\s+|\s+$/, '');
}
var ValidateEmployeeLogin = function () {

    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {
        var searchform = $('#login_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#login_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                user_name: msg1,
                password: msg2
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
            runValidatorUserSelection();
        }
    };
}();
var ValidateEmployee = function () {
    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg4 = $("#error_msg4").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {
        var searchform = $('#login_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#login_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                admin_username: {
                    required: true
                },
                employee_username: {
                    required: true
                },
                employee_password: {
                    required: true
                }
            },
            messages: {
                admin_username: msg1,
                employee_username: msg2,
                employee_password: msg4,
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
            runValidatorUserSelection();
        }
    };
}();
var ValidateEmployeeRegister = function () {
    // function to initiate Validation Sample 1
    var msg1 = $("#error_employee_msg1").html();
    var msg2 = $("#error_employee_msg2").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function () {
        var searchform = $('#login_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#login_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                employee_username: {
                    required: true
                },
                employee_password: {
                    required: true
                }
            },
            messages: {
                employee_username: msg1,
                employee_password: msg2,
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
            runValidatorUserSelection();
        }
    };
}();