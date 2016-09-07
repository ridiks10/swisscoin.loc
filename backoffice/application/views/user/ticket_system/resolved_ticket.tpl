<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-file-o"></i>{lang('resolved_tickets')}
            </div>
            <div class="panel-body">
                <div id="span_js_messages" style="display:none;">
                    <span id="confirm_msg1">{lang('sure_you_want_to_reopen_ticket')}</span>
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
                </div>
                <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
                <table  class="table table-striped table-hover table-full-width" id="sample-table-1">
                    <thead>
                        <tr class="th">            
                            <th>Sl No</th> 
                            <th>{lang('ticket')} ID</th>
                            <th>{lang('Subject')}</th>
                            <th>{lang('Category')}</th>
                            <th>{lang('status')} </th>
                            <th>{lang('last_replier')}</th>
                            <th>{lang('priority')}</th>
                            <th>{lang('timeline')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {assign var=i value=1}
                        {assign var=clr value=""}
                        {assign var=id value=""}
                        {assign var=msg_id value=""}
                        {assign var=user_name value=""}
                        {if count($resolved_tickets) > 0}

                            {foreach from=$resolved_tickets item=v}


                                {$id = $v.id}  
                                {$ticket_id = $v.ticket_id}  

                                <tr>
                                    <td>{$i} </td>
                                    <td><a href="{$BASE_URL}user/ticket_system/my_ticket/{$v.ticket_id}" > {$v.ticket_id}</a></td>
                                    <td> {$v.subject}</td>
                                    <td>{$v.category}</td>
                                    <td>{$v.status} </td>
                                    <td>{if $v.lastreplier}{$v.lastreplier}{else}NA{/if} </td>
                                    <td>{$v.priority_name}</td>
                                    <td><a href="javascript:show_timeline_for_user('{$v.ticket_id}')" onclick=""  class="btn btn-primary tooltips" data-placement="top" title="timeline"><i class="glyphicon glyphicon-fullscreen"></i>
                                        </a>
                                    </td>
                                </tr>
                                {$i=$i+1}	
                            {/foreach}
                        {else}
                        <tbody>
                            <tr>
                                <td align="center" colspan="8"><b>{lang('no_resolved_tickets_found')}</b></td>
                            </tr>
                        </tbody>
                    {/if}
                    </tbody>
                </table>
                {$result_per_page1}
            </div>
        </div>
    </div>
</div>
