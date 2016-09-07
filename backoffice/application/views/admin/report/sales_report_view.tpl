{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="report_name" value="{lang('sales_report')}"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('sales_report')}
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
            <div  id="print_area" style="overflow: auto; max-height:1000px;">
                {include file="admin/report/header.tpl" name=""}
                {if $count >= 1}
                    <tr>
                    <a href={$BASE_URL}admin/excel/create_excel_sales_report>{lang('create_excel')}</a>

                    <br><br><table border='1' cellpadding='5px' cellspacing='0' align='center' width="100%" >
                        <tr class='th'>
                            <th>{lang('sl_no')}</th>
                            <th>{lang('invoice_no')}</th>
                            <th>{lang('prod_name')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{$payment_method}</th>
                            <th>{lang('amount')}</th>

                        </tr>

                        {assign var="i" value=0}
                        {foreach from=$report_arr item=v}

                            {if $i%2==0}
                                {assign var="class" value="tr1"}
                            {else}
                                {assign var="class" value="tr2"}
                            {/if}

                            {$i=$i+1}
                            <tr class="{$class}">


                                <td>{$v.id}</td>
                                <td>{$v.invoice_no}</td>
                                <td>{$v.prod_id}</td>
                                <td>{$v.user_id}</td>

                                <td>{$v.payment_method}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                            </tr>


                        {/foreach}
                        <tr><td colspan="5" style="text-align: center">{lang('total_amount')}</td><td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.sum*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td></tr>
                            {else}
                        <h4 align='center'>  <font size="6">{lang('no_data')}</font ></h4>
                        {/if}
                </table>
                {include file="admin/report/footer.tpl" name=""}
            </div>

            {if $count >= 1}
                <div class="row"  >
                    <div id = "frame" style="margin-left: 470px;">
                        <a href="" onClick="print_report();
                            return false;"><img src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" height="20" width="20" border="none" align="center" >{lang('click_here_to_print')}</a>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
    function print_report() {
        var myPrintContent = document.getElementById('print_area');
        var myPrintWindow = window.open("", "Print Report", 'left=300,top=100,width=700,height=500', '_blank');
        myPrintWindow.document.write(myPrintContent.innerHTML);
        myPrintWindow.document.close();
        myPrintWindow.focus();
        myPrintWindow.print();
        myPrintWindow.close();
        return false;
    }
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
