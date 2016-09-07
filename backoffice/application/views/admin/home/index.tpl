{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

{if $LOG_USER_TYPE!='employee'}
    <!-- start: PAGE CONTENT -->

    <style>
        
       .icon-gg-01 {
        position: relative;
        right: 7px;
        top:8px;
        }

        .mfk_wrap {
        font-size: 41px;
        display: flex;
        width: 57px;
        margin-right: 16px;
        font-weight: 800;
        }
    
      div#live_ticker {
        overflow: hidden;
        }
        
        div#live_ticker marquee {
        width: 1500px;
        }
        
    .huge {
            font-size: 15px;
        }
    .panel-gray>.panel-heading-1 {
            color: #fff;
            background-color: #3598dc !important;
            border-color: #3598dc;
            padding:10px;
        }
    .panel-gray>.panel-heading-2 {
            color: #fff;
            background-color: #e7505a !important;
            border-color: #e7505a;
            padding:10px;
        }
    .panel-gray>.panel-heading-3 {
            color: #fff;
            background-color: #32c5d2 !important;
            border-color: #32c5d2;
            padding:10px;
        }
    .panel-gray>.panel-heading-4 {
            color: #fff;
            background-color: #8e44ad !important;
            border-color: #8e44ad;
            padding:10px;
        }
        .panel-footer-1{
            padding: 5px 15px;
            background:#3f7ecb;
            color: white;}
        .panel-footer-2{
            padding: 5px 15px;
            background:#f15a64;
            color: white;}
        .panel-footer-3{
            padding: 5px 15px;
            background:#06cfdc;
            color: white;}
        .panel-footer-4{
            padding: 5px 15px;
            background:#984eb7;
            color: white;}

         .ico{
        color: rgba(255, 255, 255, 0.57);}
        </style>


    <div class="row"><!---dash box start---->
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-1">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-euro fa-3x"></i>
                        </div>
                        <div class="col-xs-5 text-left">
                            <div class="huge"><small>{lang('coin_piece')}</small></div>
                            <div style="font-size: 15px; padding-left: 10px">{$coins}</div>
                        </div>
                        <div class="col-xs-5 text-right">
                            <div class="huge"><small>{lang('free_coin')}</small></div>
                            <div style="font-size: 15px; padding-left: 10px">100.0000</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-1">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {*more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-2">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-euro fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('coin_value')}</div>
                            <div style="font-size: 18px; padding-left: 10px">0.0000</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-2">
                        <span class="pull-left"></span>
                        <span class="pull-right">{* more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-3">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-signal fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('tokens')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$total_tokens}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/tokens/more">
                    <div class="panel-footer-3">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

   

        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-euro fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('bonus_this_week')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$DEFAULT_SYMBOL_LEFT}{$bonus_this_week}{$DEFAULT_SYMBOL_RIGHT}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/bonus/bonus_this_week">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
                        
    </div><!----dash box end--->   
    <div class="row"><!---dash box start---->
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-1">
                    <div class="row">
                        <div class="col-xs-1 ico">
                            <i class="fa fa-euro fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('bonus_since_start')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$DEFAULT_SYMBOL_LEFT}{$bonus_since_start}{$DEFAULT_SYMBOL_RIGHT}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/bonus/bonus_from_start">
                    <div class="panel-footer-1">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-2">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-credit-card  fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('ewallet')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$DEFAULT_SYMBOL_LEFT}{$cash_wallet}{$DEFAULT_SYMBOL_RIGHT}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/ewallet/my_ewallet">
                    <div class="panel-footer-2">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

   
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-3">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-money fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('cash_account')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$DEFAULT_SYMBOL_LEFT}{$cash_wallet}{$DEFAULT_SYMBOL_RIGHT}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/cash_account/my_cash">
                    <div class="panel-footer-3">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>


        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-exchange fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('trading_account')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$DEFAULT_SYMBOL_LEFT}{$trade_wallet}{$DEFAULT_SYMBOL_RIGHT}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/trading/my_trading">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

 </div><!----dash box end--->
    <div class="row">
        <div id="live_ticker"></div>
    </div>
    <div class="row"><!---dash box start---->
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-1">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-list-ul fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('partner_firstline')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$firstline_count}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/my_report/unilevel_history">
                    <div class="panel-footer-1">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

  


        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-2">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-list fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('partner_secondline')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{*{$secondline_count}*}{$downline_count}</div>
                        </div>
                    </div>
                </div>
                <a href="{$BASE_URL}admin/my_report/unilevel_history">
                    <div class="panel-footer-2">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {lang('more')}.. <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-3">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            
                            <img src="{$PUBLIC_URL}images/Pikto.png" width="45px" height="38px">
                           {* <div class="mfk_wrap"><span class="mfk">S</span><i class="icon-gg-01"></i></div>*}
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('swisscoin')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$swiss_val}</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-3">
                        <span class="pull-left"></span>
                        <span class="pull-right"> {*more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-dashboard fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('splitindicator')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$split_val}&nbsp;%</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right">{* more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
     </div><!----dash box end--->
    <div class="row">
        {* carreer status *}
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-diamond fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('career_status')}</div>
                            <div style="font-size: 18px; padding-left: 10px; padding-top: 1px;">{$user_career}&nbsp;</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right">{* more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        {* carreer status *}

        {* bonus value*}
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-share-alt fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('bonus_volume')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$user_bv}&nbsp;</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right">{* more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        {* bonus value *}

        {* difficulty level *}
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-scribd fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('difficulty_level')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$difficulty_level}&nbsp;</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right">{* more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        {*difficulty level  *}

        {* academy level *}
        <div class="col-lg-3 col-md-3">
            <div class="panel panel-gray" style="border-radius: 0px;  border: 1px solid rgb(91, 91, 91); ">
                <div class="panel-heading-4">
                    <div class="row">
                        <div class="col-xs-2 ico">
                            <i class="fa fa-university fa-3x"></i>
                        </div>
                        <div class="col-xs-10 text-left">
                            <div class="huge">{lang('academy_level')}</div>
                            <div style="font-size: 18px; padding-left: 10px">{$user_academy_level}&nbsp;</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer-4">
                        <span class="pull-left"></span>
                        <span class="pull-right">{* more..*} <i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        {*difficulty level  *}


    </div>
  
    <div class="row">
        {if isset($webinar)}

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class=""></i>{$webinar['topic']}
                        {*<div class="panel-tools">
                            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                            </a>
                            <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="btn btn-xs btn-link panel-refresh" href="#">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>*}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">

                                    <a href="{$BASE_URL}../webinar/{$webinar['webinar_id']}/{$LOG_USER_NAME}" target="_blank"> 
                                        <img src="{$PUBLIC_URL}images/webinar_images/{$webinar['image']}" alt="" style="width: 100%; height: 270px;"></a>

                             
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 

        {/if}
        {if isset($workshop)}
            
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       {* <i class="clip-stats"></i>*}
                        {$workshop['workshop_title']}
                        {*<div class="panel-tools">
                            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                            </a>
                            <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="btn btn-xs btn-link panel-refresh" href="#">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>*}
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">

                                   <a href="{$workshop['link']}" target="_blank"> <img src="{$PUBLIC_URL}images/workshop/{$workshop['workshop_image']}" alt="" style="width: 100%; height: 270px;"></a>

                             
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        {/if}
        
        {if isset($video)}
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {$video->title}
                    </div>
                    <div class="panel-body">
                        <iframe  width="{$video->w}" height="{$video->h}" src="{$video->src}" frameborder="0" allowfullscreen style="width: 100%; height: 270px; float:left;"></iframe>
                    </div> 
                </div> 
            </div> 
        {/if}


        <div class="col-sm-4">
        </div>      
    </div>

    <div class="row">

        {assign var=lcp_status value='no'}
        {assign var=div_class value='col-sm-12'}

        {if $MODULE_STATUS['lead_capture_status'] == "yes" && $MODULE_STATUS['lead_capture_status_demo'] == "yes"}
            {$lcp_status = 'yes'}
        {/if}


        {if $lcp_status == "yes" }
            <div class="{$div_class}">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="clip-stats"></i>
                        {lang('Your_Lead_Capture_Page')}
                        <div class="panel-tools">
                            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                            </a>
                            <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="btn btn-xs btn-link panel-refresh" href="#">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{$SITE_URL}LCP/home?prefix={$table_prefix}&id={$user_id}" target="_blank"> <button class="btn btn-bricky" type="button" name="new_member"  value="ENROLL NEW MEMBER" id="new_member"  style="width: 100%;min-height: 30px;margin-top:15px;">{lang('Your_Lead_Capture_Page')}</button></a>
                                <input type="text" name="link1" value="{$SITE_URL}LCP/?prefix={$table_prefix}&id={$user_id}" style="width: 100%;border-color: #547a29;min-height: 25px;margin-top:15px;" readonly>                    
                            </div>                   
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
    {*<div class="row">
    <div class="col-sm-6 sm-fifty">
    <div class="panel panel-default">
    <div class="panel-heading">
    <i class="clip-stats"></i>
    {lang('joinings')}
    <div class="panel-tools">
    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
    </a>
    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
    <i class="fa fa-wrench"></i>
    </a>
    <a class="btn btn-xs btn-link panel-refresh" href="#">
    <i class="fa fa-refresh"></i>
    </a>
    </div>
    </div>
    <div class="panel-body">
    <div class="flot-medium-container">
    <div id="placeholder-h1" class="flot-placeholder"></div>
    </div>
    </div>
    </div>
    </div>
    <div class="col-sm-6 sm-fifty">
    <div class="row">
    <div class="col-sm-12">
    <div class="panel panel-default">
    <div class="panel-heading">
    <i class="clip-pie"></i>
    {lang('payout')}
    <div class="panel-tools">
    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
    </a>
    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
    <i class="fa fa-wrench"></i>
    </a>
    <a class="btn btn-xs btn-link panel-refresh" href="#">
    <i class="fa fa-refresh"></i>
    </a>
    </div>
    </div>
    <div class="panel-body">
    <div class="flot-medium-container">
    <div id="placeholder-h2" class="flot-placeholder"></div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>*}
{/if}
{*!-- end: PAGE CONTENT--*}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    {* /*var Index = function() {
    // function to initiate Chart 1
    var runChart1 = function() {
    var pageviews = [
    {assign var=array_count value=$joining_details_per_month|@count}
    {foreach from=$joining_details_per_month key=k item=i}

    [{$k}, {$i.joining}]
    {if $array_count != $k}
    ,
    {/if}

    {/foreach}
    ];
    var plot = $.plot($("#placeholder-h1"), [{
    data: pageviews,
    label: ""
    }], {
    series: {
    lines: {
    show: true,
    lineWidth: 2,
    fill: true,
    fillColor: {
    colors: [{
    opacity: 0.08
    }, {
    opacity: 0.01
    }]
    }
    },
    points: {
    show: true
    },
    bars: {
    show: false
    },
    shadowSize: 2
    },
    grid: {
    hoverable: true,
    clickable: true,
    tickColor: "#eee",
    borderWidth: 0
    },
    colors: ["#d12610", "#37b7f3", "#52e136"],
    xaxis: {
    ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"], [7, "Jul"], [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]],
    },
    yaxis: {
    ticks: 15,
    tickDecimals: 0
    }
    });

    function showTooltip(x, y, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
    position: 'absolute',
    display: 'none',
    top: y + 5,
    left: x + 15,
    border: '1px solid #333',
    padding: '4px',
    color: '#fff',
    'border-radius': '3px',
    'background-color': '#333',
    opacity: 0.80
    }).appendTo("body").fadeIn(200);
    }
    var previousPoint = null;
    $("#placeholder-h1").bind("plothover", function(event, pos, item) {
    $("#x").text(pos.x.toFixed(2));
    $("#y").text(pos.y.toFixed(2));
    if (item) {
    if (previousPoint != item.dataIndex) {
    previousPoint = item.dataIndex;
    $("#tooltip").remove();
    var x = item.datapoint[0].toFixed(2),
    y = item.datapoint[1];
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    showTooltip(item.pageX, item.pageY, item.series.label  + monthNames[x - 1] + " : " + y);
    }
    } else {
    $("#tooltip").remove();
    previousPoint = null;
    }
    });
    };
    // function to initiate Chart 2
    var runChart2 = function() {
    var data_pie = [];

    data_pie[0] = {
    label: "{lang('released_amount')}",
    data: {$released_payouts_percentage}
    },
    data_pie[1] = {
    label: "{lang('pending_amount')}",
    data: {$pending_payouts_percentage},
    };

    $.plot('#placeholder-h2', data_pie, {
    series: {
    pie: {
    show: true,
    radius: 1,
    tilt: 0.5,
    label: {
    show: true,
    radius: 1,
    formatter: labelFormatter,
    background: {
    opacity: 0.8
    }
    },
    combine: {
    color: '#999',
    threshold: 0.1
    }
    }
    },
    legend: {
    show: false
    }
    });

    function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }
    };


    return {
    init: function() {
    runChart1();
    runChart2();
    }
    };
    }();*/*}
</script>

<script>
    jQuery(document).ready(function () {
        Main.init();
    {* Index.init();
    $(".core-box").addClass("slideUp");
    $(".badge").addClass("fadeIn");*}
        //$(".panel").addClass("bigEntrance");
        LiveTicker.init();
        setInterval(call_init,600000);

    });
</script>{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
