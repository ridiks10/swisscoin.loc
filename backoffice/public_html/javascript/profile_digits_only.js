$(document).ready(function()
{
    var msg = "";
 $("#pin").keypress(function (e)  
	{
		//if the letter is not digit then display error and don't type anything
		if( e.which!=8 && e.which!=0 &&  (e.which<48 || e.which>57) && e.which != 46)
		{
			//display error message
                        msg = $("#validate_msg").html();
			$("#errmsg3").html(msg).show().fadeOut(1200,0); 
			return false;
		}	
	});
});        