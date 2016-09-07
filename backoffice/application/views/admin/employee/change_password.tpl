{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_current_password')}</span>        
    <span id="error_msg2">{lang('the_password_length_should_be_greater_than_6')}</span>        
    <span id="error_msg3">{lang('password_mismatch')}</span>  
    <span id="error_msg4">{lang('you_must_enter_your_new_password_again')}</span>     
    <span id="error_msg5">{lang('you_must_enter_your_new_password')}</span>                  
    <span id="error_msg6">{lang('you_must_enter_your_confirm_password')}</span>  
    <span id="error_msg7">{lang('special_chars_not_allowed')}</span>
    <span id="error_msg8">{lang('You_must_enter_user_name')}</span>
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
                {form_open('','role="form" class="smart-wizard form-horizontal" id="change_pass" name="change_pass" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">

                            <label class="col-sm-2 control-label" for="user_name">{lang('user_name')}:  <font color="#ff0000">*</font></label>
                            <div class="col-sm-3">
                                <input type="text" id="user_name" name="user_name" value="" onkeyup="ajax_showOptions(this, 'getUsersByLetters', 'no', event)"  tabindex="5" autocomplete="Off" >
                            </div>
                            {form_error('user_name')}
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="new_pwd">{lang('new_password')}:<font color="#ff0000">*</font></label>
                            <div class="col-sm-3">
                                <input name="new_pwd" type="password" id="new_pwd" size="20"  autocomplete="Off" tabindex="6" />
                            </div>
                            {form_error('new_pwd')}

                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="confirm_pwd">{lang('confirm_password')}:   <font color="#ff0000">*</font></label>
                            <div class="col-sm-3">
                                <input name="confirm_pwd" type="password" id="confirm_pwd" size="20"  autocomplete="Off" tabindex="7" />
                            </div>
                            {form_error('confirm_pwd')}
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">                                       
                                <button class="btn btn-bricky" type="submit" name="change_pass_button"  id="change_pass_button" value="{lang('change_password')}" tabindex="8">{lang('change_password')}</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
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