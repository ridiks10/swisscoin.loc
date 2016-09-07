{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('order_products_details')} <b>{$current_user}</b>
            </div>
            <div class="panel-body">
                <div  id="print_area" style="overflow: auto; max-height:1000px;">
                    <table border="0" width="700" height="100" align="center">
                        {foreach from=$order_details item=v}
                            <tr> 
                                <td  colspan="2"><h2><b>{lang('order_id')}: <font color="blue">#{$v.order_id_with_prefix}</font></b></h2></td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>   
                            <tr>
                                <td  colspan="2"><b>{lang('date_added')}:</b>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                            </tr>

                            <tr>
                                <td  colspan="2"><b>{lang('shipping_method')}:</b>{$v.shipping_method}</td>
                            </tr>
                            <tr>
                                <td  colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td>
                                    <h2>{lang('payment_address')}</h2>
                                    <b>{$v.payment_firstname} {$v.payment_lastname}</b><br>
                                    {$v.payment_address_1}</br>
                                    {$v.payment_city}, {$v.payment_zone}</br>
                                    {$v.payment_country}
                                </td>
                                <td>
                                    <h2>{lang('shipping_address')}</h2>
                                    <b>{$v.shipping_firstname} {$v.shipping_lastname}</b><br>
                                    {$v.shipping_address_1}</br>{$v.shipping_city}, 
                                    {$v.shipping_zone}</br>
                                    {$v.shipping_country}
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td  colspan="2">
                                    <h2><b>{lang('order_products')}</b></h2>
                                    <table border="0" width="1000" height="100" align="center">
                                        <tr style="background-color: rgba(51,51,51,0.1); width: 100px; height:35px">
                                            <td><b>{lang('model')}</b></td>
                                            <td><b>{lang('quantity')}</b></td>
                                            {if $MLM_PLAN == 'Binary'}
                                            <td><b>{lang('pair_value')}</b></td>
                                            {else}
                                            <td><b>{lang('bv')}</b></td>
                                            {/if}
                                            <td><b>{lang('price')}</b></td>
                                            {if $MLM_PLAN == 'Binary'}
                                            <td><b>{lang('total_pair_value')}</b></td>
                                            {else}
                                            <td><b>{lang('total_bv')}</b></td>
                                            {/if}
                                            <td><b>{lang('total')}</b></td>           
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                        </tr>
                                        {assign var="root" value="{$BASE_URL}user/"}

                                        {foreach from=$v.products item=k}
                                            <tr>                             
                                                <td>{$k.model}</td>                        
                                                <td>{$k.quantity}</td>
                                                <td>{$k.pair_value}</td>
                                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($k.price*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                <td>{$k.pair_value*$k.quantity}</td>
                                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($k.total*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                            <tr> 
                                                <td colspan="4"><hr></td>
                                            </tr>
                                        {/foreach}   
                                    </table>
                                </td>
                            </tr>
                            <tr>    
                                <td colspan="2">
                                    <table border="0" width="500" height="100" align="right">

                                        {foreach from=$v.order_total item=m}
                                            <tr>
                                                <td><h5>{$m.title}</h5></td><td>{$DEFAULT_SYMBOL_LEFT}{number_format($m.value*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                        {/foreach}
                                    </table>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </div>
                <div class="row"  >
                    <div id = "frame" style="margin-left: 470px;">
                        <a href="" onClick="print_order_history();
                                    return false;"><img src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" height="20" width="20" border="none" align="center" >{lang('click_here_to_print')}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
    function print_order_history() {
        var myPrintContent = document.getElementById('print_area');
        var myPrintWindow = window.open("", "Print Order History", 'left=300,top=100,width=700,height=500', '_blank');
        myPrintWindow.document.write(myPrintContent.innerHTML);
        myPrintWindow.document.close();
        myPrintWindow.focus();
        myPrintWindow.print();
        myPrintWindow.close();
        return false;
    }
</script>

{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}