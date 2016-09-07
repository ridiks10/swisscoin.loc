{assign var="report_name" value="{lang('payout_release_report')}"}
{include file="admin/report/header.tpl" name=""}
    {assign var="j" value="0"}
    {if $count >=1}

        <br><br><table border='1' align='center' width="100%" cellpadding='5px' cellspacing='0' >
            <tr>
                <th>{lang('no')}</th>
                <th>{lang('user_name')}</th>
                <th>{lang('name')}</th>
                <th>{lang('total_amount')}</th>
                <th>{lang('tds')}</th>
                <th>{lang('service_charge')}</th>
                <th>{lang('amount_payable')}</th>

            </tr>

            {foreach from=$binary_details item=v}	



                {$j=$j+1}
                <tr >
                    <td> {$j} </td>
                    <td>{$v.user_name}</td>
                    <td>{$v.user_detail_name}</td>
                    <td>{number_format($v.total_amount,2)}</td>
                    <td>{number_format($v.tds,2)}</td>
                    <td>{number_format($v.service_charge,2)}</td>
                    <td>{number_format($v.amount_payable,2)}</td>
		
                </tr>
            {/foreach}
         
        </table>
            </div>
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
                    <img src="{$PUBLIC_URL}/images/1335779082_document-print.png" alt="Print" border="none"></a>
            </td>
            </tr>
        </table>
    </div>
    {/if}

