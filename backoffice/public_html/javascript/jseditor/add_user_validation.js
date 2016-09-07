function addUserValidation(f)
{        var f_name=f.f_name.value;
         var user_name=f.user_name.value;
         var pswd=f.pswd.value;
         var re_pswd =f.re_pswd.value;
         var ph_no=f.ph_no.value;
         var mail_id=f.mail_id.value;
         var address=f.address.value;
         var numberRegex = /^[0-9]+/;
		 var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  //alert(mail_id);

    if(check(f_name))
        {
            inlineMsg('f_name','Enter  first name...',4);
            return false;
        }

    if(check(user_name))
        {
            inlineMsg('user_name','Enter  user name...',4);
            return false;
        }
	

    if(check(pswd))
        {
            inlineMsg('pswd','Enter  password...',4);
            return false;
        }
         if(check(re_pswd))
        {
            inlineMsg('re_pswd',' Re-Enter the password...',4);
            return false;
        }

        if(check1(pswd,re_pswd))
        {
            
            inlineMsg('pswd','Password missmatch.....',4);
            return false;
        }
        if(check(address))
        {
            inlineMsg('address','Enter  Address...',4);
            return false;
        }

   if(check(ph_no))
       {

           inlineMsg('ph_no','Enter  phone number...',4);
            return  false;
       }
       if(!ph_no.match(numberRegex))
	 {

    inlineMsg('ph_no','Invalid Phone number.',2);

    return false;

	}
     if( check(mail_id))
        {
             
            inlineMsg('mail_id','Enter  E-mail id...',4);
            return false;
        }
		if(!mail_id.match(emailRegex)) 
	 {

    inlineMsg('mail_id','invalid mail id.',2);

    return false;
	
	}	
    return true;

}
function check(a)
{ 
    var flg =true;
    var i=0;
    if(a =="")
     {
        return true;
     }
   else{
        while(i<a.length)
        {
         if((a.charAt(i)!=' ' ))
          {
            flg = false;
        
          }
         i++;
       }
      }
   return flg;
  
}

 function check1(a,b){
//alert(re_pswd);
       var flg = false;
       if(a != b)
           flg =true;
       return flg;

   }
   
   
   
   
   
   
   
   //jquery for number only
   
   
   $(document).ready(function(){

    //called when key is pressed in textbox
	$("#ph_no").keypress(function (e)
        // number only validation(mobile)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg3").html("<font color='red'>Digits Only</font>").show().fadeOut("slow");
	    return false;
      }
	});

});


