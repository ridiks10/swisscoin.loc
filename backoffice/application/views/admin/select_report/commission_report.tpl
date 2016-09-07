{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">

    <span id="error_msg">{lang('you_must_select_from_date')}</span>
    <span id="error_msg1">{lang('you_must_select_to_date')}</span>
    <span id="error_msg2">{lang('you_must_select_from_to_date_correctly')}</span>
    <span id="error_msg3">{lang('you_must_select_product')}</span>
    <span id ="error_msg4">{lang('you_must_select_a_to_date_greater_than_from_date')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('commission_report')}
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
                {form_open('admin/report/commission_report_view','role="form" class="smart-wizard form-horizontal" method="post"  name="commision_form" id="commision_form" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>{lang('errors_check')}.
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="from_date">
                            {lang('from_date')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="from_date" id="from_date" type="text" tabindex="1" size="20" maxlength="10"  value="" >
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            </div>{if $error_count && isset($error_array['from_date'])}{$error_array['from_date']}{/if}
                        </div>
                        <label class="col-sm-1 control-label" for="to_date" style="width: 100px;">
                            {lang('to_date')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="to_date" id="to_date" type="text" tabindex="2" size="20" maxlength="10"  value="" >
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            </div>{if $error_count && isset($error_array['to_date'])}{$error_array['to_date']}{/if}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="type">
                            {lang('amount_type')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-md-3"> 
                            <select multiple name="amount_type[]" id="amount_type" style="vertical-align: top;width: 200px;" tabindex="3">
                                {for $i=0;$i<$count_commission;$i++}
                                    {if $MLM_PLAN != "Binary" && $commission_types[$i]['db_amt_type'] == "leg"}
                                        {$i++}
                                    {/if}
                                    <option value="{$commission_types[$i]['db_amt_type']}">{$commission_types[$i]['view_amt_type']}</option>


                                {/for}
                            </select>{if $error_count && isset($error_array['amount_type[]'])}{$error_array['amount_type[]']}{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky" tabindex="4" name="commision" type="submit" value="{lang('submit')}"> {lang('submit')}</button>


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
        ValidateCommissionReport.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}