function saveToHiddenField(f)
{
    var proj=document.income_project.product.value;
    var starting=document.search_between.starting.value;
    var ending=document.search_between.ending.value;



    document.searchbyall.product_type1.value=proj;
    document.searchbyall.starrting_date.value=starting;
    document.searchbyall.ending_date.value=ending;
}