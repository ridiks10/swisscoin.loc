
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_current_password')}</span>        
    <span id="error_msg2">{lang('the_password_length_should_be_greater_than_6')}</span>        
    <span id="error_msg3">{lang('password_mismatch')}</span>  
    <span id="error_msg4">{lang('you_must_enter_your_new_password_again')}</span>     
    <span id="error_msg6">{lang('you_must_enter_your_new_password')}</span>                  
    <span id="error_msg7">{lang('you_must_enter_your_confirm_password')}</span>  
    <span id="error_msg8">{lang('special_chars_not_allowed')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable ">
            <ul id="myTab3" class="nav nav-tabs tab-green">
                {if $user_type!='employee'}
                    <li class="{$tab1}">
                        <a href="#panel_tab4_example1" data-toggle="tab">
                            <i class="pink fa fa-dashboard"></i> {lang('change_admin_password')}
                        </a>
                    </li>
                {/if}
                <li class="{$tab2}">
                    <a href="#panel_tab4_example2" data-toggle="tab">
                        <i class="blue fa fa-user"></i> {lang('change_user_password')}
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                {if $user_type!='employee'}
                    <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                        {form_open('','role="form" class="smart-wizard form-horizontal" id="change_pass_admin" name="change_pass_admin" method="post"')}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>{lang('change_admin_password')}
                            </div>  
                            <br>
                            {if $preset_demo eq 'yes'}
                                <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_in_preset_demos')} </font>
                                <br>
                                <br>
                            {/if}
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="current_pwd_admin">{lang('current_password')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-3">
                                        <input name="current_pwd_admin" type="password" id="current_pwd_admin" size="20"  autocomplete="Off" tabindex="1" />
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="new_pwd_admin">{lang('new_password')}:  <font color="#ff0000">*</font></label>
                                    <div class="col-sm-3">
                                        <input name="new_pwd_admin" type="password" id="new_pwd_admin" size="20"  autocomplete="Off" tabindex="2" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="confirm_pwd_admin">{lang('confirm_password')}:  <font color="#ff0000">*</font></label>
                                    <div class="col-sm-3">
                                        <input name="confirm_pwd_admin" type="password" id="confirm_pwd_admin" size="20"  autocomplete="Off" tabindex="3" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">

                                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                                        <button class="btn btn-bricky" type="submit" name="change_pass_button_admin"  id="change_pass_button_admin" value="{lang('change_admin_password')}"  tabindex="4" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                        {form_close()}
                    </div>
                {/if}
                <div class="tab-pane{$tab2}" id="panel_tab4_example2">

                    {form_open('','role="form" class="smart-wizard form-horizontal" id="change_pass_common" name="change_pass_common" method="post"')}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('change_user_password')}
                        </div>  
                        <br/>
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="user_name_common">{lang('user_name')}:  <font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input type="text" id="user_name_common" class="username-auto-ajax" name="user_name_common" value="" tabindex="5" autocomplete="Off" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="new_pwd_common">{lang('new_password')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input name="new_pwd_common" type="password" id="new_pwd_common" size="20"  autocomplete="Off" tabindex="6" />
                                </div>
                                <div style="display:none;">
                                    <span id='span_new_pwd_common'>
                                        {lang('you_must_enter_new_password')}
                                    </span>
                                    <span id='span_new_pwd_gt'>
                                        {lang('the_password_length_should_be_greater_than_6')}
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="confirm_pwd_common">{lang('confirm_password')}:   <font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input name="confirm_pwd_common" type="password" id="confirm_pwd_common" size="20"  autocomplete="Off" tabindex="7" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">

                                    <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                                    <button class="btn btn-bricky" type="submit" name="change_pass_button_common"  id="change_pass_button_common" value="{lang('change_user_password')}" tabindex="8">{lang('update')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidatePassword.init();
    });


</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  

