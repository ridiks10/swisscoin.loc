{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('payout_release')}
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
                <div id="transaction" type="hidden">
                    <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="div1"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {form_open('', 'name="ewallet_form_det" id="ewallet_form_det" method="post"')}
                    {if $count>0}
                        <input type= 'hidden'  name = "table_rows"  value ="{$count}" >
                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                            <thead>
                                <tr class="th" align="center">
                                <tr class="th" align="center"> 
                                    <th>{lang('no')}</th>
                                    <th>{lang('user_name')}</th>
                                    <th>{lang('user_full_name')}</th>
                                    <th>{lang('request_date')}</th>
                                    <th>{lang('balance_amount')}</th>
                                    <th>{lang('Payout_Amount')}</th>
                                    <th>{lang('ewallet_balance')}</th>
                                    <th>{lang('check')}</th>
                                        {if $MODULE_STATUS['payout_release_status']=="ewallet_request"}
                                        <th>{lang('delete')}</th>
                                        {/if}
                                    <th>{lang('view_user_data')}</th>
                                </tr>
                            </thead>
                            {assign var="i" value=0}
                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            <tbody>
                                {foreach from=$payout_details item="v"}
                                    {if $i%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}
                                    <tr class="{$class}" align="center" >
                                        <td>{counter}
                                            <input type='hidden' name='request_id{$i}' value = '{$v.req_id}'>
                                            <input type='hidden' name='user_id{$i}' value = '{$v.user_id}'>
                                            <input type='hidden' name='balance_amount{$i}' value = '{$v.balance_amount}'>
                                            <input type='hidden' name='requested_date{$i}' value = '{$v.requested_date}'>
                                            <input type='hidden' name='payout_amount{$i}' value = '{$v.payout_amount}'>
                                        </td>
                                        <td>{$v.user_name}</td>
                                        <td>{$v.user_detail_name}</td>
                                        <td>{$v.requested_date}</td>
                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.balance_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                                            
                                        </td>
                                        <td>
                                            {$DEFAULT_SYMBOL_LEFT}<input type="text" name="payout{$i}" id="payout_amount" value="{number_format($v.payout_amount*$DEFAULT_CURRENCY_VALUE,2)}" {if $MODULE_STATUS['payout_release_status']=="ewallet_request"}readonly=""{/if}/>
                                            <span id="errmsg1"></span>{$DEFAULT_SYMBOL_RIGHT}
                                        </td>
                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.cash_account*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                        <td>
                                            <input type="checkbox" name="release{$i}" id="release{$i}" class="release"/><label for="release{$i}" />
                                        </td>

                                        {if $MODULE_STATUS['payout_release_status']=="ewallet_request"}
                                            <td>
                                                <a href="javascript:delete_request({$v.req_id},'{$path}',{$v.user_id})">
                                                    <img src="{$PUBLIC_URL}images/delete.png" title="Delete {$v.user_name}" style="border:none;">
                                                </a>
                                            </td>
                                        {/if}
                                        <td>
                                            <a class="btn btn-xs btn-link panel-config" href="#panel-config" onclick="javascript:view_popup({$v.user_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$path}')"data-toggle="modal" style='color:#C48189;'>{lang('view')}</a>
                                        </td>
                                    </tr>
                                    {$i=$i+1}
                                {/foreach}                
                            </tbody>    
                        </table>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <input type="submit" class="btn btn-bricky" tabindex="1" name="release_payout" id="release_payout" value="{lang('release')}" />
                            </div>
                        </div> 
                    {else}
                         <h5 align="center">No Details Found</h5>
                    {/if} 
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
        ValidatePayoutRelease.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}