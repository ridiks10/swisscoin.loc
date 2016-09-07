function passwordMissmatch(f)
{        
    //if(document.f.user_name)
   var user_name=f.user_name1.value;
    //if(document.f.new_pswd)
    var new_pswd=f.new_pswd1.value;
//if(document.f.re_pass)
    var re_pass =f.re_pass1.value;
    //var old_pswd=f.old_pswd.value

    if(check(user_name))
    {
        inlineMsg('user_name1','Enter  user name...',4);

        return false;
    }


    if(check(new_pswd))
    {
        inlineMsg('new_pswd1','Enter  password...',4);

        return false;
    }
    if(check(re_pass))
    {
        inlineMsg('re_pass1',' Re-Enter the password...',4);

        return false;
    }

    if(check1(new_pswd,re_pass))
    {

        inlineMsg('new_pswd1','Password missmatch.....',4);
        
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



function check1(a,b)
{

//alert(re_pswd);
    var flg = false;

    if(a != b)
        flg =true;

    return flg;

}
   
  

   
   

   
  


