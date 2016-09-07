function addProductTypes(f)
{
	var product_type=f.product_type.value;
        var service=f.service.value;
        if(check(service))
        {
            inlineMsg('service','You must Select Service...',4);
            return false;
        }

    if(check(product_type))
        {
            inlineMsg('product_type','You must Enter  new Product type...',4);
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

