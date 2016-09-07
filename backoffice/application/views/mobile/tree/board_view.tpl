<script>
    function getBoardTree(id, board_id)
    {
        $.ajax({
            type: "POST",
            url: '{$BASE_URL}mobile/tree/tree_view_board',
            data: { user_id: id, board_id: board_id, {$CSRF_TOKEN_NAME}: '{$CSRF_TOKEN_VALUE}'},
            success: function(data) {
                $('#summary').html(data);
            }

        });
    }

</script>
{include file="mobile/layout/themes/default/header.tpl"  name=""}


<div id="span_js_messages" style="display: none;">
    <span id="errmsg">{lang('please_specify_a_username')}</span>
</div>

{assign var="board_name" value="{$board_config['board_name']}"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default" >
            <div class="panel-heading">
                <i class="fa fa-sitemap"></i>
                {$board_name}
            </div>
            <div class="panel-body" style="overflow: auto;">
                <button class="zoomIn"><span class="glyphicon glyphicon-zoom-in" style="font-size:20px"></span></button>
                <button class="zoomOut"><span class="glyphicon glyphicon-zoom-out" style="font-size:20px"></span></button>
                <button class="zoomOff"><span class="glyphicon glyphicon-off" style="font-size:20px"></span></button>

                <div class="row">
                    <div class="col-sm-8">
                        <ul style="float:left; margin-left: -33px;">
                            <li class="btn btn-active">{lang('active')}</li>
                            <li class="btn btn-vacant">{lang('vacant')}</li>
                        </ul>
                    </div>
                </div>

                <div id="dsply_tree_zoomable">
                    <div id="summary" class="panel-body tree-container1" style="height:100%;margin: auto">         
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{include file="mobile/layout/themes/default/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        getBoardTree('{$user_id}',{$board_id});
       
    });
</script>
{include file="mobile/layout/themes/default/page_footer.tpl" title="Example Smarty Page" name=""}