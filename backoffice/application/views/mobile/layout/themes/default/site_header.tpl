{*start: HEADER *}
<script src="{$PUBLIC_URL}javascript/currency.js" type="text/javascript" ></script>
<div class="navbar navbar-inverse navbar-fixed-top">
    {* start: TOP NAVIGATION CONTAINER *}
    <div class="container">
        <div class="navbar-header">
            {* start: RESPONSIVE MENU TOGGLER *}
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="clip-list-2"></span>
            </button>
            {* end: RESPONSIVE MENU TOGGLER *}
            {* start: LOGO *}    
            <div class="logo-header">
                <a class="navbar-brand" href="{$BASE_URL}admin/home/index"> 
                    <img src="{$PUBLIC_URL}images/logos/{$site_info["logo"]}" class="logo"/>
                </a>     
            </div>
            {* end: LOGO *}
        </div>
        <div class="navbar-tools">
            {* start: TOP NAVIGATION MENU *}

            <ul class="nav navbar-right">

                {if $MODULE_STATUS['multy_currency_status']=='yes'}
                    <li class="dropdown language">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                            {$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT}
                            <span class="badge"></span>
                        </a>

                        <ul class="dropdown-menu posts">
                            {assign var="i" value=0} 
                            {foreach from=$CURRENCY_ARR item=v}
                                <li onclick="switchCurrency('{$v.id}');">
                                    <span class="dropdown-menu-title" style="font-family: DejaVu Sans;">
                                        {$v.symbol_left}{$v.symbol_right} {$v.title}   
                                    </span>
                                </li>
                                {$i=$i+1}
                            {/foreach}
                        </ul>
                    </li>
                {/if}
                <li class="dropdown">
                    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                        <i class="clip-bubble-3"></i>
                        {if $unread_mail>0}
                            <span class="badge">{$unread_mail}</span>
                        {/if}
                    </a>
                    <ul class="dropdown-menu posts">
                        {if $unread_mail>0}
                            <li>
                                <span id="unread_mail" class="dropdown-menu-title"> You have {$unread_mail} new mail</span>
                            </li>

                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li> 
                                            {assign var=i value=1}
                                            {assign var=user_name value=""}
                                            {assign var=user_img value=""}
                                            {foreach from=$mail_content item=v}
                                                <div class="clearfix">
                                                    <a href="{$BASE_URL}admin/mail/mail_management">
                                                        <div class="thread-image">
                                                            <img alt="" src="{$PUBLIC_URL}images/profile_picture/{$v.image}" style="height:50px;width:50px;">
                                                        </div>
                                                        <div class="thread-content">
                                                            <span class="author">From: {$v.username}</span>
                                                            <span class="preview">Subject:{$v.mailadsubject}</span>
                                                            <span class="time">{$v.mailadiddate}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                                {$i=$i+1}
                                            {/foreach}
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        {else}
                            <li>
                                <span id="unread_mail" class="dropdown-menu-title"> {lang('you_have_no_new_mail')}</span>
                            </li>
                        {/if}
                        <li class="view-all">
                            <a href="{$BASE_URL}admin/mail/mail_management">
                                {lang('see_all_messages')} <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: MESSAGE DROPDOWN -->
                <!-- start: LANGUAGE DROPDOWN -->
                {if $LANG_STATUS=='yes'}
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
                <!-- end: LANGUAGE DROPDOWN -->
                <!-- start: USER DROPDOWN -->
                <li class="dropdown current-user">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        {if $LOG_USER_TYPE!='employee'}
                            <img src="{$PUBLIC_URL}images/profile_picture/{$profile_pic}" class="circle-img" alt="" height="30px" width="30px">
                        {/if}
                        <span class="username">{$LOG_USER_NAME}</span>
                        <i class="clip-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{$PATH_TO_ROOT}admin/profile/profile_view" >
                                <i class="clip-user-2"></i>
                                &nbsp;{lang('profile_management')}
                            </a>
                        </li>
                        <li>
                            <a href="{$PATH_TO_ROOT}login/logout">
                                <i class="clip-switch"></i>
                                &nbsp;{lang('logout')}
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: USER DROPDOWN -->
            </ul>
            <!-- end: TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->
<!-- start: MAIN CONTAINER -->
<div class="main-container">
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <div class="main-navigation navbar-collapse collapse">
            <div class="user-info-left">
                <img src="{$PUBLIC_URL}images/profile_picture/{$profile_pic}" width="30" height="30">
                {if $MODULE_STATUS['rank_status']=="yes"}
                    {if $rank_name!="NA"}
                        <span class="badge badge-green">Rank: {$rank_name}</span>
                    {else}
                        {if $status=="active"}
                            <span class="badge badge-green">Active</span>
                        {else}
                            <span class="badge badge-red">Inactive</span>
                        {/if}
                    {/if}
                {else}
                    {if $status=="active"}
                        <span class="badge badge-green">Active</span>
                    {else}
                        <span class="badge badge-red">Inactive</span>
                    {/if}
                {/if}
            </div>
            <!-- start: MAIN MENU TOGGLER BUTTON -->
            <div class="navigation-toggler">
                <i class="clip-chevron-left"></i>
                <i class="clip-chevron-right"></i>
            </div>
            <!-- end: MAIN MENU TOGGLER BUTTON -->
            {include file="admin/layout/themes/default/menu.tpl" title="Example Smarty Page" name=""}
        </div>
        <!-- end: SIDEBAR -->
    </div>
    <!-- start: PAGE -->
    <div class="main-content">
        <div class="container">
            <!-- start: PAGE HEADER -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- start: PAGE TITLE & BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="clip-pencil"></i>
                            <a href="{$BASE_URL}admin/home/index">
                                {lang('dashboard')}
                            </a>
                        </li>
                        {if $HEADER_LANG['page_top_header']!=lang('dashboard')}
                            <li>
                                <a href="#">
                                    {$HEADER_LANG['page_top_header']}
                                </a>
                            </li>
                        {/if}
                        {if $HEADER_LANG['page_top_small_header'] != ""}
                            <li class="active">
                                {$HEADER_LANG['page_top_small_header']}
                            </li>
                        {/if}
                        {if $HELP_STATUS==='yes'}
                            <li>
                                <a href="https://infinitemlmsoftware.com/help/{$help_link}" target="_blank">
                                    <i class="clip-info help_top_icon" title="Click here to see more help on this page!"></i>
                                </a>
                            </li>
                        {/if}	
                        <li class="pull-right">		
                            <span class="date" style="padding: 0px 0px 0px 10px;">
                                <timestamp id="date"></timestamp> 
                            </span>
                            <div id="clock"></div>

                            <div style="float: left;border-right: 1px solid #999999;padding: 0px 10px 0px 0px;">
                                <input value="{$SERVER_TIME}" id="serverClock_input" hidden>
                                <input value="{$SERVER_DATE}" id="serverDate_input" hidden>
                                <span class="date">
                                    <timestamp id="server_date"></timestamp> 
                                </span>
                                <div id="server_clock" style="float: right;"></div> 
                            </div>
                        </li> 
                    </ol>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
                    <!-- start: PAGE HEADER -->
                    <div class="page-header">
                        <h1>{$HEADER_LANG['page_header']} 
                            {if $HEADER_LANG['page_small_header'] != ""}
                                <small>{$HEADER_LANG['page_small_header']}</small>
                            {/if}
                        </h1>
                    </div>
                </div>
            </div>
            <!-- end: PAGE HEADER --> 
            {include file="admin/layout/themes/default/error_box.tpl" title="" name=""}