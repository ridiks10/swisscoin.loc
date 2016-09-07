{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>        
    <span id="error_msg2">{lang('you_must_enter_your_password')}</span>        
    <span id="error_msg3">{lang('You_must_enter_your_Password_again')}</span>        
    <span id="error_msg4">{lang('You_must_enter_your_email')}</span>                  
    <span id="error_msg5">{lang('You_must_enter_your_mobile_no')}</span>
    <span id="error_msg6">{lang('mail_id_format')}</span>
    <span id="error_msg7">{lang('You_must_enter_first_name')}</span>
    <span id="error_msg8">{lang('You_must_enter_last_name')}</span>
    <span id="error_msg12">{lang('Invalid_Username')}</span>
    <span id="error_msg13">{lang('checking_username_availability')}</span>
    <span id="error_msg14">{lang('username_validated')}</span>
    <span id="error_msg15">{lang('username_already_exists')}</span>
    <span id="error_msg11">{lang('mobile_no_should_contain_atleast_10_digits')}</span>
    <span id="confirm_msg">{lang('sure_you_want_to_delete_this_feedback_there_is_no_undo')}</span>
</div> 

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('New_Employee_Registration')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="user_register" id="user_register"')}

                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>

                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="ref_username" >{lang('user_name')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input type="text" name="ref_username" id="ref_username" onblur="check_username_availability(this.value)" autocomplete="Off" tabindex="1" maxlength="32"  {if isset($employee_reg_arr['ref_username'])} value="{$employee_reg_arr['ref_username']}"{/if}>
                        <span id="username_box" style="display:none;"></span>
                    </div>
                    {form_error('ref_username')}
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="first_name">{lang('first_name')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input type="text"  name="first_name" id="first_name"   autocomplete="Off" tabindex="2" maxlength="32" minlength="2"  {if isset($employee_reg_arr['first_name'])} value="{$employee_reg_arr['first_name']}"{/if}>
                    </div>
                    {form_error('first_name')}
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="last_name" >{lang('last_name')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input  type="text"  name="last_name" id="last_name"   autocomplete="Off" tabindex="3" maxlength="32" minlength="2"  {if isset($employee_reg_arr['last_name'])} value="{$employee_reg_arr['last_name']}"{/if}>
                    </div>
                    {form_error('last_name')}
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="first_name">{lang('email')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input type="text"  name="email" id="email"   autocomplete="Off" tabindex="4" maxlength="32" {if isset($employee_reg_arr['email'])} value="{$employee_reg_arr['email']}"{/if}>
                    </div>
                    {form_error('email')}
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="mobile_no" >{lang('mobile_no')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input type="text"  name="mobile_no" id="mobile_no"   autocomplete="Off" tabindex="5" maxlength="10" {if isset($employee_reg_arr['mobile_no'])} value="{$employee_reg_arr['mobile_no']}"{/if}>
                    </div>
                    {form_error('mobile_no')}
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pswd">{lang('password')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input type="password" name="pswd" id="pswd" tabindex="6" autocomplete="Off" size="24" maxlength="20"  >
                    </div>
                    {form_error('pswd')}
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="cpswd"  >{lang('confirm_password')} :<font color="#ff0000">*</font></label>
                    <div class="col-sm-4">
                        <input name="cpswd" id="cpswd" type="password" tabindex="7" autocomplete="Off" size="24" maxlength="20" >
                    </div>
                    {form_error('cpswd')}
                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-3">
                        <p>
                            <button class="btn btn-bricky" name="register" id="register" value="{lang('register_new_member')}" tabindex="8">
                                {lang('register_new_member')}
                            </button>
                        </p>
                    </div>
                    <div class="col-sm-2 col-sm-offset-2">
                        <p>
                            <button class="btn btn-bricky" name="reset" id="reset" type="reset" value="{lang('reset')}" tabindex="9" >
                                {lang('reset')}
                            </button>
                        </p>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        DatePicker.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}