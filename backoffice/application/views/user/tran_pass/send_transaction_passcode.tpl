{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_select_user')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('send_transaction_password')} 
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
                    {form_open('user/tran_pass/send_transaction_passcode','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" action="" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="col-md-12" >

                        <p style="color: blue">{lang('transaction_password_will_send')}</p>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <label class="col-sm-2 control-label" for="sent_passcode"><button class="btn btn-bricky" type="submit" name="sent_passcode" id="sent_passcode" value="{lang('send_password')}" tabindex="2">
                                    {lang('send_password')}
                                </button></label>
                        </div>
                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}user/">
                    </div>
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