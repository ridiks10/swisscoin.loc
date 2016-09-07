{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}
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
            <div class="tabbable ">
                <ul id="myTab3" class="nav nav-tabs tab-green">
                    {if $LOG_USER_TYPE!='employee'}
                        <li class="{$tab1}">
                            <a href="#panel_tab4_example1" data-toggle="tab">
                                <i class="pink fa fa-dashboard"></i> {lang('change_transaction_password')}
                            </a>
                        </li>
                    {/if}
                    <li class="{$tab2}">
                        <a href="#panel_tab4_example2" data-toggle="tab">
                            <i class="blue fa fa-user"></i> {lang('change_user_transaction_password')}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    {if $LOG_USER_TYPE!='employee'}
                        <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                            <p>
                                {form_open('','role="form" class="smart-wizard form-horizontal" name="change_pass" id="change_pass"')}
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>
                                    <span class="visible-md visible-lg hidden-sm hidden-xs">
                                        {lang('change_transaction_password')}
                                    </span>
                                    <span class="visible-xs visible-sm hidden-md hidden-lg">
                                        Change transact. pass
                                    </span>
                                </div>
                                {if $preset_demo eq 'yes'}
                                    <br>
                                    <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_in_preset_demos')} </font>
                                    <br>
                                {/if}
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="old_passcode">{lang('current_transaction_password')}:<font color="#ff0000">*</font> </label>
                                        <div class="col-sm-3">                           
                                            <input type="password" name="old_passcode" id="old_passcode" tabindex="1" maxlength="10" />{form_error('old_passcode')}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="new_passcode">{lang('new_transaction_password')}:<font color="#ff0000">*</font> </label>
                                        <div class="col-sm-3">                           
                                            <input type="password" name="new_passcode" id="new_passcode" tabindex="2" maxlength="10" />{form_error('new_passcode')}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="re_new_passcode">{lang('reenter_new_transaction_password')}:<font color="#ff0000">*</font> </label>
                                        <div class="col-sm-3">                           
                                            <input type="password" name="re_new_passcode" id="re_new_passcode" tabindex="3" maxlength="10" />{form_error('re_new_passcode')}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2 col-sm-offset-3">                           


                                            <button class="btn btn-bricky" type="submit" name="change_tran"  value="change_tran" id="change"  tabindex="4" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                            {form_close()}
                        </div>
                    {/if}
                    <div class="tab-pane{$tab2}" id="panel_tab4_example2">
                        <p>
                            {form_open('','role="form" class="smart-wizard form-horizontal"  name="change_pass_user" id="change_pass_user" method="post"')}
                        <div class="panel panel-default">
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                                </div>
                            </div>
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>{lang('change_user_transaction_password')}
                            </div>  
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}:<font color="#ff0000">*</font> </label>
                                    <div class="col-sm-3">                           
                                        <input type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="5" >  {form_error('user_name')} </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="new_passcode_user">{lang('new_password')}: <font color="#ff0000">*</font> </label>
                                    <div class="col-sm-3">                           
                                        <input type="password" name="new_passcode_user" id="new_passcode_user" maxlength="10" tabindex="6" /> {form_error('new_passcode_user')} </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="re_new_passcode_user">{lang('reenter_new_password')}: <font color="#ff0000">*</font> </label>
                                    <div class="col-sm-3">                           
                                        <input type="password" name="re_new_passcode_user" id="re_new_passcode_user" tabindex="7" maxlength="10" /> {form_error('re_new_passcode_user')} </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">                           

                                        <button class="btn btn-bricky" type="submit" name="change_user"  id="change_user"  tabindex="8" value="change_user" >{lang('update')}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
