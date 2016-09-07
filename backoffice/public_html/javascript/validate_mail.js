function validate_mailbox(compose_admin)

{



    var subject = compose_admin.subject.value;

    var message = compose_admin.message.value;

    var msg = "";

    if (subject == "") {

        msg = $("#error_msg1").html();
        inlineMsg('subject', msg, 4);

        return false;

    }

    if (message == "") {

        msg = $("#error_msg2").html();
        inlineMsg('message', msg, 4);

        return false;

    }

    return true;

}

function trim(a)
{

    return a.replace(/^\s+|\s+$/, '');
}

function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp = false;
    try {
        xmlhttp = new XMLHttpRequest();
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e1) {
                xmlhttp = false;
            }
        }
    }

    return xmlhttp;
}


function getUsername(username, mail_message)
{
    document.getElementById("user_id").value = username;
    document.getElementById("subject").value = mail_message;
}
//validate Mailbox Admin

function validate_mailbox_admin(compose)

{



    var subject = compose.subject.value;

    var message = compose.message.value;

    var status_mul = compose.status_mul.checked;
//alert(status_mul);

    if (status_mul) {
        var user_id = compose.user_id.value;
    }

    var msg = "";
    if (status_mul) {

        if (user_id == "") {

            msg = $("#error_msg1").html();
            inlineMsg('user_id', msg, 4);

            return false;

        }
    }



    if (subject == "") {

        msg = $("#error_msg2").html();
        inlineMsg('subject', msg, 4);

        return false;

    }

    if (message == "") {

        msg = $("#error_msg3").html();
        inlineMsg('message', msg, 4);

        return false;

    }

    return true;

}


//validate reply mail-------

function validate_replay_message(reply_mail_to)
{

    var user_id = reply_mail_to.user_id.value;

    var subject = reply_mail_to.subject.value;

    var message = reply_mail_to.message.value;

    var msg = "";


    if (subject == "") {

        msg = $("#error_msg1").html();
        inlineMsg('subject', msg, 4);

        return false;

    }

    if (message == "") {

        msg = $("#error_msg2").html();
        inlineMsg('message', msg, 4);

        return false;

    }

    return true;


}

function show_text(val)
{
    if (val == "multiple")
    {
 document.getElementById('user_div').style.display = "block";
//        var html;
//        html = " <input type='text' class='form-control' name='user_id' id='user_id' placeholder='UserName' onKeyUp=\"ajax_showOptions(this,'getCountriesByLetters',event)\" autocomplete='Off' />";
//
//
//        document.getElementById('user_div').innerHTML = html;
//        document.getElementById('user_div').style.display = "";
    }
    else {
        //document.getElementById('user_div').style.display = "none";
        document.getElementById('user_div').style.display = "none";
    }


}

function show_text_email()
{
    var html;
    html = " <label class='col-sm-2 control-label' for='user_id'>E-mail ID<span class='symbol required'></span></label><div class='col-sm-6'><input tabindex='1' type='text' id='email_id' name='email_id' onKeyUp=\"ajax_showOptions(this,'getCountriesByLetters',event)\" autocomplete='Off' /></div>";
    document.getElementById('user_div').innerHTML = html;
    document.getElementById('user_div').style.display = "";
}

function hid_text()
{
    document.getElementById('user_div').style.display = "none";
}
function showSmtp(status) {
    if (status)
    {
        document.getElementById('pair').style.display = "block";
    }
    else
    {
        document.getElementById('pair').style.display = "none";
    }
}
//});





var ValidateMail = function() {
//alert('kkkkkk');
    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
    var msg4 = $("#error_msg5").html();
    var msg5 = $("#error_msg6").html();
    var runValidateFundSelection = function() {
	var searchform = $('#compose');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#compose').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		subject: {
		    minlength: 1,
		    required: true
		},
		message1: {
		    minlength: 1,
		    required: true
		},
	
//		amount: {
//		    minlength: 1,
//		    required: true
//		}

	    },
	    messages: {
		subject: msg,
		message1: msg,
//		pswd: msg2,
//		to_user_name: msg3,
//		amount: msg4

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
	    runValidateFundSelection();
	    
	}
    };
    }();

