{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_current_password')}</span>        
    <span id="error_msg2">{lang('the_password_length_should_be_greater_than_6')}</span>        
    <span id="error_msg3">{lang('password_mismatch')}</span>  
    <span id="error_msg6">{lang('this_field_is_required')}</span>  
    <span id="error_msg8">{lang('special_chars_not_allowed')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
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
                {lang('change_password')}
            </div>
            <div class="panel-body">
                {if $preset_demo eq 'yes'}
                    <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_for_preset_users')} </font>
                    <br><br>
                {/if}
             
               {form_open('user/password/change_password','role="form" class="smart-wizard form-horizontal" id="change_pass_admin" name="change_pass_admin"  method="post" ')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="current_pwd_admin">{lang('current_password')} : <font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input name="current_pwd_admin" type="password" id="current_pwd_admin" tabindex="1" autocomplete="Off" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="new_pwd_admin">{lang('new_password')}  : <font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input name="new_pwd_admin" type="password" id="new_pwd_admin" size="20"  autocomplete="Off" tabindex="2" />
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="confirm_pwd_common">{lang('confirm_password')}  : <font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input name="confirm_pwd_admin" type="password" id="confirm_pwd_admin" size="20"  autocomplete="Off" tabindex="3" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" name="change_pass_button_admin"  id="change_pass_button_admins" value="{lang('change_password')}" tabindex="4" {if $preset_demo eq 'yes'}disabled{/if}>{lang('change_password')}</button>
                        </div>
                    </div>
                        {form_close()}
             
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidatePassword.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
