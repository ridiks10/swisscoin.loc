{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg6">{lang('please_select_at_least_one_checkbox')}</span> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div> 
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('view_epin_request')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="view_request_form" id="view_request_form"')}

                    {assign var="arr_length" value=count($pin_detail_arr)}



                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('requested_pin_count')}</th>
                                <th>{lang('amount')}</th>
                                <th>{lang('date')}</th>
                                <th>{lang('expiry_date')}</th>
                                <th>{lang('count')}</th>
                                <th>{lang('check')}</th>
                            </tr>
                        </thead>
                        {if $arr_length >0}
                            <tbody>

                                {assign var="class" value=""}
                                {assign var="i" value="0"}
                                {assign var="k" value="1"}
                                {foreach from=$pin_detail_arr item=v}
                                    {if $i%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}

                                    <tr class="{$class}" align="center" >
                                        <td>{$k}</td>
                                        <td>{$v.user_name}</td>
                                        <td>{$v.pin_count}<input type="hidden" name='rem_count{$k}' id='rem_count{$k}' value="{$v.pin_count}"/></td>
                                        <td>{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}<input type="hidden" name='amount{$k}' id='amount{$k}' value="{$v.amount}"/></td>
                                        <td>{$v.req_date}</td>
                                        <td>{$v.expiry_date}<input type="hidden" name='expiry_date{$k}' id='expiry_date{$k}' value="{$v.expiry_date}"/></td>
                                        <td><input name='count{$k}' id='count' type='text'  size='4' maxlength='50'  value='{$v.rem_count}' /></td>
                                        <td><input  name='active{$k}' id='activate{$k}' type="checkbox" value="yes" class="active"><label for="activate{$k}" ></label>
                                            <input type='hidden' id="id{$k}" name='id{$k}' value='{$v.req_id}'/><input type='hidden' name='user_id{$k}' value='{$v.user_id}'/>
                                            <input type='hidden' name='product{$k}' value='{$v.product_id}'>
                                        </td>
                                    </tr>
                                    {$k=$k+1}
                                {/foreach} 


                            <div class="form-group">
                                <input  type="hidden"  name="total_count" value="{$k}" >


                            </div>


                            </tbody>
                        {else}
                            <tbody>
                                <tr><td colspan="12" align="center"><h4>{lang('no_epin_request_found')}</h4></td></tr>
                            </tbody>
                        {/if} 
                    </table>
                    {$result_per_page}
                    <div class="col-sm-12">
                        <input class="btn btn-bricky pull-right" type="submit"  name="allocate" id="allocate"  value='{lang('allocate')}' tabindex="1" >

                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>          


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();

        ValidateEpinRequest.init();
        ValidateUser.init();
        DateTimePicker.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}