/*function validate_menu_item(main_menu_add)
 {

  var link = main_menu_add.link.value;
   var text = main_menu_add.text.value;
   var menu_id = main_menu_add.menu_id.value;

  if(link == "") {
 var msg;
 msg=$("#validate_msg1").html();
  inlineMsg('link',msg,4);

  return false;

  }
  if(text == "") {
var msg;
msg=$("#validate_msg2").html();
  inlineMsg('text',msg,4);

  return false;

  }

if(menu_id == "") {
var msg;
msg=$("#validate_msg3").html();
  inlineMsg('menu_id',msg,4);

  return false;

  }
   return true;
}*/


//============================================= 
 $(document).ready(function() {
     var msg = $("#error_msg1").html();
    var msg1 = $("#error_msg2").html();
    var msg2 = $("#error_msg3").html();
    var msg3 = $("#error_msg4").html();
     
     
   
        $("#main_menu_add").validate({
            submitHandler:function(form) {
                SubmittingForm();
            },
            rules: {
               link: {
                   
                    required: true
               
                },
                text: {
                   
                    required: true
               
                },
                refrence_id:{
                   
                    required: true
               
                }
                
            },
            messages: {
                link:msg3,
                text:msg3,
                refrence_id:msg3
                
                
            }
            
            
        });
    });
    
    
    //-------------------






