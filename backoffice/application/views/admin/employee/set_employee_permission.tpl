{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
</div> 

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('set_employee_modules')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="permission_form" id="permission_form"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="user_name">{lang('select_employee')}:</label>
                    <div class="col-sm-4">
                        <input  type="text"  name="user_name" id="user_name"   autocomplete="Off"  onkeyup="ajax_showOptions(this, 'getUsersByLetters', 'no', event)"  tabindex="1" >
                        <span id="username_box" style="display:none;"></span>
                    </div>
                    {form_error('user_name')}
                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" name="user_name_submit" id="user_name_submit" value="{lang('view_module_permission')}" tabindex="2">
                            {lang('view_module_permission')}
                        </button>
                    </div>
                </div>
                {form_close()}
                {if $user_name_submit}
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-12">
                                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="set_permission_form" id="set_permission_form"')}
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <i class="fa fa-external-link-square"></i>{lang('set_permission_of')} {$user_name}
                                    </div>
                                    <div class="panel-body">
                                        <table style="background:white;border-top:0px;" class="table table-striped  table-full-width" id="sample_1">
                                            <input type="hidden" name="user" id="user" value="{$user_name}">
                                            <tr style="background:white;border-top:0px;" class="th" align="left">
                                                <td style="background:white;border-top:0px;">
                                                    {$main_menu}
                                                    {$other_menu}
                                                    {$submit_button}
                                                </td> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                {form_close()}               
                            </div>
                        </div>
                    </div>
                {/if}
            </div> 
        </div>    
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}