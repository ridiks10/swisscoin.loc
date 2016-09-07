function edit_auto_respnder(id)

{
//alert('4444');
     var confirm_msg="Do you want to Edit this?";
    var path_root=$("#path_root").val();
    if(confirm(confirm_msg))

    {

        document.location.href=path_root+'configuration/auto_responder_settings/edit/'+id;

    }



}
function delete_auto_respnder(id)

{
//alert('4444');
     var confirm_msg="Do you want to Delete this?";
    var path_root=$("#path_root").val();
    if(confirm(confirm_msg))

    {

        document.location.href=path_root+'configuration/auto_responder_settings/delete/'+id;

    }



}

function edit_getting_started(id)

{
//alert('4444');
     var confirm_msg="Do you want to Edit this?";
    var path_root=$("#path_root").val();
    if(confirm(confirm_msg))

    {

        document.location.href=path_root+'configuration/getting_started/edit/'+id;

    }



}
function delete_getting_started(id)

{
//alert('4444');
     var confirm_msg="Do you want to Delete this?";
    var path_root=$("#path_root").val();
    if(confirm(confirm_msg))

    {

        document.location.href=path_root+'configuration/getting_started/delete/'+id;

    }



}