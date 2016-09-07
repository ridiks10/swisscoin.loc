function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}

function disable()

{
    document.fund_form.fund_trans.disabled = true;
}

function enable()
{
    document.fund_form.fund_trans.disabled = false;
}

var ValidateFund = function () {
    
    // function to initiate Validation Sample 1
    var msg=$("#error_msg1").html();
    var msg1=$("#error_msg2").html();
    var msg2=$("#error_msg3").html();
    var msg3=$("#error_msg4").html();
    var msg4=$("#error_msg5").html();
    var msg5=$("#error_msg6").html();
    var runValidateFundSelection = function () {
        var searchform = $('#fund_form');        
        var errorHandler1 = $('.errorHandler', searchform);        
        $('#fund_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
             
                error.insertAfter(element);
            // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                avb_amount: {
                    minlength: 1,
                    required: true
                },
                pswd: {
                    minlength: 1,
                    required: true
                },
                to_user_name: {
                    minlength: 1,
                    required: true
                },
                amount: {
                    minlength: 1,
                    required: true
                }
                
            },
            messages: {
                user_name: msg,
                avb_amount: msg,
                pswd: msg2,
                to_user_name: msg3,
                amount: msg4
               
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
    var runValidateFundAdminSelection = function () {
        var searchform = $('#fund_admin');        
        var errorHandler1 = $('.errorHandler', searchform);        
        $('#fund_admin').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
             
                error.insertAfter(element);
            // for other inputs, just perform default behavior
            },
            ignore: ':hidden',
            rules: {
                user_name: {
                    minlength: 1,
                    required: true
                },
                pswd: {
                    minlength: 1,
                    required: true
                },
                to_user_name: {
                    minlength: 1,
                    required: true
                },
                amount: {
                    minlength: 1,
                    required: true
                }
                
            },
            messages: {
                
                user_name: msg,
                pswd: msg1,
                to_user_name: msg2,
                amount: msg3
               
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
            runValidateFundSelection();
            runValidateFundAdminSelection();
        }
    };
}();

$(document).ready(function()
{	
	
	$("#amount").keypress(function (e)  
	{
		//if the letter is not digit then display error and don't type anything
		if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))
		{
			//display error message
			$("#errmsg1").html("Digits Only ").show().fadeOut(1200,0); 
			return false;
		}	
	});
	
	return true;
       
        
});


$("#to_user_name").blur(function()
{
    var path_temp = document.fund_form.path_temp.value;
    var path_root = document.fund_form.path_root.value;
    var newusername = document.fund_form.to_user_name.value;

    var user_null = trim(newusername);

    var emailRegex = /^[""]+/;

    var error = 0;

    if (user_null == "")
    {

        $("#msgboxsponsor").removeClass();

        $("#msgboxsponsor").addClass('messageboxsponsorerror');

        $("#msgboxsponsor").html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /> Invalid user name...').show().fadeTo(1900, 1);

        error = 1;
        disable();
    }
    if (error != 1)
    {
        var sponsor_availability = path_root + "user/ewallet/user_availability";
        disable();
        //remove all the class add the messagebox classes and start fading
        $("#errormsg1").removeClass();

        $("#errormsg1").addClass('messagebox');


        $("#errormsg1").html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + 'Username validating...').show().fadeTo(1900, 1);
        //$("#errormsg1").html(msg).show().fadeTo(1900,1);

        //check the username exists or not from ajax
        $.post(sponsor_availability, {user_name: newusername}, function(data)
        {
            if (trim(data) == 'no') //if username not avaiable
            {
                $("#errormsg1").fadeTo(200, 0.1, function() //start fading the messagebox
                {
                    //add message and change the class of the box and start fading
                    $(this).removeClass();
                    $(this).addClass('messageboxerror');
                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/Error.png" /> Invalid User name...').show().fadeTo(1900, 1);

                    disable();
                });
            }
            else
            {
                $("#errormsg1").fadeTo(200, 0.1, function()  //start fading the messagebox
                {
                    //add message and change the class of the box and start fading

                    $(this).removeClass();

                    $(this).addClass('messageboxok');

                    $(this).html('<img align="absmiddle" src="' + path_temp + 'images/accepted.png" />' + 'Username validated').show().fadeTo(1900, 1);
                    enable();
                });
            }

        });

    }

});