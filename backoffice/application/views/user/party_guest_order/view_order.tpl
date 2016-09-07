{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{assign var="path" value="{$BASE_URL}user/"}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('view_order')}
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
                {assign var="path" value="{$BASE_URL}user/"}
                <input type="hidden" name="guest_id" id="guest_id" value="{$guest.guest_id}" />
                {if count($data)!=0}
                    {assign var="i" value=1}
                    <table align="center" class="table table-striped table-bordered table-hover table-full-width">
                        <tr class="th">
                            <th>{lang('no')}</th>
                            <th>{lang('product_name')}</th>
                            <th>{lang('quantity')}</th>
                            <th>{lang('price')}</th>
{*                            <th>{lang('discount_price')}</th>*}
                            <th>{lang('total_price')}</th>
                        </tr>
                        {$tot=0}
                        {foreach from=$data item=v}
                            <tr>
                                <td>{$i}</td>
                                <td>{$v.product_name}
                                    <input type="hidden" name="product_id{$i}" id="product_id{$i}" value="{$v.product_id}"/>
                                </td>
                                <td>{$v.count}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
{*                                <td>${number_format($v.discount_price,2)}</td>*}
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format(($v.price*$v.count)*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                            </tr>
                            {$tot=$tot+$v.price*$v.count}
                            {assign var=i value=$i+1}
                        {/foreach}
                    </table>
                    <table align="right">
                        <tr><td>{lang('total_amounts')}: {$DEFAULT_SYMBOL_LEFT}{number_format($tot*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td></tr>
                    </table>
                {else}
                    <center>
                        {lang('no_orders_found')} !!!
                    </center>
                {/if}
                </form>
            </div>                
        </div>       
    </div>   
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}