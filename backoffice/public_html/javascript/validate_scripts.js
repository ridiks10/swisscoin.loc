var ValidateScripts = function() {
    // function to initiate Validation Sample 1

    var runValidateScriptAdd = function() {
	var msg = $("#errmsg").html();
	var msg1 = $("#errmsg1").html();
	var msg2 = $("#errmsg2").html();
	var msg3 = $("#errmsg3").html();
	var msg4 = $("#errmsg4").html();
	var msg5 = $("#errmsg5").html();
	var script_form = $('#script_form');
	var errorHandler1 = $('.errorHandler', script_form);
	$('#script_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		link_name: {
		    minlength: 1,
		    required: true
		},
		script_name: {
		    minlength: 1,
		    required: true
		},
		script_type: {
		    minlength: 1,
		    required: true
		},
		script_loc: {
		    minlength: 1,
		    required: true
		},
		script_order: {
		    minlength: 1,
		    required: true
		},
		script_status: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		link_name: msg,
		script_name: msg1,
		script_type: msg2,
		script_loc: msg3,
		script_order: msg4,
		script_status: msg5
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
    var runValidateLink = function() {
	var msg = $("#errmsg6").html();
	var search_script = $('#search_script');
	var errorHandler1 = $('.errorHandler', search_script);
	$('#search_script').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		link_name: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		link_name: msg
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
	    runValidateScriptAdd();
	    runValidateLink();
	}
    };
}();