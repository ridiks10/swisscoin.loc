{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('view_subscribers')}
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
                <table class="table table-hover" id="sample-table-1">
                    <thead>
                        <tr class="th">
                            <th>{lang('no')}</th>
                            <th>{lang('email')}</th>
                            <th>{lang('date')}</th>
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $arr_count!=0}
                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}user/"}
                            {assign var="i" value=0}
                            {foreach from=$news_details item=v}
                                {assign var="id" value="{$v.id}"}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.email}</td>
                                    <td>{$v.date|date_format:'%m-%d-%Y'}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:delete_newsletter({$v.id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('remove')}"><i class="fa fa-times fa fa-white"></i></a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="#" onclick="delete_newsletter({$id}, '{$path}')">
                                                            <i class="fa fa-times"></i>{lang('remove')}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                        {else}
                        <tr><td colspan="6" align="center"><h4>{lang('no_newsletter_found')}</h4></td></tr>
                                {/if}
                </table></div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}