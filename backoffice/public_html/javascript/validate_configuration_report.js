/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var ValidateUser = function () {
   
    var msg1=$("#validate_msg1").html();
    var msg2=$("#validate_msg2").html();
    var msg3=$("#validate_msg6").html();
    var msg4=$("#validate_msg4").html();
    var msg5=$("#validate_msg5").html();
    
    var runValidateLetterConfig = function () {
        
        var searchform = $('#report_config');
        var errorHandler1 = $('.errorHandler', searchform);
      //  var successHandler1 = $('.successHandler', form_setting);
       
        $('#report_config').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
             
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
             },
            ignore: ':hidden',
            rules: {
              addr: {
                    minlength: 1,
                    required: true
                },
//                favicon: {
//                    minlength: 1,
//                    required: true
//                },
//                img_logo: {
//                    minlength: 1,
//                    required: true
//                },
               email: {
                    minlength: 1,
                    required: true,
                    email:true
                },
                 phone: {
                    minlength: 10,
                    required: true
                }
            },
            messages: {
                
                addr:"You must enter the address",
//               favicon: msg2,
//                img_logo: msg4,
                email: 
                        {
                            required:msg5,
                             email:"Your email address must be in the format of name@domain.com"
                        },
                phone:msg3
                
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
            runValidateLetterConfig();
           
        }
    };
    
}();

$(document).ready(function()
{	
	
	$("#pin_length").keypress(function (e)  
	{
		//if the letter is not digit then display error and don't type anything
		if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))
		{
			//display error message
			$("#errmsg1").html("Digits Only ").show().fadeOut(1200,0); 
			return false;
		}	
	});
	$("#phone").keypress(function (e)  
	{
		//if the letter is not digit then display error and don't type anything
		if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))
		{
			//display error message
			$("#errmsg2").html("Digits Only..... ").show().fadeOut(1200,0); 
			return false;
		}	
	});
	$("#length").keypress(function (e)  
	{
		//if the letter is not digit then display error and don't type anything
		if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))
		{
			//display error message
			$("#errmsg1").html("Digits Only....").show().fadeOut(1200,0); 
			return false;
		}	
	});
	$("#payout_amount").keypress(function (e)  
	{
		//if the letter is not digit then display error and don't type anything
		if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))
		{
			//display error message
			$("#errmessage1").html("Digits Only....").show().fadeOut(1200,0); 
			return false;
		}	
	});
});


/*
function trim(a)
{
	return a.replace(/^\s+|\s+$/,'');
}

function show_prefix()
{
	var html;
	html = "<td>Username Prefix</strong></td><td><input type='text' name ='prefix' id ='prefix' maxlength='19' title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
	document.getElementById('prefix_div').innerHTML=html;
	document.getElementById('prefix_div').style.display="";	
}

function hide_prefix()
{
	document.getElementById('prefix_div').style.display="none";	
}

function show_tab()
{

	document.getElementById('user_type_div').style.display="";	
	document.getElementById('user_type_div1').style.display="";	
}


function hide_tab()
{

	document.getElementById('user_type_div').style.display="none";	
	document.getElementById('user_type_div1').style.display="none";	
        document.getElementById('prefix_div').style.display="none";	
}



function validate_configuration(form_setting)
{                                                                                
    var tds = form_setting.tds.value;
		
	var pair = form_setting.pair.value;          
    
	var ceiling = form_setting.ceiling.value;
    
 	var service = form_setting.service.value;
	
	if(form_setting.product_status.value=="yes")
	{
		var product_point_value = form_setting.product_point_value.value;
	}
	
	if(form_setting.referal_status.value=="yes")
    {
        var referal_amount = form_setting.referal_amount.value;
    } 
	
	if(pair == "") 
	{var msg;
             msg=$("#validate_msg1").html();
		inlineMsg('pair',msg,4);
		return false;
	}
        if(pair < '0') 
	{
            var msg;
             msg=$("#validate_msg7").html();
		inlineMsg('pair',msg,4);
		return false;
	}
	
	if(ceiling == "") 
	{
            var msg;
             msg=$("#validate_msg2").html();
		inlineMsg('ceiling',msg,4);
		return false;
	}
	
	if(service == "") 
	{
            var msg;
             msg=$("#validate_msg3").html();
		inlineMsg('service',msg,4);
		return false;
	} 
	
	if(tds == "") 
	{
            var msg;
             msg=$("#validate_msg4").html();
		inlineMsg('tds',msg,4);
		return false;
	}

	if(product_point_value == "") 
	{
            var msg;
             msg=$("#validate_msg5").html();
		inlineMsg('product_point_value',msg,4);
		return false;
	}

	/*if(pair_value == "") 
	{
		inlineMsg('pair_value','You must enter Pair Value...',4);
		return false;
	}*/
  
/*	if(referal_amount == "")
	{
            var msg;
             msg=$("#validate_msg6").html();
		inlineMsg('referal_amount',msg,4);
		return false;
	}

    return true;

}

$(document).ready(function()

{


$("#pair").keypress(function (e)  

	{


	  //if the letter is not digit then display error and don't type anything

	  if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))

	  {

		//display error message

		$("#errmsg4").html("Digits Only ").show().fadeOut(1200,0); 

	   return false;

      }	

	});
$("#ceiling").keypress(function (e)  

	{


	  //if the letter is not digit then display error and don't type anything

	  if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))

	  {

		//display error message

		$("#errmsg5").html("Digits Only ").show().fadeOut(1200,0); 

	   return false;

      }	

	});
$("#service").keypress(function (e)  

	{


	  //if the letter is not digit then display error and don't type anything

	  if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))

	  {

		//display error message

		$("#errmsg6").html("Digits Only ").show().fadeOut(1200,0); 

	   return false;

      }	

	});
$("#tds").keypress(function (e)  

	{


	  //if the letter is not digit then display error and don't type anything

	  if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))

	  {

		//display error message

		$("#errmsg7").html("Digits Only ").show().fadeOut(1200,0); 

	   return false;

      }	

	});
$("#product_point_value").keypress(function (e)  

	{


	  //if the letter is not digit then display error and don't type anything

	  if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))

	  {

		//display error message

		$("#errmsg8").html("Digits Only ").show().fadeOut(1200,0); 

	   return false;

      }	

	});
$("#referal_amount").keypress(function (e)  

	{


	  //if the letter is not digit then display error and don't type anything

	  if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57))

	  {

		//display error message

		$("#errmsg9").html("Digits Only ").show().fadeOut(1200,0); 

	   return false;

      }	

	});
        });

function validate_letter_config(form_setting)
{

	if(document.form_setting.company_name)
    {
        var company_name = form_setting.company_name.value;
    }

	if(document.form_setting.company_add)
    {
        var company_add = form_setting.company_add.value;
    }

	if(document.form_setting.txtDefaultHtmlArea)
    {
        var txtDefaultHtmlArea = form_setting.txtDefaultHtmlArea.value;
    }

	if(document.form_setting.product_matter)
    {
		var product_matter = form_setting.product_matter.value;
    }
	
	if(document.form_setting.place)
	{
		var place = form_setting.place.value;
	}
	
	if(company_name == "") 
	{var msg;
             msg=$("#validate_msg1").html();
		inlineMsg('company_name',msg,4);
		return false;
	}

	if(company_add == "") 
	{
            var msg;
             msg=$("#validate_msg2").html();
		inlineMsg('company_add',msg,4);
		return false;
	}

	if(txtDefaultHtmlArea == "") 
	{
            var msg;
             msg=$("#validate_msg3").html();
		inlineMsg('txtDefaultHtmlArea',msg,4);
		return false;
	}

	if(product_matter == "")
	{
            var msg;
             msg=$("#validate_msg4").html();
		inlineMsg('product_matter',msg,4);
		return false;
	}

   /*if(pair_value == "") 
    {
		inlineMsg('pair_value','You must enter Pair Value...',4);
		return false;
	}*/
	
/*	if(place == "") 
    {
        var msg;
             msg=$("#validate_msg5").html();
		inlineMsg('place',msg,4);
		return false;
	}
	
    return true;
}
/* ****************** edited on 2/3/2011 starts ****************************** */
/*function validate_admin_referal(admin_referal_form)
{
	 var user_name = admin_referal_form.user_name.value;
         var msg;
          msg=$("#errmsg1").html();
	 if( user_name == "" )
	 {
		inlineMsg('user_name',msg,4);
		return false;
	 }
	 return true;
}
/* ****************** edited on 2/3/2011 ends ****************************** */

/*function validate_pin_configuration(pin_config_form)
{   
	var pin_length = pin_config_form.pin_length.value;
    var pin_maxcount = pin_config_form.pin_maxcount.value;
	
	if( pin_length == "")
	{var msg;
             msg=$("#validate_msg1").html();
		inlineMsg('pin_length',msg,4);
		return false;
	}
	
	if( pin_length < 6 || pin_length > 25)
	{
		inlineMsg('pin_length','E-Pin Length should between 6 and 25...',4);
		return false;
	}
	
	if( pin_maxcount == "")
	{
		inlineMsg('pin_maxcount','You must enter maximum pin count...',4);
		return false;
	}
	
	return true;
}


	

function validate_username_configuration(username_config_form)
{                                                                      
    var length = username_config_form.length.value;
    var prefix = username_config_form.prefix.value;
	
	if( length == "")
	{
            var msg;
             msg=$("#validate_msg1").html();
		inlineMsg('length',msg,4);
		return false;
	}
	
	if( length < 6 || length > 10)
	{
            var msg;
             msg=$("#validate_msg2").html();
		inlineMsg('length',msg,4);
		return false;
	}
	
	if(username_config_form.prefix_status[0].checked)
	{
		if( prefix == "")
		{
                    var msg;
             msg=$("#validate_msg3").html();
			inlineMsg('prefix',msg,4);
			return false;
		}
		
		if(prefix.length <3 || prefix.length>15)
		{
                    var msg;
             msg=$("#validate_msg4").html();
			inlineMsg('prefix',msg,4);
			return false;
		}
	}
	
	return true;
}


function validate_site_config(site_config_form)
{
	var regNum = /^ *[0-9]+ *$/;
	var regEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	
	var co_name = site_config_form.co_name.value;
	var img_logo = site_config_form.img_logo.value;
	var email = site_config_form.email.value;
	var phone = site_config_form.phone.value;
	var icon = site_config_form.favicon.value;
	im = new Image();
	im.src = site_config_form.img_logo.value;
	
	if(co_name=="")
	{var msg;
             msg=$("#validate_msg1").html();
		inlineMsg('co_name',msg,4);
		return false;
	} 
	
	var ico = icon.substring(icon.lastIndexOf('.') + 1);
	
	if(ico !="")
	{
		if(ico != "ico")
		{var msg;
             msg=$("#validate_msg2").html();
			inlineMsg('favicon',msg,4);
			return false;
		} 
	}
	
	var ext = img_logo.substring(img_logo.lastIndexOf('.') + 1);
	
	if(img_logo !="")
	{
		if(ext != "png" && ext != "PNG" && ext != "JPEG" && ext != "jpeg" && ext != "jpg" && ext != "JPG")
		{var msg;
             msg=$("#validate_msg3").html();
			inlineMsg('img_logo',msg,4);
			return false;
		} 
	}
	
	
	if(email=="")
	{	var msg;
             msg=$("#validate_msg4").html();
		inlineMsg('email',msg,4);
		return false;
	}
	if(!regEmail.test(email))
	{var msg;
             msg=$("#validate_msg5").html();
		inlineMsg('email',msg,4);
		return false;
	}
	if(phone=="")
	{var msg;
             msg=$("#validate_msg6").html();
		inlineMsg('phone',msg,4);
		return false;
	}
	if(!regNum.test(phone))
	{var msg;
             msg=$("#validate_msg7").html();
		inlineMsg('phone',msg,4);
		return false;
	}
	return true;
}


function getUsernamePrefix()
{
	var html;
	var path_root =document.username_config_form.path_root.value;
	var getUsernamePrefix=path_root+"admin/configuration/getUsernamePrefix";
	$.post(getUsernamePrefix,function(data)
	{
		data = trim(data);
		if(data != "")
		{
			html = "<td>Username Prefix</strong></td><td><input type='text' name ='prefix' id ='prefix' maxlength='19' value='"+data+"'title='This is the prefix of user name. It should contain 3 to 15 characters.'><span id='errmsg1'></span></td>";
			document.getElementById('prefix_div').innerHTML=html;
			document.getElementById('prefix_div').style.display="";	
		}			
	});
}
*/


//============added by Aparna============//
 /*$(document).ready(function() {
     var msg = $("#validate_msg1").html();
     var msg4 = $("#validate_msg4").html();
     var msg7 = $("#validate_msg7").html();
     
     
   
        $("#report_config").validate({
            submitHandler:function(form) {
                SubmittingForm();
            },
            rules: {
               addr: {
                    minlength: 1,
                    required: true
                },
                email: {
                    minlength: 1,
                    required: true,
                    email:true
                },
                phone: {
                    minlength: 10,
                    required: true
                    
                }
            },
            messages: {
                addr:msg,
                email: msg4,
                phone: msg7,
                
            }
            
            
        });
    });
*/


//==========code ends====================//