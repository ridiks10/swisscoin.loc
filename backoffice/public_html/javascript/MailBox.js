
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
function deleteMessage(id, row, type, path_root)
{
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteMessage/" + id + "/" + type;
    }
}
function deleteSentMessage(id, row, type, path_root)
{
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteSentMessage/" + id + "/" + type;
    }
}
function deleteDownlineMessages(id, row, type, path_root)
{
    
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteDownlineSendMessage/" + id + "/" + type;
    }
}
function deleteFromMessage(id, row, type, path_root)
{
   
    var confirm_msg = $("#confirm_msg").html();
    if (confirm(confirm_msg))
    {
        document.location.href = path_root + "/mail/deleteDownlineFromMessage/" + id + "/" + type;
    }
}


function getOneMessage(msg_id, user_id, type, path_root)
{
    // alert(path_root);
    //var path_root=document.path.value;
    var strURL = path_root + "/mail/getMessage/" + msg_id + "/" + user_id + "/" + type;
//alert(strURL);
    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"			
                if (req.status == 200)
                {

                    // document.getElementById('text_message').innerHTML=trim(req.responseText);
                    document.getElementById('username' + msg_id).style.color = "#C48189";
                    document.getElementById('suject' + msg_id).style.color = "#C48189";
                    document.getElementById('date' + msg_id).style.color = "#C48189";
                }
                else
                {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }

}

function view_popup(id, row, type, path_root)
{

    var strURL = path_root + 'payout/user_details/' + id;

    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"	

                if (req.status == 200)
                {

                    document.getElementById('div1').innerHTML = trim(req.responseText);

                    document.getElementById('transaction').style.visibility = 'visible';


                }
                else
                {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }
}
function view_news_popup(id, row, type, path_root)
{

    var strURL = path_root + 'news/show_news/' + id;

    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"	

                if (req.status == 200)
                {

                    document.getElementById('div1').innerHTML = trim(req.responseText);

                    document.getElementById('transaction').style.visibility = 'visible';


                }
                else
                {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }
}

function getleadetails(id, path_root)
{

    // alert(path_root);
    //var path_root=document.path.value;
    var strURL = path_root + "/member/getleads/" + id;
//alert(strURL);
    var req = getXMLHTTP();
    if (req) {

        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                // only if "OK"			
                if (req.status == 200)
                {

                    document.getElementById('text_message').innerHTML = trim(req.responseText);
                }
                else
                {
                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                }
            }
        }
        req.open("GET", strURL, true);
        //alert(strURL);
        req.send(null);
    }

}

var ValidateUser = function() {

    // function to initiate Validation Sample 1
    var msg = $("#error_msg").html();
    var msg1 = $("#error_msg1").html();
    var msg2 = $("#error_msg2").html();
    var msg3 = $("#error_msg3").html();
    var msg4 = $("#error_msg4").html();
    var msg5 = $("#error_msg5").html();
    var runValidatorweeklySelection = function() {
        var searchform = $('#compose_admin');
        var errorHandler1 = $('.errorHandler', searchform);
        $('#compose_admin').validate({
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
                message: {
                    minlength: 1,
                    required: true
                }

            },
            messages: {
                subject: msg,
                message: msg1

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
    /*   var runValidatordailySelection = function() {
     var searchform = $('#change_pass_common');
     var errorHandler1 = $('.errorHandler', searchform);
     $('#change_pass_common').validate({
     errorElement: "span", // contain the error msg in a span tag
     errorClass: 'help-block',
     errorPlacement: function(error, element) { // render error placement for each input type
     
     error.insertAfter(element);
     // for other inputs, just perform default behavior
     },
     ignore: ':hidden',
     rules: {
     user_name_common: {
     minlength: 1,
     required: true
     },
     new_pwd_common: {
     minlength: 1,
     required: true
     },
     confirm_pwd_common: {
     minlength: 1,
     required: true,
     equalTo: "#new_pwd_common"
     }
     },
     messages: {
     user_name_common: msg5,
     new_pwd_common: msg1,
     confirm_pwd_common: msg3
     
     
     
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
     };*/
    return {
        //main function to initiate template pages
        init: function() {
            runValidatorweeklySelection();

        }
    };
}();