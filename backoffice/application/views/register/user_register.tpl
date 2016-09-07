<!DOCTYPE html>
<html lang="en" class="no-js">
    <!-- start: HEAD -->
    <!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
    <!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
    <head>
        <title>{$title}</title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- end: META -->    
        <link rel="shortcut icon" type="image/png" href="{$PUBLIC_URL}images/logos/{$site_info["favicon"]}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.0.0.js"></script>
        <!-- start: MAIN CSS -->
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap/css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}fonts/style.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/main.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/main-responsive.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/iCheck/skins/all.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/perfect-scrollbar/src/perfect-scrollbar.css">
        <link rel="stylesheet/less" type="text/css" href="{$PUBLIC_URL}css/styles.less">
        <link rel="stylesheet/less" type="text/css" href="{$PUBLIC_URL}css/animations.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/theme_light.css" type="text/css" id="skin_color">        
        <link href="{$PUBLIC_URL}plugins/summernote/build/summernote.css">
        <!-- end: MAIN CSS -->

        {*!-- start: JS/CSS REQUIRED FOR THIS PAGE ONLY --*}
        {foreach from = $ARR_SCRIPT item=v}
            {assign var="type" value=$v.type}
            {assign var="loc" value=$v.loc}
            {if $loc == "header"}
                {if $type == "js"}
                    <script src="{$PUBLIC_URL}javascript/{$v.name}" type="text/javascript" ></script>
                {elseif $type == "css"}
                    <link href="{$PUBLIC_URL}css/{$v.name}" rel="stylesheet" type="text/css" />
                {elseif $type == "plugins/js"}
                    <script src="{$PUBLIC_URL}plugins/{$v.name}" type="text/javascript" ></script>
                {elseif $type == "plugins/css"}
                    <link href="{$PUBLIC_URL}plugins/{$v.name}" rel="stylesheet" type="text/css" />
                {/if}
            {/if}
        {/foreach}
        {*!-- end: JS/CSS REQUIRED FOR THIS PAGE ONLY --*}
        <script src="{$PUBLIC_URL}javascript/switch_lang.js" type="text/javascript" ></script>
        {if $CURRENT_CTRL != 'login' && $SESS_STATUS}
            <script src="{$PUBLIC_URL}javascript/timer.js" type="text/javascript"></script>
            {*<script src="{$PUBLIC_URL}javascript/page_loader.js" type="text/javascript"></script>*}
            <script src="{$PUBLIC_URL}javascript/currency.js" type="text/javascript" ></script>
        {/if}

        <script>
            $.ajaxSetup({
                data: {
            {$CSRF_TOKEN_NAME}: '{$CSRF_TOKEN_VALUE}'
                }
            });
        </script>
    </head>
    <body  class="{if $CURRENT_CTRL =='login'}login example2{/if}" >
        <input type = "hidden" name = "base_url" id = "base_url" value = "{$BASE_URL}" />
        <input type = "hidden" name = "img_src_path" id="img_src_path" value="{$PUBLIC_URL}"/>
        <input type = "hidden" name = "current_url" id = "current_url" value = "{$CURRENT_URL}" />
        <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "{$CURRENT_URL_FULL}" />
        <input type = "hidden" name = "DEFAULT_CURRENCY_VALUE " id="DEFAULT_CURRENCY_VALUE " value="{$DEFAULT_CURRENCY_VALUE }"/>
        <input type = "hidden" name = "DEFAULT_CURRENCY_CODE" id="DEFAULT_CURRENCY_CODE" value="{$DEFAULT_CURRENCY_CODE}"/>
        <input type = "hidden" name = "DEFAULT_SYMBOL_LEFT" id="DEFAULT_SYMBOL_LEFT" value="{$DEFAULT_SYMBOL_LEFT}"/>
        <input type = "hidden" name = "DEFAULT_SYMBOL_RIGHT" id="DEFAULT_SYMBOL_RIGHT" value="{$DEFAULT_SYMBOL_RIGHT}"/>
        <input type = "hidden" name = "TABLE_PREFIX" id="TABLE_PREFIX" value="{$TABLE_PREFIX}"/>
        <input type = "hidden" name = "user_type" id="user_type" value="{$LOG_USER_TYPE}"/>



        <div id="span_js_messages" style="display: none;"> 
            <span id="validate_sponsor_name">{sprintf(lang('required'),lang("sponsor name"))}</span>
            <span id="validate_msg2">{lang('validate_placement_data')}</span>
            <span id="validate_msg3">{lang('checking_your_position')}</span>
            <span id="validate_msg4">{lang('position_validated')}</span>
            <span id="validate_msg5">{lang('position_not_useable')}</span>
            <span id="validate_msg6">{lang('sponser_name_validated')}</span>
            <span id="validate_msg7">{lang('checking_sponser_user_name')}</span>
            <span id="validate_msg8">{lang('invalid_sponser_user_name')}</span>
            <span id="validate_msg9">{lang('invalid_e_pin')}</span>
            <span id="validate_msg10">{lang('e_pin_validated')}</span>
            <span id="validate_msg11">{lang('checking_e_pin_availability')}</span>
            <span id="validate_msg12">{lang('you_must_select_product')}</span>
            <span id="validate_msg13">{lang('you_must_enter_e_pin')}</span>
            <span id="validate_msg14">{lang('you_must_enter_full_name')}</span>
            <span id="validate_msg15">{lang('you_must_enter_password')}</span>
            <span id="validate_msg16">{lang('minimum_six_characters_required')}</span>
            <span id="validate_msg17">{lang('you_must_enter_your_password_again')}</span>
            <span id="validate_msg18">{lang('password_miss_match')}</span>
            <span id="validate_msg19">{lang('you_must_select_date_of_birth')}</span>
            <span id="validate_msg20">{lang('age_should_be_greater_than_18')}</span>
            <span id="validate_msg21">{lang('you_must_enter_sponser_user_name')}</span>
            <span id="validate_msg22">{lang('you_must_enter_sponser_id')}</span>
            <span id="validate_msg23">{lang('you_must_select_your_position')}</span>
            <span id="validate_msg24">{lang('referral_name')}</span>
            <span id="validate_msg25">{lang('You_must_enter_your_mobile_no')}</span>
            <span id="validate_msg26">{lang('terms_condition')}</span>
            <span id="validate_msg27">{lang('user_name_not_availablity')}</span>
            <span id="validate_msg28">{lang('user_name_not_available')}</span>
            <span id="validate_msg29">{lang('user_name_available')}</span>
            <span id="validate_msg30">{lang('You_must_select_a_date')}</span>
            <span id="validate_msg31">{lang('You_must_select_a_month')}</span>
            <span id="validate_msg32">{lang('You_must_select_a_year')}</span>
            <span id="validate_msg33">{lang('You_must_select_gender')}</span>
            <span id="validate_msg34">{lang('You_must_select_country')}</span>
            <span id="validate_msg35">{lang('mail_id_format')}</span>
            <span id="validate_msg36">{lang('mob_no_10_digit')}</span>
            <span id="validate_msg37">{lang('digits_only')}</span>
            <span id="validate_msg38">{lang('you_must_enter_username')}</span>
            <span id="validate_msg39">{lang('special_chars_not_allowed')}</span>
            <span id="validate_msg40">{lang('you_must_enter_email_id')}</span>
            <span id="validate_msg41">{lang('You_must_enter_your_address')}</span>
            <span id="validate_msg42">{lang('enter_card_no')}</span>
            <span id="validate_msg43">{lang('ent_amnt')}</span>
            <span id="validate_msg44">{lang('ent_valid_no')}</span>
            <span id="validate_msg45">{lang('ent_expiry_date')}</span>
            <span id="validate_msg46">{lang('ent_fore_name')}</span>
            <span id="validate_msg47">{lang('ent_sure_name')}</span>
            <span id="validate_msg48">{lang('special_chars_not_allowed')}</span> 
            <span id="validate_msg49">{lang('checking_balance')}</span>
            <span id="validate_msg50">{lang('insuff_bal')}</span> 
            <span id="validate_msg51">{lang('bal_ok')}</span>
            <span id="validate_msg52">{lang('invalid_transaction_password')}</span>
            <span id="validate_msg53">{lang('transaction_ok')}</span>
            <span id="validate_msg54">{lang('checking_transaction')}</span>
            <span id="validate_msg55">{lang('bal_ok')}</span>
            <span id="validate_msg56">{lang('you_must_select_pay_type')}</span>
            <span id="validate_msg57">{lang('you_must_enter_pin_value')}</span>
            <span id="validate_msg58">{lang('characters_only')}</span>
            <span id="validate_msg59">{lang('pan_format')}</span>
            <span id="validate_msg60">{lang('checking_trans_details')}</span>
            <span id="validate_msg61">{lang('invalid_trans_details')}</span>
            <span id="validate_msg62">{lang('valid_trans_details')}</span>
            <span id="validate_msg63">{lang('username_more_than_6_charactors')}</span>
            <span id="validate_msg65">{lang('enter_second_name')}</span>
            <span id="validate_msg66">{lang('enter_address_line2')}</span>
            <span id="validate_msg67">{lang('enter_city')}</span>
            <span id="validate_msg68">{lang('sponsor_full_name')}</span>
            <span id="validate_msg69">{lang('enter_atleast_3_chars')}</span>
            <span id="validate_msg70">{lang('mobile_number_must_10digits_long')}</span>
            <span id="validate_msg71">{lang('duplicate_epin')}</span>
            <span id="validate_msg72">{lang('user_name_cannot_be_null')}</span>
            <span id="validate_msg73">{lang('must_enter_first_name')}</span>
            <span id="validate_msg74">{lang('must_enter_second_name')}</span>
            <span id="validate_msg75">{lang('only_alphanumerals')}</span>
            <span id="validate_msg76">{lang('username_cannot_be_greater_than_12_characters')}</span>
            <span id="validate_msg78">{lang('city_field_characters')}</span>
            <span id="validate_msg79">{lang('adderss_field_characters')}</span>
            <span id="validate_msg80">{lang('password_characters_allowed')}</span>
            <span id="validate_msg81">{lang('digits_only')}</span>
            <span id="select_state">{lang('select_state')}</span>

        </div>
        <style>
            .val-error {
                color:rgba(249, 6, 6, 1);
                opacity:1;
            }
            .box-login {
                background: #FFF none repeat scroll 0% 0%;
                border-radius: 5px;
                box-shadow: -30px 30px 50px rgba(0, 0, 0, 0.32);
                overflow: hidden;
                padding: 15px;
            }
            body, .main-container, .footer, .main-navigation, ul.main-navigation-menu > li > ul.sub-menu, .navigation-small ul.main-navigation-menu > li > ul.sub-menu {

                background-color: rgba(204, 204, 204, 0.39) !important;
            }
        </style>
        <script>
            jQuery(document).ready(function ()
            {
                jQuery("#close_link").click(function ()
                {
                    jQuery("#message_box").fadeOut(1000);
                    jQuery("#message_box").removeClass('ok');
                });
            });
        </script>
        <script type="text/javascript">
            function getSwitchLanguage(lang,lang_id) {
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
                $('#cur_lang_id').val(lang_id)
                document.location.href = redirect_url;
            }
        </script>

        <p>
            {if $MESSAGE_DETAILS }
                {if $MESSAGE_STATUS }
                    {if $MESSAGE_TYPE }
                        {assign var="message_class" value="errorHandler alert alert-success"}
                    {else}
                        {assign var="message_class" value="errorHandler alert alert-danger"}
                    {/if}

                <div id="message_box"  class="{$message_class}">
                    <div id="message_note">                           
                        {$MESSAGE_DETAILS}
                    </div>
                    <a href="#" id= "close_link" class="panel-close pull-right" style="margin-top: -18px;"> <i class="fa fa-times"></i></a>
                </div>
            {/if}
        {/if}
    </p>
    <div class="main-login col-sm-4 col-sm-offset-4">

        <div class="logo" style="text-align: center;">
            <img src="{$PUBLIC_URL}images/logos/{$site_info['logo']}"/>
        </div>
        <!-- start: LOGIN BOX -->
        <div class="box-login">


            <ul class="topoptions">


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
                        <ul class="dropdown-menu posts" style="margin-left: -150px;">
                            {foreach from=$LANG_ARR item=v}
                                <li onclick="getSwitchLanguage('{$v.lang_code}','{$v.lang_id}');" >
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

                            </td>
                            </tr>
                        </table>
                        {form_open('register/register_submit', 'role="form" class="smart-wizard form-horizontal" method="post"  name="form" id="form"')}
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-remove-sign"></i> {lang('errors_check')}.
                        </div>
                        <fieldset>

                            <input type="hidden" name="cur_lang_id" id="cur_lang_id" value="{$LANG_ID}"/>
                            <input type="hidden" name="mlm_plan" id="mlm_plan" value="{$MLM_PLAN}"/>
                            <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}"/>
                            <input type="hidden" name="lang_id" id="lang_id" value="{$LANG_ID}"/>
                            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
                            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}"/>
                            <input type="hidden" id="reg_from_tree" name="reg_from_tree" value="{$reg_from_tree}"/>
                            <input type="hidden" id="username_type" name="username_type" value="{$user_name_type}"/>

                            <input type="hidden" id="ewallet_bal" name="ewallet_bal" value="0"/>

                            <input type="hidden" id ="product_status" name= "product_status"  value = "{$MODULE_STATUS['product_status']}" />              
                            <input name="date_of_birth" id="date_of_birth" type="hidden" size="16" maxlength="10"  {if $reg_count>0} value="{$reg_post_array['date_of_birth']}" {/if} />


                            <div id="step-1">
                                <div class="col-md-12">
                                    <div class="errorHandler alert alert-danger no-display">
                                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                    </div>
                                </div>


                                <div class="form-group" {*style="margin-top: 10px;"*}>
                                    <label class="control-label col-sm-offset-1" for="sponsor_user_name">{lang('sponsor_user_name')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <input name="sponsor_user_name"  id="sponsor_user_name" type="text" size="22" maxlength="20" autocomplete="Off" value="{$sponsor_user_name}"  title="" class="form-control" readonly="readonly"/>
                                        <span id="referral_box" style="display:none;"></span> 
                                        <span id="errormsg4"></span>
                                        {if isset($error['sponsor_user_name'])}<span class='val-error' >{$error['sponsor_user_name']} </span>{/if}
                                    </div> 
                                </div>
                                <input name="sponsor_full_name"  id="sponsor_user_name" type="hidden"  autocomplete="Off" value="Infinite"  title="" class="form-control"/>



                                {if $reg_from_tree && $MLM_PLAN != "Unilevel"} 
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="placement_user_name">{lang('placement_user_name')}:<font color="#ff0000">*</font></label>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <input  type="text" name="placement_user_name" id="placement_user_name" size="20" value="{$placement_user_name}" readonly="" autocomplete="Off" title="" class="form-control"/> 
                                            <span id="username_box" style="display:none;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="placement_full_name">{lang('placement_full_name')}:<font color="#ff0000">*</font></label>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <input  type="text" name="placement_full_name" id="placement_full_name" size="22" maxlength="50"  value="{$placement_full_name}" readonly="" autocomplete="Off"  class="form-control">
                                        </div>
                                    </div>
                                {else}
                                    <input  type="hidden" name="placement_user_name" id="placement_user_name" size="20" value="{$placement_user_name}" readonly="" autocomplete="Off" title="" class="form-control"/> 
                                    <input  type="hidden" name="placement_full_name" id="placement_full_name" size="22" maxlength="50"  value="{$placement_full_name}" readonly="" autocomplete="Off"  class="form-control">
                                {/if}

                                {if $MLM_PLAN == "Binary"}
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="position">{lang('position')}:<font color="#ff0000">*</font></label>
                                        <div class="col-sm-7">
                                            <select  name="position" id="position" class="form-control" >   

                                                {if $reg_from_tree} 
                                                    {if $position =='L'}
                                                        <option value="L" selected="selected" readonly="true">{lang('left_leg')}</option>
                                                    {elseif $position =='R'}
                                                        <option value="R" selected="selected" readonly="true">{lang('right_leg')}</option>
                                                    {/if}
                                                {else}
                                                    <option value="" selected="selected">{lang('select_leg')}</option>
                                                    <option value="L" {if isset($reg_post_array['position']) && $reg_post_array['position'] == 'L'}selected=""{/if}>{lang('left_leg')}</option>
                                                    <option value="R" {if isset($reg_post_array['position']) && $reg_post_array['position'] == 'R'}selected=""{/if}>{lang('right_leg')}</option>
                                                {/if}                                            
                                            </select>
                                            <span id="errormsg2"></span>
                                            {if isset($error['position'])}<span class='val-error' >{$error['position']} </span>{/if}
                                        </div>
                                    </div> 
                                {else}
                                    <input  type='hidden' value='' name='position' id='position' class="form-control">
                                {/if}

                                {if $MODULE_STATUS['product_status'] == "yes"}


                                    <input  type='hidden' value='0' name='product_id' id='product_id' class="form-control">
                                {else}
                                    <input  type='hidden' value='0' name='product_id' id='product_id' class="form-control">
                                {/if}

                            </div> 

                            <div id="step-2">

                                {if {$user_name_type}!="dynamic"}
                                    <div class="form-group">
                                        <label class="control-label col-sm-offset-1" for="user_name_entry">{lang('User_Name')}:<font color="#ff0000">*</font></label>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <input  type="text" name="user_name_entry" id="user_name_entry" maxlength="12" autocomplete="Off"  {if $reg_count>0} value="{$reg_post_array['user_name_entry']}" {/if} class="form-control">
                                            <span id="errormsg3"></span>
                                            <span id="errmsg33"></span>
                                            {if isset($error['user_name_entry'])}<span class='val-error'>{$error['user_name_entry']} </span>{/if}
                                        </div>  
                                    </div>
                                {else}
                                    <input  type='hidden' value='{$user_name_type}' name='user_name_entry' id='user_name_entry' class="form-control">
                                {/if}


                                <div class="form-group">

                                    <label class="control-label col-sm-offset-1" for="email">{lang('email')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <input  name="email" id="email" type="text"  autocomplete="Off" maxlength="75" class="form-control" {if isset($reg_post_array['email'])} value="{$reg_post_array['email']}" {/if}>
                                        {if isset($error['email'])}<span class='val-error' >{$error['email']} </span>{/if}
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-offset-1" for="country">{lang('country')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <select   name="country" id="country" {*onChange="getAllStates(this.value)"*} class="form-control" >                                       
                                            <option value="" class="form-control">{*{lang('select_country')}*}</option>
                                            {$countries}
                                        </select>
                                        {if isset($error['country'])}<span class='val-error' >{$error['country']} </span>{/if}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-offset-1" for="password">{lang('password')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <input   type="password"  name="pswd" id="pswd"  maxlength="35" autocomplete="Off"  class="form-control" >
                                        {if isset($error['pswd'])}<span class='val-error' >{$error['pswd']} </span>{/if}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-offset-1" for="cpswd">{lang('confirm_password')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <input  name="cpswd" id="cpswd" type="password" autocomplete="Off"  maxlength="35" class="form-control" >
                                        {if isset($error['cpswd'])}<span class='val-error' >{$error['cpswd']} </span>{/if}
                                    </div>
                                </div>




                                <div class="modal fade" id="panel-config" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                                                    &times;
                                                </button>
                                                <h4 class="modal-title">{lang('terms_conditions')}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table cellpadding="0" cellspacing="0" align="center">
                                                    <tr>
                                                        <td width="95%">
                                                            {$termsconditions}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-2"> </div>
                                    <label class="col-sm-8" for="">    

                                        <label class="checkbox-inline">
                                            <input name="agree" id="agree"  type="checkbox"  >
                                            <a class="btn btn-xs btn-link panel-config" data-toggle="modal" href ="#panel-config"  style="text-decoration: none" >
                                                {lang('I_ACCEPT_TERMS_AND_CONDITIONS')}
                                            </a>
                                            <font color="#ff0000">*</font>
                                            {if isset($error['agree'])}<span class='val-error' >{$error['agree']} </span>{/if}
                                        </label>
                                    </label>
                                </div>
                                <div class="form-group">

                                    <div class="col-sm-4 col-sm-offset-3">

                                        <button  class="btn btn-blue next-step btn-block"  id="form_submit" type='submit' name='form_submit' disabled='disabled'>
                                            Submit <i class="fa fa-arrow-circle-right"></i>
                                        </button> 
                                    </div>
                                </div>
                            </div> 

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
    <script>
        jQuery(document).ready(function () {
            Main.init();
            ValidateUser.init();
        {*        FormWizard.init();*}

        });

        window.onload = function () {
            $("#sponsor_user_name").trigger('blur');
        {*if (document.getElementById("page_container") && document.getElementsByClassName("main-navigation")) {
        document.getElementById("page_container").style.height = $(".main-navigation").height() + "px";
        }
        if (document.getElementById("page_container") && document.getElementById("menu")) {
        document.getElementById("page_container").style.height = $("#menu").height() + "px";
        }*}
        }
    </script> 
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}




   <style type="text/css">

        @media screen and (min-width: 768px) {

            .modal-dialog {

                width: 760px; /* New width for default modal */

            }

            .modal-sm {

                width: 400px; /* New width for small modal */

            }

        }

        @media screen and (min-width: 992px) {

            .modal-lg {

                width: 992px; /* New width for large modal */

            }

        }

    </style>







