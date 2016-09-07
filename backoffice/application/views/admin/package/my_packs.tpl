{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>    
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('view_package')}
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
                {if $arr_count!=0}
                     <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th>{lang('no')}</th>
                                <th>{lang('package_name')}</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>{lang('package_bv')}</th>
                                <th>{lang('package_token')}</th>
                                {*<th>{lang('package_date')}</th>*}
                                
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="i" value=0}
                            {foreach from=$package_details item=v}
                                

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.package_name}</td>
                                    <td>{$v.quantity}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{$v.price*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>
                                   {* <td>{$v.package_price}</td>*}
                                    <td>{$v.bv}</td>
                                    <td>{$v.token}</td>
                                   {* <td>{$v.package_date}</td>*}
                                   {* <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:edit_package({$package_id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')} {$v.package_title}"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:delete_package({$package_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.package_title}"><i class="fa fa-times fa fa-white"></i></a>
                                            <a href="javascript:view_package({$package_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.package_title}">view</a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="javascript:edit_package({$package_id},'{$path}')">
                                                            <i class="fa fa-edit"></i> {lang('edit')}
                                                        </a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="javascript:delete_package({$package_id},'{$path}')">
                                                            <i class="fa fa-times"></i> {lang('remove')}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>*}
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                    </table>
                {else}
                    <h4 align="center">{lang('no_package_found')}</h4>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}