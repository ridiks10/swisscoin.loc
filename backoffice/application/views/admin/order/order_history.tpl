{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('order_history')}
            </div>
            <div class="panel-body">
                {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}:</label>
                    <div class="col-sm-3">

                        <input placeholder="{lang('type_member_name')}" class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" />
                        <span class="help-block" for="user_name"></span>
                    </div>
                </div>                  
                {*          <div class="form-group">
                <label class="col-sm-2 control-label" for="submit_date">
                Date
                </label>
                <div class="col-sm-3">
                <div class="input-group">
                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="submit_date" id="submit_date" type="text" tabindex="3" size="20" maxlength="10"  value="" >
                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                </div>
                </div>
                </div> *}                                     
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" id="view_order" value="view_order" name="view_order" >
                            {lang('view_orders')}
                        </button>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
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
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    {if $count>0} 
                        <tbody>
                            {assign var="root" value="{$BASE_URL}admin/"}
                            {foreach from=$order_details item=v}
                                <tr>
                                    <td>{$v.order_id_with_prefix}</td>                                  
                                    <td>{$v.user_name}</td> 
                                    <td>{$v.customer_name}</td>                                 
                                    <td>{$v.model}</td>
                                    <td>{$v.pair_value}</td>
                                    <td>
                                         {foreach from=$v.price item=k}
                                                {$DEFAULT_SYMBOL_LEFT}{number_format($k*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                                         {/foreach}
                                    </td>
                                    <td>{$v.quantity}</td>
                                    <td>{$v.total_pair_value}</td>
                                    <td>
                                         {foreach from=$v.total_price item=k}
                                                {$DEFAULT_SYMBOL_LEFT}{number_format($k*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}
                                         {/foreach}
                                     </td>
                                    <td>{$v.shipping_method}</td>
                                    <td><b>{$v.shipping_firstname} {$v.shipping_lastname}</b><br>{$v.shipping_address_1}</br>{$v.shipping_city}, {$v.shipping_zone}</br>{$v.shipping_country}</td>
                                    <td>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                                    <td>
                                        <a href="{$BASE_URL}admin/order/order_details/{$v.order_id}" target="_blank">
                                            <button type="button" name="order_id" id="order_id" class="btn btn-bricky top-btn" value="{$v.order_id}">{lang('view_more')}</button>
                                        </a>
                                    </td>                                
                                </tr>
                            {/foreach}
                        </tbody>

                    </table> {$result_per_page}
                {else}
                    <tbody>
                        <tr><td colspan="13" align="center" ><h4 align="center">{lang('no_data')}</h4></td></tr>
                    </tbody>
                    </table> 
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}