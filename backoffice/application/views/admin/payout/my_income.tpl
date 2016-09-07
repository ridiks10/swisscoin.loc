
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{assign var="count" value = '0'}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{if !isset($smarty.post.income_statement)}
    <div class="row" >
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {lang('income')}
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
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="search_mem" id="search_mem"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i>{lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">{lang('select_user_id')} <span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <input  type="text" id="user_name"  name="user_name" autocomplete="Off" tabindex="1">
                                <span id="username_box" style="display:none;"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" type="submit" name="weekdate" id="weekdate" value="{lang('submit')}" tabindex="2">
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
    <div id="username_val" style="display:none;">{$user_name}</div>
{/if}
{if $week_date}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('income')}
                </div>
                <div class="panel-body">
                    {if !$is_valid_username}
                        <h4 align="center"><font color="#FF0000">{lang('Username_not_Exists')}</font></h4>
                        {else}
                            {assign var="count" value = count($binary)}
                        <h2 align="center"> {lang('weekwise_income')} : {$user_name}</h2> 
                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                            <thead>
                                <tr class="th">
                                    <th class="hidden-xs">{lang('no')}</th>
                                    <th class="hidden-xs">{lang('paid_date')}</th>
                                    <th class="hidden-xs">{lang('paid_amount')}</th>    
                                    <th>{lang('status')}</th>
                                </tr>
                            </thead>
                            {if $count>0} 
                                {assign var="i" value = 0}
                                {assign var="status" value = ""}
                                {assign var="class" value = ""}
                                <tbody>
                                    {foreach from=$binary item=v}          
                                        <tr class="{$class}">{$i=$i+1}
                                            <td class="hidden-xs" >{$i} </td>                                          
                                            
                                            <td class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;{$v.paid_date}</td>
                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                            <td class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$v.paid_type}</td>
                                            
                                        </tr>
                                        
                                    {/foreach}
                                </tbody>
                            </table>
                        {else}
                            <tbody>
                                <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_income_found')}</h4></td></tr>
                            </tbody>
                            </table>
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{if $count>0} 
    <script>
        jQuery(document).ready(function () {
            Main.init();
            TableData.init();
            ValidateUser.init();
        });
    </script>
{else}
    <script>
        jQuery(document).ready(function () {
            Main.init();
            ValidateUser.init();
        });
    </script>
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}