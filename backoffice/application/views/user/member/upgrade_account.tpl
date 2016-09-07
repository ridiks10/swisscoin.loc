{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="errmsg">{lang('You_must_enter_transaction_password')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>   {lang('activate_account')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="search_mem" id="search_mem"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="amount">{lang('amount')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input class="form-control"  type="text" id="amount" name="amount" autocomplete="Off" tabindex="1" value="{$upgradeAmount}" readonly="readonly"> {form_error('amount')}

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="transaction_password">{lang('transaction_password')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input class="form-control"  type="text" id="transaction_password" name="transaction_password" autocomplete="Off" tabindex="1" > {form_error('transaction_password')}

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky"  type="submit" name="pay" id="submit" value="{lang('pay')}" tabindex="2" > {lang('pay')} </button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>

    </div>

</div>    



{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function() {
        Main.init();
        //TableData.init();
        ValidateUpgradeMemberUser.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}