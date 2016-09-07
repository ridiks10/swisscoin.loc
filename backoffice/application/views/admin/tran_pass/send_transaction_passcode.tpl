{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="col-md-12" >

                        <p style="color: blue">{lang('transaction_password_will_send_admin')}</p>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input class="form-control"  type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" > {form_error('user_name')}

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <label class="col-sm-2 control-label" for="sent_passcode"><button class="btn btn-bricky" type="submit" name="sent_passcode" id="sent_passcode" value="{lang('send_password')}" tabindex="2">
                                    {lang('send_password')}
                                </button></label>
                        </div>
                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
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
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}