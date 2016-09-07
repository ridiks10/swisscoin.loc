
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id ="error_msg">{lang('You_must_select_from_date')}</span>
    <span id ="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id ="error_msg2">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id ="error_msg3">{lang('You_must_select_a_date')}</span>
    <span id ="error_msg4">{lang('You_must_select_a_Todate_greaterThan_Fromdate')}</span>
</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('daily_joining')}
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
                {form_open('admin/report/total_joining_daily','role="form" class="smart-wizard form-horizontal" method="post"  name="daily" id="daily" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="date">
                            {lang('date')}: <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="date" id="date" type="text" tabindex="1" size="20" maxlength="10"  value="" >
                                <label for="date" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                            </div>{if $error_count && isset($error_array['date'])}{$error_array['date']}{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky"tabindex="2" name="dailydate" type="submit" value="{lang('submit')}"> {lang('submit')} </button>

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
                <i class="fa fa-external-link-square"></i>{lang('weekly_joining')}
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
                {form_open('admin/report/total_joining_weekly','role="form" class="smart-wizard form-horizontal" method="post" name="weekly_join" id="weekly_join" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date1">
                            {lang('from_date')}: <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="3" size="20" maxlength="10"  value="" >
                                <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                            </div>{if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date2">
                            {lang('to_date')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="4" size="20" maxlength="10"  value="" >
                                <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                            </div>{if $error_count_weekly && isset($error_array_weekly['week_date2'])}{$error_array_weekly['week_date2']}{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky"tabindex="5" name="weekdate" type="submit" value="{lang('submit')}"> {lang('submit')}</button>

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