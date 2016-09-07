var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg2").html();
    var msg1 = $("#error_msg3").html();
    var msg2 = $("#error_msg1").html();

    var runValidatorweeklySelection = function() {
	var searchform = $('#compose');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#compose').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		error.insertAfter($(element).closest('.input-group'));
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		subject: {
		    minlength: 1,
		    required: true
		},
		user_id: {
		    minlength: 1,
		    required: true
		},
		message: {
		    minlength: 1,
		    required: true
		},
		message1: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		subject: msg,
		user_id: msg2,
		message: msg2,
		message1: msg1

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

	}
    };
}();

$(".dropsmalldown").click(function(){
$(this).parent(".btn-group").toggleClass("open");
});