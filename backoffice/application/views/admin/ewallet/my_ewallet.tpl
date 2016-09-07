{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('select_user_name')}</span>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{if !isset($smarty.post.ewallet_details)}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {lang('my_ewallet_details')}
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
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}<span class="symbol required"></span></label>
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
{if $ewallet_view_permission!='no'}
   
    <div id="username_val" style="display:none;">{$user_name}</div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('my_ewallet_details')}
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
                    {assign var=count value=""}
                    {assign var=i value="0"}
                    {assign var=amount value=""}
                    {assign var=date value=""}
                    {assign var=amount_type value=""}
                    {assign var=class value=""}
                    {assign var=type value=""}
                    {assign var=balance value=""}
                    {assign var=total_debit value=""}
                    {assign var=total_credit value=""}
                    {$total_debit = 0}
                    {$total_credit = 0}	
                    <center><h3>{lang('ewallet_details')} : {$user_name} </h3></center>
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('slno')}</th>
                                <th>{lang('date')}</th>
                                <th>{lang('description')}</th>
                                <th>{lang('debit')}</th>
                                <th>{lang('credit')}</th>
                                <th>{lang('balance')}</th>
                            </tr>
                        </thead>
                        {if $details_count>0}
                            <tbody>
                                {$balance = 0}
                                {foreach from=$ewallet_details item=v}
                                    {$offset = $offset + 1}
                                    {assign var=ded_type value="credit"}
                                    {$i_bal = $v.balance}
                                    {$amount = $v.total_amount}
                                    {$date = $v.date}
                                    {$amount_type = $v.amount_type}
                                    {* {if $amount_type!="admin_credit" && $amount_type!="admin_debit" && $amount_type!="user_credit" && $amount_type!="user_debit" && $amount_type!="registration"}
                                    {$view_amount_type = $v.amount_type}
                                    {/if}*}
                                    {if $amount_type == "user_credit"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type ="{lang('Transfer_From')}  $from_usr_name"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "user_debit"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type="{lang('Transfer_To')}  $from_usr_name"}
                                        {$balance = round($balance - $amount,2)}
                                        {$amount = "-"+$amount}
                                        {$ded_type = 'debit'}
                                    {else if $amount_type == "admin_debit"}
                                        {assign var=from_usr_name value= $v.from_user_name}  
                                        {assign var=tran_concept value= $v.transaction_concept}   
                                        {$type="{lang('Deducted_By')}  $from_usr_name :$tran_concept"}
                                        {$balance = round($balance - $amount,2)}
                                        {$amount = "-"+$amount}
                                        {$ded_type = 'debit'}
                                    {else if $amount_type == "admin_credit"}
                                        {assign var=from_usr_name value= $v.from_user_name}    
                                        {assign var=tran_concept value= $v.transaction_concept}    
                                        {$type="{lang('Credited_By')}  $from_usr_name :$tran_concept"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "referral"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} {lang('referal_commission')} {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                        {$amount = "+"+$amount}
                                    {else if $amount_type == "released"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('Deducted_Amount_for')} {lang('payout_release')} By $from_usr_name"}
                                        {$balance = round($balance - $amount,2)}
                                        {$amount = "-"+$amount}
                                        {$ded_type = 'debit'}
                                    {else if $amount_type == "release_comission"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('charged_fee_for_withdrawal')} {lang('payout_release')} By $from_usr_name"}
                                        {$balance = round($balance - $amount,2)}
                                        {$amount = "-"+$amount}
                                        {$ded_type = 'debit'}
                                    {else if $amount_type == "Level Commission"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} {lang('level_commission')} {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "Direct Bonus"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} Direct Bonus {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                        
                                    {else if $amount_type == "Team Bonus"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} Team Bonus {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                        
                                    {else if $amount_type == "Matching Bonus"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} Matching Bonus {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                        
                                    {else if $amount_type == "Fast Start Bonus"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} Fast Start Bonus"}
                                        {$balance = $balance + $amount}
                                        
                                    {else if $amount_type == "Diamond Pool"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} Diamond Pool"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "auto_board_1"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} {lang('lauto_board')} {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "fsb"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} FSB {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "Board Commission"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {if {$MODULE_STATUS['table_status']} eq 'no'}
                                            {$type = "{lang('board_fill_commission')}"}
                                        {else}
                                            {$type = "{lang('table_commission')}"}
                                        {/if}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "Rank Commission"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('rank_commission')}"}
                                        {$balance = $balance + $amount}
                                    {else if $amount_type == "annual_fee"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('Deducted_Amount_for')} {lang('annual_fee')} {lang('from')} $from_usr_name"}
                                        {$balance = $balance - $amount}
                                        {$ded_type = 'debit'}
                                    {else if $amount_type == "registration"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('Deducted_Amount_for')} {lang('registration_of')} $from_usr_name"}
                                        {$balance = $balance - $amount}
                                        {$ded_type = 'debit'}
                                    
                                    {else if $amount_type == "repurchase"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('Deducted_Amount_for')} {lang('package_purchase')}"}
                                        {$balance = $balance - $amount}
                                        {$ded_type = 'debit'}
                                    {else if $amount_type == "minus_credit"}
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('minus_credit')}"}
                                        {$balance = $balance + $amount}
                                    {else} 
                                        {assign var=from_usr_name value= $v.from_user_name}
                                        {$type = "{lang('You_Received')} $amount_type {lang('from')} $from_usr_name"}
                                        {$balance = $balance + $amount}
                                    {/if}
                                    {if $i%2 == 0}
                                        {$class="tr2"}
                                    {else}
                                        {$class="tr1"}
                                    {/if}		
                                    {$i = $i+1}
                                    <tr class="{$class}" align="center" >
                                        <td>{$offset}</td>
                                        <td>{$date}</td>
                                        <td>{$type}</td>
                                        {if $ded_type=='credit'}
                                            <td></td>
                                            <td class="text-left"><font color="#00581E">{$DEFAULT_SYMBOL_LEFT}{number_format($amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}
                                                </font></td>
                                            {else if $ded_type=='debit'}
                                            <td class="text-left"><font color="#f16164">{$DEFAULT_SYMBOL_LEFT}{number_format($amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</font></td>
                                            <td></td>
                                        {/if}
                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($i_bal*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                {/foreach}
                                <tr class="th">
                                    <td colspan="5" align="right"><b>Page sum </b></td>
                                    <td align="center" id=""><b>{$DEFAULT_SYMBOL_LEFT}{number_format($balance*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                                </tr>
                                <tr class="th">
                                    <td colspan="5" align="right"><b>{lang('available_amount')} </b></td>
                                    <td align="center" id=""><b>{$DEFAULT_SYMBOL_LEFT}{number_format($total*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                                </tr>
                            </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-8">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    {$links}
                                </ul>
                            </nav>
                        </div>
                    </div>
                        {else}
                            <tbody><tr><td align="center" colspan="8"><b>No Details Found</b></td></tr></tbody>
                    </table>{/if}

                </div>
            </div>
        </div>
    </div>          
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{if $details_count>0}
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
