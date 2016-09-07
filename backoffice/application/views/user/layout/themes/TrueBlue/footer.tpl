{*!-- start: FOOTER --*}
{if $SESS_STATUS} 
    {if $FOOTER_DEMO_STATUS=='yes' && $DEMO_STATUS=="yes"}
        <div class="row">
            <div class="col-sm-6" style="margin:0;padding:0;">
                <div class="col-sm-12 sm-fifty">
                    <div class="panel panel-default">
                        <div class="panel-body no-padding" >
                            <div class="pull-left noteimg col-sm-2">
                                <img src="{$PUBLIC_URL}images/1358439241_Draft.png" />
                            </div>
                            <div class="pull-left notetxt col-sm-10">
                                <p>
                                    <font color="black">
                                    1.   {lang('this_demo_can_customize_your_own_mlm_plan_with_fully_licensed_mode')} {$FOOTER_DEMO_STATUS}<br/>
                                    2.   {lang('once_the_demo_is_ready_you_can_simply_move_the_demo_to_your_own_domain_name')} <br/>
                                    3.   {lang('this_demo_will_be_automatically_deleted_after_48_hours_unless_upgraded')} <br/>
                                    4.   {lang('you_can_upgrade_this_demo_to_one_month_or_can_purchase_the_software')}<br/>
                                    5 .  {lang('use_google_chrome_or_mozilla_firefox_for_better_view')}<br/>
                                    </font>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" style="margin:0;padding:0;">
                <div class="col-sm-12 sm-fifty">
                    <div class="panel panel-default">
                        <div class="panel-body no-padding">
                            <div class="pull-left noteimg col-sm-2">
                                <img src="{$PUBLIC_URL}images/1358439696_lifesaver.png" />
                            </div>
                            <div class="pull-left notetxt col-sm-10">
                                <p>                           
                                    {if $upgrade_cond==active}   
                                        <a class="btn btn-orange" href="{$BASE_URL}user/revamp/revamp_update_plan"><i class="fa fa-plus"></i>
                                            {lang('upgrade_now')}
                                        </a>
                                        <br/>
                                    {/if}
                                    <a href="{$BASE_URL}user/revamp/send_feedback">{lang('click_here_to_place_a_feedback_for_support')} </a> <br />
                                    <font color="black">{lang('website')} : www.ioss.in <br />
                                    Blog : www.blog.infinitemlmsoftware.com<br />
                                    Skype ID:infinitemlm<br /></font>
                                </p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    {/if}
{/if}

{include file="user/layout/themes/default/chat.tpl" title="" name=""}
</div>
<!-- Spacer ends -->
</div>
<!-- Container fluid ends -->
</div>
<!-- Main Container Ends -->
</div>
<!-- Dashboard Wrapper End -->

<!-- Footer Start -->
<footer>
    <div class="footer clearfix" style="margin-left:220px;">
        <div class="footer-inner">
            {$curr_date = date('Y')}
            {$curr_date} &copy; {$site_info['company_name']} {$smarty.const.SOFTWARE_VERSION} {if $FOOTER_DEMO_STATUS=='yes'}- <a href="https://ioss.in" target="_blank">Developed by Infinite Open Source Solutions LLP&trade;</a>
            {/if}
        </div>
        <div class="footer-items col-sm-1">
            <span class="go-top"><i class="clip-chevron-up"></i></span>
        </div>
    </div>
</footer>
<!-- Footer end -->

{*!-- end: FOOTER --*}



{*!-- start: MAIN JAVASCRIPTS --*}

<script src="{$PUBLIC_URL}javascript/themes/TrueBlue/bootstrap.min.js"></script>
<script src="{$PUBLIC_URL}javascript/themes/TrueBlue/tiny-scrollbar.js"></script>
<script src="{$PUBLIC_URL}javascript/themes/TrueBlue/daterange/moment.js"></script>
<script src="{$PUBLIC_URL}javascript/themes/TrueBlue/daterange/daterangepicker.js"></script>
<script src="{$PUBLIC_URL}javascript/main.js"></script>
<!--[if lt IE 9]>
<script src="{$PUBLIC_URL}plugins/respond.min.js"></script>
<script src="{$PUBLIC_URL}plugins/excanvas.min.js"></script>
<![endif]-->
<script src="{$PUBLIC_URL}plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="{$PUBLIC_URL}plugins/blockUI/jquery.blockUI.js"></script>
<script src="{$PUBLIC_URL}plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="{$PUBLIC_URL}plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="{$PUBLIC_URL}plugins/less/less-1.5.0.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<!-- Date Range -->
<script src="{$PUBLIC_URL}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<!-- Custom JS -->
<script src="{$PUBLIC_URL}javascript/themes/TrueBlue/custom.js"></script>
<script src="{$PUBLIC_URL}javascript/themes/TrueBlue/custom-index.js"></script>
<script src="{$PUBLIC_URL}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="{$PUBLIC_URL}plugins/iCheck/jquery.icheck.min.js"></script>
<script src="{$PUBLIC_URL}javascript/ajax-auto-user.js"></script>
{*!-- end: MAIN JAVASCRIPTS --*}
{*!-- end: validation common files --*}


{*!-- start: Live Notifications JAVASCRIPTS --*}
<link rel="stylesheet" href="{$PUBLIC_URL}plugins/notifications/css/jquery.notificator.css">
<script src="{$PUBLIC_URL}plugins/notifications/js/notificator.js"></script>
<script src="{$PUBLIC_URL}plugins/notifications/js/refresh.js"></script>
{*!-- end: Live Notifications JAVASCRIPTS --*}

{*!-- start: JAVASCRIPTS AND CSS REQUIRED FOR THIS PAGE ONLY --*}
{foreach from = $ARR_SCRIPT item=v}
    {assign var="type" value=$v.type}
    {assign var="loc" value=$v.loc}
    {if $loc == "footer"}
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
{*!-- end: JAVASCRIPTS AND CSS REQUIRED FOR THIS PAGE ONLY --*}