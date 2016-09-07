

function trim(s)
	{
	  return s.replace(/^\s+|\s+$/,'');
	}
$(document).ready(function()
{


	$("#login_form").submit(function()
	{
            var post_path =$("#path_root").val()+"login/validate_login";
            //alert(post_path);
            // currnt_url =location.href;
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('messagebox').text('Validating....')
                .fadeIn(1000);
		//check the username exists or not from ajax
                
		$.post(post_path,{user_name:$('#username').val(),password:$('#password').val(),
                    rand:Math.random()} ,function(data)
        {
		  if(trim(data)=='yes') //if correct login detail
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in.....').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 //document.location='secure.php';
				 document.location='../home/login_home';
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Invalid User Name or Password...').
                              addClass('messageboxerror').fadeTo(900,1);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	//now call the ajax also focus move from 
	$("#password").blur(function()
	{
		$("#login_form").trigger('submit');
	});
});
