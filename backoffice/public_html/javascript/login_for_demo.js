
function trim(s)
	{
	  return s.replace(/^\s+|\s+$/,'');
	}
        
$(document).ready(function()
{
	$("#login_form").submit(function()
	{//alert("hello");
             var post_path =$("#path_root").val()+"login/validate_login";
             var image =$("#view_image").val()+"images/loader.gif"

// alert(post_path);
                var login_status=document.login_form.login_status_hid.value;
                 // alert(login_status);
	          if(login_status=="user")
                      {
                           var admin_username=document.login_form.admin_username.value;
                           //alert(admin_username);
                           document.login_form.admin_username_hid.value=admin_username;
                      }
                //remove all the class add the messagebox classes and start fading
		$("#loginmsg").removeClass().addClass('messageboxok').html('<img align="absmiddle" src='+image+' /> Validating.......').show().fadeTo(1900,1);
		//check the username exists or not from ajax\
           
		$.post(post_path,{ user_name:$('#user_name').val(),password:$('#password').val(),login_status_hid:$('#login_status_hid').val(),admin_username_hid:$('#admin_username_hid').val(),rand:Math.random() } ,function(data)
        {
           //alert('#'+data+'#');
		  if(trim(data)=='binary') //if correct login detail
		  {
		  	$("#loginmsg").fadeTo(200,0.1,function()  //start fading the messagebox
			{
			  //add message and change the class of the box and start fading
	$(this).html('Logging in...........').removeClass().addClass('messageboxok').fadeTo(900,1,
              function()
			  {
			  
			  //alert('gggggg');
			  	 //redirect to secure page
				 document.location=$("#path_root").val();
				 
			  });

			});
		  }
		  else  if(trim(data)=='matrix') //if correct login detail
		  {
		  //alert(data);
		  
		  	$("#loginmsg").fadeTo(200,0.1,function()  //start fading the messagebox
			{
			  //add message and change the class of the box and start fading
			  $(this).html('Logging in...........').removeClass().addClass('messageboxok').fadeTo(900,1,
              function()
			  {
			      
			  	  document.location=$("#path_root_matrix").val();
				
			  });

			});
		  }
		  else if(trim(data)=='no')
		  {
		  	$("#loginmsg").fadeTo(200,0.1,function() //start fading the messagebox
			{
			  //add message and change the class of the box and start fading
			  $(this).html('Incorrect User Name or Password...').removeClass().addClass('messageboxerror').fadeTo(900,1);
			});
          }


		else
		  {
		  	$("#loginmsg").fadeTo(200,0.1,function() //start fading the messagebox
			{
			  //add message and change the class of the box and start fading
			  $(this).html('Check database connectivity...').removeClass().addClass('messageboxerror').fadeTo(900,1);
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

	$("#submit").click(function()
	{

	//alert('submmit');
		$("#login_form").trigger('submit');
	});

		$("#username").blur(function()
	{
		document.login_form.password.focus();
		//console.log('niju');
	});



	});
