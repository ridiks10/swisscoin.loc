{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<innerdashes>
    <hdash> 
        <img src="{$PUBLIC_URL}images/1335698592_edit.png" border="0" />
        {$tran_Shipping_Details}
        {if $HELP_STATUS}
            <a href="https://infinitemlmsoftware.com/help/feedback" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png" /></buttons>
            </a>
        {/if}
    </hdash>  

    <cdash-inner>

        <table align="center">
            <tr height='20px'>
                <td  colspan="3" align='center'>
                    <h1>
                        <font face="Arial, Helvetica, sans-serif">
                        <font color="#F40000">I</font>nfinite <font color="#F40000">O</font>pen <font color="#F40000">S</font>ource <font color="#F40000">S</font>olutions</font>
                    </h1>
                </td>
            </tr>
            <tr ><td  colspan="3" align='center'>Technology Business Incubator,</td></tr>
            <tr ><td  colspan="3" align='center'>NIT Campus (P.O.), Calicut - 673601, Kerala,</td></tr>
            <tr ><td  colspan="3" align='center'>Phone: +91 495 2287430</td></tr>
            <tr><td  colspan="3" align='center'>Email:info@ioss.in</td></tr>
        </table>
        <hr/>
        <table width="100%" >
            <tr>
                <td><strong>{$tran_SHIP_TO}:</strong>{*$v.shipping_address*}</td>                  
            </tr>
        </table>
        <h4> {$tran_Invoice_No}: {$invoice_no}</h4>
        <h4> {$tran_Date_Ordered}: {date("D M Y")}</h4>
        <h4> {$tran_Payment_method}: {$tran_Credit_Card}</h4>
        </br>
        <table  width="100%" border="1">
            <tr>
                <th>{$tran_product}</th>
                <th>{$tran_Quantity}</th> 
                <th>{$tran_Price}</th>
                <th>{$tran_Shipping_Price}</th>                
                <th>{$tran_total}</th>
            </tr>
            {assign var='grant_total' value=0}
            {assign var='total_price' value=0}
            {foreach from=$purchase_details item=v}

                {$total_price = ({$v.price}*{$v.quantity}) + ({$v.shipping_price}*{$v.quantity})}
                {$grant_total = $grant_total + $total_price}
                <tr align="center">
                    <td>{$v.product_name}</td>
                    <td>{$v.quantity}</td>
                    <td>{number_format({$v.price})}</td>
                    <td>{$v.shipping_price}</td>
                    <td>{number_format($total_price,2)}</td>
                </tr>  
            {/foreach}
            <tr>
                <td colspan="4" align="right"><b>{$tran_total_amount}</b></td>
                <td align="center"><b>{number_format($grant_total,2)}</b></td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table width='60%' align='center'>
            <tr align="center">
                <td><strong>{$tran_Date_Added}</strong></td>
                <td colspan="2"><strong>{$tran_status}</strong></td>
                <td><strong>{$tran_comments}</strong></td>
            </tr>
            <tr align="center">
                <td>{date("D M Y")}</td>
                <td colspan="2">{$tran_Processing}</td>
                <td>{$tran_English}</td>
            </tr>
        </table>

        <table width='20%' align='right'>
            <tr>
                <td align='right'>
                    <div id = "frame">
                        <a href="" onClick="window.print();
                                return false;"> <img src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" height="20" width="20" border="none"></a>
                    </div>
                </td>
            </tr>
        </table>
    </cdash-inner>
</innerdashes>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}