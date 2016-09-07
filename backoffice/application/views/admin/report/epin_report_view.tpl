{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="report_name" value="{lang('epin_report')}"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('epin_report')}
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
                    <br><br><table border='1' cellpadding="5px" cellspacing="0" align='center' width="100%" >
                        <tr>
                            <td colspan = '19'><a href={$BASE_URL}admin/excel/create_excel_epin_report>{lang('create_excel')}</a></td>
                        </tr>
                        <tr>
                            <th>{lang('no')}</th>
                            <th>{lang('used_user')}</th>
                            <th>{lang('epin')}</th>
                            <th>{lang('pin_uploaded_date')}</th>
                            <th>{lang('epin_amount')}</th>
                            <th>{lang('pin_balance_amount')}</th>
                        </tr>
                        {assign var="i" value=0}
                        {foreach from=$pin_details item=v}
                            {$i = $i+1}
                            <tr >
                                <td> {$i}</td>
                                <td>{$v.used_user}</td>
                                <td>{$v.pin_number}</td>
                                <td>{$v.pin_alloc_date}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                            </tr>
                        {/foreach}
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
