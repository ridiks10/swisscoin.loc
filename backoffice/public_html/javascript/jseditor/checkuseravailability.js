

function trim(s)
	{
	  return s.replace(/^\s+|\s+$/,'');
	}
$(document).ready(function()

{
var post_path =$("#path_root").val()+"user/check_username_availability";
var view_path = $("#view_path").val()+"images/";
		$("#user_name").blur(function()
	{
	
   var error=0;

   
   
   
   
   
   
   
     if($('#user_name').val() =="") 

	{

		$("#messagebox").removeClass();

		$("#messagebox").addClass('messageboxerror');

		$("#messagebox").html('<img align="absmiddle"\n\
 src="../application/views/images/Error.png" /> Invalid Username...').show().fadeTo(1900,1);

		error=1;


	}
   
   
   
	if(error!=1)

	{

		//remove all the class add the messagebox classes and start fading

		$("#messagebox").removeClass();

		$("#messagebox").addClass('messagebox');

		$("#messagebox").html('<img align="absmiddle" \n\
src="../application/views/images/loader.gif" /> Checking username...').show().fadeTo(1900,1);

		//check the username exists or not from ajax

		$.post(post_path,{ username:$('#user_name').val()} ,function(data)

        {
            var str =data.toString();
		  if(/*str.serch("no")!=-1*/trim(data)=="no") //if username not avaiable

		  {

		  	$("#messagebox").fadeTo(200,0.1,function() //start fading the messagebox

			{ 

			  //add message and change the class of the box and start fading

			   $(this).removeClass();
 $(this).addClass('messageboxok');
			  //$(this).addClass('messageboxerror');
 $(this).html('<img align="absmiddle" \n\
src="../application/views/images/accepted.png" />Username Available...').show().fadeTo(1900,1);

			 // $(this).html('<img align="absmiddle" \n\
//src="../application/views/images/Error.png" />User name Already exists...').show().fadeTo(1900,1);

			  //disable();
return true;
			});		
  
          }

		  else

		  {

		  	$("#messagebox").fadeTo(200,0.1,function()  //start fading the messagebox

			{ 

			  //add message and change the class of the box and start fading

			  $(this).removeClass();
  $(this).addClass('messageboxerror');
			 // $(this).addClass('messageboxok');
$(this).html('<img align="absmiddle" \n\
src="../application/views/images/Error.png" />User name Already exists...').show().fadeTo(1900,1);
			  //$(this).html('<img align="absmiddle" \n\
//src="../application/views/images/accepted.png" />Username Available...').show().fadeTo(1900,1);

			  //enable();
 return false;

			});
                         

		  }

		  //disable();

        });
		
     }
		
		});

		return false;
		
			});