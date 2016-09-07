{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {$langs['view']}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        {$board_icon="active.gif"}
                        {foreach from=$board_details item=v}
                            <a id="element_{$v.board_id}" href="{$BASE_URL}user/boardview/view_board_details/{$v.board_id}"  title="{$langs['show_all']}" >   
                                <div  class="col-md-3 board-icon" style="border: 1px #ccc solid;text-align: center; margin: 10px;padding: 10px; {if $v.board_id == $board_no}background-color: #f5f5f5;{/if}" id="board-icon-{$v.board_id}">
                                    <h3>{$v.board_name}</h3><br/>
                                    <img id="element_image_{$v.board_id}" alt="{lang('board_view')}" height='48px' width='48px' src="{$PUBLIC_URL}images/{$board_icon}">
                                </div>
                            </a>
                        {/foreach}
                    </div>
                </div>

                <div class="row">
                    <div  class="col-md-12">
                        {foreach from=$board_details item=v}
                            <div id ="user_boards{$v.board_id}" {if $v.board_id != $board_no}style="display:none;"{/if} class="user_boards">
                                {if $v.board_id == $board_no}
                                    {include file="user/boardview/board_view_management.tpl" title="Example Smarty Page" name=""}
                                {/if}
                            </div>
                        {/foreach}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}