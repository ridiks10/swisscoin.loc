{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('set_module_status')}
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                {form_open('','name="module_status_form" id="module_status_form"')}              
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>

                        <tr class="th" align="center">
                            <th>{lang('no')}</th>
                            <th>{lang('status')}</th>
                            <th> {lang('action')}</th>
                        </tr>

                    </thead>
                    <tbody>
                        {assign var="count" value="1"}
                         <tr>
                            <td>{$count}</td> 
                            <td>{lang('Ewallet')}</td>
                            <td>
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_ewallet_status" value="yes" {if $MODULE_STATUS['ewallet_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'ewallet_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'ewallet_status', 'no')" {/if} >  

                                </div>
                                {if $MODULE_STATUS['ewallet_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/ewallet/my_ewallet">{lang('e_wallet')}</a>
                                {/if}
                                <span id="ewallet_status" style="display:none;"></span>
                            </td>
                        </tr>
                        {$count = $count + 1}
                         <tr>
                            <td>{$count}</td> 
                            <td>{lang('epin')} </td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_pin_status" value="yes" {if $MODULE_STATUS['pin_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'pin_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'pin_status', 'no')" {/if} >                             
                                </div>
                                {if $MODULE_STATUS['pin_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/pin_config">{lang('epin_settings')}</a>
                                {/if}
                                <span id="pin_status" style="display:none;"></span>
                            </td>
                        </tr>
                        {if $MODULE_STATUS['opencart_status_demo']=='no'}
                            {$count = $count + 1}
                            <tr>
                                <td>{$count}</td> 
                                <td>{lang('product')}</td>
                                <td>   
                                    <div class="make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_product_status" value="yes" {if $MODULE_STATUS['product_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'product_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'product_status', 'no')" {/if}>    
                                    </div>
                                    {if $MODULE_STATUS['product_status']=='yes'}
                                        <a href="{$PATH_TO_ROOT_DOMAIN}admin/product/product_management">{lang('product_management')}</a>
                                    {/if}
                                    <span id="product_status" style="display:none;"></span>
                                </td>
                            </tr>
                        {/if}

                    <input type="hidden" name="set_module_status" id="set_opencart_status" value="no" >               
                    {*{if $MODULE_STATUS['opencart_status_demo']=='yes'}
                    {$count = $count + 1}
                    <tr>

                    <td>{$count}</td>  
                    <td>{lang('store')}</td>
                    <td>   
                    <div class="make-switch" data-on="success" data-off="warning">
                    <input type="checkbox" name="set_module_status" id="set_opencart_status" value="yes" {if $MODULE_STATUS['opencart_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'opencart_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'opencart_status', 'no')" {/if} >                             
                    </div>
                    <span id="opencart_status" style="display:none;"></span>

                    </td>
                    </tr>
                    {/if}*}
                    {$count = $count + 1}
                    
                     <tr>
                            <td>{$count}</td>           
                            <td>{lang('sponsor_tree')}</td> 
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_sponsor_tree_status" value="yes" {if $MODULE_STATUS['sponsor_tree_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_tree_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_tree_status', 'no')" {/if} >                             
                                </div>
                                {if $MODULE_STATUS['sponsor_tree_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/tree/sponsor_tree">{lang('sponsor_tree')}</a>

                                {/if}
                                <span id="sponsor_tree_status" style="display:none;"></span>
                            </td>

                        </tr>
                        {$count = $count + 1}
                       
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('referal_income_status')} </td>
                            <td>
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_referal_status"  value="yes" {if $MODULE_STATUS['referal_status']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'referal_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'referal_status', 'no')"{/if}>                             
                                </div>
                                {if $MODULE_STATUS['referal_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/configuration_view">{lang('Referral_Income_Management')}</a>
                                {/if}
                                <span id="referal_status" style="display:none;"></span>
                            </td>
                        </tr>
                        {if $MLM_PLAN != 'Unilevel' && $MLM_PLAN != 'Matrix'}
                        {$count = $count + 1}
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('unilevel_commission')}</td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['sponsor_commission_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_commission_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_commission_status', 'no')" {/if} >                             
                                </div>
                                {if $MODULE_STATUS['sponsor_commission_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/configuration_view/level">{lang('unilevel_commission')}</a>  
                                {/if}
                                <span id="sponsor_commission_status" style="display:none;"></span>
                            </td>
                        </tr>
                    {/if}
                    {$count=$count+1}
                     <tr>
                        <td>{$count}</td> 
                        <td>{lang('rank')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_rank_status" value="yes" {if $MODULE_STATUS['rank_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'rank_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'rank_status', 'no')" {/if} >                             
                            </div>
                            {if $MODULE_STATUS['rank_status']=='yes'}
                                <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/rank_configuration">{lang('rank_settings')}</a>
                            {/if}
                            <span id="rank_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count + 1}
                     <tr>
                        <td>{$count}</td> 
                        <td>{lang('multi_language')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_lang_status" value="yes" {if $MODULE_STATUS['lang_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lang_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lang_status', 'no')" {/if} >                             
                            </div>
                            {if $MODULE_STATUS['lang_status']=='yes'}
                                <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/language_settings">{lang('language_settings')}</a>  
                            {/if}
                            <span id="lang_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {if $MODULE_STATUS['multy_currency_status_demo']=='yes'}
                        {$count = $count + 1}
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('MultiCurrency')}</td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['multy_currency_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'multy_currency_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'multy_currency_status', 'no')" {/if} >                             
                                </div>
                                {if $MODULE_STATUS['multy_currency_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/currency/currency_management">{lang('currency_management')}</a>  
                                {/if}
                                <span id="multy_currency_status" style="display:none;"></span>
                            </td>
                        </tr>
                    {/if}
                     {if $MODULE_STATUS['lead_capture_status_demo']=='yes'}
                        {$count = $count + 1}
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('Lead_Capture_Status')}</td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_footer_demo_status" value="yes" {if $MODULE_STATUS['lead_capture_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lead_capture_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lead_capture_status', 'no')" {/if} >                             
                                </div>
                                <span id="lead_capture_status" style="display:none;"></span>
                            </td>
                        </tr>
                    {/if}
                     {if $MODULE_STATUS['ticket_system_status_demo']=='yes'}
                        {$count = $count + 1}
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('Ticket_System_Status')}</td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_footer_demo_status" value="yes" {if $MODULE_STATUS['ticket_system_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'ticket_system_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'ticket_system_status', 'no')" {/if} >                             
                                </div>
                                <span id="ticket_system_status" style="display:none;"></span>
                            </td>
                        </tr>
                    {/if}
                     {if $MODULE_STATUS['autoresponder_status_demo']=='yes'}
                        {$count = $count + 1}
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('AutoResponder_Status')}</td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['autoresponder_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'autoresponder_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'autoresponder_status', 'no')" {/if} >                             
                                </div>
                                {if $MODULE_STATUS['autoresponder_status']=='yes'}
                                    <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/auto_responder_settings">{lang('auto_responder_settings')}</a>
                                {/if}
                                <span id="autoresponder_status" style="display:none;"></span>
                            </td>
                        </tr>
                    {/if}
                     {if $MODULE_STATUS['replicated_site_status_demo']=='yes'}
                        {$count = $count + 1}
                        <tr>
                            <td>{$count}</td> 
                            <td>{lang('Replicated_Site_Status')}</td>
                            <td>   
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['replicated_site_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'replicated_site_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'replicated_site_status', 'no')" {/if} >                             
                                </div>
                                <span id="autoresponder_status" style="display:none;"></span>
                            </td>
                        </tr>
                    {/if}
                    {$count = $count + 1}
                     <tr>
                        <td>{$count}</td>  
                        <td>{lang('privileged_user')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_employee_status" value="yes" {if $MODULE_STATUS['employee_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'employee_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'employee_status', 'no')" {/if} >                             
                            </div>
                            {if $MODULE_STATUS['employee_status']=='yes'}
                                <a href="{$PATH_TO_ROOT_DOMAIN}admin/employee/employee_register">{lang('privileged_user')} {lang('Registration')}</a>
                            {/if}
                            <span id="employee_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count + 1}
                     <tr>
                        <td>{$count}</td> 
                        <td>{lang('sms')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_sms_status" value="yes" {if $MODULE_STATUS['sms_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sms_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sms_status', 'no')" {/if} >                             
                            </div>
                            {if $MODULE_STATUS['sms_status']=='yes'}
                                <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/sms_settings">{lang('sms_settings')}</a>
                            {/if}
                            <span id="sms_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count + 1}
                     <tr>
                        <td>{$count}</td> 
                        <td>{lang('upload_document')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_upload_status" value="yes" {if $MODULE_STATUS['upload_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'upload_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'upload_status', 'no')" {/if} >                             
                            </div>
                            {if $MODULE_STATUS['upload_status']=='yes'}
                                <a href="{$PATH_TO_ROOT_DOMAIN}admin/news/upload_materials">{lang('upload_document')}</a>
                            {/if}
                            <span id="upload_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count + 1}
                    <tr>
                        <td>{$count}</td> 
                        <td>{lang('live_chat')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_live_chat_status" value="yes" {if $MODULE_STATUS['live_chat_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'live_chat_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'live_chat_status', 'no')" {/if} >                             
                            </div>
                            <span id="live_chat_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count+1}
                     <tr>
                        <td>{$count}</td> 
                        <td>{lang('footer_demo_status')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_footer_demo_status" value="yes" {if $MODULE_STATUS['footer_demo_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'footer_demo_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'footer_demo_status', 'no')" {/if} >                             
                            </div>
                            <span id="footer_demo_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count=$count+1}
                      <tr>
                        <td>{$count}</td> 
                        <td>{lang('stat_counter_settings')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_count_status" value="yes" {if $MODULE_STATUS['statcounter_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'statcounter_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'statcounter_status', 'no')" {/if} >                             
                            </div>
                            {if $MODULE_STATUS['statcounter_status']=='yes'}
                                <a href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/stat_counter_settings">{lang('Stat_Counter_Settings')}</a>
                            {/if}
                            <span id="statcounter_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count + 1}
                    <tr>
                        <td>{$count}</td> 
                        <td>{lang('help')}</td>
                        <td>   
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox" name="set_module_status" id="set_help_status" value="yes" {if $MODULE_STATUS['help_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'help_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'help_status', 'no')" {/if} >                             
                            </div>
                            <span id="help_status" style="display:none;"></span>
                        </td>
                    </tr>
                    {$count = $count + 1}
                 
                    </tbody>    
                </table>
                {form_close()}
            </div>
        </div>
    </div>
</div>


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  