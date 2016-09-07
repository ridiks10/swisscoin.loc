{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;">
    <span id="row_msg">rows</span>
    <span id="show_msg">shows</span>    
</div>

{foreach from=$package_details item=m}

    <div class="modal fade" id="panel-config{$m.order_id}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">Order Details</h4>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>


                            {assign var="total" value=0}
                            {foreach from=$m.package_purchase item=p}

                                <tr>
                                    <td>{$p.package_name}</td>
                                    <td>{$p.quantity}</td>
                                    <td>{$p.price }</td>
                                    <td>{$p.price * $p.quantity}</td>
                                    {assign var=total value= $total + $p.price * $p.quantity} 
                                </tr>
                            {/foreach}
                        </tbody>
                        <tfoot>
                            
                        {if $m.fp_status == '1'}  
                            
                        {$fp_charge=25}
                        {$total=$total+$fp_charge}
                        <tr><td></td>
                        <td></td>
                        <td ><b>Enrolment</b></td>
                        <td><b>{$fp_charge}</b></td></tr>
                        {/if}
                        
                        <tr><td></td>
                        <td></td>
                        <td ><b>Total</b></td>
                        <td><b>{$total}</b></td></tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>



{/foreach}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('order_history')}
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
                {if $arr_count!=0}
                    <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th width="5%">Si No</th>
                                <th>{lang('Order_Id')}</th>
                                <th>{lang('Date')}</th>
                                <th>{lang('Amount')}</th>
                                <th>{lang('Details')}</th>
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}

                            {assign var="i" value=0}
                            {foreach from=$package_details item=v}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.order_id}</td>
                                    <td>{$v.date}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{$v.price*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>

                                    <td> <a class="btn btn-primary" href ="#panel-config{$v.order_id}"  data-toggle="modal" > Details</a></td>
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                    </table>
                    {$result_per_page}
                {else}
                     <h5 align="center">No Details Found</h5>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();

    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}