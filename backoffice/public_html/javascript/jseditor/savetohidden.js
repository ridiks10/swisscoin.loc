function saveToHiddenField()
{

    var date=document.searchformdate.searchdate.value;

    var cust_name=document.searchformcust.searchcustomername.value;

    var country=document.searchformcountry.country.value;

    var starting_date=document.betweendate.starting.value;

    var ending_date=document.betweendate.ending.value;

    var location=document.searchlocation.location.value;

    var state=document.searchstate.state.value;




    document.submilt_all.date_all.value=date;

    document.submilt_all.cust_name_all.value=cust_name;

    document.submilt_all.country_all.value=country;

    document.submilt_all.starting_date_all.value=starting_date;

    document.submilt_all.ending_date_all.value=ending_date;
    
    document.submilt_all.location_all.value=location;

    document.submilt_all.state_all.value=state;
}