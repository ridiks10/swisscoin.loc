{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">  
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
{assign var="i" value=1}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('guest_manager')}
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
                {form_open('', 'method="POST" name="proadd" id="proadd"')}
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>                               
                                <th>{lang('first_name')}</th>
                                <th>{lang('last_name')}</th>
                                <th>{lang('address')}</th>
                                <th>{lang('phone')}</th>
                                <th>{lang('email')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$data item=v}
                                {assign var="active" value="{$v.status}"}
                                <tr>
                                    <td>{$i}</td>
                                    <td>{$v.first_name}</td>
                                    <td>{$v.last_name}</td>
                                    <td>{$v.address}</td>
                                    <td>{$v.phone}</td>
                                    <td>{$v.email}</td>
                                    <td>
                                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}user">
                                        {if $active=='yes'}
                                            <div class="visible-md visible-lg visible-sm visible-xs">
                                                <a href="javascript:edit_guest({$v.id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')} {$v.first_name}"><i class="fa fa-edit"></i></a>

                                                <a href="javascript:delete_guest({$v.id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.first_name}"><i class="glyphicon glyphicon-remove-circle"></i></a>                                    
                                            </div>
                                        {/if}
                                        <a href="{$PATH_TO_ROOT_DOMAIN}user/party/view_order/{$v.id}">
                                            <input type="button" name="view" id="view" value="{lang(view_order)}" class="btn btn-danger btn-sm">
                                        </a>
                                    </td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        </tbody>
                    </table>
                    <div class="col-sm-3 col-sm-offset-9">
                        <a href="create_guest"><input type="button" name="create" id="create" value="{lang('create_new')}" class="btn btn-bricky"></a>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
        //DatePicker.init();
        //ValidateUser.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}