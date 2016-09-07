{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{*include file="../select_report/report_tab.tpl"  name=""*}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('You_must_select_from_date')}</span>
    <span id="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id="errmsg4">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="error_msg2">{lang('You_must_enter_user_name')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>      {lang('full_epin_report')}
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
                {form_open('admin/report/epin_report_view','role="form" class="smart-wizard form-horizontal" method="post"    name="daily" id="daily" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="full_epin">
                            {lang('full_epin_report')}
                        </label>
                        <div class="col-sm-6">
                            <button class="btn btn-bricky" tabindex="1" name="full_epin" type="submit" value="{lang('view')}"> {lang('view')} </button>

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
        DatePicker.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}