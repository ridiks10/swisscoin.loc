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
                <i class="fa fa-external-link-square"></i>{lang('compose_mail')}
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
                                                <!-- quick email widget -->
                                                <div class="box box-info">
                                                    <div class="box-header">
                                                        <i class="fa fa-envelope"></i>

                                                        <h3 class="box-title">{lang('compose_mail')}</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        {form_open('','role="form"  method="post" name="compose" id="compose"')}

                                                            <div class="form-group">

                                                                <select class="form-control" id="mail_status" name="mail_status" onchange="show_text(this.value)">
                                                                    <option value="single" {if $mail_status=="single"} selected {/if}>{lang('Single_User')}</option>
                                                                    <option value="all"  {if $mail_status=="all"} selected {/if}>{lang('All_Users')}</option>

                                                                </select>
                                                            </div>

                                                            {if $mail_status=="single"}
                                                                <div class="form-group" id="user_div">

                                                                    <input type='text' class='form-control username-auto-ajax' name='user_id' id='user_id' placeholder='{lang('Single_User')}' autocomplete="Off" />{form_error('user_id')}
                                                                </div>
                                                            {/if}


                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="subject" id="subject" placeholder="{lang('subject')}" />{form_error('subject')}
                                                            </div>
                                                            <div>                                                
                                                                <textarea class="textarea" name='message1' id='message1' placeholder="{lang('user_message')}" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>{form_error('message1')}
                                                            </div>

                                                            <div class="box-footer clearfix">

                                                                <button class="btn btn-bricky" type="submit" name="adminsend"  id="adminsend" value="{lang('send_message')}" tabindex="4">{lang('send_message')}</button>
                                                            </div>
                                                            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">

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
        ValidateMail.init();
        $(".textarea").wysihtml5();
    });


</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
