{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('order_products_for')} <b>{$guest['first_name']}</b>
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>  {lang('add_to_cart')}
                                <div class="panel-tools">
                                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                    </a>
                                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-expand" href="#">
                                        <i class="fa fa-resize-full"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-close" href="#">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    {form_open('', 'name="select_product" id="select_product" method="POST" onSubmit="return (this);"')}
                                    {$cntpdt = count($pdts)}
                                    <div class="col-sm-4">
                                        <select class="form-control" name="keyword" id="keyword" tabindex="1">
                                            <option value="">{lang('select_a_product')}</option>
                                            {foreach from=$pdts item=v}                                      
                                                <option value="{$v.product_name}">{$v.product_name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" name="search" id="search" value="Find Products"  class="btn btn-bricky">{lang('find_products')}</button>
                                    </div>
                                    {form_close()}
                                </div>

                                <br>
                                <br>
                                <div class="row">
                                    <div class="select_product_top col-sm-12">                                         
                                        <table align="center" class="table table-striped table-bordered table-hover table-full-width">

                                            <tr class="th">
                                                <th>{lang('no')}</th>
                                                <th>{lang('product_name')}</th>
                                                <th>{lang('price')}</th>
                                                    {*                                                <th>{lang('discount_price')}</th>*}
                                                <th>{lang('stock')}</th>
                                                <th>{lang('quantity')}</th>
                                            </tr>
                                            {if count($product)!=0}
                                                {assign var=i value=1}
                                                {foreach from=$product item=v}      
                                                    {form_open('', 'name="add_produ" id="add_produ"  method="POST" onSubmit="return order_product_add(this.value);"')}
                                                        <input type="hidden" name="guest_id" id="guest_id" value="{$guest['guest_id']}"/>                             
                                                        <tr>
                                                            <td>{$i}
                                                                <input type="hidden" name="product_id" id="product_id" value="{$v.product_id}" />

                                                            </td>
                                                            <td>{$v.product_name}</td>
                                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                            {*                                                            <td>${number_format($v.discount_price,2)}</td>*}
                                                            <td>{$v.stock}</td>
                                                            <td><input type="text"  class="box-small"  id="qty" name="qty" size="3" value="0"/>
                                                                <button type="submit" id="add" name="add" value="Add to Cart"  class="btn btn-bricky">{lang('add_to_cart')}</button>
                                                                <input type="hidden" id="ii" name="ii" value="{$i}">
                                                            </td>
                                                        </tr>

                                                        {assign var=i value=$i+1}
                                                    {form_close()}
                                                {/foreach}

                                            {/if} 

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i> {lang('items_in_the_cart')}
                                <div class="panel-tools">
                                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                    </a>
                                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-expand" href="#">
                                        <i class="fa fa-resize-full"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-close" href="#">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">
                                {assign var=j value=1}
                                {form_open('', 'name="select_product" id="select_product" method="POST" onSubmit="return (this);"')}
                                <input type="hidden" id="count" name="count" value="{count($product_selected)}"/>
                                <input type="hidden" name="guest_id" id="guest_id" value="{$guest['guest_id']}"/>  

                                <table align="center" class="table table-striped table-bordered table-hover table-full-width">
                                    <tr class="th">
                                        <th>{lang('no')}</th>
                                        <th>{lang('product_name')}</th>
                                        <th>{lang('price')}</th>
                                        <th>{lang('quantity')}</th>
                                        <th>{lang('total_price')}</th>
                                    </tr>
                                    {if count($product_selected)>0}
                                        {foreach from=$product_selected item=v}
                                            <tr>
                                                <td>{counter}  
                                                    <input type="hidden" name="product_id_sel{$j}" id="product_id_sel{$j}" value="{$v.product_idd}" />
                                                </td>

                                                <td>{$v.product_name}</td> 
                                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td><input type="hidden" id="discount_price{$j}" name="discount_price{$j}" value="{$v.price}">
                                            <td>{$v.qty} <input type="hidden" name="qty{$j}" id="qty{$j}" value="{$v.qty}" /></td>
                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.tot_price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                            {assign var=j value=$j+1}
                                        {/foreach}
                                    {else}
                                        <tr>
                                            <td colspan="5"><font color='red'>{lang('no_items_found_in_the_cart')}</font></td>
                                        </tr>
                                    {/if}
                                </table>                                 
                                {if count($product_selected)>0}
                                    <div style="width:85%;text-align:right">
                                        <button type="submit" value="Add Products" name="submit" id="submit" class="btn btn-yellow"/>{lang('complete_this_guest_order')}</button>
                                        <button type="submit" name="back" id="back" value="Cancel" class="btn btn-bricky">{lang('cancel')}</button>
                                    </div>
                                {/if}
                                {form_close()}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i> {lang('unprocessed_orders')}
                                <div class="panel-tools">
                                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                    </a>
                                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-expand" href="#">
                                        <i class="fa fa-resize-full"></i>
                                    </a>
                                    <a class="btn btn-xs btn-link panel-close" href="#">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="panel-body">                                
                                <table align="center" class="table table-striped table-bordered table-hover table-full-width">
                                    <tr class="th">
                                        <th>{lang('no')}</th>
                                        <th>{lang('product_name')}</th>
                                        <th>{lang('price')}</th>
                                        <th>{lang('quantity')}</th>
                                        <th>{lang('total_price')}</th>
                                    </tr>
                                    {if count($cart_item)>0}
                                        {assign var=i value=1}
                                        {assign var=tot_count value=0}
                                        {assign var=tot_price value=0}
                                        {foreach from=$cart_item item=v}
                                            <tr>
                                                <td>{$i}
                                                    <input type="hidden" name="product_id" id="product_id" value="{$v.product_id}" />
                                                </td>
                                                <td>{$v.product_name}</td>
                                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                <td>{$v.count}</td>
                                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                            {assign var=i value=$i+1}
                                            {assign var=tot_count value=$tot_count+$v.count}
                                            {assign var=tot_price value=$tot_price+$v.total_amount}

                                        {/foreach}
                                        <tr>
                                            <td colspan="2"></td>
                                            <td><b>{lang('total')}</b></td><td><b>{$tot_count}</b></td><td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($tot_price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                                        </tr>
                                    {else}
                                        <tr>
                                            <td colspan="5"><font color='red'>{lang('no_unprocessed_orders_found')}</font></td>
                                        </tr>
                                    {/if} 
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        {form_open('', 'name="back" id="back" method="post"')}
                        <input type="submit" name="back" id="back" value="Return To Guest List"  class="btn btn-green">
                        {form_close()}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}