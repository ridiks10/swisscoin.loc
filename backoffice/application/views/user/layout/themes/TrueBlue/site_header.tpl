<!-- Dashboard Wrapper Start -->
<div class="dashboard-wrapper">
    <!-- Left sidebar start -->
    <aside id="sidebar"  style="height:100%">
        <!-- Logo starts -->
        <a href="#" class="logo">
            <img src="{$PUBLIC_URL}images/logos/{$site_info["logo"]}" alt="logo">
        </a>
        <!-- Logo ends -->

        <!-- Menu start -->
        <div id='menu'   style="background: #398ab9;  ">
            {include file="user/layout/themes/TrueBlue/menu.tpl" title="user_menu" name=""}           
        </div>
    </aside>
    <!-- Left sidebar end -->

    <!-- Header start -->
    <header>
        <div class="pull-right">
            <ul id="mini-nav" class="clearfix">

                <!-- start: MESSAGE DROPDOWN -->
                <li class="list-box hidden-xs">
                    <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="clip-bubble-3" aria-hidden="true" data-icon="&#xe129;"></div>

                        <span class="info-label red-bg animated rubberBand">{$unread_mail}</span>
                    </a>
                    <ul class="dropdown-menu sm fadeInUp animated messages">
                        <li class="dropdown-header">You have {$unread_mail} messages</li>

                        {assign var=i value=1}
                        {assign var=user_name value=""}
                        {assign var=user_img value=""}
                        {foreach from=$mail_content item=v}
                            <li>
                                <a href="{$BASE_URL}user/mail/mail_management">
                                    <div class="icon">
                                        <img  class="img-circle" src="{$PUBLIC_URL}images/profile_picture/{$v->userphoto}" alt="Browser">
                                    </div>
                                    <div class="details">
                                        <strong class="text-danger">{$LOG_USER_NAME}</strong>
                                        <span class="preview">Subject:{$v->subject}</span>
                                        <span class="time">{$v->date}</span>
                                    </div>
                                </a>
                            </li>
                        {/foreach}
                        <li class="view-all">
                            <a href="{$BASE_URL}user/mail/mail_management">
                                See all messages <i class="fa fa-arrow-circle-o-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- end: MESSAGE DROPDOWN -->

                {if $MODULE_STATUS['multy_currency_status']=='yes'}
                    <!-- start: currency DROPDOWN -->
                    <li class="list-box hidden-xs">
                        <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
                            {$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT}

                            <span class="badge"></span>
                        </a>
                        <ul class="dropdown-menu sm fadeInUp animated messages">
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
                    <!-- end: currency DROPDOWN -->
                {/if}

                {if $LANG_STATUS=='yes'}
                    <!-- start: language DROPDOWN -->
                    <li class="list-box hidden-xs">
                        <a id="drop2" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <div class="fs1" aria-hidden="true"">
                                {foreach from=$LANG_ARR item=v}
                                    {if $LANG_ID == $v.lang_id}
                                        <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> 
                                    {/if}
                                {/foreach}
                            </div>
                        </a>

                        <ul class="dropdown-menu sm fadeInUp animated messages">
                            {foreach from=$LANG_ARR item=v}
                                <li class="dropdown-content" onclick="getSwitchLanguage('{$v.lang_code}');">
                                    <span class="dropdown-menu-title">
                                        <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png" /> {$v.lang_name}
                                    </span>
                                </li>
                            {/foreach}
                        </ul>
                    </li>
                    <!-- end: language DROPDOWN -->
                {/if}

                <li class="list-box hidden-xs dropdown">
                    <a id="drop1" href="#" role="button" class="dropdown-toggle current-user" data-toggle="dropdown">
                        {$LOG_USER_NAME} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu sm fadeInUp animated messages">
                        <li class="dropdown-content">
                            <a href="{$BASE_URL}user/profile/profile_view">{lang('profile_management')}</a>
                            <a href="{$BASE_URL}login/logout">{lang('logout')}</a>
                        </li>
                    </ul>
                </li>
                <li class="list-box hidden-lg hidden-md hidden-sm" id="mob-nav">
                    <a href="#">
                        <i class="fa fa-reorder"></i>
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <!-- Header ends -->

    <!-- Main Container Start -->
    <div class="main-container"  style="min-height:871px">
        <!-- Top Bar Starts -->
        <div class="top-bar clearfix">
            <div class="page-title" style="width: 100%;">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="tabs"> 

                            <h4>
                                <div class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></div>
                                <a href="{$BASE_URL}user/home/index" class="samll">
                                    {lang('dashboard')}
                                </a>
                                {if $HEADER_LANG['page_top_header']!=lang('dashboard')}
                                    <a href="#">
                                        &#47;&nbsp;&nbsp;{$HEADER_LANG['page_top_header']}
                                    </a>
                                {/if}
                                {if $HEADER_LANG['page_top_small_header'] != ""}
                                    <li class="active">
                                        {$HEADER_LANG['page_top_small_header']}
                                    </li>
                                {/if}
                                {if $HELP_STATUS==='yes'}
                                    <li>
                                        <a href="https://infinitemlmsoftware.com/help/" target="_blank">
                                            <i class="clip-info help_top_icon" title="Click here to see more help on this page!"></i>
                                        </a>
                                    </li>
                                {/if}
                                <li class="pull-right" style="font-size: 14px; list-style: none;">
                                    <span class="date" style="padding: 0px 0px 0px 10px;">
                                        <timestamp id="date"></timestamp> 
                                    </span>
                                    <div style="display: inline;" id="clock"></div>
                                    <div style="float: left;border-right: 1px solid #999999;padding: 0px 10px 0px 0px;">
                                        <input value="{$SERVER_TIME}" id="serverClock_input" hidden>
                                        <input value="{$SERVER_DATE}" id="serverDate_input" hidden>
                                        <span class="date">
                                            <timestamp id="server_date"></timestamp> 
                                        </span>
                                        <div style="display: inline;" id="server_clock" style="float: right;"></div> 
                                    </div>
                                </li>    
                            </h4> 
                        </ol>
                    </div>                        
                </div>
            </div>
        </div>
        <!-- Top Bar Ends -->

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <!-- Spacer starts -->
            <div class="spacer-xs">
                <!-- end: PAGE HEADER --> 
                {include file="user/layout/themes/TrueBlue/error_box.tpl" title="" name=""}