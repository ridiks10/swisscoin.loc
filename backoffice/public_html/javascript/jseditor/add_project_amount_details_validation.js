function validateProjectAmount(f)
{

    var customer=f.customer.value;
    var poject_name =f.poject_name.value;



    var currency=f.currency.value;
    var dollar1=f.dollar1.value;

    var rate=f.rate.value;

    var rupees=f.rupees.value;

     var tax1=f.tax1.value;

    var discount1=f.discount1.value;
     var grant_total1=f.grant_total1.value;
     var   date_of_add=f.date_of_add.value




    var numberRegex = /^[0-9]+/;

    if(customer == "" )
    {
        inlineMsg('customer','Enter a customer...',1);

        return false;
    }

    



    if(currency == "" ||currency == " " ||currency == "  " ||currency == "    ")
    {
        inlineMsg('currency','Select Currency ...',1);
        return false;
    }
    if(currency == "dollar" && dollar1=="")
    {
        inlineMsg('dollar1','Enter amount in Dollar ...',1);
        return false;
    }
    if(currency == "dollar" && rate=="")
    {
        inlineMsg('rate','Enter Exchange rate ...',1);
        return false;
    }

     if(rupees == "" )
    {
        inlineMsg('rupees','Enter amount in Rupees ...',1);
        return false;
    }


     if(tax1 == "" ||tax1>100 )
    {
        inlineMsg('tax1','Enter Tax ...',1);
        return false;
    }

 if(discount1 == "" ||discount1>100)
    {
        inlineMsg('discount1','Enter Discount ...',1);
        return false;
    }

if(grant_total1 == "" )
    {
        inlineMsg('grant_total1','Enter Grand Total ...',1);
        return false;
    }
     
    if(!grant_total1.match(numberRegex))
    {

        inlineMsg('grant_total1','Invalid ....',2);

        return false;
    }

if(date_of_add == "" )
    {
        inlineMsg('date_of_add','Enter Date ...',1);
        return false;
    }
    

    
    


    

   if(poject_name == "" ||poject_name == " " ||poject_name == "  " ||poject_name == "    ")
    {
        inlineMsg('poject_name','Select Project Name...',1);

        return false;
     }
   

    return true;
}


function addNewTextBoxes(f)
{
    var dd=$("#currency").val();

    if(dd=="dollar")
    {
        $("#USD").show();
        $("#rate1").show();

        
    }
    else
        {
         $("#USD").hide();
        $("#rate1").hide();

        }

    


}

function convertDollartorupee()
{
     var dollar = parseFloat(document.save_cust_invoice.dollar1.value);

    var rate = parseFloat(document.save_cust_invoice.rate.value);

    var amount=dollar*rate;




   document.save_cust_invoice.rupees.value=amount;
}


function FindTaxAndDiscount()
{
     var tax1=parseFloat(document.save_cust_invoice.tax1.value);

    var discount1=parseFloat(document.save_cust_invoice.discount1.value);

    var rupees=parseFloat(document.save_cust_invoice.rupees.value);

    grant_total=rupees+(rupees*tax1/100)-(rupees*discount1/100)


   document.save_cust_invoice.grant_total1.value=grant_total;
}




function setVal(f)
{
    var proj_id = f.value;
    // alert(proj_id);
    document.save_cust_invoice.proj_id.value = proj_id;
   // alert(document.save_cust_invoice.proj_id.value);


}