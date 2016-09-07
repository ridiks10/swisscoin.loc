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
        <img src="{$PUBLIC_URL}images/logos/logo.png"/>
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <p>
            {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/error_box.tpl" title="" name=""}
        </p>

        <div id="profileTabList" class="tabs">
            <a href="#admin" {if $url_user_type=="admin"} class="active" {/if} >{lang('admin_login')}</a>
            <span style="color: #428bca; text-decoration: none;margin-right: 10px;">|</span>
            <a href="#user" {if $url_user_type=="user"} class="active" {/if}> {lang('user_login')}</a>
        </div>

        <ul class="topoptions">
            {if $HELP_STATUS}
                <li style="padding: 0px 0px 0px 0px">
                    <a href="https://infinitemlmsoftware.com/help/login" target="_blank">{lang('help')}</a>
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
            <div id="admin" class="tab_content" {if $url_user_type=="admin"} style="display: block;" {else} style="display: none;" {/if}>
                <section>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                        <left>
                            <h3>
                                {lang('admin_login')} {lang('Form')}
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
                    {form_open('login/verifylogin_admin','class="form-login" id="login_form_admin" name="login_form_admin" onload="document.getElementById(\'captcha-form\').focus()"')}
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-remove-sign"></i>{lang('errors_check')}.
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <span class="input-icon">
                                <input tabindex="1" type="text" name="admin_user_name"  id="admin_user_name" autocomplete="Off" size="32" maxlength="128" border="0" value="{$admin_user_name}" placeholder="{lang('user_name')}" class="form-control" />
                                <i class="fa fa-user"></i> </span>
                        </div>
                        <div class="form-group form-actions">
                            <span class="input-icon">
                                <input tabindex="2" type="password"  name="admin_password" id ="admin_password" size="32" maxlength="32" placeholder="{lang('password')}" class="form-control password" /><br/>
                                {if $admin_captcha_status=='yes'}
                                    <div class="imgcaptcha">

                                        <div class="col-md-6 col-my" style="padding:0px; text-align:left;">  
                                            <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha" /></div>
                                        <div class="col-md-6 col-my" style="padding:0px;">   <div class="Change-text">
                                                <a href="#" onclick="
                                                        document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/admin/' + Math.random();
                                                        document.getElementById('captcha-form').focus();"
                                                   id="change-image" class="color">Not readable? Change text.</a></div> 
                                            <div class="width-media">	
                                                <input tabindex="3"type="text" style="width:100%;" name="captcha" id="captcha" autocomplete="off" /><br/></div>
                                        </div>
                                    </div>
                                {/if}
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="flag" id="flag" value="">
                            <input type ="submit"  tabindex="3" id="admin_login" name="admin_login" value = "{lang('login')}" class="btn btn-bricky pull-center" /><span id="loginmsg" style="display:none"></span>
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
            <div id="user" class="tab_content" {if $url_user_type=="user"} style="display: block;" {else} style="display: none;" {/if}>
                <section>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                        <left>
                            <h3>
                                {lang('user_login')} {lang('Form')}
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
                    {form_open('login/verifylogin_user','id="login_form" name="login_form" class="form-login" onload="document.getElementById(\'captcha-form\').focus()"')}
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                    </div>
                    <fieldset>

                        {if $admin_user_name==""}
                            <div class="form-group">
                                <span class="input-icon">
                                    <input tabindex="1" type="text" name="admin_username"  id="admin_username" autocomplete="Off" size="32" maxlength="128" border="0" placeholder="{lang('admin_user_name')}" class="form-control" value="{$admin_user_name}"/>
                                    <i class="fa fa-user"></i> </span>
                            </div>
                        {else}
                            <input tabindex="1" type="hidden" name="admin_username"  id="admin_username" autocomplete="Off" size="32" maxlength="128" border="0"  value="{$admin_user_name}"/>
                        {/if}
                        <div class="form-group">
                            <span class="input-icon">
                                <input tabindex="1" type="text" name="user_username"  id="user_username" autocomplete="Off"size="32" maxlength="128" border="0" value="{$user_user_name}" placeholder="{lang('user_name')}" class="form-control" />
                                <i class="fa fa-user"></i> </span>
                        </div>
                        <div class="form-group form-actions">
                            <span class="input-icon">
                                <input tabindex="2" type="password"  name="user_password" id ="user_password" size="32" maxlength="32" placeholder="{lang('password')}"  class="form-control password" />
                                <br />
                                {if $user_captcha_status}
                                    <div class="imgcaptcha">

                                        <div class="col-md-6 col-my" style="padding:0px; text-align:left;">  
                                            <img src="{$BASE_URL}captcha/load_captcha/user" id="captcha_user" /></div>
                                        <div class="col-md-6 col-my" style="padding:0px;">   <div class="Change-text">
                                                <a href="#" onclick="
                                                        document.getElementById('captcha_user').src = '{$BASE_URL}captcha/load_captcha/user/' + Math.random();
                                                        document.getElementById('captcha-user').focus();"
                                                   id="change-image" class="color">Not readable? Change text.</a></div> 
                                            <div class="width-media">
                                                <input tabindex="3" style=" width:100%;" type="text" name="captcha_user" id="captcha_user" autocomplete="off" /><br/>
                                            </div> </div>
                                    </div>
                                {/if}
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="flag" id="flag">
                            <input type ="submit"  tabindex="3"  class="btn btn-bricky pull-center" id="user_login" name="user_login" value = "{lang('login')}" onclick="setFlag('user')"/> <span id="loginmsg" style="display:none"></span>
                            <!--	Login 
                            <i class="fa fa-arrow-circle-right"/></i>-->

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
    {$curr_date = date('Y')}
    <div class="" style=" text-align: center; float: none; margin-top: 10px; ">
        {$curr_date} &copy; {$COMPANY_NAME}
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/login_footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateLogin.init();
        ValidateUserLogin.init();
    });
</script>
<script>

    $(".tabs > a").click(function () {
        $(".tabs a").removeClass("active"); // removes 'active' class from all anchors in '.tabs'
        $(this).addClass("active"); // current tab will be 'active'
        navIndex = $('.tabs > a').index(this); // check the index
        $.cookie("nyacord", navIndex); // set the index for cookie

        $('.tab_content').hide();
        activeTab = $(this).attr("href"); // the active tab + content
        $(activeTab).fadeIn(0);
        return false;
    });

</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}