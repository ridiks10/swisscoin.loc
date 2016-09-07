{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">  
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('view_order')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <center> 
                        {$det['first_name']}{" "}{$det['last_name']}<br> 
                        {$det['guest_address']}<br>
                        {$det['guest_city']}<br>
                        {$det['guest_email']}
                    </center>
                </div>
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                        {$i=1}
                        <tr class="th" align="center">
                            <th>{lang('no')}</th>
                            <th>{lang('party')}</th>
                            <th>{lang('product_name')}</th>
                            <th>{lang('quantity')}</th>
                            <th>{lang('amount')}</th>
                            <th>{lang('processed')}</th>
                            <th>{lang('date')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach from=$order item=v}
                            <tr>
                                <td>{$i}</td>
                                <td>{$v.party_name}</td>
                                <td>{$v.product_name}</td>
                                <td>{$v.count}</td>
                                <td>${number_format($v.total_amount,2)}</td>
                                <td>{$v.processed}</td>
                                <td>{$v.date}</td>
                                {$i=$i+1}
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
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