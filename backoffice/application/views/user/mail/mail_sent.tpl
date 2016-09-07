{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

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
                                            {include file="user/mail/mail_header.tpl"  name=""}


                                            <div class="col-md-9 col-sm-8">


                                                <div class="table-responsive">
                                                    <table class="table table-mailbox">
                                                        <!-- THE MESSAGES -->

                                                        {assign var=i value=1}
                                                        {assign var=clr value=""}
                                                        {assign var=id value=""}
                                                        {assign var=msg_id value=""}
                                                        {assign var=user_name value=""}
                                                        {if $cnt_mails > 0}
                                                            {foreach from=$row item=v}
                                                                {$id = $v.mailadid}     

                                                                {$user_name = $v.user_name}  

                                                                <tr>

                                                                    <td class="name"> <a id="" class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}"  data-toggle="modal" style='color:#C48189; text-decoration: none'>  {$user_name}</a></td>
                                                                    <td class="subject"> <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}"  data-toggle="modal" style='color:#C48189;text-decoration: none'> {$v.mailadsubject}</a></td>
                                                                    <td class="time"><a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}"  data-toggle="modal" style='color:#C48189;text-decoration: none'> {$v.mailadiddate}</a></td>
                                                                    <td class="center">
                                                                        {$msg_id=$v.mailadid}
                                                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                            <a href="#" onclick="deleteSentMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                                                                        </div>
                                                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                            <div class="btn-group">
                                                                                <a class="dropsmalldown btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                                                </a>
                                                                                <ul role="menu" class="dropdown-menu pull-right">
                                                                                    <li role="presentation">
                                                                                        <a role="menuitem" tabindex="-1" href="#" onclick="deleteSentMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')">
                                                                                            <i class="fa fa-times"></i>  {lang('remove')}
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
                                                    </table> </div><!-- /.table-responsive -->
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
{assign var=id value=""}
{assign var=msg_id value=""}
{assign var=user_name value=""}


{foreach from=$row item=v}
    {$id = $v.mailadid}     
    {$user_name = $v.user_name}
    <div class="modal" id="panel-config{$id}"  role="dialog" aria-hidden="true">

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
                                {lang('subject')} :{$v.mailadsubject}
                            </th>
                        </tr>
                        <tr align="center">
                            <th class="th" colspan="2">
                                {lang('to')} : {lang('admin')}
                            </th>
                        </tr>
                        <tr align="justify">
                            <td class="th" colspan="2" style="padding-top:10px;">
                                <b>{lang('message')}:</b> <div class="scrolloverview"> {$v.mailadidmsg}</div>
                            </td>

                        </tr>
                    </table>

                </div>
                <div class="modal-footer">


                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {lang('close')}
                    </button>
                </div>


                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
{/foreach}                
<!-- /.modal -->
<!-- end: SENT DETAILS FORM --> 

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script type="text/javascript">
    Main.init();
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
