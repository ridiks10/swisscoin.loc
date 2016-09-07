{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}    
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_select_date')}   </span>
    <span id="row_msg">{lang('rows')} </span>
    <span id="show_msg">{lang('shows')}</span>

</div>
<!-- end: PAGE HEADER -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('monthly_revenue_details')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="weekly_join" id="weekly_join" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>{lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date2">{lang('select_date')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="date" id="date" type="text" tabindex="4" size="20" maxlength="10"   >
                                <label for="date" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>


                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" id="submit" value="submit" name="submit" tabindex="2">
                                {lang('submit')}
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>
{if $status == 1}

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('Total_income')}
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
                    <table  class="table table-striped table-bordered table-hover table-full-width" id="sample_1" width='50'>
                        <thead>
                            <tr class ='th' >
                                <th class="hidden-xs">{lang('Amount_Type')}</th>
                                <th class="hidden-xs">{lang('Amount')}</th>

                            </tr>
                        </thead>
                        <tbody>
                            {assign var="total_amount" value="0"}
                            {foreach from=$monthly_income_details item=v}
                                {assign var="total_amount" value="{$total_amount+$v}"}
                                <tr>
                                    <td class="hidden-xs" >{lang('Joining')}</td>
                                    <td class="hidden-xs">{$v}</td>

                                </tr>
                            {/foreach}
                            <tr>
                                <td>{lang('Total_amount')}</td>
                                <td>{$total_amount}</td>
                            </tr>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('Total_Commsion_details')}
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

                    <table  class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class ='th' >
                                <th class="hidden-xs">{lang('Amount_Type')}</th>
                                <th class="hidden-xs">{lang('Amount')}</th>

                            </tr>
                        </thead>
                        <tbody>
                            {assign var="total_amount_tot" value="0"}
                            {foreach from=$monthly_commission_details item=v}
                                {assign var="total_amount_tot" value="{$total_amount_tot+$v.total_amount}"}
                                <tr>
                                    <td class="hidden-xs" >{$v.amount_type}</td>
                                    <td class="hidden-xs">{$v.total_amount}</td>

                                </tr>
                            {/foreach}
                            <tr><td>{lang('Total_amount')}</td><td> {$total_amount_tot}</td></tr>
                        </tbody>

                    </table>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b> {lang('perc')}{$date} :{$percentage}%</b>
                </div>

            </div>
        </div>

    </div>

{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function() {
        Main.init();
        DateTimePicker.init();
        Validate_revenue.init();
        TableData.init();
    });
</script>




{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}