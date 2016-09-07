function edit_scripts(id, root)

{

    var confirm_msg = $('#confirm_msg1').html();
    if (confirm(confirm_msg))

    {
	document.location.href = root + 'menus/add_new_scripts/edit/' + id;

    }



}