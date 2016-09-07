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
    <span id="error_msg1">{lang('please_enter_username')}</span>
    <span id="error_msg2">{lang('please_enter_password')}</span>
    <span id="error_msg3">{lang('please_enter_captcha')}</span>
</div>

<div class="main-login col-sm-4 col-sm-offset-4">

    <div class="logo">
        <img src="{$PUBLIC_URL}images/logos/{$site_info['logo']}"/>
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <p>
            {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/error_box.tpl" title="" name=""}
        </p>

        <ul class="topoptions">
            {if $HELP_STATUS =="yes"}
                <li style="padding: 0px 0px 0px 0px">
                    <a href="https://infinitemlmsoftware.com/help/{$help_link}" target="_blank">{lang('help')}</a>
                </li>
            {/if}

            {if $LANG_STATUS=="yes"}
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
            {/if}
        </ul>

        <div id="profileTabData" class="both">

            <div id="user" class="tab_content">
                <section>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                        <left>
                            <h3>
                                {lang('user_login')}
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
                    {form_open('login/verifylogin','id="login_form" name="login_form" class="form-login" onload="document.getElementById(\'captcha-form\').focus()"')}
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <span class="input-icon">
                                <input tabindex="1" type="text" name="user_username"  id="user_username" autocomplete="Off"size="32" maxlength="32" border="0" value="{$url_user_name}" placeholder="{lang('user_name')}" class="form-control"  />
                                <i class="fa fa-user"></i> </span>
                        </div>
                        <div class="form-group form-actions">
                            <span class="input-icon">
                                <input type="password" class="form-control password" name="user_password" id="user_password" placeholder="Password" tabindex="2" maxlength="32"/>
                                <i class="fa fa-lock"></i>
                                <a class="forgot" href="{$BASE_URL}login/forgot_password">
                                    {lang('forgot_password')}
                                </a> 
                                <br />
                                {if $CAPTCHA_STATUS}
                                    <div class="imgcaptcha">
                                        <div class="col-md-6 col-my" style="padding:0px; text-align:left;">  
                                            <img src="{$BASE_URL}captcha/load_captcha/user" id="captcha_user" />
                                        </div>
                                        <div class="col-md-6 col-my" style="padding:0px;">   <div class="Change-text">
                                                <a href="#" onclick="
                                                        document.getElementById('captcha_user').src = '{$BASE_URL}captcha/load_captcha/user/' + Math.random();
                                                        document.getElementById('captcha-user').focus();"
                                                   id="change-image" class="color">{lang('not_readable_change_text')}</a></div> 
                                            <div class="width-media">
                                                <input tabindex="3" style=" width:100%;" type="text" name="captcha_user" id="captcha_user" autocomplete="off" /><br/>
                                            </div> 
                                        </div>
                                    </div>
                                {/if}
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="flag" id="flag">
                            <input type ="submit"  tabindex="3"  class="btn btn-bricky pull-right" id="user_login" name="user_login" value = "{lang('login')}" /> <span id="loginmsg" style="display:none"></span>
                        </div>
                        {* <div class="new-account">
                            {lang('dont_have_an_account')}? 
                           <a href="{$BASE_URL}register/user_register" class="register">*}
                            {* <a href="{$BASE_URL}../{$admin_user_name}" class="register">
                                {lang('sign_up_now')}
                            </a>*}

                           {* <a href="{$BASE_URL}../" class="backtowebsite">
                                {lang('back_to_web_site')}				
                            </a>
                        </div>*}
                    </fieldset>
                    {form_close()}
                </section>
            </div>
        </div>
    </div>
    <div class="" style=" text-align: center; float: none; margin-top: 10px; ">
        {date('Y')} &copy; {$COMPANY_NAME} {$smarty.const.SOFTWARE_VERSION}
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
<script src="{$PUBLIC_URL}javascript/login_user.js" type="text/javascript"></script>
<script>
        jQuery(document).ready(function() {
            Main.init();
            ValidateLoginUser.init();
        });
</script>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["setDomains", ["*.swisscoin.eu"]]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.swisscoin.eu/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//piwik.swisscoin.eu/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}