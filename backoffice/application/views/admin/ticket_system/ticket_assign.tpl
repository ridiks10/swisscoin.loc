{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg1">{lang('sure_you_want_to_assign_ticket_to_another_person')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>
{if $flag}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    <div class="panel-tools">
                    </div> {lang('assign_ticket')}          
                </div>
                <div class="panel-body">
                    {*<form role="form" class="smart-wizard form-horizontal" name="ticket_assign_form" id="ticket_assign_form" action="" method="post">*}
                        {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="ticket_assign_form" id="ticket_assign_form"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="ticket_id">{lang('ticket_id')}<font color="#ff0000" >*</font> </label>
                            <div class="col-sm-3">
                                <input tabindex="1" type="text" readonly name="ticket_id" id="ticket_id" size="20" value="{$ticket_id}" class="form-control" readonly/>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="employee">{lang('select_employee')}<font color="#ff0000" >*</font> </label>
                            <div class="col-sm-3">

                                <input placeholder="Type employee name here" class="form-control username-auto-ajax" type="text" id="employee" name="employee" autocomplete="Off" tabindex="2" />
                                <span class="help-block" for="user_name"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" type="submit" id="assign_employee" value="assign_employee" name="assign_employee" tabindex="3">{lang('assign')}
                                </button>
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>   
{/if}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                <div class="panel-tools">
                    
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                    <i class="fa fa-resize-full"></i>
                    </a>
                   
                </div>  {lang('open_tickets')}            
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    {if $count>0}
                        <thead>
                        <tr class="th" align="center">
                        <th  width="6%">Sl No</th>
                        <th width="12%">{lang('ticket_id')}  </th>
                        <th width="10%">{lang('updated')}  </th>
                        <th width="10%">{lang('user_id')}  </th>
                        <th width="15%">{lang('subject')}  </th>
                        <th width="8%">{lang('status')}  </th>
                        <th width="10%">{lang('category')}  </th>
                        <th width="12%">{lang('last_replier')}  </th>
                        <th width="11%">{lang('assigned_to')}  </th>
                        </tr>
                        </thead>
                        <tbody>
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$open_tickets item=v}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                <tr class="{$class}" {*align="center"*} >
                                    <td>{counter}</td>
                                    <td><a href="{$BASE_URL}admin/ticket_system/ticket/{$v.ticket_id}" >{$v.ticket_id}</a></td>
                                    <td>{$v.updated}</td>
                                    <td>{$v.name}</td>
                                    <td>{$v.subject}</td>
                                    <td>{$v.status}</td>
                                    <td>{$v.category_name}</td>
                                    <td>{$v.last_replier}</td>
                                    <td>{$v.assignee_name}</td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        {else} 
                        <h3>{lang('no_open_tickets_found')}  </h3>
                    {/if}
                    </tbody>
                </table>
                 {$result_per_page}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateAssign.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}