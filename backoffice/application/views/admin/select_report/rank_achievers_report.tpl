{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_select_from_date')}</span>
    <span id="error_msg1">{lang('you_must_select_to_date')}</span>
    <span id="errmsg4">{lang('you_must_select_from_to_date_correctly')}</span>
    <span id ="error_msg4">{lang('you_must_select_a_to_date_greater_than_from_date')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('rank_achieve_report')}
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
                {form_open('admin/report/rank_achievers_report_view','role="form" class="smart-wizard form-horizontal" method="post" name="sales_report" id="weekly_payout" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>{lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="rank">
                                {lang('select_rank')}<span class="symbol required"></span>
                            </label>
                            <div class="col-sm-7">
                                <select name="ranks[]" multiple style="width: 16em;" tabindex="1">
                                    {foreach from=$rank_arr item=rank}
                                        <option value="{$rank["rank_id"]}">{$rank["rank_name"]}</option>
                                    {/foreach}
                                </select>
                            {if $error_count && isset($error_array['ranks[]'])}{$error_array['ranks[]']}{/if}
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="week_date1">
                        {lang('from_date')}<span class="symbol required"></span>
                    </label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="2" size="20" maxlength="10"  value="" >
                            <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                        </div>{if $error_count && isset($error_array['week_date1'])}{$error_array['week_date1']}{/if}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="week_date2">
                        {lang('to_date')}<span class="symbol required"></span>
                    </label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="3" size="20" maxlength="10"  value="" >
                            <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                        </div>{if $error_count && isset($error_array['week_date2'])}{$error_array['week_date2']}{/if}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky"tabindex="4" name="weekdate" type="submit" value="{lang('submit')}">{lang('submit')}</button>
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