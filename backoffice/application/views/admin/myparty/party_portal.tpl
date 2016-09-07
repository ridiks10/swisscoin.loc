{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg_delete">{lang('are_you_sure_want_to_close_this_party')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('my_party_portal')}
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

                    {lang('you_may_use')}

                </div>
            </div>
        </div>
    </div>
</div>
{form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"   name="party_portal" id="party_portal"')}

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i> {lang('step')} {lang('one')} :  {lang('select_a_party_to_view')}
                    </div>
                    <div class="panel-body" style=" overflow: scroll;height: 188px;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="party_no">
                                {lang('party_name')}:
                            </label>
                            <div class="col-sm-6">
                                <select name="party_no" id="party_no" onChange="setSessionPartyId(this.value)" class="form-control" style="width: 250px;">
                                    {if $count==0}
                                        <option value="">{lang('select_party')}</option>
                                        {foreach from=$party_available item=v}
                                            {if $v.status=='open'}
                                                <option value="{$v.id}">{$v.status}{"  "}-{"  "}{$v.id}{"  "}-{"  "}{$v.party_name}-{"  "}{"  "}-{"  "}{$v.from_date}-{"  "}{$v.host_name}</option>
                                            {else}
                                                <option style="color: red;" value="{$v.id}">{$v.status}{"  "}-{"  "}{$v.id}{"  "}-{"  "}{$v.party_name}{"  "}-{"  "}{$v.from_date}-{"  "}{$v.host_name}</option>
                                            {/if}
                                        {/foreach}
                                    {else}
                                        {if $selected_party.status=='open'}
                                            <option style="color: black;" value="{$party}">{$selected_party.status}{""}-{""}{$selected_party.id}{""}-{""}{$selected_party.party_name}{""}-{""}{$selected_party.from_date}{""}-{""}{$selected_party.host_name}{""}</option> 
                                        {else}

                                            <option style="color: red;" value="{$party}">{$selected_party.status}{""}-{""}{$selected_party.id}{""}-{""}{$selected_party.party_name}{""}-{""}{$selected_party.from_date}{""}-{""}{$selected_party.host_name}{""}</option>                                 
                                        {/if}
                                        <option style="color: black;" value="">----Select Party----</option>
                                        {foreach from=$party_available item=v}
                                            {if $v.status=='open'}
                                                {if $party!=$v.id}                               
                                                    <option style="color: black;" value="{$v.id}">{$v.status}{"  "}-{"  "}{$v.id}{"  "}-{"  "}{$v.party_name}{"  "}-{"  "}{$v.from_date}-{"  "}{$v.host_name}</option>
                                                {/if}
                                            {else}
                                                {if $party!=$v.id}   
                                                    <option style="color: red;" value="{$v.id}">{$v.status}{"  "}-{"  "}{$v.id}{"  "}-{"  "}{$v.party_name}{"  "}-{"  "}{$v.from_date}-{"  "}{$v.host_name}</option>
                                                {/if}
                                            {/if} 
                                        {/foreach}
                                    {/if}
                                    {if $selected_party.status=="closed"}
                                    </select>
                                    <span id="notice" style="color:#0aa;font-size: 13px;">
                                        {lang('the_selected_party_is_closed')} !!!
                                    </span>
                                {/if}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="button" name="proceed" id="proceed" class="btn btn-bricky" value="{lang(proceed)}"  onClick="viewAllStepsParty()" style="margin-left: 85px; margin-top: 20px;">                        
                            </div>
                        </div>

                        {if $count>0}

                            <div id="party_start_end_date" >
                                <span style="margin-left: 61px;color: #ac2b26"><b>{lang('start_dates')} {$selected_party.from_date} {$selected_party.from_time}</b></span></br>
                                <span style="margin-left: 61px;color: #ac2b26"><b>{lang('end_dates')}{$selected_party.to_date} {$selected_party.to_time}</b></span>
                            </div>

                        {/if}

                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>   {lang('set_up_a_new_party')} 
                    </div>
                    <div class="panel-body">


                        <div class="form-group" align="center">
                            <div class="col-sm-3">
                                <a href="../party_setup/create_party"><input type="button" name="new_party" id="new_party" class="btn btn-bricky" value="{lang('new_party')}" style="margin-top: 50px; margin-left: 144px; margin-bottom: 57px;display: none;" ></a>
                                <a href="../party_setup/create_party"><input type="button" name="new_party" id="new_party" class="btn btn-bricky" value="{lang('new_party')}" style="margin-top: 50px; margin-left: 144px; margin-bottom: 57px;" ></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="party_details" style="display: none">              

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>{lang('step')} {lang('two')}:{lang('add_guests_and_manage_evites')}
                    </div>
                    <div class="panel-body">
                        <center><h4>{lang('guests_added')} </h4></center>

                        <table id="grid" class="table table-striped table-bordered table-hover table-full-width">

                            <thead>
                                <tr class="th">
                                    <th>{lang('no')}</th>
                                    <th>{lang('guest_name')}</th>
                                    <th>{lang('guest_email')}</th>
                                    <th>{lang('guest_phone')}</th>
                                </tr>
                            </thead>
                            <tbody>

                                {foreach from=$guest_data item=v}
                                    <tr>
                                        <td>{counter}</td>
                                        <td>{$v.name}</td>
                                        <td>{$v.email}</td>
                                        <td>{$v.phone}</td>
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                        <div class="pull-right">  
                            {if $count!=0 && $selected_party.status!="closed"}
                                <a href="../party/invite_guest"><input type="button" name="invite" id="invite" class="btn btn-bricky" value="{lang('add_another_guest')}" ></a>
                                {/if}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>{lang('step')}{lang('three')} : {lang('enter_the_party_orders_into_a_batch')}

                    </div>
                    <div class="panel-body">


                        <center><h4>{lang('batch_orders')} </h4></center>
                            {if $count!=0 && $selected_party.status!="closed"}

                            <div class="pull-right" >
                                <a href="../party_guest_order/guest_orders"><input type="button" name="new_order" id="new_order" value="{lang('enter_order_now')}" class="btn btn-bricky"></a>
                            </div>
                            <br>
                            <br>

                        {/if}
                        <b>{lang('unprocessed_orders')}</b>
                        <table align="center" class="table table-striped table-bordered table-hover table-full-width">
                            <thead>
                                <tr class="th">
                                    <th>{lang('no')}</th>
                                    <th>{lang('select')}</th>
                                    <th>{lang('guest_name')}</th>
                                    <th>{lang('count')}</th>
                                    <th>{lang('price')}</th>
                                    <th>{lang('edit_order')}</th>
                                </tr>
                            </thead>
                            {$i=1}
                            {if count($unpro_order)!=""}
                                <tbody>
                                    {assign var="path" value="{$BASE_URL}admin/"}
                                    {assign var="tot_count_un" value=0}
                                    {assign var="tot_amount_un" value=0}
                                    {foreach from=$unpro_order item=v}
                                        <tr>
                                            <td>{$i}</td>
                                            <td>
                                                <input type = 'checkbox' name = 'select{$i}' value= 'yes'  id ='select{$i}'>
                                                <label for="select{$i}"></label>
                                                <input type="hidden" name="party_id{$i}" id="party_id{$i}" value="{$v.party_id}"/>
                                                <input type="hidden" name="guest_id{$i}" id="guest_id{$i}" value="{$v.guest_id}"/>
                                            </td>
                                            <td>{$v.guest_name}</td>
                                            <td>{$v.count}</td>
                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}<input type="hidden" name="total_amount{$i}" id="total_amount{$i}" value="{$v.total_amount}"/></td>
                                            <td><a href="javascript:edit_order({$v.guest_id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                        {$i=$i+1}
                                        {$tot_count_un=$tot_count_un+$v.count}
                                        {$tot_amount_un=$tot_amount_un+$v.total_amount}
                                    {/foreach}
                                    <tr>
                                        <td></td><td></td><td><b>{lang('total')}</b></td><td><b>{lang('count')}:{$tot_count_un}</b></td><td><b>{lang('price')}:{$DEFAULT_SYMBOL_LEFT}{number_format($tot_amount_un*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td><td></td>
                                    </tr>
                                </tbody>
                            {else}       
                                <tr>
                                    <td colspan="6"> {lang('no_unprocessed_orders')} !!!</td>
                                </tr>
                            {/if}        
                        </table>
                        {if count($unpro_order)!=""}
                            <input type="hidden" name="count" id="count" value="{$i}"/>
                            <input type="submit" name="process" id="process" value="{lang('process_selected_order_now')}" class="btn btn-bricky"/>
                        {/if}
                        <label><b>{lang('processed_orders')}</b></label>
                        <table class="table table-striped table-bordered table-hover table-full-width">
                            <thead>
                                <tr class="th">
                                    <th>{lang('no')}</th>
                                    <th>{lang('guest_name')}</th>
                                    <th>{lang('count')}</th>
                                    <th>{lang('price')}</th>
                                    <th>{lang('view_order')}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {if count($pro_order)!=""}
                                    {$i=1}
                                    {assign var="tot_count" value=0}
                                    {assign var="tot_amount" value=0}
                                    {foreach from=$pro_order item=v}
                                        <tr>
                                            <td>{$i}</td>
                                            <td>{$v.guest_name}</td>
                                            <td>{$v.count}</td>
                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>               
                                            <td>
                                                <a href="../party_guest_order/view_order/{$v.guest_id}"> 
                                                    <input type="button" value="{lang('view')}" class="btn btn-bricky"> 
                                                </a>
                                            </td>               
                                        </tr>
                                        {$i=$i+1}
                                        {$tot_count=$tot_count+$v.count}
                                        {$tot_amount=$tot_amount+$v.total_amount}
                                    {/foreach}
                                    <tr>
                                        <td></td><td><b>{lang('total')}</b></td><td><b>{lang('count')}:{$tot_count}</b></td><td><b>{lang('price')}:{$DEFAULT_SYMBOL_LEFT}{number_format($tot_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td><td></td>
                                    </tr>

                                {else}
                                    <tr>
                                        <td colspan="5">{lang('no_processed_orders')} !!!</td>
                                    </tr>
                                {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>{lang('step')}{lang('four')} :{lang('close_the_party')}
                    </div>
                    <div class="panel-body">
                        {lang('when_all_steps_have_been_completed')}
                        <div class="form-group">
                            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin">

                            {if $count!=0 && $selected_party.status!="closed"}
                                <div class="col-sm-2 col-sm-offset-2">
                                    <a href="javascript:confirmClose({$party})"> <input type="button" name="close_party" class="btn btn-bricky" id="close_party" value="{lang('close_party')}" ></a>
                                    {/if}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{form_close()}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}