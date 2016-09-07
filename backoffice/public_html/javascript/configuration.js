function set_language_id(new_lang_id,type){
    document.getElementById('lang_id').value = new_lang_id;
    var base_url=document.getElementById('base_url').value;
    if(type=='terms')
        document.location.href=base_url+"admin/configuration/content_management/"+new_lang_id+"#tabs-2";
    else if(type=='letter')
        document.location.href=base_url+"admin/configuration/content_management/"+new_lang_id+"#tabs-1";
    else if (type == 'email')
        document.location.href = base_url + "admin/configuration/email_management/" + new_lang_id ;

}