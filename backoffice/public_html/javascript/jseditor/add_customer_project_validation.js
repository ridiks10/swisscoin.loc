function validateCustomerProject(f)
{
    
    var name=f.name.value;
    var description =f.description.value;
    var date=f.date.value;
    if(name == "" ||name == " " ||name == "  " ||name == "    ")
    {
      
        inlineMsg('name','Enter Project Name...',4);
        return false;
    }


    if(description == "" ||description == " " ||description == "  " ||description == "    ")
    {
        inlineMsg('description','Enter Project Description...',4);
        return false;
    }
    
    if(date == "")
    {
        inlineMsg('date','Enter Project completion Date...',1);
        return false;
    }

    return true;

}

/*
function calculateTotalAmount()
{
    
    var tax=parseFloat(addprojectform.tax.value);
 
    var discount=parseFloat(addprojectform.discount.value);

    var amount=parseFloat(addprojectform.amount.value);
   

    var total_amount=amount+(amount*(tax/100))-(amount*(discount/100));

   document.addprojectform.total_amount.value=total_amount;

}



function addNewTextBox(f)
{
    
    if(f=="US Dollar")
        {
           
             $("#exchnage_rate").show();
             $("#us_dollar").show();
          
        }
        else
            {
                
                 $("#exchnage_rate").hide();

                 $("#us_dollar").hide();
            }

}



function dollarToRupees()
{
     var rate=parseFloat(addprojectform.rate.value);

    var dollar=parseFloat(addprojectform.dollar.value);




    var rs=rate*dollar;

   document.addprojectform.amount.value=rs;
}


*/