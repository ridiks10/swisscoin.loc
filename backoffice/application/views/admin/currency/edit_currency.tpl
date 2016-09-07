{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 

    <span id="validate_msg1">{lang('enter_title')}</span>
    <span id="validate_msg2">{lang('enter_code')}</span>
    <span id="validate_msg3">{lang('enter_value')}</span>
    <span id="validate_msg4">{lang('enter_symbol_left')}</span>
    <span id="validate_msg5">{lang('enter_symbol_right')}</span>
    <span id="validate_msg6">{lang('enter_decimal')}</span>
    <span id="validate_msg7">{lang('enter_status')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('edit_currency')}
            </div>
            <div class="panel-body">
                {form_open('', 'name="currency_entry" id="currency_entry" class="smart-wizard form-horizontal" method="post"')}
                    <input type="hidden" id="currency_id" name="currency_id" value="{$currency_details['id']}">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>


                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('currency_title')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="currency_title" id ="currency_title" value="{$currency_details['title']}" autocomplete="Off" tabindex="2">{form_error('currency_title')}



                        </div> 

                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('currency_code')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="currency_code" id ="currency_code" value="{$currency_details['code']}" autocomplete="Off" tabindex="2">{form_error('currency_code')}



                        </div>

                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('currency_value')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="currency_value" id ="currency_value" value="{$currency_details['value']}" autocomplete="Off" tabindex="2">{form_error('currency_value')}



                        </div>

                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('symbol_left')} :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="symbol_left" id ="symbol_left" value="{$currency_details['symbol_left']}" autocomplete="Off" tabindex="2">{form_error('symbol_left')}



                        </div>

                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('symbol_right')} :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="symbol_right" id ="symbol_right" value="{$currency_details['symbol_right']}" autocomplete="Off" tabindex="2">{form_error('symbol_right')}



                        </div>

                    </div>






                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('status')}:<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name ="status" id ="status" tabindex="1">


                                <option value="enabled" {if $currency_details['status']=='enabled'} selected="" {/if}>{lang('enabled')}</option>
                                <option value="disabled" {if $currency_details['status']=='disabled'} selected="" {/if} >{lang('disabled')}</option>

                            </select>

                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Update" name="update" id="update" >{lang('update')}</button>                                
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
        validate_multy_currency.init();

    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  