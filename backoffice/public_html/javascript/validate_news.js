
function edit_events(id, root)

{
    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/event/edit/' + id;

    }



}

//Delete News

function delete_events(id, root)

{
    var confirm_msg = $('#confirm_msg2').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/event/delete/' + id;

    }



}
function edit_system(id, root)

{
    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/system/edit/' + id;

    }



}

//Delete News

function delete_system(id, root)

{
    var confirm_msg = $('#confirm_msg2').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/system/delete/' + id;

    }



}
function edit_quote(id, root)

{
    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/motivation/edit/' + id;

    }



}

//Delete News

function delete_quote(id, root)

{
    var confirm_msg = $('#confirm_msg2').html();
    if (confirm(confirm_msg))

    {

	document.location.href = root + 'news/motivation/delete/' + id;

    }



}

var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();

    var runValidatorweeklySelection = function() {
	var searchform = $('#upload_news');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#upload_news').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		news_title: {
		    minlength: 1,
		    required: true
		},
		news_desc: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		news_title: msg,
		news_desc: msg1

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

var ValidateNewsUpload = function() {

    // function to initiate Validation Sample 1
    var msg = $("#validate_msg1").html();
    var msg1 = $("#validate_msg2").html();
    var runValidateNewsUpload = function() {
	var searchform = $('#upload_materials');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#upload_materials').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		file_title: {
		    minlength: 1,
		    required: true
		},
		upload_doc: {
		    minlength: 1,
		    required: true
		}
	    },
	    messages: {
		file_title: msg,
		upload_doc: msg1
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
	    runValidateNewsUpload();

	}
    };
}();