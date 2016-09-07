{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_sender_id')}</span>
    <span id="validate_msg2">{lang('you_must_enter_user_name')}</span>
    <span id="validate_msg3">{lang('you_must_enter_password')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('sms_settings')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" name="sms_form" id="username_config_form"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="sender_id">{lang('sender_id')}:<font color="#ff0000" >*</font></label>
                    <div class="col-sm-6">
                        <input  type="text"  name ="sender_id" id ="sender_id" value="" tabindex="1">
                        <span id="username_box" style="display:none;"></span>{form_error('sender_id')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="user_name">{lang('user_name')}:<font color="#ff0000" >*</font></label>
                    <div class="col-sm-6">
                        <input  type="text"  name ="user_name" id ="user_name" value="" tabindex="2">
                        <span id="username_box" style="display:none;"></span>{form_error('user_name')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="password">{lang('password')}:<font color="#ff0000" >*</font></label>
                    <div class="col-sm-6">
                        <input  type="password"  name ="password" id ="password" value="" tabindex="3">
                        <span id="username_box" style="display:none;"></span>{form_error('password')}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <input class="btn btn-bricky" type="submit"  name ="sms_config" id ="sms_config" value="{lang('submit')}" tabindex="4">
                        <span id="username_box" style="display:none;"></span>
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
        ValidateSmsSettings.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}