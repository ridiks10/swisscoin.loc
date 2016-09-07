{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg2">{lang('NO_BALANCE')}</span>
    <span id="error_msg3">{lang('Please_type_transaction_password')}</span>
    <span id="error_msg4">{lang('Please_type_To_User_name')}</span>                     
    <span id="error_msg5">{lang('Please_type_Amount')}</span>
    <span id="error_msg6">{lang('NO_BALANCE')}</span>     
    <span id="validate_msg1">{lang('digits_only')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('ewallet')}
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
                <div id="step1" style="display: {$step1}">                  
                         {form_open('user/ewallet/fund_transfer','role="form" class="smart-wizard form-horizontal" method="post" name="fund_form" id="fund_form"')}
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="font-weight:bold; color:#000;">Step:1</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="avb_amount">{lang('available_amount')}:</label>
                            <div class="col-sm-6">
                                {$DEFAULT_SYMBOL_LEFT}<input type="text" id="avb_amount" name="avb_amount" readonly="1" value="{number_format($balamount*$DEFAULT_CURRENCY_VALUE,2)}"  autocomplete="Off" tabindex="1" />{$DEFAULT_SYMBOL_RIGHT}
                                <input type="hidden" id="bal" name="bal"   value="{$balamount}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="to_user_name">
                                {lang('transfer_to')}:<span class="symbol required"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" id="to_user_name" name="to_user_name" autocomplete="Off" tabindex="3" /><span id="errormsg1"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="amount">{lang('amount')}: <span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <input type="text" id="amount" name="amount" tabindex="4" />
                                <span id="errmsg1"></span>
                            </div>
                        </div>
                             
                        <div class="form-group" {if $trans_fee ==0} style="display:none;" {/if}>
                            <label class="col-sm-2 control-label" for="amount"> {lang('transaction_fee')}: <span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <label>{$DEFAULT_SYMBOL_LEFT}{number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</label>
                            </div>
                        </div>
                           
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-bricky"tabindex="5" name="fund_trans" id="fund_trans" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                                <button class="btn btn-bricky"tabindex="5" name="reset" id="fund_trans" type="reset" value="{lang('reset')}"> {lang('reset')} </button>

                            </div>
                        </div>

                        <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin" >
                         {form_close()}
                 
                </div>
                <div id="step2" style="display: {$step2}">


                    <div style="font-weight:bold; color:#000;">Step:2</div>
                    
                        {form_open('user/ewallet/fund_transfer','class="smart-wizard form-horizontal col-sm-12" method="post" name="fund_transfer_form" id="fund_transfer_form" action=""')}
                        <div class="form-group">
                            <label class="col-sm-3" for="user_name">{lang('ewallet_balance')}</label>

                            <label>{$DEFAULT_SYMBOL_LEFT}{number_format($bal_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</label>

                        </div>

                        <input type="hidden" name="tot_req_amount" value="{$total_req_amount}"/>
                        <div class="form-group">
                            <label class="col-sm-3" for="user_name">{lang('receiver')}:</label>
                            <input name="to_username" type="hidden" class="form-control" value="{$to_user}"/><b>{$to_user}</b>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="user_name">{lang('amount_to_transfer')}:</label>
                            <input name="amount" class="form-control" type="hidden" value="{$amount}"/> {$DEFAULT_SYMBOL_LEFT}{number_format($amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3" for="pswd">
                                {lang('transaction_password')} <span class="symbol required"></span>
                            </label>
                            <div class="form-group col-sm-2">
                                <input type="password" id="pswd" name="pswd" tabindex="1" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3">
                                <button class="btn btn-bricky"tabindex="2" name="transfer" id="transfer" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                                <button class="btn btn-bricky"tabindex="2" name="cancel" id="cancel" type="reset" onclick="document.location = 'fund_transfer'" value="{lang('cancel')}"> {lang('cancel')} </button>
                            </div>
                        </div>
                          {form_close()}     
                
                </div>
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateFund.init();

    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
