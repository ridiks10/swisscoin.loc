
$(document).ready(function()
{
    var msg1 = "<p style='color:rgb(185, 74, 72);'>This field is required. </p>";
    var msg2 = $("#validate_msg13").html();
    var msg3 = $("#validate_msg12").html();
    var msg4 = $("#validate_msg14").html();
    var msg15 = "<p style='color:rgb(185, 74, 72);'>please enter Correct youtube/vimeo link. </p>";
    var msg16="";
    $("#no").click(function() {
        $("#prefix_div").hide("fast");

    });


    $("#upload_compensation").submit(function()
    {
        var flag=0;
        
        //if the letter is not digit then display error and don't type anything
        if (document.getElementById('compensation_desc').value=="")
        {
            flag=1;
        }
        if(flag==1){
            //display error message
            $("#errmsg1").html(msg1).show();
            return false;
        }
    });
    
     $("#webinar-form").submit(function()
    {
        var flag=0;
        
        //if the letter is not digit then display error and don't type anything
        
        if (document.getElementById('txtDefaultHtmlArea').value=="")
        {
            flag=1;
        }
        if(flag==1){
            //display error message
            $("#errmsg1").html(msg1).show();
            return false;
        }
        if(flag==0){
             $("#errmsg1").html(msg16).show();
        }
        
    });
//    $("#webinar-form").submit(function ()
//    {
//        flag = 1;
//        url = document.getElementById('video').value;
//        if (url.match(/^http:\/\/(?:.*?)\.?(youtube|vimeo)\.com\/(embed\?[^#]*v=(\w+)|(\d+)).+$/))
//        {
//            flag = 0;
//        }
//        if (flag == 1) {
//            $("#errmsg15").html(msg15).show();
//            return false;
//        }
//    });

    
    return true;

});

function trim(a)
{
    return a.replace(/^\s+|\s+$/, '');
}


//=====================================================================//
$(document).ready(function() {
    var msg1 = $("#validate_msg1").html();
    var msg2 = $("#validate_msg2").html();
    var msg3 = $("#validate_msg3").html();
    var msg4 = $("#validate_msg4").html();
    var msg5 = $("#validate_msg5").html();
    var msg6 = $("#validate_msg6").html();
    $("#webinar-form").validate({
        submitHandler: function(form) {
            SubmittingForm();
        },
        rules: {
            date: {
                required: true,
                date: true
            },
            url: {
               
                required: true,
                url: true
            },
            user_name: {
                
                maxlength: 50,
                required: true
            }  ,
//             password: {
//               
//                maxlength: 50,
//                required: true
//                
//            }  , 
            topic: {
                maxlength: 50,
                required: true
            }  , 
            txtDefaultHtmlArea: {
               
                required: true
                
            } , 
            video: {
               
                required: true
                
            } ,  
            userfile: {
               
                required: true
                
            }   
        },
        messages: {
            url: 'invalid url format',
            user_name: 'user name required',
//            password: 'password required',
            topic: 'topic required',
            txtDefaultHtmlArea: 'description required',
            date:{
                date:'please enter date in correct formate(yyyy-mm-dd)',
                required:'date in required',
            },
            video:'embeded link required',
            userfile:'webinar image required',
//            video:{
//                url:'please enter video link in correct  url format',
//            }
        }
    });
});
$(document).ready(function() {
 
    $("#upload_workshop").validate({
        submitHandler: function(form) {
            SubmittingForm();
        },
        rules: {
            workshop_title: {
                required: true,
                minlength: 1
            },
            userfile: {
                required: true,
            },
            link: {
                required: true,
                url: true
            }
        },
        messages: {
            workshop_title:'title is required..',
            userfile:'please select an image..',
            link:{
                url:'please enter correct url format',
            }
        }
    });
});
$(document).ready(function() {

    $("#upload_compensation").validate({
        submitHandler: function(form) {
            SubmittingForm();
        },
        rules: {
            compensation_title: {
               
                required: true,
                minlength: 1,
                maxlenth: 50

            },
//            link: {
//                required: true,
//                url: true
//            },
//            compensation_desc: {
//                minlength:1,
//                required: true
//            },
           
        },
        messages: {
            compensation_title:'Title is required',
           // compensation_desc:'Description is required',
            userfile:'Image is required',
//            link:{
//                url:'please enter correct url format',
//            }
        }
    });
});