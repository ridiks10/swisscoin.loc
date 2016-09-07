{*start: SITE HEADER *}
<div id="topheader" class="navbar navbar-inverse">
    {* start: TOP NAVIGATION CONTAINER *}
    <div class="container">
        <div class="navbar-header">
            {* start: RESPONSIVE MENU TOGGLER *}
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="clip-list-2"></span>
            </button>
            {* end: RESPONSIVE MENU TOGGLER *}
            {* start: LOGO *}
            <a class="navbar-brand" href="{$BASE_URL}user/home/index">
                <img src="{$PUBLIC_URL}images/logos/{$site_info['logo']}" style="width: 225px;margin-top: 0px;position: absolute;" />
            </a>
            {* end: LOGO *}
        </div>
        <div class="navbar-tools">
            {* start: TOP NAVIGATION MENU *}
            <ul class="nav navbar-right main-top-menu">

                <!-- start: MESSAGE DROPDOWN -->
                <li class="dropdown maildropdown">
                    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                        <img src="{$PUBLIC_URL}images/themes/Dandelion/mail-icon.png" />

                        <span class="username">{$unread_mail} {lang('new_messages')}</span>
                    </a>

                    <ul class="dropdown-menu posts">
                        {if $unread_mail==0}
                            <li>
                                <span id="unread_mail_count" class="dropdown-menu-title"> You have no new mail</span></li>

                        {elseif $unread_mail>0}
                            <li>
                                <span id="unread_mail_count" class="dropdown-menu-title"> You have {$unread_mail} new mail</span>
                            </li>

                            <li>
                                <div class="drop-down-wrapper">
                                    <ul>
                                        <li> 
                                            {assign var=i value=1}
                                            {assign var=user_name value=""}
                                            {assign var=user_img value=""}
                                            {foreach from=$mail_content item=v}<ul>
                                                    <div class="clearfix" style="width: 74%;">
                                                        <a href="{$BASE_URL}user/mail/mail_management">
                                                            <div class="thread-content">
                                                                <span class="author">From: {$v->username}</span>
                                                                <span class="preview">Subject:{$v->subject}</span>
                                                                <span class="date">{$v->date}</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    {$i=$i+1}
                                                {/foreach}</ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        {/if}


                        <li class="view-all">
                            <a href="{$BASE_URL}user/mail/mail_management">
                                See all messages <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                    </ul>

                </li>
                <!-- end: MESSAGE DROPDOWN -->

                {if $MODULE_STATUS['multy_currency_status']=='yes'}
                    <!-- start: CURRENCY DROPDOWN -->
                    <li class="dropdown language">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                            {$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT}
                            <span class="badge"></span>
                            {lang('currency')}
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
                    <!-- end: CURRENCY DROPDOWN -->
                {/if}

                {if $LANG_STATUS=='yes'}
                    <!-- start: language DROPDOWN -->
                    <li class="dropdown language">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">                            
                            {foreach from=$LANG_ARR item=v}
                                {if $LANG_ID == $v.lang_id}
                                    <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> 
                                    {lang('language')}
                                {/if}
                            {/foreach}
                            <span class="badge"></span>
                        </a>
                        <ul class="dropdown-menu posts">
                            {foreach from=$LANG_ARR item=v}
                                <li onclick="getSwitchLanguage('{$v.lang_code}');">
                                    <span class="dropdown-menu-title">
                                        <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> {$v.lang_name}
                                    </span>
                                </li>
                            {/foreach}
                        </ul>
                    </li>
                    <!-- end: language DROPDOWN -->
                {/if}
                <!-- start: USER DROPDOWN -->
                <li class="dropdown current-user">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img src="{$PUBLIC_URL}images/profile_picture/{$profile_pic}"  height="30" width="30"/>
                        <span class="username">{$LOG_USER_NAME}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{$PATH_TO_ROOT}user/profile/profile_view" >
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
        </div>
    </div>
</div>
{*end: SITE HEADER *}
{*start: Main Container *}
<div class="main-container">
    <div class="topshadowdivwrap">
        <div class="topshadowdiv"></div>
    </div>
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <div class="main-navigation navbar-collapse collapse">
            <div class="user-info-lefts">
                <img src="{$PUBLIC_URL}images/logos/{$site_info["favicon"]}">
                <div class="userinfotopcdiv">
                    <span class="userinfotopc mofc">{lang('welcome_to')}</span>
                    <span class="userinfotopc ofvirtual">{$site_info['company_name']}</span>
                </div>
            </div>
            {include file="user/layout/themes/Dandelion/menu.tpl" title="Example Smarty Page" name=""}
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
                    <div class="page-header">
                        <ol class="breadcrumb">
                            <li>
                                <i class="clip-pencil"></i>
                                <a href="{$BASE_URL}user/home/index"> 
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
                            {if $HELP_STATUS=='yes'}
                                <li>
                                    <a href="https://infinitemlmsoftware.com/help/{$help_link}" target="_blank">
                                        <i class="clip-info help_top_icon" title="Click here to see more help on this page!"></i>
                                    </a>
                                </li>
                            {/if}
                            <!-- start: TIME -->
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
                                    <div id="server_clock" style="float: right;  display: inline-block;font-family: 'Dosis', sans-serif;font-size: 18px;font-weight: 100;line-height: 16px"></div> 
                                </div>
                            </li> 
                            <!-- end: TIME -->
                        </ol>
                    </div>
                    <!-- end: PAGE TITLE & BREADCRUMB -->
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
            {include file="user/layout/themes/Dandelion/error_box.tpl" title="" name=""}
