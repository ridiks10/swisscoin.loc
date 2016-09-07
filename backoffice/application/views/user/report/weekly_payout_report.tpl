

<style type="text/css">
body { font:12px Arial; margin:25px; background:#fff url(../../public_html/images/bg_print.gif) repeat-x }
#content{ height:auto;width:auto;margin:auto; }
#tablewrapper { width:auto; margin:0 auto;padding:20px;background-color:#fff;border:1px solid #c6d5e1; }
#tablewrapper table{ margin:auto;}
#tableheader { height:55px }
#tableheader select { float:left; font-size:12px; width:125px; padding:2px 4px 4px }
#tableheader input { float:left; font-size:12px; width:225px; padding:2px 4px 4px; margin-left:4px }
#tablefooter { height:15px; margin-top:20px }
#tablenav { float:left }
#tablenav img { cursor:pointer }
#tablenav div { float:left; margin-right:15px }
#tablelocation { float:right; font-size:12px }
#tablelocation select { margin-right:3px }
#tablelocation div { float:left; margin-left:15px }
.page { margin-top:2px; font-style:italic }
#selectedrow td { background:#c6d5e1; }
#tablewrapper{ margin-top:10px; }
#tablewrapper table td{ padding:3px; }
table td{ font-size:12px; }
h2 { font-size:24px;margin-top:10px;margin-bottom:10px;font-weight:normal ;font-family:dosis;}
hr{ border-top:1px dotted #000;background:none;margin-bottom:5px; }
table#datastore { border-collapse:collapse;border-bottom:1px solid #c5c5c5;border-top:1px solid #c5c5c5;border-right:1px solid #c5c5c5;color:#2e2e2e;font-weight:normal;width:100%; }
table#datastore  th,table#grid{ border-bottom:1px solid #c5c5c5;font-weight:normal; }
table#datastore  td,table#grid th{ padding:4px 0px;text-align:center;border-left:1px solid #c5c5c5; }
table#datastore  thead{ line-height:30px;color:#444;font-weight:normal }
table#datastore  .mainframe td table#grid tr td{ line-height:24px;font-size:14px;vertical-align:middle }
table#datastore  tr { background-color: #f5f5f5; }
table#datastore  tr:hover { background-color: #FFF;color:#000 }
</style>
{assign var="report_name" value="{$tran_user_payout_report}"}
{include file="user/report/header.tpl" name=""}
<div id="tablewrapper">

    <table border="0" width="100%" align="center" style="border-collapse:collapse" bordercolor="#000000">
        <tr>
            <td align='left' ><img src="{$PUBLIC_URL}images/logo.png" align="left"  ></td>
            <td>
                <table align="center">
                    <tr height='20px'>
                        <td  colspan="3" align='center'>
                            <h1>
                                <font face="Arial, Helvetica, sans-serif">
                                <font color="#F40000">I</font>nfinite <font color="#F40000">O</font>pen<font color="#F40000">S</font>ource <font color="#F40000">S</font>olutions</font>
                            </h1>
                        </td>
                    </tr>
                    <tr height='20px'><td  colspan="3" align='center'><b>Technology Business Incubator,</b></td></tr>
                    <tr height='20px'><td  colspan="3" align='center'><b>NIT Campus (P.O.), Calicut - 673601, Kerala,</b></td></tr>
                    <tr height='20px'><td  colspan="3" align='center'><b>Phone: +91 495 2287430</b></td></tr>
                    <tr height='20px'><td  colspan="3" align='center'><b>Email:info@ioss.in</b></td></tr>
                </table>
            </td>
            <td align='right' ><b>Date:{$date}</td>
        </tr>
        <tr>
            <td colspan="3"><hr /></td>
        </tr>
        <tr>
            <td colspan="3" align="center"><h2>{$report_name}</h2></td>
        </tr>
    </table>
{if $count >= 1}

<br><br><table border='1' cellpadding="0" cellspacing="0" align='center' >
<tr>
        <th>{$tran_no}</th>
	<th>{$tran_full_name}</th>
	<th>{$tran_user_name}</th>
        <!--
    <th>Left Count</th>
    <th>Right Count</th>
    <th>Total Leg</th>
        -->
    <th>{$tran_total_amount}</th>
    <th>{$tran_tds}</th>
    <th>{$tran_service_charge}</th>
    <th>{$tran_amount_payable}</th>
    </tr>
    {assign var="i" value=0}
    {foreach from=$weekly_payout item=v}
        
  {$i = $i+1}
   
	<tr >

	                 <td>{$i}</td>
			 <td>{$v.full_name}</td>
			<td>{$v.user_name}</td>
                        <!--
			<td><?php echo $left_leg; ?></td>
			<td><?php echo $right_leg; ?></td>
			<td><?php echo $total_leg; ?></td>
                        -->
			<td>{$v.total_amount}</td>
    		        <td>{$v.tds}</td>
    		        <td>{$v.service_charge}</td>
    	                <td>{$v.amount_payable}</td>
			</tr>
{/foreach}
	<!--
		<tr>
			<td colspan='9' align='right'>
			<a href='excel/weekly_report_excel.php?from=$from_date&to=$to_date'>Create Excel file</a>
			</td>
			</tr>
			-->
      </table>
{/if}
</div>
<div id = "frame">
            <table align="center" style="margin-top:10px;">
                <tr>
                    <td>
                <center>
                    {$tran_click_here_print}
                </center>
                </td>
                <td>
                    <a href="" onClick="window.print();return false">
                        <img src="{$PUBLIC_URL}/images/1335779082_document-print.png" alt="Print" border="none"></a>
                </td>
                </tr>
            </table>
        </div>