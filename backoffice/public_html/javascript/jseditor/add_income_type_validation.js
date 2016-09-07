function addIncomeTypes(f)
{
	var inc_type=f.inc_type.value;
    
    if(check(inc_type))
        {
            inlineMsg('inc_type','You must Enter  new expense...',4);
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

