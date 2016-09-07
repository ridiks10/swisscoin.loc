{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_select_a_date')}</span>
    <span id="error_msg2">{lang('You_must_select_a_date')}</span>
    <span id="errmsg4">{lang('You_must_Select_From_To_Date_Correctly')}</span>
</div>
{if $payout_release_status=='from_ewallet_request'|| $payout_release_status=='from_ewallet'}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('payout_release_report')}
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
                    {form_open('admin/report/payout_release_ewallet_request','role="form" class="smart-wizard form-horizontal" method="post"   name="searchform" id="searchform"  target="_blank"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="week_date1">
                                {lang('select_payout_released_date')}1 <span class="symbol required"></span>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="1" size="20" maxlength="10"  value="" >
                                    <br>{if $error_count && isset($error_array['week_date1'])}{$error_array['week_date1']}{/if}
                                    <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="week_date2">
                                {lang('select_payout_released_date')}2 <span class="symbol required"></span>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="2" size="20" maxlength="10"  value="" >
                                    <br>{if $error_count && isset($error_array['week_date2'])}{$error_array['week_date2']}{/if}
                                    <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky"tabindex="3" id="payout_released" name="payout_released" type="submit" value="{lang('view')}"> {lang('view')} </button>
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{else}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {lang('payout_release_report')}
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
                    {form_open('admin/report/payout_released_report_binary','role="form" class="smart-wizard form-horizontal" method="post" name="searchform2" id="searchform2"  target="_blank"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div> 
                        {if $payout_type == "daily" }
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="week_date1">
                                    {lang('select_payout_released_date')}<span class="symbol required"></span>
                                </label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="4" size="20" maxlength="10"  value="" >
                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                    </div>
                                </div>
                            </div>
                        {else}
                            <!--
         <div class="form-group">
    
        
            <div class="col-md-3">   
               <select class="form-control"    id="released_date1" name="released_date1" tabindex="6">
                <option value="">{lang('select_date')}</option>
                            {foreach from=$arr_dates item=v}

                                <option value="{$v}">{$v}</option>
                            {/foreach}
                        </select>
                    </div></div>
                            -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="released_date1">
                                    {lang('select_payout_released_date')}<span class="symbol required"></span>
                                </label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" id="released_date1" name="released_date1" type="text" tabindex="5" size="20" maxlength="10"  value="" >
                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                    </div>
                                </div>
                            </div>


                        {/if}
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky"tabindex="6"  type="submit" name="payout_released" value="{lang('view')}" > {lang('view')} </button>
                                <input type="hidden" name="payout_type" value="released">

                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}
{if $payout_release_status=='from_ewallet_request'}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('payout_pending_report')}
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
                    {form_open('admin/report/payout_request_pending','role="form" class="smart-wizard form-horizontal" method="post"   name="searchform1" id="searchform1"  target="_blank"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="week_date3">
                                {lang('select_payout_released_date')}1 <span class="symbol required"></span>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date3" id="week_date3" type="text" tabindex="7" size="20" maxlength="10"  value="" >
                                    <br>{if $error_request_count && isset($error_array_request['week_date3'])}{$error_array_request['week_date3']}{/if}
                                    <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="week_date4">
                                {lang('select_payout_released_date')}2 <span class="symbol required"></span>
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date4" id="week_date4" type="text" tabindex="8" size="20" maxlength="10"  value="" >
                                    <br>{if $error_request_count && isset($error_array_request['week_date4'])}{$error_array_request['week_date4']}{/if}
                                    <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky"tabindex="9" name="payout_released" type="submit" value="{lang('view')}"> {lang('view')} </button>


                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{else}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('payout_pending_report')}
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
                    {form_open('admin/report/payout_released_report_binary','role="form" class="smart-wizard form-horizontal" method="post"   name="searchform3" id="searchform3"  target="_blank"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div> 
                        {if $payout_type == "daily" }
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="week_date2">
                                    {lang('select_payout_released_date')}<span class="symbol required"></span>
                                </label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="10" size="20" maxlength="10"  value="" >
                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                    </div>
                                </div>
                            </div>
                        {else}
                            <!--  <div class="form-group">
                                  
                                  <div class="col-md-3">   
                                  <select class="form-control"    id="released_date2" name="released_date2" tabindex="6">
                                      <option value="">{lang('select_date')}</option>
                            {foreach from=$arr_dates item=v}

                                <option value="{$v}">{$v}</option>
                            {/foreach}
                        </select>
                        </div></div>-->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="released_date2">
                                    {lang('select_payout_released_date')}<span class="symbol required"></span>
                                </label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="released_date2" id="released_date2" type="text" tabindex="11" size="20" maxlength="10"  value="" >
                                        <br>{if $error_binary_count && isset($error_array_binary['released_date2'])}{$error_array_binary['released_date2']}{/if}
                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                    </div>
                                </div>
                            </div>

                        {/if}
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky"tabindex="12"  type="submit" name="payout_released" value="{lang('view')}" > {lang('view')} </button>
                                <input type="hidden" name="payout_type" value="pending">

                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        DatePicker.init();
        ValidateUser.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}




