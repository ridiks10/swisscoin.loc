{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('order_history')}<b>{if $user_name!="admin"} {$user_name}{/if}</b>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                        <tr class="th">
                            <th><b>{lang('order_id')}</b></th>
                            <th><b>{lang('user_name')}</b></th>
                            <th><b>{lang('customer')}</b></th>
                            <th><b>{lang('product')}</b></th>
                            {if $MLM_PLAN == 'Binary'}
                            <th><b>{lang('pair_value')}</b></th>
                            {else}
                            <th><b>{lang('bv')}</b></th>
                            {/if}
                            <th><b>{lang('price')}</b></th>
                            <th><b>{lang('quantity')}</b></th>
                            {if $MLM_PLAN == 'Binary'}
                            <th><b>{lang('total_pair_value')}</b></th>
                            {else}
                             <th><b>{lang('total_bv')}</b></th>
                             {/if}
                            <th><b>{lang('total_price')}</b></th>
                            <th><b>{lang('shipping_method')}</b></th>
                            <th><b>{lang('shipping_address')}</b></th>
                            <th><b>{lang('date')}</b></th>
                            <th><b>{lang('action')}</b></th>
                        </tr>
                    </thead>
                    {if $count>0} 
                        <tbody>
                            {assign var="root" value="{$BASE_URL}user/"}
                            {foreach from=$order_details item=v}
                                <tr>
                                    <td>{$v.order_id_with_prefix}</td>  
                                    <td>{$v.user_name}</td>
                                    <td>{$v.customer_name}</td>  
                                    <td>{$v.model}</td>
                                    <td>{$v.pair_value}</td>
                                    <td>
                                         {foreach from=$v.price item=k}
                                                {$DEFAULT_SYMBOL_LEFT}{number_format($k*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}
                                         {/foreach}
                                     </td>
{*                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>*}
                                    <td>{$v.quantity}</td>
                                    <td>{$v.total_pair_value}</td>
                                    <td>
                                         {foreach from=$v.total_price item=k}
                                                {$DEFAULT_SYMBOL_LEFT}{number_format($k*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}
                                         {/foreach}
                                     </td>
{*                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>*}
                                    <td>{$v.shipping_method}</td>
                                    <td><b>{$v.shipping_firstname} {$v.shipping_lastname}</b><br>{$v.shipping_address_1}</br>{$v.shipping_city}, {$v.shipping_zone}</br>{$v.shipping_country}</td>
                                     <td>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                                    <td>
                                        <a href="{$BASE_URL}user/order/order_details/{$v.order_id}" target="_blank">
                                            <button type="button" name="order_id" id="order_id" class="btn btn-bricky top-btn" value="{$v.order_id}">{lang('view_more')}</button>
                                        </a>
                                    </td>                                
                                </tr>
                            {/foreach}
                        </tbody>

                    </table> {$result_per_page}
                {else}
                    <tbody>
                        <tr><td colspan="13" align="center"><h4 align="center">{lang('invalid_order')}.</h4></td></tr>
                    </tbody>
                    </table> 
                {/if}
            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}