{assign var="report_name" value="{lang('fund_transfer_report')}"}

{include file="admin/report/header.tpl" name=""}

{if $cnt >= 1}
    
    <div id="tablewrapper">
    {assign var="j" value="0"}
    <br><br><table border='1' align='center' cellpadding='5px' cellspacing='0' width="100%">
        <tr>
            <th>{lang('sl_no')}</th>
            <th>{lang('customer')}</th>
            <th>{lang('im_full_name')}</th>
           
            <th>{lang('amount_type')}</th>
             <th>{lang('transfer_amount')}</th>

        </tr>

        {foreach from=$fund_transfer_rprt item=v}	
            {$j=$j+1}
            <tr >
                <td> {$j} </td>
                <td>{$v.user_name}</td>
                <td>{$v.full_name}</td>
               
                <td>{$v.amount_type}</td>
                <td>{number_format($v.amount,2)}</td>

            </tr>
        {/foreach}
       </table>
</div>
<div id = "frame">
    <table align="center" style="margin-top:2px;">
        <tr>
            <td>
        <center>
            {lang('click_here_print')}
        </center>
        </td>
        <td>
            <a href="" onClick="window.print();return false">
                    <img src="{$PUBLIC_URL}/images/1335779082_document-print.png" alt="Print" border="none">
        </td>
        </tr>
    </table>
</div>

{else}
    <div id="tablewrapper">{lang('sorry_no_details_found')}</div>
{/if}