{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>INV-000{$order_id} 
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
            <div class="panel-body">
                <div class="bodycontainer">
                    <table width=100% cellpadding=0 cellspacing=0 border=0 class="message">
                      <tr><td>
                                <table width=100% cellpadding=12 cellspacing=0 border=0>
                                    <tr><td>
                                            <div style="overflow: hidden;">
                                                <font size=-1>
                                                <div dir="ltr">
                                                    <br>
                                                    <div class="gmail_quote">

                                                        <div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
                                                            <div style="width:100%">

                                                                <div style="float:right;width:100%;height:350px;"> 
                                                                    <img src="{$PUBLIC_URL}images/logos/nlogo.png" alt="{$site_info['company_name']}" style="margin-bottom:20px;border:none;width:190px;height:150px;float:right;" > 


                                                                    <div class="inv_wrap">

                                                                        <div style="width:60%;">
                                                                            <span style="text-align:left;color: #8a8a8a;font-size: 7px;"><u>{$site_info['company_address']}</u></span>
                                                                            <br/>
                                                                            <br/>

                                                                            {* {$site_info['company_address']}*}

                                                                            <b>{$f_name}</b>
                                                                            <br/>{if $address1!='NA' && $address1 !=''}

                                                                            {$address1},{/if}{if $address2!='NA' && $address2 !=''}

                                                                                    <br/>{$address2},{/if}{if $city!='NA' && $city!=''}

                                                                                    <br/>{$city},{/if}{if $postcode!='NA' && $postcode!=''}

                                                                                {$postcode}{/if}</div>

                                                                            <div>{*<b>{$site_info['company_name']}</b><br/> *}{$com_address}</div>


                                                                        </div>
                                                                    </div>
                                                                    <div style='width:100%;height:80px;'>  </div>
                                                                    <h4>{lang('INVOICE')}</h4><br> 

                                                                    <table style="border-collapse:collapse;width:50%;border-top:0px solid #dddddd;border-left:0px solid #dddddd;margin-bottom:20px">
                                                                        <thead>
                                                                            <tr>
                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:10px;color:#222222;width:40%;" {*colspan="2"*}>{lang('order_details')}</td><td></td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px"><td><b>{lang('invoice_id')}: </b></td><td>INV-000{$order_id}</td></tr>
                                                                            <tr style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px"><td><b>{lang('date_added')}: </b></td><td>{$order_details['0']['date']}</td></tr>
                                                                            <tr style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px"><td><b>{lang('payment_method')}:</b></td><td>{$payment_type}</td></tr>




                                                                            {*<tr>*}
                                                                            {* <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:15px"><b>{lang('invoice_id')}:</b> INV-000{$order_id} <br>
                                                                            <b>{lang('date_added')}:</b> {$order_details['0']['date']}<br>
                                                                            <b>{lang('payment_method')}:</b> E-Wallet<br>
                                                                            </td>*}

                                                                            {* <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px"><b>E-mail:</b> <a href="{$user_email}" target="_blank">{$user_email}</a><br>
                                                                            <b>{lang('mobile')}:</b> {$user_phone}<br>
                                                                            {*<b>Order Status:</b> Pending<br>*}{*</td>*}
                                                                            {* </tr>*}
                                                                        </tbody>
                                                                    </table>
                                                                    {*<table style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px">
                                                                    <thead>
                                                                    <tr>
                                                                    <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Payment Address</td>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                    <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px">tester1 tester1<br>ytutut<br>tyutut 467657<br>Imo<br>Nigeria</td>
                                                                    </tr>
                                                                    </tbody>
                                                                    </table>*}


                                                                    <table style="border-collapse:collapse;width:100%;border-top:0px solid #dddddd;border-left:0px solid #dddddd;margin-bottom:20px">
                                                                        <thead>
                                                                            <tr>
                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;{*background-color:#efefef;*}font-weight:bold;text-align:left;padding:12px;color:#222222; width:35%;" >{lang('package')}</td>

                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;{*background-color:#efefef;*}font-weight:bold;text-align:center;padding:12px;color:#222222;width:25%;">{lang('quantity')}</td>
                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;{*background-color:#efefef;*}font-weight:bold;text-align:center;padding:12px;color:#222222;width:25%;">{lang('price')}</td>
                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;{*background-color:#efefef;*}font-weight:bold;text-align:center;padding:12px;color:#222222;width:15%;">{lang('total')}</td>
                                                                            </tr>
                                                                        </thead>
                                                                        {assign var="sub_total" value=0}
                                                                        {assign var="total" value=0}
                                                                        {foreach from=$order_details item=v}     

                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:left;padding:10px">{$v.package_name} </td>

                                                                                    <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:10px">{$v.quantity}</td>
                                                                                    <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:10px">{$DEFAULT_SYMBOL_LEFT} {$v.price} {$DEFAULT_SYMBOL_RIGHT}</td>

                                                                                    {$sub_total= $v.price * $v.quantity}
                                                                                    {$total= $total + $sub_total}
                                                                                    <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:10px">{$DEFAULT_SYMBOL_LEFT} {$sub_total} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        {/foreach }

                                                                        <tfoot>

                                                                            {*  <tr>
                                                                            <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:right;padding:7px" colspan="3"><b>Sub-Total</b></td>
                                                                            <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:right;padding:7px">{$DEFAULT_SYMBOL_LEFT} {$total} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                                            </tr>*}

                                                                            {if $fp_status==1}

                                                                                {$fp_charge=25}
                                                                                {$total=$total+$fp_charge}
                                                                                <tr>
                                                                                    <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;{*background-color:#efefef;*}font-weight:bold;text-align:left;padding:12px;color:#222222;" colspan="3"><b>{lang('Enrolment')}</b></td>
                                                                                    <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:7px;color:#222222"> {$DEFAULT_SYMBOL_LEFT} {$fp_charge} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                                                </tr>
                                                                            {/if}
                                                                            <tr>
                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;{*background-color:#efefef;*}font-weight:bold;text-align:left;padding:12px;color:#222222;" colspan="3"><div style='float: left; text-align: left'>{lang('TOTAL')}</div>
                                                                                    <div style='float: right; text-align: right'>{lang('TAX_FREE')}</div></td>
                                                                                <td style="font-size:12px;border-right:0px solid #dddddd;border-bottom:0px solid #dddddd;text-align:center;padding:7px;color:#222222;border-top:2px solid #dddddd;"> {$DEFAULT_SYMBOL_LEFT} {$total}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div><br></div>
                                                    <div style='width:100%;height:90px;'>  </div>
                                                    <div style="text-align:center;color: #8c8c8c;font-size: 10px;">
                                                        <br/>


                                                        EURO SOLUTION GMBH, Ruessenstrasse 12, 6340 Baar, Schweiz<br/>info@swisscoin.eu,

                                                        www.swisscoin.eu<br/>Raiffeisenbank Aarau-Lenzburg, IBAN: CH1480698000013826785, BIC:

                                                        RAIFCH22698<br/>CEO: Werner Marquetant, UID CHE-142.141.405 MWST


                                                    </div>

                                                </div></td>
                             </tr>
                                    </table>
                                </td>
                             </tr>
                        </table>
                    </div>



                    <a href="../show_customer/{$order_id} " target="_blank"><button id="cmd">{lang('generate')} PDF</button></a>                                                         

                </div>
            </div>
        </div>
    </div>



    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
    <script>
        jQuery(document).ready(function () {
            Main.init();


        });
    </script>
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}

    <style>


        .inv_wrap div {
            width: 184px;
        }
        .inv_wrap {
            overflow: hidden;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }


    </style>