<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">
    <!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
    <!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>{$title}</title>
        <meta name="description" content="Cloud Admin Panel" />
        <meta name="keywords" content="Admin, Dashboard, Bootstrap3, Sass, transform, CSS3, HTML5, Web design, UI Design, Responsive Dashboard, Responsive Admin, Admin Theme, Best Admin UI, Bootstrap Theme, Bootstrap, Light weight Admin Dashboard,Light weight, Light weight Admin, Light weight Dashboard" />
        <meta name="author" content="Bootstrap Gallery" />

        <link rel="shortcut icon" href="{$PUBLIC_URL}images/logos/{$site_info["favicon"]}">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-migrate-1.0.0.js"></script>

        <!-- Bootstrap CSS -->
        <link href="{$PUBLIC_URL}plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css">
        <!-- Animate CSS -->
        <link href="{$PUBLIC_URL}css/themes/TrueBlue/animate.css" rel="stylesheet" media="screen">
        <!-- date range -->
        <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}css/themes/TrueBlue/daterange.css">
        <!-- Main CSS -->
        <link href="{$PUBLIC_URL}css/themes/TrueBlue/main_user.css" rel="stylesheet" media="screen">
        <!-- Slidebar CSS -->
        <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}css/themes/TrueBlue/slidebars.css">
        <!-- Font Awesome -->
        <link href="{$PUBLIC_URL}fonts/themes/TrueBlue/font-awesome.min.css" rel="stylesheet">
        <!-- Metrize Fonts -->
        <link href="{$PUBLIC_URL}fonts/themes/TrueBlue/metrize.css" rel="stylesheet">
        <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->

        <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}css/themes/TrueBlue/user_theme_light.css">
        <link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}fonts/themes/TrueBlue/style.css">
        <link rel="stylesheet" href="{$PUBLIC_URL}plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'/>
        <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'/>
        <link href="{$PUBLIC_URL}plugins/summernote/build/summernote.css"/>

        {*!-- start: CSS REQUIRED FOR THIS PAGE ONLY --*}
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
        {*!-- end: CSS REQUIRED FOR THIS PAGE ONLY --*}  
        <script src="{$PUBLIC_URL}javascript/switch_lang.js" type="text/javascript" ></script>
        {if $CURRENT_CTRL != 'login' && $SESS_STATUS}
            <script src="{$PUBLIC_URL}javascript/timer.js" type="text/javascript"></script>
            {*<script src="{$PUBLIC_URL}javascript/page_loader.js" type="text/javascript"></script>*}
            <script src="{$PUBLIC_URL}javascript/currency.js" type="text/javascript" ></script>
        {/if}

        <script>
            jQuery(document).ready(function () {
                $.ajaxSetup({
                    data: {
            {$CSRF_TOKEN_NAME}: '{$CSRF_TOKEN_VALUE}'
                    }
                });
            });
        </script>      
    </head>  
    <body>
        <input type = "hidden" name = "base_url" id = "base_url" value = "{$BASE_URL}" />
        <input type = "hidden" name = "current_url" id = "current_url" value = "{$CURRENT_URL}" />
        <input type = "hidden" name = "current_url_full" id = "current_url_full" value = "{$CURRENT_URL_FULL}" />
        <input type="hidden" name="img_src_path" id="img_src_path" value="{$PUBLIC_URL}"/>
        <input type="hidden" name="DEFAULT_CURRENCY_VALUE " id="DEFAULT_CURRENCY_VALUE " value="{$DEFAULT_CURRENCY_VALUE }"/>
        <input type="hidden" name="DEFAULT_CURRENCY_CODE" id="DEFAULT_CURRENCY_CODE" value="{$DEFAULT_CURRENCY_CODE}"/>
        <input type="hidden" name="DEFAULT_SYMBOL_LEFT" id="DEFAULT_SYMBOL_LEFT" value="{$DEFAULT_SYMBOL_LEFT}"/>
        <input type="hidden" name="DEFAULT_SYMBOL_RIGHT" id="DEFAULT_SYMBOL_RIGHT" value="{$DEFAULT_SYMBOL_RIGHT}"/>
        <input type="hidden" name="TABLE_PREFIX" id="TABLE_PREFIX" value="{$TABLE_PREFIX}"/>
        <input type="hidden" name="user_type" id="user_type" value="{$LOG_USER_TYPE}"/>

        {if $SESS_STATUS}  
            <!--site header-->	
            {include file="admin/layout/themes/TrueBlue/site_header.tpl" title="Example Smarty Page" name=""}
            <!--site header-->            
        {/if}