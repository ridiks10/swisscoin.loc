<div>
    {*!-- end: PAGE --*}
</div>
{*!-- end: MAIN CONTAINER --*}

{*!-- start: FOOTER --*}
</div>

<div class="footer clearfix">
    <div class="footer-inner">
        {$curr_date = date('Y')}
        {$curr_date} &copy; {$site_info['company_name']} {$smarty.const.SOFTWARE_VERSION} {if $FOOTER_DEMO_STATUS=='yes'}- <a href="https://ioss.in" target="_blank">Developed by Infinite Open Source Solutions LLP&trade;</a>
        {/if}
    </div>
    <div class="footer-items">
        <span class="go-top"><i class="clip-chevron-up"></i></span>
    </div>
</div>
{*!-- end: FOOTER --*}

{*!-- start: MAIN JAVASCRIPTS --*}
<!--[if lt IE 9]>
<script src="{$PUBLIC_URL}plugins/respond.min.js"></script>
<script src="{$PUBLIC_URL}plugins/excanvas.min.js"></script>
<![endif]-->
<script src="{$PUBLIC_URL}plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{$PUBLIC_URL}plugins/blockUI/jquery.blockUI.js"></script>
<script src="{$PUBLIC_URL}plugins/iCheck/jquery.icheck.min.js"></script>
<script src="{$PUBLIC_URL}plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="{$PUBLIC_URL}plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="{$PUBLIC_URL}plugins/less/less-1.5.0.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<script src="{$PUBLIC_URL}javascript/main.js"></script>

{*!-- start: valdiation common files --*}
<script src="{$PUBLIC_URL}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="{$PUBLIC_URL}javascript/form-wizard.js"></script>

{*!-- end: validation common files --*}
{*!-- end: MAIN JAVASCRIPTS --*}
<!-- start: Grid files -->

<!-- end: Grid files -->

{*!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --*}
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
{*!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --*}
<script>
        jQuery(document).ready(function() {
            $("#close_link").click(function()
            {
                $("#message_box").removeClass('ok');
            })
        });


</script>