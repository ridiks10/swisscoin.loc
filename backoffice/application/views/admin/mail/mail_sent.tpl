{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('mail_management')} 
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
                <aside class="">
                    <!-- Content Header (Page header) -->
                    <section class="content-header no-margin">
                        <h1 class="text-center">

                        </h1>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <!-- MAILBOX BEGIN -->
                        <div class="mailbox row">
                            <div class="col-xs-12">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <div class="row">
                                            {include file="admin/mail/mail_header.tpl"  name=""}
                                            <div class="col-md-9 col-sm-8">
                                                <div class="table-responsive">
                                                    <table class="table table-mailbox">
                                                        <!-- THE MESSAGES -->

                                                        {assign var=i value=1}
                                                        {assign var=clr value=""}
                                                        {assign var=id value=""}
                                                        {assign var=msg_id value=""}
                                                        {assign var=user_name value=""}
                                                        {if $cnt_adminmsgs > 0}
                                                            {foreach from=$adminmsgs item=v}
                                                                {$id = $v.id}   
                                                                {$user_name = $v.user_name}  

                                                                <tr>
                                                                    <td class="name"> <a id="" class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}"  data-toggle="modal" style='color:#C48189; text-decoration: none'>  {if $v.type == 'team'}ALL{else}{$user_name}{/if}</a></td>
                                                                    <td class="subject"> <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}"  data-toggle="modal" style='color:#C48189;text-decoration: none'> {$v.mailtoussub}</a></td>
                                                                    <td class="time"><a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}"  data-toggle="modal" style='color:#C48189;text-decoration: none'> {$v.mailtousdate}</a></td>
                                                                    <td class="center">
                                                                        {$msg_id=$v.id}
                                                                        <div class="visible-md visible-lg hidden-sm hidden-xs buttons-widget">
                                                                            <a href="#" onclick="deleteSentMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                                                                        </div>
                                                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                            <div class="btn-group">
                                                                                <a class="dropsmalldown btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                                                </a>
                                                                                <ul role="menu" class="dropdown-menu pull-right">
                                                                                    <li role="presentation">
                                                                                        <a role="menuitem" href="#" onclick="deleteSentMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')">
                                                                                            <i class="fa fa-times"></i>{lang('remove')}
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </td>   
                                                                </tr>
                                                                {$i=$i+1}
                                                            {/foreach}
                                                        {else}
                                                            {lang('You_have_no_mails_in_sent')}
                                                        {/if}
                                                    </table>
                                                </div><!-- /.col (RIGHT) -->
                                            </div><!-- /.row -->
                                        </div><!-- /.box-body -->
                                        <div class="box-footer clearfix">
                                            <div class="pull-right">
                                                <small> {$result_per_page}</small>

                                            </div>
                                        </div><!-- box-footer -->
                                    </div><!-- /.box -->
                                </div><!-- /.col (MAIN) -->
                            </div>
                            <!-- MAILBOX END -->
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div>
        </div>
    </div>
</div>


<!-- start: SENT DETAILS FORM -->
{assign var=i value=1}
{assign var=clr value=""}
{assign var=pop_id value=""}
{assign var=msg_id value=""}
{assign var=user_name value=""}


{foreach from=$adminmsgs item=v}
    {$pop_id = $v.id}     
    {$user_name = $v.user_name}
    <div class="modal" id="panel-config{$pop_id}"  role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" tabindex="1">
                        &times;
                    </button>
                    <h4 class="modal-title">{lang('mail_details')}</h4>
                </div>
                <div class="modal-body">

                    <table cellpadding="0" cellspacing="0" align="center">
                        <tr align="center">
                            <th class="th" colspan="2">
                                {lang('subject')} :{$v.mailtoussub}
                            </th>
                        </tr>
                        <tr align="center">
                            <th class="th" colspan="2">
                            {lang('to')} : {if $v.type == 'team'}ALL{else}{$user_name}{/if}
                        </th>
                    </tr>
                    <tr align="justify">
                        <td class="th" colspan="2" style="padding-top:10px;">
                            <b>{lang('message')}:</b> <div class="scrolloverview"> {$v.mailtousmsg}</div>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {lang('close')}
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{$i=$i+1}
{/foreach}                
<!-- /.modal -->
<!-- end: SENT DETAILS FORM --> 

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script type="text/javascript">
    $(function () {
        $(".textarea").wysihtml5();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
