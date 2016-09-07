{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{*{$tab1} {$tab2} {$tab3}*}
<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('ticket_management')}
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
                <!-- start: INBOX DETAILS FORM -->
                {assign var=i value=1}
                {assign var=clr value=""}
                {assign var=id value=""}
                {assign var=msg_id value=""}
                {assign var=user_name value=""}

                {foreach from=$row item=v}
                    {$id = $v.id}
                    <div class="modal fade" id="panel-config{$id}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title">{lang('Ticket_details')}</h4>
                                </div>
                                <div class="modal-body">

                                    <table cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>
                                                <b>{lang('Ticket_tracking_ID')} :</b> {$v.ticket_id}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="th">
                                                <b>{lang('status')}:</b>
                                                {if $v.status==3}
                                                    <font color="#33FF00">{lang('resolved')}</font>
                                                {else if $v.status == 1}
                                                    <font color="#ff0000">{lang('awaiting_reply')}</font>
                                                {else if $v.status == 2}
                                                    <font color="#ff0000">{lang('replied')}</font>
                                                {else if $v.status == 0}
                                                    <font color="#ff0000">{lang('new')}</font>
                                                {else if $v.status == 4}
                                                    <font color="#ff0000">{lang('in_progress')}</font>
                                                {else if $v.status == 5}
                                                    <font color="#ff0000">{lang('on_hold')}</font>
                                                {/if}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="th">
                                                <b>{lang('Created_on')}:</b> {$v.created_date}
                                        </tr>
                                        <tr>
                                            <td class="th">
                                                <b>{lang('Updated_date')}:</b> {$v.updated_date}
                                        </tr>
                                        <tr>
                                            <td class="th">
                                                <b>{lang('Created_By')}:</b> {$v.user}
                                        </tr> 
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <a href="{$BASE_URL}user/mail/view_ticket_details/{$v.ticket_id}"
                                       <button type="button" class="btn btn-bricky">
                                            {lang('View')}
                                    </a>
                                    {if $v.status!=3}
                                        <a href="{$BASE_URL}user/mail/view_ticket_details/{$v.ticket_id}"
                                           <button type="button" class="btn btn-bricky">
                                                {lang('Reply')}</button>
                                        </a>
                                    {/if}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        {lang('Close')}
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                {/foreach}                
                <!-- /.modal -->
                <!-- end: INBOX DETAILS FORM --> 						                
                <div id="span_js_messages" style="display:none;">
                    <span id="error_msg1">{lang('subject_is_required')}</span>
                    <span id="error_msg2">{lang('priority_is_required')}</span>
                    <span id="error_msg3">{lang('category_is_required')}</span>
                    <span id="error_msg4">{lang('message_is_required')}</span>      
                </div>
                <div class="tabbable ">
                    <ul id="myTab3" class="nav nav-tabs tab-green">
                        <li class="{$tab1}">
                            <a href="#panel_tab4_example1" data-toggle="tab">
                                <i class="pink fa fa-dashboard"></i> {lang('inbox')}
                            </a>
                        </li>
                        <li class="{$tab2}">
                            <a href="#panel_tab4_example2" data-toggle="tab">
                                <i class="blue fa fa-user"></i> {lang('Create_ticket')}
                            </a>
                        </li>
                        <li class="{$tab3}">
                            <a href="#panel_tab4_example3" data-toggle="tab">
                                <i class="blue fa fa-user"></i> {lang('view_ticket')}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <input type="hidden" name="active_tab" id="active_tab" value="" >
                        <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                            <p>
                                {include file="user/mail/ticket_inbox.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab2}" id="panel_tab4_example2">

                            <p>
                                {include file="user/mail/create_ticket.tpl"  name=""}
                            </p>
                        </div>
                        <div class="tab-pane{$tab3}" id="panel_tab4_example3">

                            <p>
                                {include file="user/mail/view_ticket.tpl"  name=""}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
