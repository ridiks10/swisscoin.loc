
{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="errmsg1">{$LANG['You_must_select_a_date']}</span>
    <span id="errmsg2">{$LANG['You_must_select_from_date']}</span>
    <span id="errmsg3">{$LANG['You_must_select_to_date']}</span>
    <span id="errmsg4">{$LANG['You_must_Select_From_To_Date_Correctly']}</span>
    <span id="row_msg">{$LANG['rows']}</span>
    <span id="show_msg">{$LANG['shows']}</span>
</div>
<!-- end: PAGE HEADER -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{$LANG['weekly_payout']}
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
                            <i class="fa fa-times-sign"></i> {$LANG['errors_check']}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date1">{$LANG['date']} 1<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="4" size="20" maxlength="10" >
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date2">{$LANG['date']} 2<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="4" size="20" maxlength="10"   >
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" id="weekdate" value="profile_update" name="weekdate" tabindex="2">
                                {$LANG['submit']}
                            </button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>
{if $form_submit || $session}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
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
                    {$LANG['weekly_payout']}
                </div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class ='th' >
                                <th class="hidden-xs">S.No.</th>
                                <th>{$LANG['user_name']}</th>
                                <th class="hidden-xs">{$LANG['total_amount']}</th>
                                <th class="hidden-xs">{$LANG['tds']}</th>
                                <th class="hidden-xs">{$LANG['service_charge']}</th>
                                <th>{$LANG['amount_payable']}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {if $length>0}
                                {foreach from=$weekly_payout item=v}
                                    {assign var="total_amount_tot" value="{$total_amount_tot+$v.total_amount}"}
                                    {assign var="tds_tot" value="{$tds_tot+$v.tds}"}
                                    {assign var="service_charge_tot" value="{$service_charge_tot+$v.service_charge}"}
                                    {assign var="amount_payable_tot" value="{$amount_payable_tot+$v.amount_payable}"}
                                    <tr>

                                        <td class="hidden-xs" >{counter}</td>
                                        <td>{$v.user_name}</td>
                                        <td class="hidden-xs">{$v.total_amount}</td>
                                        <td class="hidden-xs">{$v.tds}</td>
                                        <td class="hidden-xs">{$v.service_charge}</td>
                                        <td>{$v.amount_payable}</td>

                                    </tr> 
                                {/foreach}
                                <tr bgcolor='#5E8487' align='center'>
                                    <td class="hidden-xs"><b></b></td>
                                    <td><b>Total</b></td>
                                    <td class="hidden-xs"><b>{$total_amount_tot}</b></td>
                                    <td class="hidden-xs"><b>{$tds_tot}</b></td>
                                    <td class="hidden-xs"><b>{$service_charge_tot}</b></td>
                                    <td><b>{$amount_payable_tot}</b></td>

                                </tr>  
                            {else}
                                <tr bgcolor='#5E8487' align='center'>
                                    <td class="hidden-xs" >{counter}</td>
                                    <td>{$user_name}</td>
                                    <td class="hidden-xs">0</td>
                                    <td class="hidden-xs">0</td>
                                    <td class="hidden-xs">0</td>
                                    <td>0</td>

                                </tr>  
                            {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{/if}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{if $length>0}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            DateTimePicker.init();
            ValidateUser.init();
            TableData.init();
        });
    </script>
{else}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            DateTimePicker.init();
            ValidateUser.init();
            TableData.init();

        });
    </script>
{/if}
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}