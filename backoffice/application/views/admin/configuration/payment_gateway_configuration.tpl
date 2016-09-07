{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('payment_gateway_configuration')}
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
                                <th>{lang('payment_logo')}</th>
                                <th>{lang('status')}</th>
                                <th>{lang('mode')}</th>
                                <th>{lang('sort_order')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>


                            {assign var="i" value=0}
                            {foreach from=$card_status item=v}
                                {if $v.status=="yes"}
                                    <tr>                  
                                        <td>{assign var="i" value=$i+1}{$i}</td>
                                        <td>{$v.gateway_name}</td>
                                        <td><img src="{$BASE_URL}/public_html/images/logos/{$v.logo}"height='48px' width='100px'/></td>
                                        <td>{if $v.status=='yes'}<font color="green">{lang('enabled')}</font>{else}<font color="red">{lang('disabled')}</font>{/if}</td>
                                        <td><font color="green">{if $v.mode=='live'}Live{else}Test{/if}</font></td>
                                        <td><input type="text" id="sort_order" name="sort_order{$i}" value="{$v.sort_order}"><span id="errmsg1"></span></td>
                                        <td>
                                            <div class="make-switch-new" data-on="success" data-off="warning">
                                                <input type="checkbox" name="set_module_status" id="set_paypal_status"  value="no" {if $v.status=="no"} onChange="change_credit_card_status('{$PATH_TO_ROOT_DOMAIN}admin/', {$v.id}, 'yes')" {else} checked onChange="change_credit_card_status('{$PATH_TO_ROOT_DOMAIN}admin/', {$v.id}, 'no')"{/if}>
                                            </div>
                                            {if $v.id==1 && $v.status=="yes"}<a href="paypal_config">{lang('Paypal_Configuration')}</a>{/if}
                                            {if $v.id==3 && $v.status=="yes"}<a href="epdq_config">{lang('EPDQ Configuration')}</a>{/if}
                                            {if $v.id==4 && $v.status=="yes"}<a href="authorize_config">{lang('authorize_configuration')}</a>{/if}
                                        </td>
                                <input type="hidden" id="number" name="number" value="{$i}">
                                <input type="hidden" id="id" name="id{$i}" value="{$v.id}">
                                </tr>
                            {/if}
                        {/foreach}
                        </tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky" type="submit" id="update" value="update" name="update" tabindex="2" >
                                {lang('update')}
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
    jQuery(document).ready(function () {
        Main.init();
        // ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
