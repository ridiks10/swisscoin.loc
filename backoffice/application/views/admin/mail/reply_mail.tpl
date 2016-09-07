{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_message_here')}   </span>        
    <span id="error_msg3">{lang('you_must_select_user')}</span>        
    <span id="error_msg2">{lang('you_must_enter_subject_here')}</span>                  

</div>      


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('reply_mail')}
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
                                            <div class="col-md-9 col-sm-8" >
                                                <div class="box box-info">
                                                    <div class="box-header">
                                                        <i class="fa fa-envelope"></i>
                                                        <h3 class="box-title">{lang('reply_mail')}</h3>
                                                    </div>
                                                    <div class="box-body">
                                                       {form_open('','name="compose" id="compose" class="smart-wizard form-horizontal" method="post"')} <div class="form-group">
                                                                <input type="text" class="form-control" id="user_id1" name="user_id1" readonly value="{$reply_user}"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="subject" id="subject" value=" Rep:{$reply_msg}" />{form_error('subject')}
                                                            </div>
                                                            <div>
                                                                <textarea class="textarea" name='message' id='message' placeholder="{lang('message_to_send')}" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>{form_error('message')}
                                                            </div>

                                                            <div class="box-footer clearfix">

                                                                <button class="btn btn-bricky" type="submit" id="send" value="{lang('send_message')}" name="send" tabindex="2">
                                                                    {lang('send_message')}</button>
                                                            </div>
                                                       {form_close()}
                                                    </div>
                                                </div>
                                            </div><!-- /.col (RIGHT) -->
                                        </div><!-- /.row -->
                                    </div><!-- /.box-body -->

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


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();
        $(".textarea").wysihtml5();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
