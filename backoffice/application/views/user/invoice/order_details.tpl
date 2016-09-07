{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;">
    <span id="row_msg">rows</span>
    <span id="show_msg">shows</span>    
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('invoice')}
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
                {if $order_details}
                     <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th>{lang('no')}</th>
                                <th>{lang('Order_Id')}</th>
                                <th>{lang('invoice_number')}</th>
                                <th>{lang('Amount')}</th>
                                <th>{lang('Date')}</th>
                                
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}
                            
                            {assign var="i" value=0}
                            {foreach from=$order_details item=v}
                               

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.order_id}</td>
                                    <td><a href="my_invoice/{$v.order_id}" >INV-000{$v.order_id}</a></td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{$v.price}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td>{$v.date}</td>
                                    
                                   
                                </tr>                    
                            {/foreach}
                        </tbody>
                    </table>
                {else}
                     <h5 align="center">No Details Found</h5>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}