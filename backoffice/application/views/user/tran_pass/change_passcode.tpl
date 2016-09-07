{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_current_transaction_password')}</span>
    <span id="error_msg2">{lang('you_must_enter_new_transaction_password')}</span>
    <span id="error_msg3">{lang('transaction_password_length_should_be_more_than_8')}</span>
    <span id="error_msg4">{lang('reenter_new_transaction_password')}</span>                     
    <span id="error_msg5">{lang('new_transaction_password_mismatch')}</span>        
    <span id="error_msg6">{lang('you_must_select_a_username')}</span>
</div>	
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('change_transaction_password')} 
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
                {if $preset_demo eq 'yes'}
                    <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_for_preset_users')} </font>
                    <br><br>
                {/if}
                    {form_open('user/tran_pass/change_passcode','role="form" class="smart-wizard form-horizontal" name="change_pass" id="change_pass" action="" method="post" ')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="old_passcode">{lang('current_transaction_password')}:<font color="#ff0000">*</font> </label>
                        <div class="col-sm-3">                           
                            <input type="password" name="old_passcode" id="old_passcode" tabindex="1" maxlength="10" />{form_error('old_passcode')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="new_passcode">{lang('new_transaction_password')}:<font color="#ff0000">*</font> </label>
                        <div class="col-sm-3">                           
                            <input type="password" name="new_passcode" id="new_passcode" tabindex="2" maxlength="10" />{form_error('new_passcode')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="re_new_passcode">{lang('reenter_new_transaction_password')}:<font color="#ff0000">*</font> </label>
                        <div class="col-sm-3">                           
                            <input type="password" name="re_new_passcode" id="re_new_passcode" tabindex="3" maxlength="10" />{form_error('re_new_passcode')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">                           
                            <button class="btn btn-bricky" type="submit" name="change"  id="change"  tabindex="4" value="change" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}