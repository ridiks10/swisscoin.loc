var ValidateBanking = function () {


    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var msg6 = $("#error_msg6").html();


    var runValidatorUserSelection = function () {


        $.validator.addMethod("alpha_spec", function (value, element) {
            return this.optional(element) || value == value.match(/^[.a-zA-Z0-9 ]+$/);
        }, msg5);
        var searchform = $('#banking_form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#banking_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                bank: {
                    minlength: 1,
                    required: true,
                    alpha_spec: true
                },
                branch: {
                    minlength: 1,
                    required: true,
                    alpha_spec: true
                },
                ifsc: {
                    minlength: 1,
                    required: true,
                    alpha_spec: true
                },
                acc_no: {
                    minlength: 1,
                    required: true,
                    number: true
                }
            },
            messages: {
                acc_no: {
                    required: msg4,
                    minlength: msg4,
                    number: msg6
                },
                branch: {
                    required: msg2,
                    minlength: msg2,
                    alpha_spec: msg5
                },
                bank: {
                    required: msg1,
                    minlength: msg1,
                    alpha_spec: msg5
                },
                ifsc: {
                    required: msg3,
                    minlength: msg3,
                    alpha_spec: msg5
                }

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


function ChooseOption() {
    var action = $('#action').val();
    var path = $('#path').val();
    var url = path + '/payout/payout_release_request';
    var fund_transfer = path + '/ewallet/fund_transfer';

    if (action == 'payout_request') {
        $(location).attr('href', url);
    }
    else if (action == 'fund_transfer') {
        $(location).attr('href', fund_transfer);
    }
}


