{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_merchant_id')}</span>
    <span id="validate_msg2">{lang('you_must_enter_transaction_password')}</span>


    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">

</div>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('authorize_configuration')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="authorize_status_form" id="authorize_status_form" method="post"')}
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="merchant_log_id">{lang('merchant_log_id')} </label>
                        <div class="col-sm-3">                           
                            <input type="text" name="merchant_log_id" id="merchant_log_id" tabindex="1" value="{$authorize_details['merchant_id']}" />{form_error('merchant_log_id')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="transaction_key">{lang('transaction_key')}</label>
                        <div class="col-sm-3">                           
                            <input type="password" name="transaction_key" id="transaction_key" tabindex="2"value="{$authorize_details['transaction_key']}"/>{form_error('transaction_key')}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-4">   
                            <button class="btn btn-bricky" type="submit" name="update_authorize"  value="change_tran" id="change"  tabindex="4">{lang('update')}</button>
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
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
