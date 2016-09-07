<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-file"></i>
                <div class="panel-tools">                   
                </div>
                {lang('search')} {lang('tickets')}
            </div>
            <div class="panel-body">
                {* <form role="form" class="smart-wizard form-horizontal"  name="compose" id="view_ticket_form" method="post" action="" enctype="multipart/form-data">*}
                {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal"  method="post"  name="compose" id="view_ticket_form"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="subject">{lang('category')} </label>
                    <div class="col-sm-4">
                        <!--<input tabindex="1" name="subject" type="text" id="subject" size="35"   />-->
                        <select tabindex="3" name="category" type="text" id="category" class="form-control" >
                            <option value="">Select {lang('category')}</option>
                            {foreach from=$category_arr item=v}
                                <option value="{$v.cat_id}">{$v.cat_name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        {lang('priority')} 
                    </label>
                    <div class="col-sm-4" >                                    
                        <select name="priority" id="priority" type="text" class="form-control" tabindex="2"> 
                            <option value="">Select {lang('priority')}</option>
                            {foreach from=$priority_arr item=v}
                                <option value="{$v.priority_id}">{$v.priority}</option>
                            {/foreach}

                        </select>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                        {lang('status')}
                    </label>
                    <div class="col-sm-4" >                                    
                        <select name="status" id="status" type="text" class="form-control" tabindex="2"> 
                            <option value="">Select {lang('status')}</option>
                            {foreach from=$status_arr item=v}
                                <option value="{$v.status_id}">{$v.status}</option>
                            {/foreach}

                        </select>  
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" id="view2" value="search" name="search" tabindex="3">{lang('search')}</button>
                    </div>
                </div>

                {form_close()}

            </div>
        </div>
    </div>

</div>
{if $search_flag}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-file-o"></i>{lang('tickets')}
                </div>

                <div class="panel-body">

                    <div id="span_js_messages" style="display:none;">
                        <span id="confirm_msg1">Sure you want to reopen the ticket</span>
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
                                <th>{lang('reopen')}</th>
                                <th>{lang('timeline')}</th>



                            </tr>
                        </thead>
                        <tbody>
                            {assign var=i value=1}
                            {assign var=clr value=""}
                            {assign var=id value=""}
                            {assign var=msg_id value=""}
                            {assign var=user_name value=""}
                            {if $searched_ticket_count > 0}

                                {foreach from=$searched_tickets item=v}


                                    {$id = $v.id}  
                                    {$ticket_id = $v.ticket_id}  

                                    <tr>
                                        <td>
                                            {$i}
                                        </td>
                                        <td>
                                            <a href="{$BASE_URL}ticket_system/view_ticket_details/{$v.ticket_id}"> {$v.ticket_id}</a>
                                        </td>
                                        <td>
                                            {$v.subject}
                                        </td>

                                        <td>
                                            {$v.category}
                                        </td>
                                        <td>
                                            {$v.status}
                                        </td>

                                        <td>
                                        {if $v.lastreplier}{$v.lastreplier}{else}NA{/if}
                                    </td>
                                    <td>
                                        {$v.priority_name}
                                    </td>
                                    {if $v.status=="Resolved"}
                                        <td>
                                            <a href="javascript:reopen_ticket('{$ticket_id}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="Reopen"><i class="fa fa-edit"></i></a>
                                        </td>
                                    {else}
                                        <td><i class="fa fa-edit"></i></td>
                                    {/if}
                                    <td><a href="javascript:show_timeline_for_user('{$v.ticket_id}')" onclick=""  class="btn btn-primary tooltips" data-placement="top" title="timeline"><i class="glyphicon glyphicon-fullscreen"></i>
                                        </a></td>

                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        {else}
                        <tbody>
                            <tr>
                                <td align="center" colspan="8">
                                    <b>{lang('no_tickets_found_for_this_search_criteria')}</b>
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
{/if}
