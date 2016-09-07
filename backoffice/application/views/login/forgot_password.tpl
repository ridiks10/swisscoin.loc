{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="main-login col-sm-4 col-sm-offset-4">
    <div class="logo">
        <img src="{$PUBLIC_URL}images/logos/{$site_info["logo"]}" />
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <h2>{lang('forgot_password')}</h2>
        <p>
        <mesasge>{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/error_box.tpl" title="" name=""}</mesasge>
        </p>
        <div id="span_js_messages" style="display:none;">
            <span id="error_msg1">{lang('Invalid_Username')}</span>        
            <span id="error_msg2">{lang('Invalid_email')}</span>        
        </div>

        {form_open('', 'class="login_form" id="forgot_password" name="forgot_password" method="post" onload="document.getElementById("captcha-form").focus()"')}
        <div class="errorHandler alert alert-danger no-display">
            <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
        </div>
        <fieldset>
            <div class="form-group">
                <span class="input-icon">
                    <input type="text" class="form-control"  id="user_name" name="user_name" placeholder="{lang('user_name')}" AUTOCOMPLETE = "OFF" tabindex="1" >{form_error('user_name')}
                    <i class="fa fa-user"></i> </span><span class="help-block" for="user_name"></span>
            </div>

            <div class="form-group">
                <span class="input-icon">
                    <input type="text" class="form-control"  id="e_mail" name="e_mail" placeholder="{lang('email')}" AUTOCOMPLETE = "OFF" tabindex="2" >  {form_error('e_mail')} 


                    <div class="imgcaptcha">

                        <div class="col-md-6 col-my" style="padding:0px; text-align:left;">  
                            <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha" /></div>
                        <div class="col-md-6 col-my" style="padding:0px;">   <div class="Change-text">
                                <a href="#" onclick="document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/admin/' + Math.random();
                                             document.getElementById('captcha-form').focus();"
                                   id="change-image" class="color">Not readable? Change text.</a></div> 
                            <div class="width-media">	
                                <input type="text" style="width:100%;" name="captcha" id="captcha-form" autocomplete="off" tabindex="3" /><br/></div>
                        </div>
                    </div>
            </div>
            <div class="form-actions">
            </div>
            <div class="form-actions">
                <input type="submit" class="btn btn-bricky pull-right" id="forgot_password_submit" name="forgot_password_submit" value="{lang('send_request')}" tabindex="4" >&nbsp;

                <leftspan style="float:none"><a href="{$BASE_URL}" ><div class="btn btn-light-grey go-back">
                            <i class="fa fa-circle-arrow-left"></i> Back
                        </div></a>
                </leftspan>
            </div>
        </fieldset>
        {form_close()}
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
</body>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
