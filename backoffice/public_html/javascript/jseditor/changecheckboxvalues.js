function setPermissionEnquiry(f)

{
  
 if(f.checked==1)
 {
   // document.set_permission_form.addenquiry.checked=1;
   // document.set_permission_form.delet_enquiry.checked=1;
    $("#enq").show();
	$("#view_all_enq").show();
	$("#SearchEnquiry").show();
	$("#SearchEnqReminder").show();

 }

 if(f.checked==0)
 {
     
   // document.set_permission_form.addenquiry.checked=0;
   // document.set_permission_form.delet_enquiry.checked=0;
    $("#enq").hide();
	$("#view_all_enq").hide();
	$("#SearchEnquiry").hide();
	$("#SearchEnqReminder").hide();
 }

}



function setPermissionCustomer(f)
{
 if(f.checked==1)
 {
   $("#cust").show();
   $("#view_all_customers").show();
   // document.set_permission_form.add_customer.checked=1;
    // document.set_permission_form.edit_customer.checked=1;
 }

 if(f.checked==0)
 {
   
    //document.set_permission_form.add_customer.checked=0;
    //document.set_permission_form.edit_customer.checked=0;
    $("#cust").hide();
	$("#view_all_customers").hide();
 }

}
function setPermissionReminder(f)
{
if(f.checked==1)
{
$("#reminder").show();
$("#view_all_reminders").show();
}
if(f.checked==0)
{
$("#reminder").hide();
$("#view_all_reminders").hide();
}

}
function setPermissionProject(f)
{
if(f.checked==1)
{
$("#project").show();

}
if(f.checked==0)
{
$("#project").hide();
}
}
function setPermissionVenders(f)
{
if(f.checked==1)
{
$("#vendors").show();
}
if(f.checked==0)
{
$("#vendors").hide();
}

}
function setPermissionUser(f)
{
if(f.checked==1)
{
$("#users").show();
$("#change_password").show();
}
if(f.checked==0)
{
$("#users").hide();
$("#change_password").hide();
}
}


function setPermissionAccounting(f)
{
 if(f.checked==1)
 {
   // document.set_permission_form.add_new_income.checked=1;
   // document.set_permission_form.add_project_amt_details.checked=1;
    // document.set_permission_form.add_customer_invoice.checked=1;

    // document.set_permission_form.view_dues.checked=1;
    //document.set_permission_form.add_new_exp_type.checked=1;
   //  document.set_permission_form.add_exp.checked=1;

    // document.set_permission_form.view_all_exp.checked=1;
    //document.set_permission_form.view_prof_loss.checked=1;
    // document.set_permission_form.add_new_inc_type.checked=1;

    $("#accounting5").show();
     $("#accounting4").show();
     $("#accounting3").show();
     $("#accounting2").show();
     $("#accounting6").show();

 }

 if(f.checked==0)
 {
     $("#accounting5").hide();
     $("#accounting4").hide();
     $("#accounting3").hide();
     $("#accounting2").hide();
     $("#accounting6").hide();
   // document.set_permission_form.add_new_income.checked=0;
   // document.set_permission_form.add_project_amt_details.checked=0;
   //  document.set_permission_form.add_customer_invoice.checked=0;

   //  document.set_permission_form.view_dues.checked=0;
   // document.set_permission_form.add_new_exp_type.checked=0;
   //  document.set_permission_form.add_exp.checked=0;

    // document.set_permission_form.view_all_exp.checked=0;
    //document.set_permission_form.view_prof_loss.checked=0;
    // document.set_permission_form.add_new_inc_type.checked=0;

     
 }

}
function setPermissionAccount(f)
{
if(f.checked==1)
{
$("#set_module_permission").show();
$("#view_users_credit").show();
}
if(f.checked==0)
{
$("#set_module_permission").hide();
$("#view_users_credit").hide();
}


}
function setPermissionReport(f)
{
if(f.checked==1)
{
$("#income_report").show();
$("profit_loss").show();
}
if(f.checked==0)
{
$("#income_report").hide();
$("#profit_loss").hide();

}







}

function setPermissionProductAnsServices(f)
{
   if(f.checked==1)
 {
     $("#product1").show();
     
     
     $("#product2").show();
  //  document.set_permission_form.view_prducts.checked=1;
  //  document.set_permission_form.add_new_product.checked=1;
  //  document.set_permission_form.view_services.checked=1;
  //  document.set_permission_form.add_services.checked=1;
 }

 if(f.checked==0)
 {
    
     $("#product1").hide();
     $("#product2").hide();
     
  //  document.set_permission_form.view_prducts.checked=0;
  //  document.set_permission_form.add_new_product.checked=0;
 //   document.set_permission_form.view_services.checked=0;
  //  document.set_permission_form.add_services.checked=0;
 }
}




function setPermissionQuote(f)
{
   if(f.checked==1)
 {
     $("#quote2").show();
	 $("#download_q").show();
	 
   // document.set_permission_form.change_status.checked=1;
   // document.set_permission_form.view_quotes.checked=1;
 }

 if(f.checked==0)
 {
   // document.set_permission_form.change_status.checked=0;
   // document.set_permission_form.view_quotes.checked=0;
     $("#quote2").hide();
	 $("#download_q").hide();
 }
}


function validation()
{
   var user1=document.get_user_name_form.user1.value;
  // alert(user1);
   
    if(user1=="")
        {
            inlineMsg('user1','You must Enter User Name...',4);
            return false;
        }
        else
            {
                return true;
            }

}



/*function setHiddenField()
{
     var user=document.get_user_name_form.user1.value;
     document.set_permission_form.user.value=user;
   alert(document.set_permission_form.user.value);
    // return true;
}*/






