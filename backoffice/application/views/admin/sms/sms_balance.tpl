{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="errmsg1">{lang('You_must_select_a_date')}</span>
    <span id="errmsg2">{lang('You_must_select_from_date')}</span>
    <span id="errmsg3">{lang('You_must_select_to_date')}</span>
    <span id="errmsg4">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('sms_balance_details')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post" name="daily" id="daily"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-sm-6 control-label" for="count">
                                {lang('sms_package_current_balance_is')} {$balance}
                            </label>
                            <div class="col-sm-6">
                                <a href="https://www.infinitesms.in" target="_blank">
                                    <img src="https://www.infinitesms.in/images/logo.gif" style="border:1px solid #ccc;padding:1px;"/>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label" for="count">
                                <div class="visible-md visible-lg hidden-sm hidden-xs">
                                    <blockquote class="pull-right">
                                        <p>
                                            {lang('thanks_for_using_infinte_sms_service')}
                                        </p>
                                        <small>{lang('regards')} <cite title="Source Title"><a href="https://www.infinitesms.in" target="_blank">www.infinitesms.in</a></cite></small>
                                    </blockquote>
                                </div>
                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                    <blockquote class="text-left">
                                        <p>
                                            {lang('thanks_for_using_infinte_sms_service')}
                                        </p>
                                        <small>{lang('regards')} <cite title="Source Title"><a href="https://www.infinitesms.in" target="_blank">www.infinitesms.in</a></cite></small>
                                    </blockquote>
                                </div>
                            </label>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
    {*if count($daily_joinings) != 0 || count($weekly_joinings)!=0*}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            TableData.init();
            DatePicker.init();
            ValidateUser.init();
        });
    </script>
    {*else*}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            DatePicker.init();
            ValidateUser.init();
        });
    </script>
    {*/if*}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
