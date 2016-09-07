



function validateInvoice(f)
{
   
   
    var customer=f.customer.value;
    var poject_name =f.poject_name.value;

    var date=f.date.value;

    var installment_no=f.installment_no.value;
    var recipt_amt=f.recipt_amt.value;
	var amt=ss-recipt_amt;
	
    var category=f.category.value;
    var dd_no=f.dd_no.value;

    var check_no=f.check_no.value;
    var check_bank1=f.check_bank1.value;
    var check_date1=f.check_date1.value;
    var branch=f.branch1.value;
     var net_bank_trans_id1=f.net_bank_trans_id1.value;

    var bank_name=f.bank_name.value;
    var acc_number=f.acc_number.value;
    
     var pay_pal_id1=f.pay_pal_id1.value;
       var dollar1=f.dollar1.value;
       var rate=f.rate.value;
        var west_id=f.west_id.value;

        var mctn1=f.mctn1.value;
         var reciever_name1=f.reciever_name1.value;
      

var sender_name1=f.sender_name1.value;

    var numberRegex = /^[0-9]+/;

    if(category == "" )
    {
        inlineMsg('category','Select category...',1);

        return false;
    }

    if(customer == "" ||customer == " " ||customer == "  " ||customer == "    ")
    {
        inlineMsg('customer','Enter Project Name...',1);

        return false;
     }



    if(date == "" ||date == " " ||date == "  " ||date == "    ")
    {
        inlineMsg('date','Enter date...',1);
        return false;
    }

    if(installment_no == "" ||installment_no == " " ||installment_no == "  "
            ||installment_no == "    ")
    {
        inlineMsg('installment_no','Enter Installment number...',1);
        return false;
    }

    if(!installment_no.match(numberRegex))
    {

        inlineMsg('installment_no','Invalid ....',2);

        return false;
    }


    if(recipt_amt == "" ||recipt_amt == " " ||recipt_amt == "  " ||recipt_amt == "    ")
    {
	
            inlineMsg('recipt_amt','Invalid...',1);
            return false;
    }

    if(!recipt_amt.match(numberRegex))
    { 

        inlineMsg('recipt_amt','Invalid ....',2);

        return false;
    }

    if(poject_name == "" )
    {
        inlineMsg('poject_name','Select Project...',1);
        return false;
    }

    if(category=="DD"&& dd_no=="")
        {
            inlineMsg('dd_no','Enter DD no...',1);
        return false;
        }


        if(category=="check"&& check_no=="")
        {
            inlineMsg('check_no','Enter Check number...',1);
        return false;
        }
        if(category=="check"&& check_bank1=="")
        {
            inlineMsg('check_bank1','Enter Bank Name...',1);
        return false;
        }

        if(category=="check"&& check_date1=="")
        {
            inlineMsg('check_date1','Enter Date...',1);
        return false;
        }
        if(category=="bank"&& bank_name=="")
        {
            inlineMsg('bank_name','Enter Bank Name...',1);
        return false;
        }

        if(category=="bank"&& branch=="")
        {
            inlineMsg('branch1','Enter Branch Name...',1);
        return false;
        }
        if(category=="bank"&& acc_number=="")
        {
            inlineMsg('acc_number','Enter Account Number...',1);
        return false;
        }
         if(category=="netbanking"&& net_bank_trans_id1=="")
        {
            inlineMsg('net_bank_trans_id1','Enter Net Banking Transaction ID...',1);
        return false;
        }

        if(category=="paypal"&& pay_pal_id1=="")
        {
            inlineMsg('pay_pal_id1','Enter Pay Pal ID...',1);
        return false;
        }
        if(category=="paypal"&& dollar1=="")
        {
            inlineMsg('dollar1','Enter Amount in US dollar...',1);
        return false;
        }
        if(category=="paypal"&& rate=="")
        {
            inlineMsg('rate','Enter Exchange rate...',1);
        return false;
        }

       
        if(category=="westernunion"&& dollar1=="")
        {
            inlineMsg('dollar1','Enter amount in dollar...',1);
        return false;
        }
         if(category=="westernunion"&& west_id=="")
        {
            inlineMsg('west_id','Enter Transfer ID...',1);
        return false;
        }

         if(category=="westernunion"&& mctn1=="")
        {
            inlineMsg('mctn1','Enter MCTN...',1);
        return false;
        }
         if(category=="westernunion"&& sender_name1=="")
        {
            inlineMsg('sender_name1','Enter sender Name...',1);
        return false;
        }
        if(category=="westernunion"&& reciever_name1=="")
        {
            inlineMsg('reciever_name1','Enter Reciever Name...',1);
        return false;
        }
        if(category=="westernunion"&& rate=="")
        {
            inlineMsg('rate','Enter Exchange rate...',1);
        return false;
        }
		



    return true;
}


function addNewTextBoxes(f)
{

 
    var dd=$("#category").val();
     
    if(dd=="DD")
    {
        $("#ddno").show();
        $("#checkno").hide();

        $("#check_bank").hide();
        $("#check_date").hide();

        $("#net_bank_trans_id").hide();
        $("#bank").hide();

        $("#branch").hide();
        $("#paypal_id").hide();

        $("#dollar").hide();
        $("#western_id").hide();

        $("#mctn").hide();
        $("#sender_name").hide();

        $("#reciever_name").hide();
        $("#exchange_rate").hide();
        $("#account_number").hide();

    }

    else if(dd=="check")
    {
        $("#checkno").show();
        $("#check_bank").show();

        $("#check_date").show();
        $("#ddno").hide();

        $("#net_bank_trans_id").hide();
        $("#bank").hide();

        $("#branch").hide();
        $("#paypal_id").hide();

        $("#dollar").hide();
        $("#western_id").hide();

        $("#mctn").hide();
        $("#sender_name").hide();

        $("#reciever_name").hide();
        $("#exchange_rate").hide();

        $("#account_number").hide();

    }

    else if(dd=="netbanking")
    {
        $("#net_bank_trans_id").show();
        $("#checkno").hide();

        $("#ddno").hide();
        $("#check_bank").hide();

        $("#check_date").hide();
        $("#bank").hide();

        $("#branch").hide();
        $("#paypal_id").hide();

        $("#dollar").hide();
        $("#western_id").hide();

        $("#mctn").hide();
        $("#sender_name").hide();

        $("#reciever_name").hide();
        $("#exchange_rate").hide();

        $("#account_number").hide();

    }

    else if(dd=="bank")
    {
        $("#bank").show();
        $("#branch").show();
        $("#account_number").show();

        $("#checkno").hide();
        $("#ddno").hide();

        $("#check_bank").hide();
        $("#check_date").hide();

        $("#net_bank_trans_id").hide();
        $("#paypal_id").hide();

        $("#dollar").hide();
        $("#western_id").hide();

        $("#mctn").hide();
        $("#sender_name").hide();

        $("#reciever_name").hide();
        $("#exchange_rate").hide();
    }

    else if(dd=="paypal")
    {
        $("#paypal_id").show();
        $("#dollar").show();
        $("#exchange_rate").show();
        $("#checkno").hide();
        $("#ddno").hide();

        $("#check_bank").hide();
        $("#check_date").hide();

        $("#net_bank_trans_id").hide();
        $("#bank").hide();

        $("#branch").hide();
        $("#western_id").hide();

        $("#mctn").hide();
        $("#sender_name").hide();

        $("#reciever_name").hide();
        $("#account_number").hide();

    }

    else if(dd=="westernunion")
    {

        $("#western_id").show();
        $("#mctn").show();

        $("#dollar").show();
        $("#exchange_rate").show();

        $("#sender_name").show();
        $("#reciever_name").show();

        $("#checkno").hide();
        $("#ddno").hide();

        $("#check_bank").hide();
        $("#check_date").hide();

        $("#net_bank_trans_id").hide();
        $("#bank").hide();

        $("#branch").hide();
        $("#paypal_id").hide();
        $("#account_number").hide();

    }


    else
    {

        $("#checkno").hide();
        $("#ddno").hide();

        $("#check_bank").hide();
        $("#check_date").hide();

        $("#net_bank_trans_id").hide();
        $("#bank").hide();

        $("#branch").hide();
        $("#paypal_id").hide();

        $("#dollar").hide();
        $("#western_id").hide();

        $("#mctn").hide();
        $("#sender_name").hide();

        $("#reciever_name").hide();
        $("#exchange_rate").hide();
        $("#account_number").hide();
    }




}

function convertDollartorupee()
{
     var dollar=parseFloat(save_cust_invoice.dollar1.value);
     
    var rate=parseFloat(save_cust_invoice.rate.value);

    var amount=dollar*rate;




   document.save_cust_invoice.recipt_amt.value=amount;
}
