{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">

    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_news_there_is_no_undo')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg1">{lang('you_must_enter_rank_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_referal_count')}</span>
</div> 


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
                {lang('payout_settings')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="payout_form" id="payout_form"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>


                <div class="panel-body">
                    <div class="form-group">
                        {if $MODULE_STATUS['payout_release_status']=="from_ewallet" ||$MODULE_STATUS['payout_release_status']=="ewallet_request"}
                            <label class="col-sm-2 control-label" for="min_payout">   {lang('Minimum_Payout_Amount')}:</label>
                            <div class="col-sm-3">

                                {$DEFAULT_SYMBOL_LEFT}&nbsp;&nbsp;<input tabindex="10" type = 'text' name ='min_payout' id='payout_amount_min' value="{number_format($obj_arr["min_payout"]*$DEFAULT_CURRENCY_VALUE,2)}" title="{lang('Minimum_Amount_for_Payout_Release')}">{$DEFAULT_SYMBOL_RIGHT}{form_error('min_payout')}
                            {else}
                                <input type="hidden" name="min_payout" id="min_payout" value="0"/>
                            {/if}
                            <span id="errmsg6"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        {if $MODULE_STATUS['payout_release_status']=="from_ewallet" ||$MODULE_STATUS['payout_release_status']=="ewallet_request"}
                            <label class="col-sm-2 control-label" for="max_payout">   {lang('Maximum_Payout_Amount')}:</label>
                            <div class="col-sm-3">

                                {$DEFAULT_SYMBOL_LEFT}&nbsp;&nbsp;<input tabindex="10" type = 'text' name ='max_payout' id='payout_amount_max' value="{number_format($obj_arr["max_payout"]*$DEFAULT_CURRENCY_VALUE,2)}" title="{lang('Maximum_Amount_for_Payout_Release')}">{$DEFAULT_SYMBOL_RIGHT}{form_error('max_payout')}
                            {else}
                                <input type="hidden" name="min_payout" id="min_payout" value="0"/>
                            {/if}
                            <span id="errmsg7"></span>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-2 control-label" for="payout_status"> {lang('payout_method')} : </label>
                        <div class="col-sm-4">
                            {*  <p>
                            <input tabindex="11" type="radio" id="payout_normal" name="payout_status" value="normal" {if $MODULE_STATUS['payout_release_status']=='normal'}checked {/if}/>
                            <label for="payout_normal">{lang('daily')}</label>
                            </p>*}
                            <p>
                                <input tabindex="11" type="radio" name="payout_status" id="payout_ewallet" value="from_ewallet" {if $MODULE_STATUS['payout_release_status']=='from_ewallet'}checked {/if} />
                                <label for="payout_ewallet">{lang('from_e_wallet')}</label>
                            </p>
                            <p>
                               <input tabindex="11" type="radio" name="payout_status" id="payout_ewallet_req" value="ewallet_request" {if $MODULE_STATUS['payout_release_status']=='ewallet_request'}checked {/if} />
                                <label for="payout_ewallet_req">{lang('e_wallet_request')}</label>
                            </p>
                            <span id="errmsg6"></span>
                            {form_error('payout_status')}
                        </div>

                    </div>
                    <div class="form-group">
                        {if $MODULE_STATUS['payout_release_status']=="ewallet_request"}
                            <label class="col-sm-2 control-label" for="payout_validity"> {lang('Payout_Request_Validity')}:</label>
                            <div class="col-sm-3">
                                <input type="text" name ="payout_validity"  id ="payout_amount" value="{$obj_arr["payout_request_validity"]}" title="{lang('Payout_Request_Validity_days')}"> {form_error('payout_validity')}
                            </div>   
                        {else}
                            <input type="hidden" name ="payout_validity"  id ="payout_amount" value="{$obj_arr["payout_request_validity"]}" >   
                        {/if}

                    </div>


                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="12" name="setting" id="setting" title="{lang('update')}">{lang('update')}</button>
                        </div>
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
        TableData.init();
        Validateconfig.init();

    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
