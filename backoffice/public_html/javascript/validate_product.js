$(document).ready(function()

{
    var msg = "";
    $("#product_amount").keypress(function(e)
    {
        var flag=0;
        if(e.which == 46){
            if($(this).val().indexOf('.') != -1){
                flag=1;
            }
        }
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
	{
            flag=1;
        } 
        if( flag==1){
        //display error message
	   
//	    msg = $("#validate_msg1").html();
             msg = 'Enter Numbers Only..';
	    $("#errmsg1").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
	return true;
    });
    $("#pair_value").keypress(function(e)
    {
        var flag=0;
        if(e.which == 46){
            if($(this).val().indexOf('.') != -1){
                flag=1;
            }
        }   
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46)
	{
            flag=1;
        } 
         if( flag==1){
            //display error message
	    msg = $("#validate_msg1").html();
	    $("#errmsg2").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
	return true;
    });
    $("#bv_value").keypress(function(e)
    {
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
	{
	    //display error message
	    msg = $("#validate_msg1").html();
	    $("#errmsg2").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
	return true;
    });
    $("#no_of_token").keypress(function(e)
    {
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
	{
	    //display error message
	    msg = $("#validate_msg1").html();
	    $("#errmsg3").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
	return true;
    });
    $("#splits").keypress(function(e)
    {
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
	{
	    //display error message
	    msg = $("#validate_msg1").html();
	    $("#errmsg7").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
	return true;
    });
    $("#academy_level").keypress(function(e)
    {
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
	{
	    //display error message
	    msg = $("#validate_msg1").html();
	    $("#errmsg9").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
	return true;
    });
});




var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#validate_msg_img2").html();
    var msg5 = $("#validate_msg_img1").html();
    var msg6 = $("#error_msg4").html();
    var msg7 = $("#error_msg7").html();
    var msg8 = $("#error_msg8").html();
    var msg9 = $("#error_msg9").html();
    var runValidatorweeklySelection = function() {

	var searchform = $('#proadd');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#proadd').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		prod_name: {
		    minlength: 1,
		    required: true
		},
		product_id: {
		    minlength: 1,
		    required: true
		},
		product_amount: {
		    minlength: 1,
		    required: true
		},
		pair_value: {
		    minlength: 1,
                    digits: true,
		    required: true
		},
                no_of_token: {
		    minlength: 1,
                     digits: true,
		    required: true
		},
                splits: {
		    minlength: 1,
                     digits: true,
		    required: true
		},
                academy_level: {
		    minlength: 1,
                     digits: true,
		    required: true
		},
		bv_value: {
		    minlength: 1,
                     digits: true,
		    required: true
		},
		userfile: {
		   
		    required: true
		}

	    },
	    messages: {
		prod_name: msg,
		product_id: msg1,
		product_amount: msg3,
                no_of_token: msg7,
                splits: msg8,
                academy_level: msg9,
		pair_value: msg6,
		userfile: 'Please select product image..'
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
    var runValidatordailySelection = function() {

	var searchform = $('#product_image_form');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#product_image_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		prod_id: {
		    required: true
		}
//                userfile: {
//                    minlength: 1,
//                    required: true
//                }
	    },
	    messages: {
		prod_id: "Select Product"
			//  userfile:msg4

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
	    runValidatorweeklySelection();
	    runValidatordailySelection();
	}
    };
}();