function assignToHiddenFields()
{
    
//assign text field values to variable
    var quote_name=document.search2.q_name.value;
    

    var project_name=document.search1.proj_name.value;

    var cust_name=document.search.customer_name.value;

     var quote_version=document.search3.version.value;
    
   
     
//assign values to hidden fields



    document.search_all.quote_name.value=quote_name;

    document.search_all.p_name.value=project_name;

    document.search_all.c_name.value=cust_name;

    document.search_all.quote_ver.value=quote_version;


}