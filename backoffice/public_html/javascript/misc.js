//Edit Productfunction edit_prod(id){    var confirm_msg = $("#confirm_msg_edit").html();    var path_root = $("#path_root").val();    if (confirm(confirm_msg))    {        document.location.href = path_root + 'admin/product/product_management/edit/' + id;    }}function delete_prod(id){    var confirm_msg = $("#confirm_msg_delete").html();    var path_root = $("#path_root").val();    if (confirm(confirm_msg))    {        document.location.href = path_root + 'admin/product/delete_product/delete/' + id;           }}function view_news(id){    var confirm_msg = $("#confirm_msg_edit").html();    var path_root = $("#path_root").val();          document.location.href = path_root + 'user/document/view_document/view/' + id;}//Activate Productfunction activate_prod(id){    var confirm_msg = $("#confirm_msg_activate").html();    var path_root = $("#path_root").val();    if (confirm(confirm_msg))    {        document.location.href = path_root + 'admin/product/active_product/activate/' + id;    }}//Inactivate Productfunction inactivate_prod(id){    var confirm_msg = $("#confirm_msg_inactivate").html();    var path_root = $("#path_root").val();    if (confirm(confirm_msg))    {        document.location.href = path_root + 'admin/product/inactivate_product/inactivate/' + id;    }}//delete Passcodefunction delete_pin(id, root){    var confirm_msg = $("#error_msg_delete").html();    if (confirm(confirm_msg))    {        document.location.href = root + 'epin/delete_epin/delete/' + id;    }}// Delete All E-Pinfunction delete_all_epin(root,pin_status,page){    var confirm_msg = $("#error_msg_delete_all").html();    if (confirm(confirm_msg))    {        document.location.href = root + 'epin/delete_all_epin/delete/'+pin_status+'/'+page;    }}//Block Passcodefunction block_pin(id, root){    var confirm_msg = $("#error_msg_block").html();    if (confirm(confirm_msg))    {        document.location.href = root + 'epin/active_epin/block/' + id;    }}//Activate Passcodefunction activate_pin(id, root){    var confirm_msg = $("#error_msg_activate").html();    if (confirm(confirm_msg))    {        document.location.href = root + 'epin/inactive_epin/activate/' + id;    }}//edit Newsfunction edit_news(id, root){    var confirm_msg = $('#confirm_msg1').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'news/add_news/edit/' + id;    }}function view_news(id, root){           document.location.href = root + 'news/view_news/view/' + id;}function view_compensation(id, root){           document.location.href = root + 'compensation/view_compensation/view/' + id;}function edit_compensation(id, root){    var confirm_msg = $('#confirm_msg1').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'compensation/add_compensation/edit/' + id;    }}function view_user_news(id, root){           document.location.href = root + 'user/news/view_all_news/view/' + id;}function view_user_compensation(id, root){           document.location.href = root + 'user/compensation/view_all_compensation/view/' + id;}//Delete Newsfunction delete_news(id, root){    var confirm_msg = $('#confirm_msg2').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'news/add_news/delete/' + id;    }}function delete_compensation(id, root){    var confirm_msg = $('#confirm_msg2').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'compensation/add_compensation/delete/' + id;    }}//Delete Feedbackfunction delete_feedback(id, root){    var confirm_msg = $('#confirm_msg').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'feedback/feedback_view/delete/' + id;    }}//Block Userfunction block_user(id, active){    var base_url = document.search_mem.base_url.value;    if (active == 'yes')    {        if (confirm("Sure you want to Block this User? There is NO undo!"))        {            document.location.href = base_url + 'member/search_member/block/' + id;        }    }    else    {        if (confirm("Sure you want to Activate this User? There is NO undo!"))        {            document.location.href = base_url + 'member/search_member/activate/' + id;        }    }}function delete_pin_admin(id, root){    var confirm_msg = $("#error_msg6").html();    if (confirm(confirm_msg))    {        document.location.href = root + 'epin/delete/' + id;    }}function edit_rank(id, root){    var confirm_msg = $('#confirm_msg_edit').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'configuration/rank_configuration/edit/' + id;    }}function edit_board(id, root){    {        document.location.href = root + 'configuration/board_configuration/edit/' + id;    }}function inactivate_rank(id, root){    var confirm_msg = $('#confirm_msg_inactivate').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'configuration/inactivate_rank/' + id;    }}function activate_rank(id, root){    var confirm_msg = $('#confirm_msg_activate').html();    if (confirm(confirm_msg))    {        document.location.href = root + 'configuration/activate_rank/' + id;    }}function delete_rank(id, root){    var confirm_msg = $('#confirm_msg_delete').html();    if (confirm("Sure you want to Delete? There is NO undo!"))    {        document.location.href = root + 'configuration/rank_configuration/delete_rank/' + id;    }}/*function delete_pin_admin(id)  {  if(confirm("Sure you want to delete this Passcode ? There is NO undo!"))  {  document.location.href='../epin/delete/delete/'+id;  }    }function delete_pin_admin(id)  {  if(confirm("Sure you want to delete this Passcode ? There is NO undo!"))  {  document.location.href='../epin/view_pin_user/delete/'+id;  }    }*/function delete_docs(id, root){    if (confirm("Sure you want to delete this Material ? There is NO undo!"))    {        document.location.href = root + 'news/upload_materials/delete/' + id;    }}//---------------------------------------------/*function hide_docs(id,root)  { if(confirm("Sure you want to hide this Docs ?"))  {  document.location.href=root+'document/show_document/hide/'+id;  }    }*///----------------------------------------------edited by amruthafunction delete_docss(id, root){    if (confirm("Sure you want to Delete? There is NO undo!"))    {        document.location.href = root + 'employee/search_employee/delete/' + id;    }}function edit_docs(id, root){    if (confirm("Sure you want to Edit? There is NO undo!"))    {        document.location.href = root + 'employee/search_employee/edit/' + id;    }}//----------------------------------------------function delete_employee(id, root){    if (confirm("Sure you want to Delete? There is NO undo!"))    {        document.location.href = root + 'employee/view_all_employee/delete/' + id;    }}function edit_employee(id, root){    if (confirm("Sure you want to Edit? There is NO undo!"))    {        document.location.href = root + 'employee/view_all_employee/edit/' + id;    }}function delete_newsletter(id, root){    var confirm_msg = 'Do You Want To Remove This Email? There is No Undo!';    if (confirm(confirm_msg))    {        document.location.href = root + 'news/view_newsletter/delete/' + id;    }}function reopen_ticket(id){    var confirm_msg = $("#confirm_msg1").html();    var path_root = $("#path_root").val();//alert(path_root);//alert(confirm_msg);    if (confirm(confirm_msg))    {        document.location.href = path_root + 'user/ticket_system/my_ticket/'+" "+'/tab4/reopen/' + id;    }}function assign_ticket(id){    var confirm_msg = $("#confirm_msg1").html();    var path_root = $("#path_root").val();    if (confirm(confirm_msg))    {        document.location.href = path_root + 'admin/ticket_system/ticket_assign/assign/' + id;    } }// need to chec these to functionsfunction view_assigned_tickets(id){    var path_root = $("#path_root").val();     document.location.href = path_root + 'admin/employee/view_ticket_details/' + id;}function show_more(){   document.getElementById('more_search_type').style.display = "";   document.getElementById('less_option').style.display = "";   document.getElementById('more_option').style.display = "none";}function show_less(){   document.getElementById('more_search_type').style.display = "none";   document.getElementById('less_option').style.display = "none";   document.getElementById('more_option').style.display = "";   document.getElementById('s_my').value="";   document.getElementById('s_ot').value="";   document.getElementById('s_un').value="";   document.getElementById('archive').value="";   document.getElementById('tckt_category').value="";   document.getElementById('week_date').value="";}function show_timeline(id){  var path_root = $("#path_root").val();   document.location.href = path_root + 'admin/ticket_system/ticket_time_line/' + id;}function show_timeline_for_user(id){  var path_root = $("#path_root").val();   document.location.href = path_root + 'user/ticket_system/ticket_time_line/' + id;}