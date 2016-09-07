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
        <link href="{$PUBLIC_URL}plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}fonts/style.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/main.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/main-responsive.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/perfect-scrollbar/src/perfect-scrollbar.css">
        <link rel="stylesheet/less" type="text/css" href="{$PUBLIC_URL}css/styles.less">
        <link rel="stylesheet" href="{$PUBLIC_URL}css/theme_light.css" type="text/css" id="skin_color">
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

    <body>
        <input type = "hidden" name = "base_url" id = "base_url" value = "{$BASE_URL}" />
        <input type="hidden" name="img_src_path" id="img_src_path" value="{$PUBLIC_URL}"/>
        <input type = "hidden" name = "current_url" id = "current_url" value = "{$CURRENT_URL}" />
        <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "{$CURRENT_URL_FULL}" />
        <input type="hidden" name="DEFAULT_CURRENCY_VALUE " id="DEFAULT_CURRENCY_VALUE " value="{$DEFAULT_CURRENCY_VALUE}"/>
        <input type="hidden" name="DEFAULT_CURRENCY_CODE" id="DEFAULT_CURRENCY_CODE" value="{$DEFAULT_CURRENCY_CODE}"/>
        <input type="hidden" name="DEFAULT_SYMBOL_LEFT" id="DEFAULT_SYMBOL_LEFT" value="{$DEFAULT_SYMBOL_LEFT}"/>
        <input type="hidden" name="DEFAULT_SYMBOL_RIGHT" id="DEFAULT_SYMBOL_RIGHT" value="{$DEFAULT_SYMBOL_RIGHT}"/>
        <input type="hidden" name="TABLE_PREFIX" id="TABLE_PREFIX" value="{$TABLE_PREFIX}"/>
        <input type="hidden" name="user_type" id="user_type" value="{$LOG_USER_TYPE}"/>



        {*{if $LOG_USER_TYPE=='distributor'}﻿
        {include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
        {else}
        {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
        {/if}*}
        {*lmodification*}
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



        <style type="text/css">
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:12px;
                margin:0px;
                line-height:18px;
            }
            img{
                border:none;
            }
            .brdr_style{
                border:1px solid #ccc;
            }
            .text_trnfm{
                text-transform:uppercase;
            }
            .preview-subtitle{
                font-weight:  bold;
            }
        </style>

        <style type="text/css" media="print">
            body * { visibility: hidden; }
            #print_div * { 
                visibility: visible; 
            }
            #print_div { 
                position: absolute; 
                top: 30px; 
                left: 10px; 
                width: 95%; 
                font-family:Arial, Helvetica, sans-serif;
                font-size:13px;
                margin:0px;
                line-height:24px;
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
        <div id="message_box"></div>



        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        {lang('preview')} 
                        <div class="panel-tools">

                            {if $LANG_STATUS=="yes"}
                                <li class="dropdown language" style=" list-style-type: none;">
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
                                            <li onclick="getSwitchLanguage('{$v.lang_code}');" >
                                                <span class="dropdown-menu-title">
                                                    <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> {$v.lang_name}
                                                </span>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </li>
                            {/if}
                        </div>
                    </div>
                    <div class="panel-body">

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


                        <div id="print_div">
                            <table width = "100%">
                                <tr>
                                    <td>   
                                        <img  height="50px" src="{$PUBLIC_URL}images/logos/{$site_info["logo"]}" alt="" /> 
                                    </td>
                                    <td align="right">
                                        {$letter_arr['company_name']} <br />
                                        {$letter_arr['address_of_company']}
                                    </td>
                                </tr>
                                <tr><td colspan="2"><hr /></td></tr>
                            </table>
                            <table> 
                                <tr style="font-size: 13px;">
                                    <td>   
                                        <label class="col-sm-12 preview-subtitle" for="user_name">{lang('User_Name')}</label>
                                    </td>
                                    <td>:  {$user_registration_details['user_name']}</td>
                                </tr>
                                {* <tr style="font-size: 13px;">
                                <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('distributers_name')}</label>
                                </td>
                                <td>:  {$user_registration_details['first_name']} {$user_registration_details['last_name']}</td>
                                </tr>*}
                                {* <tr style="font-size: 13px;">
                                <td valign="top">   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('address')}</label>
                                </td>
                                <td><span class="pull-left">:</span> 
                                <div class="col-sm-12">
                                {$user_registration_details['address']}
                                {if $user_registration_details['address_line2'] != '' && $user_registration_details['address_line2'] !="NA"}
                                <br/>{$user_registration_details['address_line2']}
                                {/if}
                                {if $user_registration_details['state_name']!='' && $user_registration_details['state_name'] !="NA"}
                                <br/>{$user_registration_details['state_name']}
                                {/if}
                                <br/>{$user_registration_details['country_name']}
                                </div>
                                </td>
                                </tr>*}
                                {*<tr style="font-size: 13px;">
                                <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('phone_number')}</label>
                                </td>
                                <td>:  {$user_registration_details['mobile']}</td>
                                </tr>*}

                                <tr style="font-size: 13px;">
                                    <td>   
                                        <label class="col-sm-12 preview-subtitle" for="user_name">{lang('email')}</label>
                                    </td>
                                    <td>:  {$user_registration_details['email']}</td>
                                </tr>
                                <tr style="font-size: 13px;">
                                    <td>   
                                        <label class="col-sm-12 preview-subtitle" for="user_name">{lang('date_of_joining')}</label>
                                    </td>
                                    <td>:  {$user_registration_details['reg_date']}</td>
                                </tr>

                                {* <tr>
                                <td colspan="2">
                                <h4><br/></h4>
                                </td>
                                </tr>*}
                                {if $user_registration_details['reg_amount']>0}
                                    <tr style="font-size: 13px;">
                                        <td>   
                                            <label class="col-sm-12 preview-subtitle" for="user_name">{lang('registration_amount')}</label>
                                        </td>
                                        <td>:  {$DEFAULT_SYMBOL_LEFT}{number_format($user_registration_details['reg_amount']*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                {/if}


                                {*{if $MODULE_STATUS['product_status'] == "yes"}
                                <tr style="font-size: 13px;">
                                <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('package')}</label>
                                </td>
                                <td>:  {$user_registration_details['product_name']}</td>
                                </tr>
                                <tr style="font-size: 13px;">
                                <td>   
                                <label class="col-sm-12 preview-subtitle" for="user_name">{lang('package')}</label>
                                </td>
                                <td>:  {$DEFAULT_SYMBOL_LEFT}{number_format($user_registration_details['product_amount']*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                </tr>
                                {/if}*}

                                {if $referal_status == "yes"}
                                    <tr style="font-size: 13px;">
                                        <td>   
                                            <label class="col-sm-12 preview-subtitle" for="user_name">{lang('sponsor')}</label>
                                        </td>
                                        <td>:  {$sponsorname}</td>
                                    </tr>

                                {/if}
                                <tr style="font-size: 13px;">
                                    <td>   
                                        <label class="col-sm-12 preview-subtitle" for="user_name">{lang('Placment_ID')}</label>
                                    </td>
                                    <td>:  {$adjusted_id}</td>
                                </tr>
                                {if $FOOTER_DEMO_STATUS=="yes"}
                                    <tr style="font-size: 13px;">
                                        <td>   
                                            <label class="col-sm-12 preview-subtitle" for="user_name">{lang('Login_Link')}</label>
                                        </td>
                                        <td>:  
                                            {if $DEMO_STATUS == "yes"}
                                                {$PATH_TO_ROOT}login/index/user/{$admin_user_name}/{$user_name}
                                            {else}
                                                {$PATH_TO_ROOT}login/index/{$user_name_encrypted}
                                            {/if}
                                        </td>
                                    </tr>
                                {/if}
                            </table>

                            <br/>
                            <hr/>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p>
                                            {$letter_arr['main_matter']}
                                        </p>
                                    </div>
                                </div></div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p>
                                            {lang('winning_regards')},
                                        </p>
                                    </div>
                                </div></div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p>
                                            {lang('admin')}
                                        </p>
                                    </div>
                                </div></div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p>
                                            {$letter_arr['company_name']} 
                                        </p>
                                    </div>
                                </div></div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label" for="user_name">{lang('place')}</label>

                                    <div class="col-sm-12">
                                        {$letter_arr['place']}
                                    </div>
                                </div></div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-sm-1 control-label" for="user_name">{lang('date')}</label>

                                    <div class="col-sm-12">
                                        {$date}
                                    </div>
                                </div></div>
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                            <input type="hidden" id="id" name="id" value="{$id}">
                            <td align="right">

                                {if $MLM_PLAN != "Board"}
                                    <a href="{$PATH_TO_ROOT}{*{$user_type}/tree/genology_tree*}" style="text-decoration:none">
                                        <div class="col-sm-6 col-sm-offset-2">
                                            <button class="btn btn-bricky"  value="{lang('go_to_tree_view')}">
                                                {lang('go_to_tree_view')}
                                            </button>
                                        </div>
                                    </a>
                                {else}
                                    <a href="{$PATH_TO_ROOT}{$user_type}/boardview/view_board_details" style="text-decoration:none">

                                        <div class="col-sm-6 col-sm-offset-2">
                                            <button class="btn btn-bricky"  value="{lang('Club_View')}">
                                                {lang('Club_View')}
                                            </button>
                                        </div>

                                    </a>
                                {/if}
                            </td>
                            <td>
                                <div id = "frame">
                                    <a href="" onClick="window.print();
                                    return false"> <img align="right" src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" border="none"></a>	
                                </div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {if $LOG_USER_TYPE=='user'}﻿
            {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
        {else}
            {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
        {/if}

        <script>
            jQuery(document).ready(function () {
                Main.init();
            });
        </script>

        {*{if $LOG_USER_TYPE=='distributor'}﻿*}
        {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
        {*{else}
        {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
        {/if}*}

