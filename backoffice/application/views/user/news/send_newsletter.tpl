{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('newsletter')} 
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
                {form_open('user/news/send_newsletter', 'role="form" class="smart-wizard form-horizontal"  id="compose" name="compose" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="status_all">{lang('Send_Mail_To')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input tabindex="1" type="radio" id="status_all" name="mail_status" value="all" onclick="hid_text()" checked='1' />
                            <label for="status_all"></label>{lang('all_subscribers')}
                        </div>
                        <div class="col-sm-3">
                            <input tabindex="1" type="radio" name="mail_status" id="status_mul" value="single"   onclick="show_text_email()"/>
                            <label for="status_mul"></label>{lang('single_subscribers')}
                        </div>
                    </div>
                    <div class="form-group" id="user_div"  style="display:none;" >
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="subject">{lang('subject')}<span class="symbol required"></span> </label>
                        <div class="col-sm-3">
                            <input tabindex="2" name="subject" type="text" id="subject" size="35"   />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message">{lang('newsletter_to_subscribers')}<span class="symbol required"></span></label>
                            {*               <div class="col-sm-3">
                            <textarea tabindex="3" name='message' id='message' rows='20' cols='35'></textarea>
                            </div>*}
                        <div class="col-sm-9">
                            <textarea rows="12"  name="message" id="message" cols="22" tabindex="2" class="ckeditor form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" name="adminsend"  id="adminsend" value="{lang('send_message')}" tabindex="4">{lang('send_newsletter')}</button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            ValidateUser.init();
        });
    </script>
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
