{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"}

<div id="span_js_messages" style="display:none">
    <span id="error_msg">{lang('select_user_id')}</span>
</div>

<!-- start: GENOLOGY TREE-->                                         
<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <i class="fa fa-sitemap"></i>
                {$board_name}
            </div>
            <div class="panel-body" >
                <button class="zoomIn"><span class="glyphicon glyphicon-zoom-in" style="font-size:20px"></span></button>
                <button class="zoomOut"><span class="glyphicon glyphicon-zoom-out" style="font-size:20px"></span></button>
                <button class="zoomOff"><span class="glyphicon glyphicon-off" style="font-size:20px"></span></button>

                <div id="loader-div" style="z-index:9999;text-align: center;display: none;"><img src="{$PUBLIC_URL}images/loader.gif" style="margin-left: 10px;"/></div>

                <div id="summary" class="panel-body tree-container1" style="height:100%;margin: auto;width: 100%;top: 0px;">
                    {if isset($MODULE_STATUS['table_status']) && $MODULE_STATUS['table_status'] == "yes"}
                        {include file="user/tree/table_view.tpl" title="Example Smarty Page" name=""}
                    {else}
                        {include file="user/tree/tree_view_board.tpl" title="Example Smarty Page" name=""}
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: GENOLOGY TREE-->

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}