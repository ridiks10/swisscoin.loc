{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="path" value="{$BASE_URL}admin/"}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('edit_order')}
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
                {form_open('', 'method="POST" name="edit_order" id="edit_order" onsubmit="return validate_update(this.value);"')}
                    {assign var="path" value="{$BASE_URL}admin/"}
                    <div>
                        <a href="javascript:select_product({$guest_id},'{$path}')">
                            <input type="button" value="Add Products" class="btn btn-bricky"> 
                        </a>
                    </div><br>
                    <input type="hidden" name="guest_id" id="guest_id" value="{$guest.guest_id}" />
                    {if count($data)!=0}
                        {assign var="i" value=1}
                        <table align="center" class="table table-striped table-bordered table-hover table-full-width">
                            <tr class="th">
                                <th>{lang('no')}</th>
                                <th>{lang('product_name')}</th>
                                <th>{lang('quantity')}</th>
                                <th>{lang('edit_quantity')}</th>
                                <th>{lang('price')}</th>
{*                                <th>{lang('discount_price')}</th>*}
                                <th>{lang('total_price')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                            {$tot=0}
                            {foreach from=$data item=v}
                                <tr>
                                    <td>{counter}</td>
                                    <td>{$v.product_name}
                                        <input type="hidden" name="product_id{$i}" id="product_id{$i}" value="{$v.product_id}"/>
                                    </td>
                                    <td>{$v.count}</td><input type="hidden" name="old_qty{$i}" id="old_qty{$i}" value="{$v.count}"/>
                                <td>
                                    <input type="text" class="box-small" name="new_qty{$i}" id="new_qty{$i}" value="0" size="3"/>
                                </td>
                               
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
{*                                <td>${number_format($v.discount_price,2)}</td>*}
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format(($v.price*$v.count)*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>
                                    <a href="javascript:delete_product_order({$v.id},{$v.product_id},'{$path}',{$v.count})" class="btn btn-teal tooltips" data-placement="top" data-original-title="Delete Order"><i class="glyphicon glyphicon-remove-circle"></i></a>                                    
                                    </a>
                                </td>
                                </tr>
                                {$tot=$tot+$v.price*$v.count}
                                {assign var=i value=$i+1}
                            {/foreach}
                            <input type="hidden" value="{$i-1}" name="count" id="count"/>
                        </table>
                        <table align="right">
                            <tr><td>{lang('total_amounts')} : {$DEFAULT_SYMBOL_LEFT}{number_format($tot*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td></tr>
                        </table>
                        <div class="form-group"  style="float: left; width: 255px;">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" tabindex="3" name="submit" id="submit"  type="submit" value="Update Order" > Update Order</button>
                            </div>
                        </div>
                        <div class="form-group"  style="float: left; text-align: left; width: 100px;">
                            <div class="col-sm-2 col-sm-offset-2">
                                <a href="../guest_orders">
                                    <input type="button" name="back" id="back" value="Cancel" class="btn btn-bricky">
                                </a>

                            </div>
                        </div>
                    {else}
                        <center>
                            {lang('no_orders_to_edit')} !!!
                        </center>
                    {/if}                   
                {form_close()}
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