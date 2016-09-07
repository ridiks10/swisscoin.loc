{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg2">{lang('you_must_select_an_amount')}</span>
    <span id="error_msg1">{lang('you_must_enter_count')}</span>        
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg3">{lang('enter_digits_only')}</span>
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
                {lang('request_epin')}
            </div>
            <div class="panel-body">
            {form_open('user/epin/request_epin','role="form" class="smart-wizard form-horizontal" method="post" name="upload" id="upload" ')} 
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="amount">{lang('amount')} <font color="#ff0000">*</font>:</label>
                        <div class="col-sm-3">
                            <select name="amount1" id="amount1"  tabindex="1" class="form-control" >
                                <option value="">{lang('select_amount')}</option>
                                {assign var=i value=0}
                                {foreach from=$amount_details item=v}
                                    <option value="{$v.amount}">{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</option>

                                    {$i = $i+1}
                                {/foreach}
                            </select> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="count">{lang('count')} : <font color="#ff0000">*</font></label>
                        <div class="col-sm-6">
                            <input name="count"  id="count" type="text"  value="" title="{lang('no_of_epin_generated')}" autocomplete="Off" tabindex="2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="reqpasscode" id="reqpasscode" value="{lang('request_epin')}" style="" title="{lang('request_epin')}" tabindex="3">
                                {lang('request_epin')}
                            </button>
                        </div>
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
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}