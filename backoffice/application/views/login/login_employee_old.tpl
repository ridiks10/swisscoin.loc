{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<style type="text/css">
    .imgcaptcha{
        width: 100%;
        margin: 0 auto;
    }
    .font16{
        font-size: 16px !important;
    }
    .imgcaptcha div, .imgcaptcha div{
        text-align: center;
    }
</style>

<script type="text/javascript">
    function getSwitchLanguage(lang) {
        var url = "";
        var base_url = $("#base_url").val();
        var current_url = $("#current_url").val();
        var current_url_full = $("#current_url_full").val();

        if (current_url != current_url_full) {
            url = current_url_full;
        } else {
            url = current_url;
        }
        var redirect_url = base_url;

        redirect_url = base_url + lang + "/" + url;
        document.location.href = redirect_url;
    }
</script>
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_admin_username')}</span>
    <span id="error_msg2">{lang('please_enter_employee_username')}</span>
    <span id="error_msg4">{lang('please_enter_password')}</span>
    <span id="error_msg3">{lang('please_enter_captcha')}</span>
</div>
<div class="main-login col-sm-4 col-sm-offset-4">

    <input type = "hidden" name = "base_url" id = "base_url" value = "{$BASE_URL}" />
    <input type = "hidden" name = "current_url" id = "current_url" value = "{$CURRENT_URL}" />
    <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "{$CURRENT_URL_FULL}" />
    <input type="hidden" name="img_src_path" id="img_src_path" value="{$PUBLIC_URL}"/>

    <div class="logo">
        <img src="{$PUBLIC_URL}images/logos/{$site_info['logo']}"/>
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <p>
            {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/error_box.tpl" title="" name=""}
        </p>


        <ul class="topoptions">
            <li style="padding: 0px 0px 0px 0px"><a href="https://infinitemlmsoftware.com/help/login" target="_blank">{lang('help')}</a></li>

            <li class="dropdown language">
                <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                    {foreach from=$LANG_ARR item=v}
                        {if $LANG_ID == $v.lang_id}
                            <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> 
                        {/if}
                    {/foreach}
                    <span class="badge"></span>
                </a>
                <ul class="dropdown-menu posts">
                    {foreach from=$LANG_ARR item=v}
                        <li onclick="getSwitchLanguage('{$v.lang_code}');" >
                            <span class="dropdown-menu-title">
                                <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> {$v.lang_name}
                            </span>
                        </li>
                    {/foreach}
                </ul>
            </li>
        </ul>

        <div id="profileTabData" class="both">

            <div id="user" class="tab_content" >
                <section>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                        <left>
                            <h3>
                                {lang('employee_login')} {lang('Form')}
                            </h3>
                        </left>
                        </td>
                        <td>
                        <right>
                            <img class="secure_login_icon" src="{$PUBLIC_URL}images/1358434827_gnome-keyring-manager.png" width="50" />
                        </right>
                        </td>
                        </tr>
                    </table>
                    {form_open('login/verify_employee_login', 'id="login_form" name="login_form" class="form-login" onload="document.getElementById(\'captcha-form\').focus()"')}
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                        </div>
                        <fieldset>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input tabindex="1" type="text" name="admin_username"  id="admin_username" autocomplete="Off" size="32" maxlength="128" border="0" placeholder="{lang('admin_user_name')}" class="form-control" value="{$admin_username}" />
                                    <i class="fa fa-user"></i> </span>
                            </div>
                            <div class="form-group">
                                <span class="input-icon">
                                    <input tabindex="1" type="text" name="employee_username"  id="employee_username" autocomplete="Off"size="32" maxlength="128" border="0" value="{$employee_username}" placeholder="{lang('employee_user_name')}" class="form-control" />
                                    <i class="fa fa-user"></i> </span>
                            </div>
                            <div class="form-group form-actions">
                                <span class="input-icon">
                                    <input tabindex="2" type="password"  name="employee_password" id ="employee_password" size="32" maxlength="32" placeholder="{lang('password')}"  class="form-control password" />
                                    <br />
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <div class="form-actions">
                           
                                <input type="hidden" name="flag" id="flag">
                                <input type ="submit"  tabindex="3"  class="btn btn-bricky pull-center" id="user_login" name="user_login" value = "{lang('login')}" onclick="setFlag('user')"/> <span id="loginmsg" style="display:none"></span>

                            </div>
                            <div class="new-account">
                                {lang('dont_have_an_account')}? 
                                <a href="https://infinitemlmsoftware.com/register.php" class="register">
                                    {lang('sign_up_now')}
                                </a>

                                <a href="https://infinitemlmsoftware.com/" class="backtowebsite">
                                    {lang('back_to_web_site')}				
                                </a>
                            </div>
                        </fieldset>
                    {form_close()}
                </section>
            </div>
        </div>
    </div>
    <div class="" style=" text-align: center; float: none; margin-top: 10px; ">
        2013 &copy; InfiniteMLMSoftware.
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateEmployee.init();
    ValidateUserLogin.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}