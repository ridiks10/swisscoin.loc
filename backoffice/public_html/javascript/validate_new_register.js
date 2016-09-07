
var ValidateUser = function () {

    var msg2 = $("#validate_msg18").html();
    var msg23 = $("#validate_msg40").html();
    var msg17 = $("#validate_msg16").html();
    var msg18 = $("#validate_msg17").html();
    var msg1 = $("#validate_msg15").html();
    var msg15 = $("#validate_msg34").html();
    var msg16 = $("#validate_msg35").html();
    var msg37 = $("#validate_msg8").html();
    var msg31 = $("#validate_msg48").html();
    var msg35 = $("#validate_msg58").html();
    var msg78 = $("#validate_msg78").html();
    var msg79 = $("#validate_msg79").html();
    var msg80 = $("#validate_msg80").html();
    var msg21 = $("#validate_msg38").html();
    var msg76 = $("#validate_msg76").html();
    var msg63 = $("#validate_msg63").html();


    var runValidatorweeklySelection = function () {
        $.validator.addMethod("alpha_dash", function (value, element) {
            return this.optional(element) || /^[a-z0-9A-Z$@$!%*#?& _~\-!@#\$%\^&\*\(\)?,.:|\\+\\[\]{}''"";`~=]*$/i.test(value);
        }, msg31);
        $.validator.addMethod("alpha_num", function (value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9]+$/);
        }, msg35);
        $.validator.addMethod("alpha_city", function (value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\.\,]+$/);
        }, msg78);
        $.validator.addMethod("alpha_address", function (value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9\s\.\,]+$/);
        }, msg79);
        $.validator.addMethod("alpha_password", function (value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z0-9!@#$%&*]+$/);
        }, msg80);



        var searchform = $('#form');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type

                error.insertAfter(element);
//                error.insertAfter($(element).closest('.input-group'));
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                sponsor_user_name: {
                    minlength: 1,
                    required: true
                },
                user_name_entry: {
                    required: true,
                    minlength: 6,
                    maxlength: 12,
                    alpha_num: true
                },
                email: {
                    required: true,
                    maxlength: 75,
                    email: true
                },
                pswd: {
                    minlength: 6,
                    alpha_password: true,
                    required: true
                },
                cpswd: {
                    minlength: 6,
                    required: true,
                    alpha_password: true,
                    equalTo: "#pswd"
                },
                country: {
                    minlength: 1,
                    required: true
                },
                agree: {
                    minlength: 1,
                    required: true
                },
            },
            messages: {
                sponsor_user_name: msg37,
                user_name_entry: {
                    required: msg21,
                    maxlength: msg76,
                    minlength: msg63,
                    alpha_num: msg31},
                email: {
                    required: msg23,
                    email: msg16},
                pswd: {
                    required: msg1,
                    minlength: msg17,
                    alpha_password: msg80},
                cpswd: {
                    required: msg18,
                    minlength: msg17,
                    equalTo: msg2,
                    alpha_password: msg80
                },
                country: msg15,
                agree: 'accept terms and conditions',
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
            runValidatorweeklySelection();

        }
    };
}();