
//==================Ajax for getting Balance amount=========================================//

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



function getAmountLeg()
{

    var root = document.fund_form.path.value;
    var user_id = document.getElementById('user_name').value;
    if (user_id == null || user_id == "" || user_id == "/")
    {
	var user_id = 0;
    }
    if(user_id)
    {
       
    var strURL = root + "/ewallet/getLegAmount/" + user_id;
    var req = getXMLHTTP();
    if (req) {
	req.onreadystatechange = function() {
	    if (req.readyState == 4) {
		if (req.status == 200) {
		    document.getElementById('user_amount_div').innerHTML = trim(req.responseText);
		} else {
		    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
		}
	    }
	}
	req.open("GET", strURL, true);
	//alert(strURL);
	req.send(null);
    }
}
}
//===========================================================//


var ValidateFund = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
    var msg4 = $("#error_msg5").html();
    var msg5 = $("#error_msg6").html();
    var runValidateFundSelection = function() {
	var searchform = $('#fund_form');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#fund_form').validate({
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
    var runValidateTranPassword = function() {
	var searchform = $('#fund_transfer_form');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#fund_transfer_form').validate({
	    errorElement: "span", // contain the error msg in a span tag
	    errorClass: 'help-block',
	    errorPlacement: function(error, element) { // render error placement for each input type

		error.insertAfter(element);
		// for other inputs, just perform default behavior
	    },
	    ignore: ':hidden',
	    rules: {
		
		pswd: {
		    minlength: 1,
		    required: true
		}

	    },
	    messages: {
		
		pswd: msg2,
		

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
    var runValidateFundAdminSelection = function() {
	var searchform = $('#fund_admin');
	var errorHandler1 = $('.errorHandler', searchform);
	$('#fund_admin').validate({
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
	    runValidateFundAdminSelection();
	    runValidateTranPassword();
	}
    };
}();

$(document).ready(function()
{
    $("#amount").keypress(function(e)
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
	    $("#errmsg1").html("Digits Only ").show().fadeOut(1200, 0);
	    return false;
	}
    });

    return true;


});
