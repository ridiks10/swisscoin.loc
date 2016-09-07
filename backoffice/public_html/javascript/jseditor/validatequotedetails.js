function validateQuoteDetails()
{
    var customer =document.save_cust_invoice.customer.value;

    var poject_name =document.save_cust_invoice.poject_name.value;

    var attach1 =document.save_cust_invoice.attach1.value;

    var date =document.save_cust_invoice.date.value;

    if(customer=="")
    {
        inlineMsg('customer','Select Customer.',2);

        return false;
    }
    if(poject_name=="")
    {
        inlineMsg('poject_name','Select Project.',2);

        return false;
    }

    if(attach1=="")
    {
        inlineMsg('attach1','Select a quote file',2);

        return false;
    }

    if(date=="")
    {
        inlineMsg('date','Enter date',2);

        return false;
    }

    return true;
}

