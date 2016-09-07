function addServiceTypes(f)
{
	var service_type=f.service_type.value;

    if(check(service_type))
        {
            inlineMsg('service_type','You must Enter  new Service type...',4);
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


