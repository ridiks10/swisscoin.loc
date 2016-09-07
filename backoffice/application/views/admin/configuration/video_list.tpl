{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"}

<div id="span_js_messages" style="display:none;">    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span> 
</div> 

<div class="row"  >
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('video_list')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-responsive" id="sample_1">
                    <thead>
                        <tr>
                            <th>Si No</th>
                            <th>{lang('title')}</th>
                            <th>{lang('url')}</th>
                            <th>{lang('on dashboard')}</th>
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    <tbody>{assign var="i" value=0}
                        {foreach from=$videos item=v}
                        <tr>{$i=$i+1}
                            <td>{$i}</td>
                            <td>{$v->title}</td>
                            <td>{$v->url}</td>
                            <td>{if $v->on_dashboard}yes{else}no{/if}</td>
                            <td style="white-space: nowrap;">
                                {if $v->on_dashboard}
                                <a class="btn btn-primary" href="video/{$v->id}/deactivate">
                                    <span class="glyphicon glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                </a>
                                {else}
                                <a class="btn btn-primary" href="video/{$v->id}/activate">
                                    <span class="glyphicon glyphicon glyphicon-star" aria-hidden="true"></span>
                                </a>
                                {/if}
                                <a class="btn btn-bricky" href="video/{$v->id}/delete">
                                    <span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </a>
                                <a class="btn btn-primary" href="video/{$v->id}">
                                    <span class="glyphicon glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}