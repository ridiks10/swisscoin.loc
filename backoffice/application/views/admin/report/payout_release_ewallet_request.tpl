{assign var="report_name" value="{lang('payout_release_report')}"}
{include file="admin/report/header.tpl" name=""}
    {assign var="j" value="0"}
   {if $count >=1}
       <br><br><table border='1' align='center' width="100%" cellpadding='5px' cellspacing='0' >
            <tr>
                <th>{lang('no')}</th>
                <th>{lang('user_name')}</th>
                <th>{lang('name')}</th>
                <th>{lang('total_account')}</th>
                <th>{lang('Date')}</th>
            </tr>
            {foreach from=$binary_details item=v}
                {$j=$j+1}
                <tr >
                    <td> {$j} </td>
                    <td>{$v.paid_user_id}</td>
                    <td>{$v.full_name}</td>
                    <td>{number_format($v.paid_amount,2)}</td>
                    <td>{$v.paid_date}</td>
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
    {else}
        <center>
                {lang('no_details_found')}
        </center>
    {/if}

