{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_user_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_sponsor_name')}</span>

</div>	

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('change_sponsor_name')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="change_sponsor" id="change_sponsor" method="post" onSubmit="return validate_username()"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_id')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" >
                            {form_error('user_name')}
                        </div>

                    </div>
                  
                        <div class="form-group">
                            <div id="sponsor_name_div"> </div>
                        </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sponsor_user_name">{lang('new_sponsor')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input class="form-control username-auto-ajax" type="text" id="sponsor_user_name" name="sponsor_user_name" autocomplete="Off" tabindex="1" onclick="getSponsorName();">
                            {form_error('sponsor_user_name')}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky" type="submit" id="change_sponsor" value="change_sponsor" name="change_sponsor" tabindex="2">
                                {lang('change_sponsor')}
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin" >
                {form_close()}
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateChangeSponsorName.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
