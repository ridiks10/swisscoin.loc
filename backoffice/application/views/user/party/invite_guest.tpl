{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">  
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('select_a_guest')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('invite_guest')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">

                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>
                    {form_open('user/party/invite_guest','name="guest" id="guest" method="post" action=""')}
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('select')}</th>
                                <th>{lang('guest_name')}</th>
                                <th>{lang('guest_email')}</th>
                                <th>{lang('guest_phone')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$i=0}
                            {foreach from=$data item=v}
                                <tr>
                                    <td>{counter}</td>
                                    <td><input type = 'checkbox' name = 'select{$i}' id="select_guest"  value= 'yes'  >
                                        <label for="select{$i}"></label>
                                    </td>
                                    <td>{$v.first_name}<input type="hidden" name="selected_id{$i}"  value="{$v.id}"></td>
                                    <td>{$v.email}</td>
                                    <td>{$v.phone}</td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        </tbody>
                    </table>

                    <div class="form-group" >
                        <div class="col-sm-2 col-sm-offset-1">
                            <button class="btn btn-bricky" tabindex="1" name="sent_evite" id="sent_evite"  type="submit"  value="Sent E-vite" >{lang('sent_invite')}</button>
                        </div>

                        <input type="hidden" name="count" id="count" value="{$i}">
                        <div class="col-sm-2 col-sm-offset-2">
                            <a href="create_guest/add_more">
                                <button class="btn btn-bricky" tabindex="2"  name="create" id="create" type="button" value="Add New Customer" >{lang('add_new_guest')}</button></a>
                        </div>

                        <div class="col-sm-2 col-sm-offset-2">
                            <a href="../myparty/party_portal">
                                <button class="btn btn-bricky" tabindex="2"  name="back" id="back" type="button" value="back" >{lang('back_to_party_portal')}</button></a>
                        </div>
                    </div>   
               {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
        ValidateInviteGuest.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}