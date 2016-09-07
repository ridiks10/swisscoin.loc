function validate_add_employee(insert)
{
 
var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
var numberRegex = /^[0-9]+/;
var tomatch=/^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/;


var ename   = insert.empname.value;
var gender  = insert.gender.value;
var desig   = insert.designation.value;
var d_o_b   = insert.d_o_b.value;
var d_o_j   = insert.d_o_j.value;
var address = insert.address.value;
var mobile  = insert.mobile.value;
var land    = insert.land.value;
var email   = insert.email.value;




if(ename=="")
   {
  inlineMsg('empname','You must Enter Name...',4);
  return false;
  }
  
  if(!(insert.gender[0].checked || insert.gender[1].checked) )
  {
   inlineMsg('gender','You must Select a Gender...',4);
   return false;
  }


  if(desig == "")
   {
  inlineMsg('designation','You must Enter Designation...',4);
  return false;
  }



  if(d_o_b == "")
   {
  inlineMsg('d_o_b','You must Enter Date Of Birth...',4);
  return false;
  }

  if(d_o_j == "")
   {
  inlineMsg('d_o_j','You must Enter Date Of Join...',4);
  return false;
  }

  if(address == "")
   {
  inlineMsg('address','You must Enter Address...',4);
  return false;
  }


if(mobile == "")
   {
  inlineMsg('mobile','You must Enter Mobile No...',4);
  return false;
  }


if(land == "")
   {
  inlineMsg('land','You must Enter Landline No...',4);
  return false;
  }
  
  if(email == "")
   {
  inlineMsg('email','You must Enter Email...',4);
  return false;
  }

  
  if(!email.match(emailRegex)) 
	 {
      inlineMsg('email','invalid mail id.',2);
      return false;
	 }
  
  return true;
}  


	$(document).ready(function(){	
   $("#mobile").keypress(function (e)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg2").html("<font color = 'red' >Digits Only</font>").
                    show().fadeOut("slow");
	    return false;
      }
	});
	
	
	$("#land").keypress(function (e)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg3").html("<font color = 'red' >Digits Only</font>").
                    show().fadeOut("slow");
	    return false;
      }
	});
	
		$("#salary").keypress(function (e)
	{
	  //if the letter is not digit then display error and don't type anything
	  if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	  {
		//display error message
		$("#errmsg4").html("<font color = 'red' >Digits Only</font>").
                    show().fadeOut("slow");
	    return false;
      }
	});

	
});
	

	

  function validate_emp_salary(insert)
  {
   var salary = insert.salary.value;
   var name   = insert.empname.value;
   
   if(name == "")
   {
    inlineMsg('empname','You Must Select a Name ...',4);
    return false;
  
   }
   
   if(salary == "")
   {
    inlineMsg('salary','You must Enter Salary...',4);
    return false;
  
   }
  }
  
  function validate_emp_attend(insert)
  {
   var date = insert.date.value;
   
   if(date == "")
   {
    inlineMsg('date','You must Enter a Date...',4);
    return false;
   }
   
   
  }

// START OF MESSAGE SCRIPT //


var MSGTIMER = 20;
var MSGSPEED = 10;
var MSGOFFSET = 10;
var MSGHIDE = 100;

// build out the divs, set attributes and call the fade function //
function inlineMsg(target,string,autohide) {
  var msg;
  var msgcontent;
  if(!document.getElementById('msg')) {
    msg = document.createElement('div');
    msg.id = 'msg';
    msgcontent = document.createElement('div');
    msgcontent.id = 'msgcontent';
    document.body.appendChild(msg);
    msg.appendChild(msgcontent);
    msg.style.filter = 'alpha(opacity=0)';
    msg.style.opacity = 0;
    msg.alpha = 0;
  } else {
    msg = document.getElementById('msg');
    msgcontent = document.getElementById('msgcontent');
  }
  msgcontent.innerHTML = string;
  msg.style.display = 'block';
  var msgheight = msg.offsetHeight;
  var targetdiv = document.getElementById(target);
  targetdiv.focus();
  var targetheight = targetdiv.offsetHeight;
  var targetwidth = targetdiv.offsetWidth;
  var topposition = topPosition(targetdiv) - ((msgheight - targetheight) / 2);
  var leftposition = leftPosition(targetdiv) + targetwidth + MSGOFFSET;
  msg.style.top = topposition + 'px';
  msg.style.left = leftposition + 'px';
  clearInterval(msg.timer);
  msg.timer = setInterval("fadeMsg(1)", MSGTIMER);
  if(!autohide) {
    autohide = MSGHIDE;  
  }
  window.setTimeout("hideMsg()", (autohide * 1000));
}

// hide the form alert //
function hideMsg(msg) {
  var msg = document.getElementById('msg');
  if(!msg.timer) {
    msg.timer = setInterval("fadeMsg(0)", MSGTIMER);
  }
}

// face the message box //
function fadeMsg(flag) {
  if(flag == null) {
    flag = 1;
  }
  var msg = document.getElementById('msg');
  var value;
  if(flag == 1) {
    value = msg.alpha + MSGSPEED;
  } else {
    value = msg.alpha - MSGSPEED;
  }
  msg.alpha = value;
  msg.style.opacity = (value / 100);
  msg.style.filter = 'alpha(opacity=' + value + ')';
  if(value >= 99) {
    clearInterval(msg.timer);
    msg.timer = null;
  } else if(value <= 1) {
    msg.style.display = "none";
    clearInterval(msg.timer);
  }
}

// calculate the position of the element in relation to the left of the browser //
function leftPosition(target) {
  var left = 0;
  if(target.offsetParent) {
    while(1) {
      left += target.offsetLeft;
      if(!target.offsetParent) {
        break;
      }
      target = target.offsetParent;
    }
  } else if(target.x) {
    left += target.x;
  }
  return left;
}

// calculate the position of the element in relation to the top of the browser window //
function topPosition(target) {
  var top = 0;
  if(target.offsetParent) {
    while(1) {
      top += target.offsetTop;
      if(!target.offsetParent) {
        break;
      }
      target = target.offsetParent;
    }
  } else if(target.y) {
    top += target.y;
  }
  return top;
}

// preload the arrow //
if(document.images) 
{
  arrow = new Image(7,80); 
  arrow.src = "../public_html/images/msg_arrow.gif";
}