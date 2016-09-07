{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_feedback_subject')}</span>
    <span id="error_msg2">{lang('you_must_enter_feedback_details')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('infinite_mlm_feedback')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    {* <a class="btn btn-xs btn-link panel-close" href="#">
                    <i class="fa fa-times"></i>
                    </a>*}
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="panel_tab4_example1">
                        <div class="panel-body">
                            {form_open('', 'method="post" class="smart-wizard form-horizontal" id="feedback_form" name="feedback_form"')}
                                <div class="col-md-12">
                                    <div class="errorHandler alert alert-danger no-display">
                                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="subject">{lang('feedback_subject')}<span class="symbol required"></span> 
                                    </label>
                                    <div class="col-sm-3">
                                        <input tabindex="2" name="feedback_subject" type="text" id="feedback_subject" size="35"   />{form_error('feedback_subject')}
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="message">{lang('feedback_details')}<span class="symbol required"></span></label>
                                    <div class="col-sm-3">
                                        <textarea tabindex="3" name='feedback_detail' id='feedback_detail' rows='20' cols='35'></textarea>{form_error('feedback_detail')}
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">

                                        <button class="btn btn-bricky" type="submit" name="send"  id="login" value="{lang('send')}" tabindex="4">{lang('send')}</button>
                                    </div>
                                </div>
                            {form_close()}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateFeed.init();
    });
</script>             
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}