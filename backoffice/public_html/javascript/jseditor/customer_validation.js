

function validateCustomer(f)
{
var custname=f.custname.value;

var orgname = f.orgname.value;

var country = f.country.value;

var mobile = f.mobile.value;

var phone=f.phone.value;

var mail = f.mail.value;

var service = f.service.value;





var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;


   
 

	
    if(custname == "" ||custname == " " ||custname == "  " ||custname == "    ")
        {
         
            inlineMsg('custname','You must Enter Your name...',4);
            return false;
        }
		

	if(orgname=="" ||orgname==" " ||orgname=="  " ||orgname=="   " ||orgname=="     " )
	{
		inlineMsg('orgname','You must Enter your Organization name....',4);
		return false;
	}

     


	if(country=="")
   {
   inlineMsg('country','Select country..',4);
            return false;
   }

 


	
	if(mobile == "" || mobile== "" || mobile  == " " ||mobile == "    ")
        {
            inlineMsg('mobile_id','You must Enter Your Mobile phone number...',4);
            return false;
        }
	
		

	 
	if(phone=="" ||phone==" " ||phone=="  " ||phone=="   " ||phone=="     " )
	{
		inlineMsg('phone','You must Enter your phone number....',4);
		return false;
	}
	
	
		
	
	
	
	
	
	

	
	
	
	if(mail=="" ||mail==" " ||mail=="  " ||mail=="   " ||mail=="     " )
	{
		inlineMsg('mail','You must Enter your mail Id....',4);
		return false;
	}

		if(!mail.match(emailRegex)) 
	 {

    inlineMsg('mail','invalid mail id.',2);

    return false;
	
	}

 /*
 if(service=="")
   {
   inlineMsg('service','Select service..',4);
            return false;
   }
*/
	





  
	
		
		
return true;

}












//jquery for number only text boxes


	$(document).ready(function(){

    //called when key is pressed in textbox
	$("#mobile_id").keypress(function (e)
        // number only validation(mobile)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg2").html("Digits Only").show().fadeOut("slow");
	    return false;
      }
	});




	$("#pincode_id").keypress(function (e)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg1").html("<font color='red'>Digits Only</font>").show().fadeOut("slow");
	    return false;
      }
	});




  //called when key is pressed in textbox
	$("#phone").keypress(function (e)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg3").html("<font color = 'red' >Digits Only</font>").
                    show().fadeOut("slow");
	    return false;
      }
	});




});


