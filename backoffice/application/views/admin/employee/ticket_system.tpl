{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('assigned_tickets')}
            </div>

            <div class="panel-body">
                <div id="span_js_messages" style="display:none;">
                    <span id="confirm_msg1">{lang('sure_you_want_to_reopen_ticket')}</span>
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
                </div>
                <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />

                <table  class="table table-striped table-bordered table-hover table-full-width" id="sample-table-1">

                    <thead>
                        <tr class="th">            
                            <th>Sl No</th> 
                             <th>{lang('ticket')} ID</th>
                            <th>{lang('Subject')}</th>
                            <th>{lang('Category')}</th>
                            <th>{lang('status')} </th>
                            <th>{lang('last_replier')}</th>
                            <th>{lang('priority')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {assign var=i value=1}
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {if count($assigned_tickets) > 0}
                            {foreach from=$assigned_tickets item=v}
                                <tr>
                                    <td> {counter}</td>                             
                                    <td> <a href="javascript:view_assigned_tickets('{$v.ticket_id}')" {if $v.read=="yes"} style='color:#C48189;' {/if} >{$v.ticket_id} </a></td>
                                    <td> {$v.subject}</td>
                                    <td> {$v.category}</td>
                                    <td> {$v.status}</td>
                                    <td> {$v.last_replier}</td>
                                    <td> {$v.priority}</td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        {else}
                        <tbody><tr>
                                <td align="center" colspan="7">
                                    <b>{lang('no_tickets_assigned')}</b>
                                </td>
                            </tr>
                        </tbody>
                        {/if}
                    </tbody>
                </table>
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


