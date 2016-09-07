          
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

                                                                {if $v.read_msg=='yes'}
                                                                    {$id = $v.mailtousid}     



                                                                    <tr>
                                                                        {if $v.flag}
                                                                            <td class="name"> <a id="" class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-toggle="modal" style='color:#C48189; text-decoration: none'>{$tran_admin}</a></td>
                                                                            {else}
                                                                            <td class="name"> <a id="" class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-toggle="modal" style='color:#C48189; text-decoration: none'>{$v.mailtoussub}</a></td>
                                                                            {/if}
                                                                        <td class="subject"> <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-toggle="modal" style='color:#C48189;text-decoration: none'> {$v.mailtoussub}</a></td>
                                                                        <td class="time"><a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-toggle="modal" style='color:#C48189;text-decoration: none'> {$v.mailtousdate}</a></td>

                                                                        <td class="center">
                                                                            {$msg_id=$v.mailtousid}
                                                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                                <a href="#" onclick="deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                                                                            </div>
                                                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                                <div class="btn-group">
                                                                                    <a class="dropsmalldown btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                                                                    </a>
                                                                                    <ul role="menu" class="dropdown-menu pull-right">
                                                                                        <li role="presentation">
                                                                                            <a role="menuitem" tabindex="-1" href="#" onclick="deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')">
                                                                                                <i class="fa fa-times"></i>  {lang('remove')}
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>




                                                                    {$i=$i+1}	
                                                                {else}

                                                                    {$id=$v.mailtousid}      


                                                                    <tr class="unread">

                                                                        <td class="name"> <a id="usernam{$id}" class="btn btn-xs btn-link panel-config" data-toggle="modal" href="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" data-toggle="modal" style='color: #007AFF;text-decoration: none'><b>{$tran_admin}</b></a></td>
                                                                        <td class="subject"><a id="sbjct{$id}" class="btn btn-xs btn-link panel-config" data-toggle="modal" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" style='color:#007AFF;text-decoration: none'> <b>{$v.mailtoussub}</b></a></td>
                                                                        <td class="time"> <a id="addate{$id}" class="btn btn-xs btn-link panel-config" data-toggle="modal" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" style='color: #007AFF;text-decoration: none'> <b>{$v.mailtousdate}</b></a></td>
                                                                        <td class="center">
                                                                            {$msg_id=$v.mailtousid}
                                                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                                <a href="#" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                                                                            </div>
                                                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                                <div class="btn-group">
                                                                                    <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                                                                    </a>
                                                                                    <ul role="menu" class="dropdown-menu pull-right">
                                                                                        <li role="presentation">
                                                                                            <a role="menuitem" tabindex="-1" href="#" onclick="deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, '{$v.type}', '{$BASE_URL}user')">
                                                                                                <i class="fa fa-times"></i> {lang('remove')}
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    {$i=$i+1}
                                                                {/if}
                                                            {/foreach}

                                                        {else}
                                                            {lang('You_have_no_mails_in_inbox')}
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
{assign var=i value=1}
{assign var=clr value=""}
{assign var=id value=""}
{assign var=msg_id value=""}
{assign var=user_name value=""}

{foreach from=$row item=v}
    {$id = $v.mailtousid}
    {$user_name = $v.user_name}
    <div class="modal" id="panel-config{$id}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">{lang('mail_details')}</h4>
                </div>
                <div class="modal-body">

                    <table cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td>
                                <b> {lang('subject')}  :</b> {$v.mailtoussub}
                            </td>
                        </tr>
                        <tr>
                            <td class="th">
                                {if $v.flag}
                                    <b> {lang('from')}  :</b> {lang('admin')}
                                {else}
                                    <b> {lang('from')}  :</b> {$v.mailtoususer}
                                {/if}
                            </td>
                        </tr>
                        <tr>
                            <td width="80%"  style="padding-top: 10px;">
                                <b> {lang('message')} :</b> <h6><p style="text-align: justify;line-height: 20px;"> {$v.mailtousmsg}</p></h6>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    {if $v.flag}
                        <a href="{$BASE_URL}user/mail/reply_mail/{$v.mailtousid}"
                           <button type="button" class="btn btn-bricky" {*onclick="getUsername('{$user_name}', '{$v.mailtoussub}');"*} >
                                {lang('reply')}</button>
                        </a>
                    {/if}
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {lang('close')}
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


{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script type="text/javascript">
    Main.init();
    $(".textarea").wysihtml5();
    //=========================code added on april 11,2014

function readMessage(id, row, type, path_root) {
    //alert('asd');
    var user_available = path_root + "/mail/readMessage";
    $.post(user_available, { id: id, type: type, {$CSRF_TOKEN_NAME}: '{$CSRF_TOKEN_VALUE}' }, function(data) {
        var status = trim(data);
        if (data >= 0) {
            $("#mailcount").html(data);
            $("#usernam" + id).css("color", "#C48189");
            $("#sbjct" + id).css("color", "#C48189");
            $("#addate" + id).css("color", "#C48189");
        }
    });
}
//=========================

</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
