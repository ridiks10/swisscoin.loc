{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('enter_subject')}</span>
    <span id="validate_msg2">{lang('enter_message')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('edit_text_invite')}
            </div>
            <div class="panel-body">
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="invite_text_form" id="invite_text_form"')}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" > {lang('subject')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="subject" id ="subject" value='{$mail_details['subject']}'  autocomplete="Off" tabindex="2">



                        </div>
                        {form_error('subject')}
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="mail_content">
                            {lang('message')} :<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-9">
                            <textarea id="mail_content"  name="mail_content"   class="tinymce form-control"  tabindex="3"  rows='10' >{$mail_details['content']}
                                
                            </textarea>{form_error('mail_content')}
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">

                        </label>


                    </div>
                    <input type='hidden' name='invite_text_id' id='invite_text_id' value='{$mail_details['id']}'>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Update" name="update" id="update" >{lang('update')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>





{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        validate_invite_config.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
