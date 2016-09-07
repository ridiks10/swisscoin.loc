function setPermissionEnquiry(f)

{

    if (f.checked == 1)
    {
	$("#enq").show();

    }

    if (f.checked == 0)
    {
	$("#enq").hide();
    }

}



function setPermissionCustomer(f)
{
    if (f.checked == 1)
    {
	$("#cust").show();
    }

    if (f.checked == 0)
    {
	$("#cust").hide();
    }

}



function setPermissionAccounting(f)
{
    if (f.checked == 1)
    {

	$("#accounting5").show();
	$("#accounting4").show();
	$("#accounting3").show();
	$("#accounting2").show();
	$("#accounting6").show();

    }

    if (f.checked == 0)
    {
	$("#accounting5").hide();
	$("#accounting4").hide();
	$("#accounting3").hide();
	$("#accounting2").hide();
	$("#accounting6").hide();

    }

}

function setPermissionProductAnsServices(f)
{
    if (f.checked == 1)
    {
	$("#product1").show();


	$("#product2").show();
    }

    if (f.checked == 0)
    {

	$("#product1").hide();
	$("#product2").hide();
    }
}




function setPermissionQuote(f)
{
    if (f.checked == 1)
    {
	$("#quote2").show();
    }

    if (f.checked == 0)
    {
	$("#quote2").hide();
    }
}


function validation()
{
    var user1 = document.get_user_name_form.user1.value;

    if (user1 == "")
    {
	inlineMsg('user1', 'You must Enter User Name...', 4);
	return false;
    }
    else
    {
	return true;
    }

}








