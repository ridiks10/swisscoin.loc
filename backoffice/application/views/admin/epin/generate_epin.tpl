<span style="display:none" id="error_msg_delete">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>
<span style="display:none" id="error_msg_delete_all">{lang('sure_you_want_to_delete_all_passcode_there_is_no_undo')}</span>
<span style="display:none" id="error_msg_block">{lang('Sure_you_want_to_block_this_Passcode_There_is_NO_undo')}</span>

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('add_new_epin')}
    </div> 
    <div class="panel-body">
        {form_open('','role="form" class="smart-wizard form-horizontal" id="generate_epin" name="generate_epin" method="post"')}
        <div class="col-md-12">
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i>{lang('errors_check')}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" >{lang('number_of_epin')}: </label>
            <div class="col-sm-4" style="padding-top: 7px;">
                {$un_allocated_pin}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="product">{lang('amount')} <font color="#ff0000">*</font>:</label>
            <div class="col-sm-3">
                <select name="amount1" id="amount1"  tabindex="1" class="form-control" >
                    <option value="">{lang('select_amount')}</option>
                    {assign var=i value=0}
                    {foreach from=$amount_details item=v}                            
                        <option value="{$v.amount}">{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</option>
                        {$i = $i+1}
                    {/foreach}
                </select>
                <span class="val-error">{form_error('amount1')}</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="count">{lang('count')} <font color="#ff0000">*</font>:</label>
            <div class="col-sm-3">
                <input tabindex="2" type="text" name="count" id="count" size="20" value="" class="form-control" title=""/>
                <span class="val-error">{form_error('count')}</span>
            </div>               
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label" for="date">
                {lang('expiry_date')}:<span class="symbol required"></span>
            </label>
            <div class="col-sm-3">
                <div class="input-group">
                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="date" id="date" type="text" tabindex="3" size="20" maxlength="10"  value="" />
                    <label for="date" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>  
                </div>
                <span class="val-error">{form_error('date')}</span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-3">
                <button class="btn btn-bricky" name="addpasscode" id="addpasscode" value="{lang('add_epin')}" tabindex="4">
                    {lang('add_epin')}
                </button>
            </div>
        </div>
        {form_close()} 
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('add_new_epin')}
    </div> 
    <div class="panel-body">
        {assign var="root" value="{$BASE_URL}admin/"}

        {form_open('','name="pin_form" id="pin_form" method="post"')}
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-sm-3">
                        <input tabindex="5" type="radio" id="status_active" name="pin_status" value="active" checked {if $status=='active'}checked='1'{/if} /><label for="val"></label>{lang('active_epin')}</div>

                    <div class="col-sm-3">
                        <input tabindex="6" type="radio" name="pin_status" id="status_inactive" value="inactive" {if $status=='inactive'}checked='1'{/if} /><label for="valid"></label>{lang('inactive_epin')}
                    </div>
                    <div class="col-sm-3" style="margin-bottom: 10px;">
                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                        <button class="btn btn-bricky" type="submit" name="view_pin"  id="view_pin" value="{lang('view_epin')}" tabindex="7" title="View E-pin">{lang('refine')}</button>
                    </div>  
                </div>
            </div>
        {form_close()}
        <table class="table table-striped table-bordered table-hover table-full-width" id="">
            <thead>
                <tr class="th" align="center">
                    <th>{lang('no')}</th>
                    <th>{lang('epin')}</th>
                    <th>{lang('amount')}</th>
                    <th>{lang('bal_amount')}</th>
                    <th>{lang('allocated_user')}</th>
                    <th>{lang('status')}</th>
                    <th>{lang('uploaded_date')}</th>
                    <th>{lang('expiry_date')}</th>
                    <th width="15%">{lang('action')}</th>
                </tr>
            </thead>
            {if $count != 0}
                <tbody>                       
                    {assign var="i" value=0}
                    {assign var="pin" value=""}
                    {assign var="tr_class" value=""}
                    {assign var="pin_status" value="ACTIVE"}
                    {foreach from=$pin_numbers item=v}                        
                        {assign var="id" value="{$v.pin_id}"}
                        {if $i%2 == 0}
                            {$tr_class="tr1"}	 
                        {else}
                            {$tr_class="tr2"}
                        {/if}

                        {if $v.status == "yes"}
                            {if $v.pin_bal_amount == 0}
                                {$pin_status = "NO BALANCE"}
                                {$status = lang('no_balance')}
                            {else}
                                {$pin_status = "ACTIVE"}
                                {$status = lang('active')}
                            {/if}
                        {elseif $v.pin_bal_amount == 0}
                            {$pin_status = "NO BALANCE"}
                            {$status = lang('no_balance')}
                        {elseif $smarty.now|date_format:'%Y-%m-%d' > $v.pin_expiry_date|date_format:'%Y-%m-%d'}
                            {$pin_status = "EXPIRED"}
                            {$status = lang('expired')}
                        {elseif $v.used_user==""}
                            {$pin_status = "BLOCKED"}
                            {$status = lang('blocked')}
                        {else}
                            {$pin_status = "USED"}
                            {$status = lang('used')}
                        {/if}  

                        {$i=$i+1}

                        <tr class="{$tr_class}" align="center" >
                            <td align="center">{$i+$from}</td>
                            <td align="center">{$v.pin}</td>
                            <td align="center"> {$DEFAULT_SYMBOL_LEFT}{$v.pin_amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>
                            <td align="center"> {$DEFAULT_SYMBOL_LEFT}{$v.pin_bal_amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>
                            {if {$v.allocated_user}==""}
                                <td align="center">NA</td>
                            {else}
                                <td align="center">{$v.allocated_user}</td>
                            {/if}                          
                            <td align="center">{$status}</td>
                            <td align="center">{$v.pin_uploded_date}</td>
                            <td align="center">{$v.pin_expiry_date}</td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs buttons-widget">
                                    <!--delete PIN start-->
                                    <a href="#" onclick="javascript:delete_pin({$id}, '{$root}')"  class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete_this_epin')}">
                                        <i class="fa fa-times fa fa-white"></i>
                                    </a>
                                    <!--delete PIN end-->
                                    {if $pin_status == "ACTIVE"}
                                        <!--block PIN start-->
                                        <a href="#" onclick="javascript:block_pin({$id}, '{$root}')"  class="btn btn-primary tooltips" data-placement="top" data-original-title="{lang('block_this_epin')}">
                                            <i class="glyphicon glyphicon-remove-circle"></i>
                                        </a>
                                        <!--block PIN end-->
                                    {else}
                                        {if $smarty.now|date_format:'%Y-%m-%d' < $v.pin_expiry_date|date_format:'%Y-%m-%d'&& $v.pin_bal_amount>0}                               <a  href="#" onclick="javascript:activate_pin({$id}, '{$root}')" class="btn btn-green tooltips" data-placement="top" data-original-title="{lang('activate_this_epin')}">

                                                <span style="display:none" id="error_msg_activate">{lang('sure_you_want_to_activate_this_passcode_there_is_no_undo')}</span>
                                                <i class="glyphicon glyphicon-ok-sign"></i>
                                            </a>
                                        {/if}
                                        <!--Activate PIN end-->
                                    {/if}
                                </div>

                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                    <div class="btn-group">
                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                        </a>
                                        <ul role="menu" class="dropdown-menu pull-right">
                                            <!--delete PIN start-->
                                            <li role="presentation">
                                                <a role="menuitem"  href="#" onclick="javascript:delete_pin({$id}, '{$root}')">

                                                    <span style="display:none" id="error_msg_delete">{lang('sure_you_want_to_delete_this_passcode_there_is_no_undo')}</span>
                                                    <i class="fa fa-times fa fa-white"></i>Delete
                                                </a>
                                            </li>
                                            <!--delete PIN end-->
                                            {if $pin_status == "ACTIVE"}
                                                <!--block PIN start-->
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" href="#" onclick="javascript:block_pin({$id}, '{$root}')" >
                                                        <i class="glyphicon glyphicon-remove-circle"></i>Block
                                                    </a>
                                                </li>
                                                <!--block PIN end-->
                                            {else}
                                                <!--Activate PIN start-->
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" href="#" onclick="javascript:activate_pin({$id}, '{$root}')">

                                                        <span style="display:none" id="error_msg_activate">{lang('sure_you_want_to_activate_this_passcode_there_is_no_undo')}</span>
                                                        <i class="glyphicon glyphicon-ok-sign"></i>Activate
                                                    </a>
                                                </li>
                                                <!--Activate PIN end-->
                                            {/if}
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {/foreach}             
                </tbody> 
            {else}
                <tbody>
                    <tr><td colspan="9" align="center"><h4 align="center"> {$empty_msg}</h4></td></tr>
                </tbody>                            
            {/if} 
        </table>
        {$result_per_page}

        {if count($pin_numbers)>0}
            <div class="col-sm-2 pull-right">
                <button class="btn btn-bricky" type="button" name="delete_all_pin"  id="delete_all_pin" value="Delete All E-pin" tabindex="8" title="Delete All E-pin" onclick="javascript:delete_all_epin('{$root}', '{$status}', '{$from}');">{lang('delete_all_epin')}</button> 
            </div>
        {/if}
    </div>
</div>
