{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_from_name')}</span>
    <span id="validate_msg2">{lang('you_must_enter_from_email')}</span>
    <span id="validate_msg3">{lang('you_must_enter_smtp_host')}</span>
    <span id="validate_msg4">{lang('you_must_enter_smtp_username')}</span>
    <span id="validate_msg5">{lang('you_must_enter_smtp_password')}</span>
    <span id="validate_msg6">{lang('you_must_enter_smtp_port')}</span>
    <span id="validate_msg7">{lang('you_must_enter_smtp_timeout')}</span>
    <span id="validate_msg8">{lang('select_mail_status')}</span>
    <span id="validate_msg9">{lang('smtp_authentication_status_cannot_be_null')}</span>
    <span id="validate_msg10">{lang('you_must_select_a_prefix')}</span>

</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('mail_configuration')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" name="mail_settings" id="mail_settings"')}

                <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">

                {*<div class="form-group">
                <label class="col-sm-2 control-label" for="reg_mail_status">{lang('reg_mail_status')}:</label>
                <div class="col-sm-6">

                <label class="radio-inline" for="status_yes"><input tabindex="3"   type="radio" name="reg_mail_status" id="reg_mail_status" value="yes" {if $mail_details["reg_mail_status"] == "yes"}checked {/if}/>
                {lang('yes')}</label>
                <label class="radio-inline"  for="status_no"><input tabindex="3"  type="radio"  name="reg_mail_status" id="reg_mail_status" value="no" {if $mail_details["reg_mail_status"] == "no"} checked {/if} />
                {lang('no')}  </label>   
                {form_error('reg_mail_status')}
                </div>
                </div>*}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="reg_mail_status">{lang('mail_type')}:</label>
                    <div class="col-sm-6">
                        <label class="radio-inline"  for="normal"><input tabindex="3"  type="radio" onclick="javascript:showSmtp(false);" name="reg_mail_type" id="reg_mail_normal" value="normal" {if $mail_details["reg_mail_type"] == "normal"} checked {/if} />
                            {lang('normal')}</label>  
                        <label class="radio-inline" for="smtp"><input tabindex="3"   type="radio" onclick="javascript:showSmtp(true);" name="reg_mail_type" id="reg_mail_smtp" value="smtp" {if $mail_details["reg_mail_type"] == "smtp"}checked {/if}/>
                            SMTP</label>

                        {form_error('reg_mail_type')}
                    </div>
                </div>

                <div  id="pair" style="display:{if $mail_details["reg_mail_type"] == "smtp"}block{else}none{/if}">

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_auth">{lang('smtp_authentiction')}<font color="#ff0000" >*</font> :</label>                            
                        <input tabindex="3"  type="radio" name="smtp_auth_type" id="smtp_auth_type" value="1" {if $mail_details['smtp_authentication'] eq '1'} checked {/if} /> 
                        <label class="radio-inline"  for="true">{lang('true')}</label>
                        <input tabindex="3"   type="radio" name="smtp_auth_type" id="smtp_auth_type" value="0" {if $mail_details['smtp_authentication'] eq '0'} checked {/if} />
                        <label class="radio-inline" for="false">{lang('false')}</label>
                        {form_error('reg_mail_type')}
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_protocol">{lang('prefix_for_secure_protocol_to_connect_to_server')}<font color="#ff0000" >*</font> :</label>                            
                        <input tabindex="3"  type="radio" name="smtp_protocol" id="smtp_protocol" value="tls" {if $mail_details['smtp_protocol'] eq 'tls'} checked {/if} /> 
                        <label class="radio-inline"  for="tls">{lang('tls')}</label> 
                        <input tabindex="3"   type="radio" name="smtp_protocol" id="smtp_protocol" value="ssl" {if $mail_details['smtp_protocol'] eq 'ssl'} checked {/if} />
                        <label class="radio-inline" for="ssl">{lang('ssl')}</label>
                        <input tabindex="3"   type="radio" name="smtp_protocol" id="smtp_protocol" value="none" {if $mail_details['smtp_protocol'] eq 'none'} checked {/if} />
                        <label class="radio-inline" for="none">{lang('none')}</label>
                        {form_error('reg_mail_type')}
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_host">{lang('smtp_host')}<font color="#ff0000" >*</font> :</label>
                        <div class="col-sm-6">
                            <input  type="text"  name ="smtp_host" id ="smtp_host" value="{$mail_details['smtp_host']}" maxlength="" title="SMTP Host" autocomplete="Off"tabindex="4">
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_username">{lang('smtp_username')}<font color="#ff0000" >*</font> :</label>
                        <div class="col-sm-6">
                            <input  type="text"  name ="smtp_username" id ="smtp_username" value="{$mail_details['smtp_username']}" maxlength="" title="SMTP Username" autocomplete="Off"tabindex="5">
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_password">{lang('smtp_password')}<font color="#ff0000" >*</font> :</label>
                        <div class="col-sm-6">
                            <input  type="password"  name ="smtp_password" id ="smtp_password" value="{$mail_details['smtp_password']}" maxlength="" title="SMTP Password" autocomplete="Off"tabindex="6">
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_port">{lang('smtp_port')}<font color="#ff0000" >*</font> :</label>
                        <div class="col-sm-6">
                            <input  type="text"  name ="smtp_port" id ="smtp_port" value="{$mail_details['smtp_port']}" maxlength="" title="SMTP Port" autocomplete="Off"tabindex="7">
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="smtp_timeout">{lang('smtp_timeout')}<font color="#ff0000" >*</font> :</label>
                        <div class="col-sm-6">
                            <input  type="text"  name ="smtp_timeout" id ="smtp_timeout" value="{$mail_details['smtp_timeout']}" maxlength="" title="SMTP Timeout" autocomplete="Off"tabindex="8">
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" id="referal_div"  height="30" class="text" style="display:none;">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" tabindex="9"   type="submit"  value="Update" name="update" id="update" > {lang('update')}</button>                                
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
        ValidateMailSettings.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  