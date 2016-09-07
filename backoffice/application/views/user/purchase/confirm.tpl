{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display: none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
    
<div class="modal fade" id="myModal" role="dialog" style="position: absolute; height: 500px; top: 30%;">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        
        <div class="modal-body">
          <p></p><blockquote>
          <p>Please Update Name and Address Details in Mydata.... </p></blockquote>
          <p></p>
        </div>
       
      </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">

                <li class="active">
                    <a data-toggle="tab" href="#panel_edit_account">
                        E-wallet payment
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#panel_edit_accounts">
                        Cash + Trading
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#panel_overview_payeer1">
                       Payza
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#panel_overview_payeer2">
                       Payeer
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#panel_overview_payeer3">
                       Sepa
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#panel_overview_payeer4">
                       Swift
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#panel_overview_payeer5">
                       Bitcoin
                    </a>
                </li>
                <li class="" style="display:  none;">
                    <a data-toggle="tab" href="#panel_paypal">
                        Paypal/Credit Card
                    </a>
                </li>
                {*<li class="">
                    <a data-toggle="tab" href="#panel_okpay">
                        OkPay
                    </a>
                </li>*}
                
               

            </ul>
            <div class="tab-content">
                <div id="panel_overview_payeer1" class="tab-pane">
                    <p>
                        <img src="{$PUBLIC_URL}images/payza.png" width="150px;" height="70px;" >
                    </p>
                    <blockquote>
                    <p>{$info_box_con_payza}</p>
                    </blockquote>
                    <p>
                        
                    </p>
                </div>
                <div id="panel_overview_payeer2" class="tab-pane">
                    <p><img src="{$PUBLIC_URL}images/payeer.png" width="150px;" height="70px;"></p><blockquote>
          <p>{$info_box_con_payeer}</p></blockquote>
          <p></p>
                </div>
                <div id="panel_overview_payeer3" class="tab-pane">
                    
                    
                    <p><img src="{$PUBLIC_URL}images/sepa.png" width="150px;" height="70px;" ></p>
          <blockquote>{$info_box_con_sepa}
          </blockquote>
          <p></p>
                </div>
                <div id="panel_overview_payeer4" class="tab-pane">
                    
                    <p><img src="{$PUBLIC_URL}images/swiftlogo.png" width="150px;" height="140px;" ></p>
          <blockquote>{$info_box_con_swift}</blockquote>
          <p></p>
                </div>
                <div id="panel_overview_payeer5" class="tab-pane">
                    
                    <p><img src="{$PUBLIC_URL}images/bicoin.png" width="150px;" height="60px;" ></p>
                    <blockquote>{$info_box_bitcoin}</blockquote>
                    <p></p>
                </div>
                   
             
                <div id="panel_edit_account" class="tab-pane active">
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {*<i class="fa fa-external-link-square"></i>*}{lang('payment_information')}
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
                                    
                                    <div class="col-sm-12 ">
                                    <button data-toggle="modal" data-target="#myModal"  id="trigger_button" style="display: none;"></button>
                                        
                                        <div style="text-align: center;font-size: 16px;">E-wallet balance : {$DEFAULT_SYMBOL_LEFT} {$cash_acc_balence} {$DEFAULT_SYMBOL_RIGHT}</div>
                                        <br/>
                                        {if isset($ewallet_info_status)}
                                            <div class="panel panel-danger">
                                                  <div class="panel-heading"><i class="fa fa-info"></i>Info</div>
                                                  <div class="panel-body">{$info_box_con_e_wallet}</div>
                                            </div>
                                        {/if}
                                        
                                        <br/>
                                        <table  class="table table-bordered table-hover" >
                                            <thead>
                                                <tr>
                                                    <th>Package</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {assign var=total value=0}
                                                {foreach from=$all_packs item=v}


                                                    <tr>
                                                        <td class='text-left'>{$v.name}</td>
                                                        <td class='text-left'>{$v.qty}</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.qty * $v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                        {$sub_total =$v.qty * $v.price}
                                                    </tr>
                                                    {$total =$total+$sub_total}
                                                {/foreach}
                                            </tbody>
                                            <tfoot style="font-size: 13px;font-weight: bold">
                                                {if $first_purchase_status == 'yes'}
                                                    {$first_purchase_charge = 25}
                                                    <tr>
                                                        <td class='text-right' colspan="3">Enrolment</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$first_purchase_charge} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    </tr>
                                                    {$total=$total+$first_purchase_charge}
                                                {/if}
                                                <tr>
                                                    <td class='text-right' colspan="3">Total</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {number_format($total,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div> 
                                   
                                    {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                                    <input type="hidden"  name="total_amount" value="{$total}">
                                    <input type="hidden"  name="payment_type" value="e_wallet">
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <input type="submit" class="btn btn-info pull-right"  id="pay_ewallet" name="pay_ewallet" value="Confirm" style="padding: 7px 25px 7px 25px;background: #3276b1;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" disabled="true">
                                        </div> 
                                    </div> 
                                    {form_close()}
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div>
                <div id="panel_paypal" class="tab-pane">
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {*<i class="fa fa-external-link-square"></i>*}{lang('payment_information')}
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

                                    <div class="col-sm-12 ">
                                        <button data-toggle="modal" data-target="#myModal"  id="trigger_button" style="display: none;"></button>

                                        <br/>
                                        <table  class="table table-bordered table-hover" >
                                            <thead>
                                            <tr>
                                                <th>Package</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {assign var=total value=0}
                                            {foreach from=$all_packs item=v}


                                                <tr>
                                                    <td class='text-left'>{$v.name}</td>
                                                    <td class='text-left'>{$v.qty}</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.qty * $v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    {$sub_total =$v.qty * $v.price}
                                                </tr>
                                                {$total = $total+$sub_total}
                                            {/foreach}
                                            </tbody>
                                            <tfoot style="font-size: 13px;font-weight: bold">
                                            {if $first_purchase_status == 'yes'}
                                                {$first_purchase_charge = 25}
                                                <tr>
                                                    <td class='text-right' colspan="3">Enrolment</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$first_purchase_charge} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                                {$total=$total+$first_purchase_charge}
                                            {/if}
                                            <tr>
                                                {assign var=fee value=$total * 0.025 + 0.35}
                                                <td class='text-right' colspan="3">Paypal Fee</td>
                                                <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {number_format($fee,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                            <tr>
                                                {$total=$total+$fee}
                                                <td class='text-right' colspan="3">Total</td>
                                                <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {number_format($total,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    {*{form_open($SWISSC_SHOP_URL,'role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}*}
                                    {*<input type="hidden" name="user_id" value="{$user_id}">*}
                                    {*<input type="hidden" name="first_purchase" value="{$first_purchase_status}">*}
                                    {*{foreach from=$all_packs item=v key=i}*}
                                        {*<input type="hidden" name="products[{$i}][id]" value="{$v['id']}">*}
                                        {*<input type="hidden" name="products[{$i}][name]" value="{$v['name']}">*}
                                        {*<input type="hidden" name="products[{$i}][price]" value="{$v['price']}">*}
                                        {*<input type="hidden" name="products[{$i}][qty]" value="{$v['qty']}">*}
                                    {*{/foreach}*}
                                    {*<div class='row'>*}
                                        {*<div class='col-sm-12'>*}
                                            {*<input type="submit" class="btn btn-info pull-right"  id="pay_ewallet" name="pay_ewallet" value="Confirm" style="padding: 7px 25px 7px 25px;background: #3276b1;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;">*}
                                        {*</div>*}
                                    {*</div>*}
                                    {*{form_close()}*}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="panel_okpay" class="tab-pane">
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {*<i class="fa fa-external-link-square"></i>*}{lang('payment_information')}
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

                                    <div class="col-sm-12 ">
                                        <button data-toggle="modal" data-target="#myModal"  id="trigger_button" style="display: none;"></button>

                                        <br/>
                                        <table  class="table table-bordered table-hover" >
                                            <thead>
                                            <tr>
                                                <th>Package</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {assign var=total value=0}
                                            {foreach from=$all_packs item=v}


                                                <tr>
                                                    <td class='text-left'>{$v.name}</td>
                                                    <td class='text-left'>{$v.qty}</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.qty * $v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    {$sub_total =$v.qty * $v.price}
                                                </tr>
                                                {$total = $total+$sub_total}
                                            {/foreach}
                                            </tbody>
                                            <tfoot style="font-size: 13px;font-weight: bold">
                                            {if $first_purchase_status == 'yes'}
                                                {$first_purchase_charge = 25}
                                                <tr>
                                                    <td class='text-right' colspan="3">Enrolment</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$first_purchase_charge} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                                {$total=$total+$first_purchase_charge}
                                            {/if}
                                            <tr>
                                                <td class='text-right' colspan="3">Total</td>
                                                <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {number_format($total,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    {*{form_open('https://www.okpay.com/process.html','role="form" class="smart-wizard form-horizontal" name="searchform" method="post"')}
                                    <input type="hidden" name="ok_receiver" value="payment@swisscoin.eu" />
                                    <input type="hidden" name="ok_currency" value="EUR" />
                                    <input type="hidden" name="ok_return_success" value="{$base_url}user/purchase/confirm_from_okpay?success=true&user_id={$user_id}">
                                    <input type="hidden" name="ok_return_fail" value="{$base_url}user/purchase/confirm_from_okpay?success=false&user_id={$user_id}">

                                    {foreach from=$all_packs item=v key=i}
                                        <input type="hidden" name="ok_item_{$i+1}_article" value="{$v['id']}" />
                                        <input type="hidden" name="ok_item_{$i+1}_name" value="{$v['name']}" />
                                        <input type="hidden" name="ok_item_{$i+1}_type" value="digital" />
                                        <input type="hidden" name="ok_item_{$i+1}_price" value="{$v['price']}" />
                                        <input type="hidden" name="ok_item_{$i+1}_quantity" value="{$v['qty']}" />
                                    {/foreach}
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <input type="submit" class="btn btn-info pull-right"  id="pay_okpay" name="pay_okpay" value="Confirm" style="padding: 7px 25px 7px 25px;background: #3276b1;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;">
                                        </div>
                                    </div>
                                    {form_close()}*}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="panel_edit_accounts" class="tab-pane">
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {*<i class="fa fa-external-link-square"></i>*}{lang('payment_information')}
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
                                    
                                    <div class="col-sm-12 ">
                                    <button data-toggle="modal" data-target="#myModal"  id="trigger_button" style="display: none;"></button>
                                        
                                        <div style="text-align: center;font-size: 16px;float: left;width: 50%;">Cash Account : {$DEFAULT_SYMBOL_LEFT} {number_format($cash_acc_balence,2)} {$DEFAULT_SYMBOL_RIGHT}</div>
                                        <div style="text-align: center;font-size: 16px;float: left;width: 50%;">Trading Account : {$DEFAULT_SYMBOL_LEFT} {number_format($trading_acc_balence,2)} {$DEFAULT_SYMBOL_RIGHT}</div>
                                        <br/>
                                         {if isset($ewallet_info_status)}
                                            <div class="panel panel-danger">
                                                  <div class="panel-heading"><i class="fa fa-info"></i>Info</div>
                                                  <div class="panel-body">{$info_box_con_cash_acc}</div>
                                            </div>
                                        {/if}
                                        
                                        <br/>
                                        <table  class="table table-bordered table-hover" >
                                            <thead>
                                                <tr>
                                                    <th>Package</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {assign var=total value=0}
                                                {foreach from=$all_packs item=v}


                                                    <tr>
                                                        <td class='text-left'>{$v.name}</td>
                                                        <td class='text-left'>{$v.qty}</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.qty * $v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                        {$sub_total =$v.qty * $v.price}
                                                    </tr>
                                                    {$total =$total+$sub_total}
                                                {/foreach}
                                            </tbody>
                                            <tfoot style="font-size: 13px;font-weight: bold">
                                                {if $first_purchase_status == 'yes'}
                                                    {$first_purchase_charge = 25}
                                                    <tr>
                                                        <td class='text-right' colspan="3">Enrolment</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$first_purchase_charge} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    </tr>
                                                    {$total=$total+$first_purchase_charge}
                                                {/if}
                                                <tr>
                                                    <td class='text-right' colspan="3">Total</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {number_format($total,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div> 
                                   
                                    {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                                    <input type="hidden"  name="total_amount" value="{$total}">
                                    <input type="hidden"  name="payment_type" value="cash_trade_acc">
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <input type="submit" class="btn btn-info pull-right"  id="pay_cash" name="pay_cash" value="Confirm" style="padding: 7px 25px 7px 25px;background: #3276b1;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" disabled="true">
                                        </div> 
                                    </div> 
                                    {form_close()}
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div>
                <div id="panel_edit_trading" class="tab-pane">
                    <div class="row" >
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    {*<i class="fa fa-external-link-square"></i>*}{lang('payment_information')}
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
                                    
                                    <div class="col-sm-12 ">
                                    <button data-toggle="modal" data-target="#myModal"  id="trigger_button" style="display: none;"></button>
                                        
                                        <div style="text-align: center;font-size: 16px;">Trading Account : {$DEFAULT_SYMBOL_LEFT} {$trading_acc_balence} {$DEFAULT_SYMBOL_RIGHT}</div>
                                        <br/>
                                        {if isset($trading_acc_status)}
                                            <div class="panel panel-danger">
                                                  <div class="panel-heading"><i class="fa fa-info"></i>Info</div>
                                                  <div class="panel-body">{$info_box_con_trade_acc}</div>
                                            </div>
                                        {/if}
                                        
                                        <br/>
                                        <table  class="table table-bordered table-hover" >
                                            <thead>
                                                <tr>
                                                    <th>Package</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {assign var=total value=0}
                                                {foreach from=$all_packs item=v}
                                                    <tr>
                                                        <td class='text-left'>{$v.name}</td>
                                                        <td class='text-left'>{$v.qty}</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$v.qty * $v.price} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                        {$sub_total =$v.qty * $v.price}
                                                    </tr>
                                                    {$total =$total+$sub_total}
                                                {/foreach}
                                            </tbody>
                                            <tfoot style="font-size: 13px;font-weight: bold">
                                                {if $first_purchase_status == 'yes'}
                                                    {$first_purchase_charge = 25}
                                                    <tr>
                                                        <td class='text-right' colspan="3">Enrolment</td>
                                                        <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {$first_purchase_charge} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    </tr>
                                                    {$total=$total+$first_purchase_charge}
                                                {/if}
                                                <tr>
                                                    <td class='text-right' colspan="3">Total</td>
                                                    <td class='text-left'>{$DEFAULT_SYMBOL_LEFT} {number_format($total,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div> 
                                   
                                    {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                                    <input type="hidden"  name="total_amount" value="{$total}">
                                    <input type="hidden"  name="payment_type" value="trading_acc">
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <input type="submit" class="btn btn-info pull-right"  id="pay_trading" name="pay_trading" value="Confirm" style="padding: 7px 25px 7px 25px;background: #3276b1;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" disabled="true">
                                        </div> 
                                    </div> 
                                    {form_close()}
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div>
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