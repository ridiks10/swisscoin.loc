{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg1">{lang('you_must_enter_transaction_password')}</span>
    <span id="error_msg2">{lang('transaction_password_atleast_8_characters_long')}</span>
    <span id="error_msg3">{lang('you_must_enter_payout_amount')}</span>
    <span id="error_msg4">{lang('payout_amount_must_be_greater_than_0')}</span>
    <span id="error_msg5">{lang('payout_amount_must_be_an_integer')}</span>
</div> 
<style>
    .val-error {
        color:rgba(249, 6, 6, 1);
        opacity:1;
    }
</style>
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
                {lang('withdraw')}   
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="" >
                    <tr class="th">
                        <th>{lang('slno')}</th>
                        <th>{lang('ewallet_balance')}</th>
                        <th>{lang('result_amount')}</th>
                        <th>{lang('waiting_withdrowal')}</th>
                        <th>{lang('total_paid')}</th>
                    </tr>
                    <tr>
                        <td>{counter}</td>
                        <td>
                            {$DEFAULT_SYMBOL_LEFT}{number_format($balance_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        <td>
                            {$DEFAULT_SYMBOL_LEFT}{number_format($result_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        <td>
                            {$DEFAULT_SYMBOL_LEFT}{number_format($req_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        <td>
                            {$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                    </tr> 

                </table>
                <h5>{lang('ewallet_balance')} :{$DEFAULT_SYMBOL_LEFT}{number_format($balance_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</h5>
            </div>
            <div class="panel-body">
            
                    {form_open('user/payout/payout_release_request','role="form" class="smart-wizard form-horizontal" method="post"  name="payout_request" id="payout_request" ')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>  {lang('errors_check')}   
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="company">{lang('please_enter_your_withdraw_amount')}   :</label>
                        <div class="col-sm-6">
                            {$DEFAULT_SYMBOL_LEFT}<input  type="text" name="payout_amount" id="payout_amount" value="{$result_amount*$DEFAULT_CURRENCY_VALUE}"  autocomplete="Off" >{$DEFAULT_SYMBOL_RIGHT}
                            {form_error('payout_amount')}
                            <span id="errmsg1"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="company">{lang('transation_password')}   :</label>
                        <div class="col-sm-6">
                            <input  type="password" name="transation_password" id="transation_password" value=""  placeholder={lang('transaction_password')} autocomplete="Off" >
                            {form_error('transation_password')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-2">
                            <button class="btn btn-bricky" name="payout_request_submit" id="payout_request_submit" value="Send Request" {if (!$KYC_status)} disabled="disabled" {/if}>
                                {lang('withdraw')}
                            </button>
                        </div><br><br><br>
                        <h5> {lang('note')}: </h5>  
                        {lang('requesting_payout_note')}<br>
                        {if (!$KYC_status)}
                        <h5> Warning: </h5>
                            {lang('kyc_missing')}<br>
                        {/if}

                    </div>
                    {form_close()}
             
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();
        ValidatePayoutRelease.init();

    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}