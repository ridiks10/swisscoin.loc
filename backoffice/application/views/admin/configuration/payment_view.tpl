{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('payment_setting')}
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
                {form_open('', 'name="payment_status_form" id="payment_status_form" method="post"')}
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('Payment_method')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="pin_status" value="{$MODULE_STATUS['pin_status']}"}
                            {assign var="ewallet_status" value="{$MODULE_STATUS['ewallet_status']}"}


                            {assign var="i" value=0}
                            {foreach from=$payment_methods item=v}
                                <tr {if $v.id == 3 && $MODULE_STATUS['ewallet_status']=='no'}style="display:none;"{/if}{if $v.id == 2 && $pin_status=='no'}style="display:none;"{/if}>                  
                                    <td>
                                        {if $v.id == 3 && $MODULE_STATUS['ewallet_status']=='no'}
                                            {$i}
                                        {elseif $v.id == 2 && $pin_status=='no'}
                                            {$i}
                                        {else}
                                            {assign var="i" value=$i+1}{$i}
                                        {/if}
                                    </td>
                                    <td>
                                        {if $v.payment_type eq 'Payment Gateway'}
                                            {lang('payment_gateway')}
                                        {elseif $v.payment_type eq 'E-pin'}
                                            {lang('epin')}
                                        {elseif $v.payment_type eq 'E-wallet'}
                                            {lang('ewallet')}
                                        {elseif $v.payment_type eq 'Free Joining'}
                                            {lang('free_joining')}
                                        {/if}
                                    </td>
                                    <td>
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_ewallet_status"  value="no" {if {$v.status}=="no"} onChange="change_payment_status('{$PATH_TO_ROOT_DOMAIN}admin/', {$v.id}, 'yes')" {else} checked onChange="change_payment_status('{$PATH_TO_ROOT_DOMAIN}admin/', {$v.id}, 'no')"{/if}>
                                        </div>
                                        {if $v.id==1 && $v.status=='yes'}<a href="payment_gateway_configuration">{lang('payment_gateway_configuration')}</a>{/if}
                                    </td>
                                </tr>
                            {/foreach}
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
