{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('paypal_configuration')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="payment_status_form" id="payment_status_form" method="post"')}
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="api_username">{lang('api_username')} </label>
                        <div class="col-sm-3">                           
                            <input type="text" name="api_username" id="api_username" tabindex="1" value='{$paypal_details['api_username']}' />{form_error('api_username')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="api_password">{lang('api_password')}</label>
                        <div class="col-sm-3">                           
                            <input type="password" name="api_password" id="api_password" tabindex="2"value='{$paypal_details['api_password']}'/>{form_error('password')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="api_signature">{lang('api_signature')}</label>
                        <div class="col-sm-3">    
                            <textarea  name="api_signature" id="api_signature" tabindex="1" rows="2" cols="19"   autocomplete="Off" >{$paypal_details['api_signature']}</textarea>
                            {form_error('api_signature')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="mode">{lang('mode')} </label>
                        <div class="col-sm-3">  
                            <select name="mode" id="mode" tabindex="1" value='{$paypal_details['mode']}' style='width:93%;'>
                                <option value="test">{lang('Test')}</option>
                                <option value="production">{lang('Production')}</option>
                            </select>
                            {form_error('mode')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="currency">{lang('currency')} </label>
                        <div class="col-sm-3">                           
                            <input type="text" name="currency" id="currency" tabindex="1" value='{$paypal_details['currency']}' />
                            {form_error('currency')}
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="return_url">{lang('return_url')} </label>
                        <div class="col-sm-3">    
                            <textarea  name="return_url" id="return_url" tabindex="1" rows="2" cols="19"   autocomplete="Off" >{$paypal_details['return_url']}</textarea>
                            {form_error('return_url')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="cancel_url">{lang('cancel_url')} </label>
                        <div class="col-sm-3">
                            <textarea  name="cancel_url" id="cancel_url" tabindex="1" rows="2" cols="19"   autocomplete="Off" >{$paypal_details['cancel_url']}</textarea>
                            {form_error('cancel_url')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-4">   
                            <button class="btn btn-bricky" type="submit" name="update_paypal"  value="change_tran" id="change"  tabindex="4">{lang('update')}</button>
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
        // ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
