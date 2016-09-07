/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function ValidateleadUrl() {


    var lead_url = document.site_config.lead_url.value;


    var matches = '%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i';

    if (lead_url.match(matches))
    {
        alert("matchayiii");

    }
    else {
        alert("ply");
    }
}
var ValidateUser = function() {

    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg6").html();
    var msg4 = $("#validate_msg4").html();
    var msg5 = $("#validate_msg5").html();
    var msg6 = $("#validate_msg8").html();


    var runValidateLetterConfig = function() {

        var searchform = $('#site_config');
        var errorHandler1 = $('.errorHandler', searchform);
        //  var successHandler1 = $('.successHandler', form_setting);

        $('#site_config').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function(error, element) { // render error placement for each input type

                error.insertAfter(element);
                // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                co_name: {
                    minlength: 1,
                    required: true
                },
                company_address: {
                    minlength: 1,
                    required: true


                },
//                favicon: {
//                    minlength: 1,
//                    required: true
//                },
//                img_logo: {
//                    minlength: 1,
//                    required: true
//                },
                email: {
                    minlength: 1,
                    required: true,
                    email: true
                },
                phone: {
                    minlength: 5,
                    //required: true
                },
                lead_url: {
                    minlength: 3,
                    required: true
                }
            },
            messages: {
                co_name: msg1,
                company_address: msg6,
//               favicon: msg2,
//                img_logo: msg4,
                email:
                        {
                            required: msg5,
                            email: "Your email address must be in the format of name@domain.com"
                        },
                lead_url:
                        {
                            required: msg5,
                            lead_url: "Your url address must be in the format of https://Revamp_Responsive/..."
                        },
                phone: msg3

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
            runValidateLetterConfig();

        }
    };

}();

$(document).ready(function()
{

    $("#phone").keypress(function(e)
    {

        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 43)
        {
            //display error message
            $("#errmsg1").html("Digits Only ").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#pin_maxcount").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg2").html("Digits Only..... ").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#length").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmsg1").html("Digits Only....").show().fadeOut(1200, 0);
            return false;
        }
    });
    $("#payout_amount").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
        {
            //display error message
            $("#errmessage1").html("Digits Only....").show().fadeOut(1200, 0);
            return false;
        }
    });
});

//=================================
$(document).ready(function() {
    $("#form_setting").validate({
        submitHandler: function(form) {
            SubmittingForm();
        },
        rules: {
            content: "required",
        },
        messages: {
            content: "Content is empty!!",
        }
    });
});
