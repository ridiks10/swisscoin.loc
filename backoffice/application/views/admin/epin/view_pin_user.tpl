{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_count')}</span>        
    <span id="error_msg2">{lang('you_must_enter_user_name')}</span>        
    <span id="error_msg3">{lang('you_must_select_a_product_name')}</span>        
    <span id="error_msg4">{lang('please_type_your_time_to_call')}</span>                  
    <span id="error_msg5">{lang('please_type_your_e_mail_id')}</span>
    <span id="error_msg">{lang('please_enter_your_company_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{if !isset($smarty.post.epin_user)}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {lang('user_wise_epin')}
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
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="view_pin_user" id="view_pin_user"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">{lang('user_wise_epin')}<span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <input  type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1">
                                <span id="username_box" style="display:none;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" type="submit" name="get_data" id="get_data"value="{lang('submit')}" tabindex="2">
                                    {lang('submit')}
                                </button>
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}
{if isset($smarty.post.user_name) && $is_valid_username}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$username}</div>
{/if}
{if isset($smarty.post.user_name) && $is_valid_username}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {lang('user_wise_epin')}
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
                    <div class="row">
                        <div class="col-sm-12">
                            {if $product_status=="yes"}
                                {if $flag}
                                    {assign var="root" value="{$root}"}

                                    <center><h3>{lang('user_wise_epin')} : {$user_name} </h3></center>                                        
                                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                                        <thead>
                                            <tr class="th" align="center">
                                                <th>{lang('no')}</th>
                                                <th>{lang('epin')}</th>
                                                <th>{lang('amount')}</th>
                                                <th>{lang('balance_amount')}</th>
                                                <th>{lang('status')}</th>
                                                <th>{lang('uploaded_date')}</th>
                                                <th>{lang('expiry_date')}</th>
                                                <th>{lang('delete')}</th>
                                            </tr>
                                        </thead>
                                        {if count($pin_arr)>0}
                                            <tbody>
                                                {assign var="i" value="0"}
                                                {assign var="class" value=""}
                                                {foreach from=$pin_arr item=v}
                                                    {if $i%2==0}
                                                        {$class="tr1"}
                                                    {else}
                                                        {$class="tr2"}
                                                    {/if}
                                                    {assign var="status" value="ACTIVE"}
                                                    {$i=$i+1}
                                                   
                                                    <tr class="{$class}">
                                                        <td>{$i}</td>
                                                        <td>{$v.pin_numbers}</td>
                                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                        <td>{$status}</td>
                                                        <td>{$v.pin_uploded_date}</td>
                                                        <td>{$v.expiry_date}</td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                <!--delete PIN start-->
                                                                <a href="javascript:delete_pin_admin({$v.id},'{$root}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete $pin">
                                                                    <span style="display:none" id="error_msg6">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>
                                                                    <i class="fa fa-times fa fa-white"></i>
                                                                </a>
                                                                <!--delete PIN end-->
                                                            </div>
                                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                                <div class="btn-group">
                                                                    <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                                                    </a>
                                                                    <ul role="menu" class="dropdown-menu pull-right">
                                                                        <!--delete PIN start-->
                                                                        <li role="presentation">
                                                                            <a role="menuitem"  href="javascript:delete_pin_admin({$v.id},'{$root}')">

                                                                                <span style="display:none" id="error_msg6">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>
                                                                                <i class="fa fa-times fa fa-white"></i>Delete
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                {/foreach}
                                            </tbody>
                                        </table>
                                        {$result_per_page}
                                    {elseif !$is_valid_username}
                                        <tbody>
                                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('username_not_exists')}</h4></td></tr>
                                        </tbody>
                                    {else}
                                        <tbody>
                                            <tr><td colspan="8" align="center"><h4 align="center">{lang('no_epin_found')}</h4></td></tr>
                                        </tbody>
                                        </table>
                                    {/if}
                                {/if}

                            {else}
                                {if $flag}

                                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                        <thead>
                                            <tr class="th" align="center">
                                                <th>{lang('no')}</th>
                                                <th>{lang('epin')}</th>
                                                <th>{lang('status')}</th>
                                                <th>{lang('uploaded_date')}</th>
                                                <th>{lang('delete')}</th>
                                            </tr>
                                        </thead>
                                        {if count($pin_arr)>0}
                                            <tbody>
                                                {assign var="i" value="0"}
                                                {assign var="class" value=""}
                                                {assign var="status" value="ACTIVE"}
                                                {foreach from=$pin_arr item=v}
                                                    {if $i%2==0}
                                                        {$class="tr1"}
                                                    {else}
                                                        {$class="tr2"}
                                                    {/if}
                                                    {assign var="status" value="ACTIVE"}
                                                    {$i=$i+1}
                                                    <tr class="{$class}">
                                                        <td>{$i}</td>
                                                        <td>{$v.pin_numbers}</td>
                                                        <td>{$status}</td>
                                                        <td>{$v.pin_uploded_date}</td>
                                                        <td><a href="javascript:delete_pin_admin({$v.id},'{$root}')">
                                                                <div id="span_js_messages" style="display: none;">
                                                                    <span id="error_msg6">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>
                                                                </div>
                                                                <img src="{$PUBLIC_URL}images/delete.png" title="Delete $pin" style="border:none;">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                {/foreach}
                                            </tbody>
                                        {else}
                                            <tbody>
                                                <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_data')}</h4></td></tr>
                                            </tbody>
                                        </table>
                                    {/if}
                                    </table>
                                    {$result_per_page}

                                {/if}
                            {/if}
                        </div>
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>    
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();

        ValidateUser.init();
        DateTimePicker.init();
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}