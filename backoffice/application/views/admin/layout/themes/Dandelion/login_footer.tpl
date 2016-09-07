<div>
{*!-- end: PAGE --*}
</div>
{*!-- end: MAIN CONTAINER --*}

{*!-- start: FOOTER --*}

<!-- For Live Chat -->
<script type="text/javascript">
/*(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://infinitemlmsoftware.com/livehelperchat/remdex-livehelperchat-b8431f1/lhc_web/index.php/chat/getstatus/(position)/bottom_right';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();*/
</script>
<!-- For Live Chat -->
</div>
 

{*!-- end: FOOTER --*}

{*!-- start: MAIN JAVASCRIPTS --*}
<!--[if lt IE 9]>
<script src="{$PUBLIC_URL}plugins/respond.min.js"></script>
<script src="{$PUBLIC_URL}plugins/excanvas.min.js"></script>
<![endif]-->
<script src="{$PUBLIC_URL}plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{$PUBLIC_URL}plugins/blockUI/jquery.blockUI.js"></script>
<script src="{$PUBLIC_URL}plugins/iCheck/jquery.icheck.min.js"></script>
<script src="{$PUBLIC_URL}plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="{$PUBLIC_URL}plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="{$PUBLIC_URL}plugins/less/less-1.5.0.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="{$PUBLIC_URL}plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="{$PUBLIC_URL}javascript/main.js"></script>
<script src="{$PUBLIC_URL}javascript/ajax-auto-user.js"></script>
{*!-- end: MAIN JAVASCRIPTS --*}

{*!-- start: valdiation common files --*}
<script src="{$PUBLIC_URL}plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{$PUBLIC_URL}plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
{*!-- end: validation common files --*}

{*!-- start: JAVASCRIPTS AND CSS REQUIRED FOR THIS PAGE ONLY --*}
    {foreach from = $ARR_SCRIPT item=v}
        {assign var="type" value=$v.type}
               
            {if $type == "js"}
                <script src="{$PUBLIC_URL}javascript/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "css"}
                <link href="{$PUBLIC_URL}css/{$v.name}" rel="stylesheet" type="text/css" />
            {elseif $type == "plugins/js"}
                <script src="{$PUBLIC_URL}plugins/{$v.name}" type="text/javascript" ></script>
            {elseif $type == "plugins/css"}
                <link href="{$PUBLIC_URL}plugins/{$v.name}" rel="stylesheet" type="text/css" />
            {/if}
       
    {/foreach}
{*!-- end: JAVASCRIPTS AND CSS REQUIRED FOR THIS PAGE ONLY --*}
<script>
   jQuery(document).ready(function() {
    $("#close_link").click(function()
{ 
    $("#message_box").removeClass('ok');
}
)
});
</script>