{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="report_name" value="{lang('member_wise_payout_report')}"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('member_wise_payout_report')}
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
                    <a href={$BASE_URL}admin/excel/create_excel_member_wise_payout_report>{lang('create_excel')}</a>
                    <br><br><table border='1' align='center'cellpadding="5px" cellspacing="0" width="100%" >

                        {assign var="user_name" value=$member_payout["user_name"]}
                        {assign var="full_name" value=$member_payout["full_name"]}
                        {assign var="total_amount" value=$member_payout["total_amount"]}
                        {assign var="amount_payable" value=$member_payout["amount_payable"]}
                        {assign var="tds" value=$member_payout["tds"]}
                        {assign var="service_charge" value=$member_payout["service_charge"]}
                        {assign var="user_pan" value=$member_payout["user_pan"]}
                        {assign var="acc_number" value=$member_payout["acc_number"]}
                        {assign var="user_bank" value=$member_payout["user_bank"]}
                        {assign var="user_address" value=$member_payout["user_address"]}

                        <tr class="text"><th align="left" width="30%">{lang('user_name')}</th><td width="30%">{$user_name}</td></tr>
                        <tr><th align="left" width="30%">{lang('full_name')}</th><td width="30%">{$full_name}</td></tr>
                        <tr><th align="left" width="30%">{lang('address')}</th><td width="30%">{$user_address}</td></tr>
                        <tr><th align="left" width="30%">{lang('bank')}</th><td width="30%">{$user_bank}</td></tr>
                        <tr><th align="left" width="30%">{lang('account_no')}</th><td width="30%">{$acc_number}</td></tr>

                        <tr><th align="left" width="30%">{lang('total_amount')}</th><td width="30%">{$DEFAULT_SYMBOL_LEFT}{number_format($total_amount,2)*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td></tr>
                        <tr><th align="left" width="30%">{lang('tds')}</th><td width="30%">{$DEFAULT_SYMBOL_LEFT}{number_format($tds,2)*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td></tr>
                        <tr><th align="left" width="30%">{lang('service_charge')}</th><td width="30%">{$DEFAULT_SYMBOL_LEFT}{number_format($service_charge,2)*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td></tr>
                        <tr><th align="left" width="30%">{lang('amount_payable')}</th><td width="30%">{$DEFAULT_SYMBOL_LEFT}{number_format($amount_payable,2)*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td></tr>

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
