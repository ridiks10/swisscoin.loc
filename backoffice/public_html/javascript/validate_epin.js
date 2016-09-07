$(document).ready(function()
{
    $("#count").keypress(function(e)
    {
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
	{
	    //display error message
	    var msg = $("#validate_msg").html();
	    $("#errmsg3").html(msg).show().fadeOut(1200, 0);
	    return false;
	}
    });
});

function validate_date()
{
    var date1 = upload.date.value;
    alert(date1);
}


//=========validate checkbox===================//

var ValidateEpinRequest = function() {


    // function to initiate Validation Sample 1
    var msg1 = $("#error_msg6").html();
    ///////----for 'CHANGE USER PASSWORD' Tab - Begin/////////
    var runValidatorUserSelection = function() {

	/*jQuery.validator.addMethod("alpha_dash", function(value, element) {
	 return this.optional(element) || /^[a-z0-9A-Z]*$/i.test(value);
	 }, msg6);*/
	$.validator.addMethod('active', function(value) {
	    return $('.active:checked').size() > 0;
	}, msg1);
	var searchform = $('#view_request_form');
	var checkboxes = $('.active');
	var checkbox_names = $.map(checkboxes, function(e, i) {
	    return $(e).attr("name")
	}).join(" ");
	var errorHandler1 = $('.errorHandler', searchform);
	$('#view_request_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    groups: {
		checks: checkbox_names
	    },
	    rules: {
		active: {
		    required: true
		}
	    },
	    messages: {
		active: {required: msg1}

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

	}
    };
}();


var ValidateUser = function() {


    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg4").html();
    var msg6 = $("#error_msg6").html();
    var msg7 = $("#error_msg7").html();

    var runValidatorweeklySelection = function() {
	var searchform = $('#generate_epin');
	var errorHandler1 = $('.errorHandler', searchform);
	$.validator.addMethod("dateCheck", function(value, searchform)
	{

	    var selectedDate = $('#date').datepicker('getDate');
	    var now = new Date();

	    var twoDigitMonth1 = selectedDate.getMonth() + 1 + "";
	    if (twoDigitMonth1.length == 1)
		twoDigitMonth1 = "0" + twoDigitMonth1;
	    var twoDigitDate1 = selectedDate.getDate() + "";
	    if (twoDigitDate1.length == 1)
		twoDigitDate1 = "0" + twoDigitDate1;


	    var twoDigitMonth2 = now.getMonth() + 1 + "";
	    if (twoDigitMonth2.length == 1)
		twoDigitMonth2 = "0" + twoDigitMonth2;
	    var twoDigitDate2 = now.getDate() + "";
	    if (twoDigitDate2.length == 1)
		twoDigitDate2 = "0" + twoDigitDate2;



	    var todayStr = now.getFullYear() + "-" + (twoDigitMonth2) + "-" + twoDigitDate2 + " " + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
	    var selectedStr = selectedDate.getFullYear() + "-" + (twoDigitMonth1) + "-" + twoDigitDate1 + " " + now.getHours() + ':' + (now.getMinutes() + 1) + ':' + now.getSeconds();
//            console.log('selectedStr: ' + selectedStr + ' today : ' + todayStr);
	    if (selectedStr >= todayStr) {
		return true;
	    }
	    else if (selectedStr === todayStr) {
		return true;
	    }
	    else {
		return false;
	    }

	});


	$("#generate_epin").validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type
		if ($(element).hasClass("date-picker")) {
		    error.insertAfter($(element).closest('.input-group'));
		}
		else
		{
		    error.insertAfter(element);
		}
		;
		//error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    submitHandler: function(form) {
		SubmittingForm();
	    },
	    rules: {
		amount1: {
		    minlength: 1,
		    required: true
		},
		count: {
		    minlength: 1,
		    required: true
		},
		date: {
		    minlength: 1,
		    required: true,
		    dateCheck: true
		}

	    },
	    messages: {
		amount1: msg,
		count: msg1,
		date: {
		    required: msg6,
		    dateCheck: msg7
		}
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
	var searchform = $('#search_epin');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#search_epin').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		amount: {
		    minlength: 1,
		    required: true
		},
		keyword: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		amount: msg5,
		keyword: msg5
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
    }

    var runValidatorweeklySelectionm = function() {

	var searchform = $('#search_pin_amount');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#search_pin_amount').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		amount: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		amount: msg

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
    var runValidatorViewPinUser = function() {
	var searchform = $('#view_pin_user');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#view_pin_user').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		user_name: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		user_name: msg2,
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
	    runValidatorweeklySelectionm();
	    runValidatorViewPinUser();


	}
    };
}();