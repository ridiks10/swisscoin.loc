{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

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
                    {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                     <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th width="5%">Si No</th>
                                <th width="10%">{lang('Order_Id')}</th>
                                <th width="18%">{lang('username')}</th>
                                <th width="15%">{lang('name')}</th>
                                <th width="15%">{lang('invoice_number')}</th>
                                <th width="15%">{lang('Amount')}</th>
                                <th width="15%">{lang('Date')}</th>
                                <th width="7%">{lang('download')}</th>
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
                                    <td>{$offset++}</td>
                                    <td>{$v.order_id}</td>
                                    <td>{$v.username}</td>
                                     <td>{if !empty($v.name)} {$v.name} {else} NA{/if}</td>
                                    <td><a href="{base_url()}admin/invoice/my_invoice/{$v.order_id}" >INV-000{$v.order_id}</a></td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{$v.price}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td>{$v.date}</td>
                                    <td align="center">
                                        <input type="checkbox" name="order_ids[]" id="" value="{$v.order_id}">
                                    </td>
                                    
                                   
                                </tr>                    
                            {/foreach}
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success">
                        Download
                    </button>
                    <a href="javascript:void(0);" style="margin-left: 20px;" id="check_all">Check All</a>
                    {form_close()}
                {else}
                     <h5 align="center">No Details Found</h5>
                {/if}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4 col-sm-offset-8">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {$links}
            </ul>
        </nav>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
       // TableData.init();

        $('#check_all').click(function () {
            var checkboxes = $('input[name="order_ids[]"]');
            var checked    = checkboxes.first().is(':checked');

            checkboxes.prop('checked', ! checked );
        });
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}