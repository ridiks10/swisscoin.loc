{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                <div class="panel-tools">
                    
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                    <i class="fa fa-resize-full"></i>
                    </a>
                   
                </div>{$ticket_type}             
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    {if $count>0}
                        <thead>
                        <tr class="th" align="center">
                        <th  width="6%">Sl No</th>
                        <th width="12%">{lang('ticket_id')}</th>
                        <th width="10%">{lang('updated')}</th>
                        <th width="10%">{lang('user_id')}</th>
                        <th width="15%">{lang('subject')}</th>
                        <th width="8%">{lang('status')}</th>
                        <th width="10%">{lang('category')}</th>
                        <th width="12%">{lang('last_replier')}</th>
                        <th width="11%">{lang('assigned_to')}</th>
                        </tr>
                        </thead>
                        <tbody>
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {assign var="class_new" value="green"}
                            {assign var="class_new" value="green"}
                            {foreach from=$open_tickets item=v}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                <tr class="{$class}" >
                                    <td>{counter}</td>
                                    <td><a href="{$BASE_URL}admin/ticket_system/ticket/{$v.ticket_id}" target="_blank">{$v.ticket_id}</a></td>
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
                        <h3>{lang('no_open_tickets_found')}</h3>
                    {/if}
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
        ValidateAssign.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}