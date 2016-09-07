{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg_user">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg1">{lang('You_must_enter_pin_count')}</span>        
    <span id="error_msg2">{lang('Please_type_transaction_password')}</span>        
    <span id="error_msg">{lang('you_must_select_an_amount')}</span>        
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('e_pin_purchase')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="fund_form" id="fund_form"')}
                    <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin" >
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>{lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input type="text" id="user_name" name="user_name" onblur ="getAmountLeg();" autocomplete="Off" tabindex="1" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="user_amount_div"> </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="amount">{lang('amount')}:<font color="#ff0000">*</font></label>
                        <div class="col-md-3">
                            <select name="amount" id="amount" tabindex="1"  class="form-control" onchange ="getAmountLeg();">
                                <option value="">{lang('select_amount')}</option>
                                {assign var=i value=0}
                                {foreach from=$amount_details item=v}
                                    <option value="{$v.id}">{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</option>
                                    {$i = $i+1}
                                {/foreach}


                            </select>     
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="pin_count">{lang('epin_count')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input tabindex="2" type="text" name="pin_count" id="pin_count" size="20" value="" title="" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="transfer" id="transfer" value="{lang('pin_purchase')}" tabindex="4">
                                {lang('pin_purchase')}
                            </button>
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
        ValidateAdminEwallet.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}