function addVendorDetails(f)
{
	var vendername=f.vendername.value;
        var orgname=f.orgname.value;
        var  vendermail=f.vendermail.value;
        var venderphone=f.venderphone.value;
        var vendermobile=f.vendermobile.value;
        var venderaddress=f.venderaddress.value;
		
			var numberRegex = /^[0-9]+/;
			var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
		
    if(check(vendername))
        {
            inlineMsg('vendername','You must Enter Vendor Name...',4);
            return false;
        }
        if(orgname == "" ||orgname == " " ||orgname == "  " ||orgname == "    ")
        {
            inlineMsg('orgname','You must Enter Organization  Name...',4);
            return false;
        }

        if(check(vendermail))
        {
            inlineMsg('vendermail','Enter Mail Id...',4);
            return false;
        }
		
		
		
		if(!vendermail.match(emailRegex)) 
	 {

    inlineMsg('vendermail','invalid mail id.',2);

    return false;
	
	}	

        if(check(venderphone))
        {
            inlineMsg('venderphone','Enter phone Number...',4);
            return false;
        }
		
		
		if(!venderphone.match(numberRegex)) 
	 {

    inlineMsg('venderphone','invalid phone number.',2);

    return false;
	
	}	
	

         if( check(vendermobile))
        {
            inlineMsg('vendermobile','Enter Mobile Number...',4);
            return false;
        }
		
		
		
		if(!vendermobile.match(numberRegex)) 
	 {

    inlineMsg('vendermobile','invalid phone number.',2);
	

    return false;
	
	}	
	

         if( check(venderaddress))
        {
            inlineMsg('venderaddress','Enter Address...',4);
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
         if((a.charAt(i)!=' '))
          {
            flg = false;

          }
         i++;
       }
      }
   return flg;
}

