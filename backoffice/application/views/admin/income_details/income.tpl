{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('select_user_id')}</span>        
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{if !isset($smarty.post.income_details_view)}
    <div class="row" >
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('select_user')} 
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
                    {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">{lang('select_user_id')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <input placeholder="{lang('type_members_name')}" class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" >

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" type="submit" id="profile_update" value="profile_update" name="profile_update" tabindex="2">
                                    {lang('view')}
                                </button>
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}
<!-- end: PAGE CONTENT -->
{if isset($smarty.post.user_name) && $is_valid_username}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$user_name}</div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
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
                    {lang('income_details')} : {$user_name}
                </div>
                <div class="panel-body">
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="feedback_form" id="feedback_form"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        {assign var=i value="0"}
                        {assign var=class value=""}
                        <center><h3>{lang('income_details')} : {$user_name} </h3></center>
                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                            <thead>
                                <tr class="th" align="center">
                                    <th>{lang('no')}</th>
                                    <th>{lang('from')}</th>
                                    <th>{lang('level')}</th>
                                    <th>{lang('amount_type')}</th>
                                    <th>{lang('amount')}</th>
                                </tr>
                            </thead>
                            {if count($amount)>0}
                                <tbody>
                                    {foreach from=$amount item=v}
                                        {if $i%2 == 0}
                                            {$class="tr2"}
                                        {else}
                                            {$class="tr1"}
                                        {/if}		
                                        {$i = $i+1}
                                        {if $v.amount_type == 'leg'}
                                            {$v.amount_type = lang('binary')}
                                        {/if}
                                        <tr class="{$class}" align="center" >
                                            <td>{$i}</td>
                                            <td>{$v.from_id}</td>
                                            <td>{$v.user_level}</td>
                                            <td>
                                                {if $v.amount_type eq 'Pin Purchased'}
                                                    {lang('pin_purchased')}
                                                {elseif $v.amount_type eq 'Payout Released'}
                                                    {lang('payout_released')}
                                                {elseif $v.amount_type eq 'Referral commission'}
                                                    {lang('referral_commission')}
                                                {elseif $v.amount_type eq 'Binary Commission'}
                                                    {lang('binary_commission')}
                                                {elseif $v.amount_type eq 'Rank Commission'}
                                                    {lang('rank_commission')}
                                                {elseif $v.amount_type eq 'Level Commission'}
                                                    {lang('level_commission')}
                                                {elseif $v.amount_type eq 'Level Commission by Repurchase'}
                                                    {lang('level_commission_by_repurchase')}
                                                {elseif $v.amount_type eq 'Binary Commission by Repurchase'}
                                                    {lang('binary_commission_by_repurchase')}
                                                {elseif $v.amount_type eq 'Board Commission'}
                                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                                        {lang('board_commission')}
                                                    {else}
                                                        {lang('table_commission')}
                                                    {/if}
                                                {/if}
                                            </td>
                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                        </tr>
                                    {/foreach}
                                    <tr><td><td colspan="3" style="text-align: right"><b>{lang('amount_total')}</b></td><td style="text-align: center"><b>{$DEFAULT_SYMBOL_LEFT}{number_format($v.tot_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td></tr>
                                </tbody>

                            {else}
                                {if $is_valid_username}
                                    <tbody>
                                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_income_details_were_found')}</h4></td></tr>
                                    </tbody>
                                {else}
                                    <tbody>
                                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('username_not_exists')}</h4></td></tr>
                                    </tbody>
                                {/if}

                            {/if}
                        </table>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>  
{/if}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}