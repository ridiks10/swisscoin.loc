function creditValidation()
{
 var user=document.allot_cre.user.value;

 var amt=document.allot_cre.amt.value;

 var date=document.allot_cre.date.value;

 if(user=="")
     {
         inlineMsg('user','You must Select User name...',2);
            return false;
     }

  if(amt=="")
     {
         inlineMsg('amt','You must Enter amount...',2);
            return false;
     }


  if(date=="")
     {
         inlineMsg('date','You must Enter date...',2);
            return false;
     }

    for (var i = 0; i < amt.length; i++)
    {
        var ch = amt.charAt(i)
        if (i == 0 && ch == ".")
        {
            continue
        }
      if (ch < "0" || ch > "9" )
        {
            inlineMsg('amt','Invalid amount...',2);
            return false
        }
        

    }

     return true;
}
