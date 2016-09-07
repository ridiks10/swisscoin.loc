{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{if !isset($smarty.post.leg_count_view)}
    <div class="row" >
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('leg_count')}
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-refresh" href="#">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <a class="btn btn-xs btn-link panel-expand" href="#">
                            <i class="fa fa-resize-full"></i>
                        </a>
                        {*<a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                        </a>*}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">                   
                        <div class="panel-body">
                            {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal" name="legcount" id="legcount" method="post"')}
                                <div class="col-md-12">
                                    <div class="errorHandler alert alert-danger no-display">
                                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="user_name"> {lang('select_user_name')}<font color="#ff0000" >*</font> </label>
                                    <div class="col-sm-3">
                                        <input  name="user_name" id="user_name" type="text" size="30" onkeyup="ajax_showOptions(this, 'getCountriesByLetter', 'no', event)" autocomplete="off" tabindex="1">
                                        <span class="help-block" for="user_name"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <button class="btn btn-bricky" type="submit" id="leg_count" value="leg_count" name="leg_count" tabindex="2">
                                            {lang('view')}
                                        </button>
                                    </div>
                                </div>
                            {form_close()}
                        </div>

                    </div>
                </div>
                {*///////////////////////////////////////////*}
            </div>
        </div>
    </div>
{/if}
{if isset($smarty.post.user_name)}
    <div id="user_account"></div>
    {if $legcount}
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    {if $legcount}
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('leg_count')}
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
                        <div class="row">
                            <div class="col-sm-12"><div class="center">
                                    {if !$is_valid_username}
                                        <h4 align="center"><font color="#FF0000">{lang('Username_not_Exists')}</font></h4>
                                        {else}
                                        <h4>{lang('leg_count')}  : {$user_name}</h4>
                                        <div id="username_val" style="display:none;">{$user_name}</div>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                            <thead>
                                                <tr class="th" align="center">
                                                <tr class="th"> 
                                                    <th>{lang('no')}</th>
                                                    <th>{lang('userid_fullname')}</th>
                                                    <th>{lang('left_point')}</th>
                                                    <th>{lang('right_point')}</th>
                                                    <th>{lang('left_carry')}</th>
                                                    <th>{lang('right_carry')}</th>
                                                    <th>{lang('total_pair')}</th>
                                                    <th><b>{lang('amount')}</b></th>
                                                </tr>
                                            </thead>
                                            {if count($user_leg_detail)!=0}
                                                {assign var="left_leg_tot" value ="0"}
                                                {assign var="right_leg_tot" value ="0"}
                                                {assign var="left_carry_tot" value ="0"}
                                                {assign var="right_carry_tot" value ="0"}
                                                {assign var="total_leg_tot" value ="0"}
                                                {assign var="total_leg_tot" value ="0"}
                                                {assign var="total_amount_tot" value ="0"}
                                                {assign var="k" value ="0"}
                                                {assign var="class" value =""}
                                                <tbody align="center">
                                                    {foreach from=$user_leg_detail item=v}
                                                        {assign var="left" value ="{$v.left}"}
                                                        {assign var="right" value ="{$v.right}"}
                                                        {assign var="left_carry" value ="{$v.left_carry}"}
                                                        {assign var="right_carry" value ="{$v.right_carry}"}
                                                        {assign var="tot_leg" value ="{$v.total_leg}"}
                                                        {assign var="tot_amt" value ="{$v.total_amount}"}
                                                        {$left_leg_tot = $left_leg_tot+$left}
                                                        {$right_leg_tot = $right_leg_tot+$right}
                                                        {$left_carry_tot = $left_carry_tot+$left_carry}
                                                        {$right_carry_tot = $right_carry_tot+$right_carry}
                                                        {$total_leg_tot = $total_leg_tot+$tot_leg}
                                                        {$total_amount_tot =$total_amount_tot+ $tot_amt}

                                                        {if $k%2==0}
                                                            {$class='tr1'}
                                                        {else}
                                                            {$class='tr2'}
                                                        {/if}
                                                        <tr>
                                                            <td>{$k}</td>
                                                            <td>{$v.user}-{$v.detail}</td>
                                                            <td>{$left}</td>
                                                            <td>{$right}</td>
                                                            <td>{$left_carry}</td>
                                                            <td>{$right_carry}</td>
                                                            <td>{$tot_leg}</td>
                                                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($tot_amt*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                        </tr>
                                                        {$k=$k+1}
                                                    {/foreach}
                                                    <tr class="{$class}" align="center" >
                                                        <td><b></b></td>
                                                        <td><b>{lang('total')}</b></td>
                                                        <td><b>{$left_leg_tot}</b></td>
                                                        <td><b>{$right_leg_tot}</b></td>
                                                        <td><b>{$left_carry_tot}</b></td>
                                                        <td><b>{$right_carry_tot}</b></td>
                                                        <td><b>{$total_leg_tot}</b></td>
                                                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($total_amount_tot*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                                                    </tr>
                                                </tbody>
                                            {else}
                                               <tbody><tr><td align="center" colspan="8"><b>{lang('No_Leg_Count_Found')}</b></td></tr></tbody> 
                                            {/if}          
                                        </table>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {/if}
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        //TableData.init();alert('hi');

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}