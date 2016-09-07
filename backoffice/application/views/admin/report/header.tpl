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
    table#datastore  th{ border-bottom:1px solid #c5c5c5;font-weight:normal; }
    table#datastore  td,table#grid th{ padding:4px 0px;text-align:center;border-left:1px solid #c5c5c5; }
    table#datastore  thead{ line-height:30px;color:#444;font-weight:normal }
    table#datastore  .mainframe td table#grid tr td{ line-height:24px;font-size:14px;vertical-align:middle }
    table#datastore  tr { background-color: #f5f5f5; }
    table#datastore  tr:hover { background-color: #FFF;color:#000 }
    table#datastore.profile_report_tbl td,table#datastore.profile_report_tbl th { text-align: left; padding-left:10px }

</style>

<div id="content">
    <div id="tablewrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-2" style="text-align:center; padding: 20px 0px 0px 0px;">
                    <div class="report-header">
                        <img src="{$PUBLIC_URL}images/logos/{$site_info["logo"]}" align="left"  >
                    </div>
                </div>
                <div class="col-sm-8">

                    <table align="center">
                        <tr height='20px'>
                            <td  colspan="3" align='center'>
                                <h1>
                                    <font face="Arial, Helvetica, sans-serif">
                                    <h3> {$report_header["company_name"]}</h3></font>
                                </h1>
                            </td>
                        </tr>
                        <tr height='20px'><td  colspan="3" align='center'><b><font color="#ff0000"></font>{$report_header["address"]}</b></td></tr>
                        <tr height='20px'><td  colspan="3" align='center'><b><font color="#ff0000">{lang('phone')}:</font>{$report_header["phone"]}</b></td></tr>
                        <tr height='20px'><td  colspan="3" align='center'><b><font color="#ff0000">{lang('email')}:</font>{$report_header["email"]}</b></td></tr>
                    </table>
                </div>
                <div class="col-sm-2" style="text-align:center; padding: 20px 0px 0px 0px;">
                    <b>{lang('Date')}:{$date}</b>
                </div>
            </div>
        </div>
        <hr />
        <h2 style="text-align: center;">{$report_name}</h2>
