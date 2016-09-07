{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">

    <span id="validate_msg1">{lang('enter_caption')}</span>
    <span id="validate_msg2">{lang('enter_description')}</span>    
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('email_invite')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="soial-invite-email" id="soial-invite-email"')}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('subject')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="subject" id ="subject" value='{$social_invite_email['subject']}'  autocomplete="Off" tabindex="2">
                        </div>
                        {form_error('subject')}
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="mail_content">
                            {lang('message')} :<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-9">
                            <textarea id="message"  name="message"   class="ckeditor form-control"   tabindex="3"  rows='10' >
                                {$social_invite_email['content']}
                            </textarea>{form_error('message')}
                        </div>
                    </div>        
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="4"   type="submit"  value="Update" name="submit_email" id="submit_email" >{lang('submit')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('facebook_invite')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="soial-invite-fb" id="soial-invite-fb"')}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('caption')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="caption" id ="caption" tabindex="5" value='{$social_invite_fb['subject']}'  autocomplete="Off">
                        </div>
                        {form_error('caption')}
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="mail_content">
                            {lang('description')} :<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-9">
                            <textarea id="description"  name="description"   class="ckeditor form-control"   tabindex="6"  rows='10' >
                                {$social_invite_fb['content']}
                            </textarea>{form_error('description')}
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="7"   type="submit"  value="Update" name="submit_fb" id="submit_fb" >{lang('submit')}</button>                                
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
        validate_invite_wallpost.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
