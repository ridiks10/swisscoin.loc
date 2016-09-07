{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_count')}</span>        
    <span id="error_msg2">{lang('you_must_enter_user_name')}</span>
    <span id ="error_msg6">{lang('you_must_select_a_date')}</span>
    <span id ="error_msg7">{lang('past_expiry_date')}</span>
    <span id ="error_msg8">{lang('select_amount')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('epin_allocation_to_user')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="user_select_form" id="user_select_form"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>{lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user')}<font color="#ff0000">*</font>:</label>
                        <div class="col-sm-3">
                            <input tabindex="1" type="text" name="user_name" id="user_name" size="20" value="" title="" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="amount">{lang('amount')} <font color="#ff0000">*</font>:</label>
                        <div class="col-sm-3">
                            <select name="amount1" id="amount1"  tabindex="2" class="form-control" >
                                <option value="">{lang('select_amount')}</option>
                                {assign var=i value=0}
                                {foreach from=$amount_details item=v}
                                    <option value="{$v.amount}">{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</option>
                                    {$i = $i+1}
                                {/foreach}
                            </select> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="count">{lang('epin_count')} <font color="#ff0000">*</font>:</label>
                        <div class="col-sm-3">
                            <input tabindex="3" type="text" name="count" id="count" size="20" value="" title=""class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="date">
                            {lang('expiry_date')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="date" id="date" type="text" tabindex="4" size="10" maxlength="10"  value="" />
                                <label for="date" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>
                            </div>
                            <span for="date" class="help-block">    </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="insert" id="insert" value="{lang('submit')}" tabindex="5">
                                {lang('submit')}
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
        ValidateUser.init();
        DateTimePicker.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}