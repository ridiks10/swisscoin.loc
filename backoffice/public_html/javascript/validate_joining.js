var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();

    var runValidatorweeklySelection = function() {
	var searchform = $('#daily');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#daily').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		//error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		date: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		date: msg3


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

	var searchform = $('#weekly_join');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#weekly_join').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		//error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		week_date1: {
		    minlength: 1,
		    required: true
		},
		week_date2: {
		    minlength: 1,
		    required: true,
		    todate_greaterthan_fromdate: true
		}
	    },
	    messages: {
		week_date1: msg,
		week_date2: {
		    minlength: msg2,
		    required: msg1,
		    todate_greaterthan_fromdate: msg4
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

	jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {
	    var FromDate = $("#week_date1").val();
	    return (ToDate > FromDate);
	}, "");
    };
    return {
	//main function to initiate template pages
	init: function() {
	    runValidatorweeklySelection();
	    runValidatordailySelection();
	}
    };
}();


var ValidateUserDeactivateActivate = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();

    var runValidatorweeklySelection = function() {
	var searchform = $('#daily');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#daily').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		//error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		date: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		date: msg3


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

	var searchform = $('#weekly_join');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#weekly_join').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		//error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		week_date1: {
		    minlength: 1,
		    required: true
		},
		week_date2: {
		    minlength: 1,
		    required: true,
		    todate_greaterthan_fromdate: true
		}
	    },
	    messages: {
		week_date1: msg,
		week_date2: {
		    minlength: msg2,
		    required: msg1,
		    todate_greaterthan_fromdate: msg4
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

	jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {
	    var FromDate = $("#week_date1").val();
	    return (ToDate > FromDate);
	}, "");
    };
    return {
	//main function to initiate template pages
	init: function() {
	    runValidatorweeklySelection();
	    runValidatordailySelection();
	}
    };
}();




var ValidateCommissionReport = function() {

    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();

    var runValidateCommissionReport = function() {
	var searchform = $('#commision_form');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#commision_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		//error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		from_date: {
		    required: true
		},
		to_date: {
		    required: true,
		    todate_greaterthan_fromdate: true
		},
		"amount_type[]": {
		    required: true
		}
	    },
	    messages: {
		from_date: msg,
		to_date: {
		    minlength: msg2,
		    required: msg1,
		    todate_greaterthan_fromdate: msg4
		},
		"amount_type[]": msg3
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
	jQuery.validator.addMethod('todate_greaterthan_fromdate', function(ToDate) {
	    var FromDate = $("#from_date").val();
	    return (ToDate > FromDate);
	}, "");
    };
    return {
	//main function to initiate template pages
	init: function() {

	    runValidateCommissionReport();
	}
    };

}();