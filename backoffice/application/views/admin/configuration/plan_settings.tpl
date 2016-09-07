{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_pay_out_pair_price')}</span>
    <span id="validate_msg2">{lang('tran_you_must_enter_celing_amount')}</span>
    <span id="validate_msg3">{lang('you_must_enter_service_charge')}</span>
    <span id="validate_msg4">{lang('you_must_enter_tds_value')}</span>
    <span id="validate_msg5">{lang('you_must_enter_product_point_value')}</span>
    <span id="validate_msg6">{lang('you_must_enter_referal_amount')}</span>
    <span id="validate_msg7">{lang('you_must_enter_a_valid_pay_out_price')}</span>  
    <span id="validate_msg11">{lang('need_rank_days')}</span>
    <span id="pair_ceiling_pv_span">{lang('pair_cieling_pv')}</span>
    <span id="pair_ceiling_count_span">{lang('pair_cieling_count')}</span>
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('plan_setting')}
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
                {form_open('admin/configuration/confirm_plan_update','role="form" class="smart-wizard form-horizontal" name= "form_setting"  id="form_setting"')}

                <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0"/>

                <div id="binary" name="binary" style="display: {if $MLM_PLAN == "Binary"} block {else} none {/if};" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="pair_ceiling_type">{lang('pair_ceiling_type')}: </label>
                        <div class="col-sm-3">
                            <select class="form-control" onchange="change_pair_ceiling_visibility(this.value);" name ="pair_ceiling_type"  id ="pair_ceiling_type" tabindex="1" title="{lang('pair_ceiling_type')}">
                                <option value="none" {if $obj_arr["pair_ceiling_type"]=='none'} selected="true"{/if}>{lang('none')}</option>
                                <option value="daily" {if $obj_arr["pair_ceiling_type"]=='daily'} selected="true"{/if}>{lang('daily')}</option>
                                <option value="weekly" {if $obj_arr["pair_ceiling_type"]=='weekly'} selected="true"{/if}>{lang('weekly')}</option>
                                <option value="monthly" {if $obj_arr["pair_ceiling_type"]=='monthly'} selected="true"{/if}>{lang('monthly')}</option>
                            </select>
                        </div>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group" id ='pair_ceiling_div' {if $obj_arr["pair_ceiling_type"] == 'none'} style="display: none;" {/if}>

                        <label id="pair_ceiling_pv_label" {if $obj_arr["pair_commission_type"] == "flat"} style="display:none;"{/if} class="col-sm-2 control-label" for="pair_ceiling">{lang('pair_ceiling_pv')}: </label>
                        <label id="pair_ceiling_count_label" {if $obj_arr["pair_commission_type"] == "percentage"} style="display:none;"{/if} class="col-sm-2 control-label" for="pair_ceiling">{lang('pair_ceiling_count')}: </label>

                        <div class="col-sm-3">
                            <input type="text" tabindex="2" name ="pair_ceiling" id ="pair_ceiling" value="{$obj_arr["pair_ceiling"]}" min="1" title="">
                            <span id="errmsg8"></span>
                        </div>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group" id ='pair_value_div' {if $obj_arr["pair_commission_type"] == 'percentage'} style="display: none" {/if}>
                        <label class="col-sm-2 control-label" for="pair_value">{lang('pair_value')}: </label>
                        <div class="col-sm-3">
                            <input type="text" tabindex="3" name ="pair_value" id ="pair_value" value="{$obj_arr["pair_value"]}" title="">
                            <span id="errmsg9"></span>
                        </div>
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group" style="display:{if $MODULE_STATUS['product_status'] == "no"} block{else} none{/if};">
                        <label class="col-sm-2 control-label" for="product_point_value">{lang('product_point_value')}: </label>
                        <div class="col-sm-3">
                            <input type="text" tabindex="4" name ="product_point_value" id ="product_point_value" value="{$obj_arr["product_point_value"]}" min="1" title="">
                            <span id="errmsg13"></span>
                        </div>
                        <span class="help-block"></span>
                    </div>
                </div>

                {if $MLM_PLAN == "Board"}
                    <input type="hidden" id="board_count" name="board_count" value="{$board_count}">
                    <input type="hidden" id="err_span" name="err_span">
                    {assign var="display_status" value="block"}
                    {assign var="i" value="0"}
                    {foreach from=$obj_arr_board item=v}
                        <div id="board{$i}" name="board{$i}" style="display: {$display_status};">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="board{$i}_name">
                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                        {sprintf(lang('board1_name'), $i + 1)}:
                                    {else}
                                        {sprintf(lang('table_name'), $i + 1)}:
                                    {/if}
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="no-special" tabindex="5" name ="board{$i}_name" id ="board{$i}_name" value="{$obj_arr_board[$i]["board_name"]}" title="">
                                    <span id="board{$i}_name_err"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="board{$i}_width">
                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                        {sprintf(lang('board1_width'), $i + 1)}:
                                    {else}
                                        {sprintf(lang('table_width'), $i + 1)}:
                                    {/if}
                                    </label>
                                <div class="col-sm-3">
                                    <input type="text" class="no-text" tabindex="6" name ="board{$i}_width" id ="board{$i}_width" value="{$obj_arr_board[$i]["board_width"]}" maxlength="1" title="" onblur="set_cleanup_flag({$obj_arr_board[$i]["board_width"]}, this.value);">
                                    <span id="board{$i}_width_err"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="board{$i}_depth">
                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                        {sprintf(lang('board1_depth'), $i + 1)}:  
                                    {else}
                                        {sprintf(lang('table_depth'), $i + 1)}:  
                                    {/if}
                                </label>
                                <div class="col-sm-3">
                                    <input type="text" class="no-text" tabindex="7" name ="board{$i}_depth" id ="board{$i}_depth" value="{$obj_arr_board[$i]["board_depth"]}" maxlength="1" title="" onblur="set_cleanup_flag({$obj_arr_board[$i]["board_depth"]}, this.value);">
                                    <span id="board{$i}_depth_err"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="board{$i}_sponsor_follow_status">
                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                        {sprintf(lang('board1_sponsor_follow_status'), $i + 1)}: 
                                    {else}
                                        {sprintf(lang('table_sponsor_follow_status'), $i + 1)}: 
                                    {/if}
                                    </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name ="board{$i}_sponsor_follow_status"  id ="board{$i}_sponsor_follow_status" tabindex="8" title="{lang('board1_sponsor_follow_status')}">
                                        <option value="yes" {if $obj_arr_board[$i]["sponser_follow_status"]=='yes'} selected="true"{/if}>{lang('yes')}</option>
                                        <option value="no" {if $obj_arr_board[$i]["sponser_follow_status"]=='no'} selected="true"{/if}>{lang('no')}</option>
                                    </select>
                                    <span id="errmsg6"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="board{$i}_reentry_status">
                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                        {sprintf(lang('board1_reentry_status'), $i + 1)}:  
                                    {else}
                                        {sprintf(lang('table_reentry_status'), $i + 1)}:  
                                    {/if}
                                    </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name ="board{$i}_reentry_status"  id ="board{$i}_reentry_status" tabindex="9" title="{lang('board1_reentry_status')}">
                                        <option value="yes" {if $obj_arr_board[$i]["re_entry_status"]=='yes'} selected="true"{/if}>{lang('yes')}</option>
                                        <option value="no" {if $obj_arr_board[$i]["re_entry_status"]=='no'} selected="true"{/if}>{lang('no')}</option>
                                    </select>
                                    <span id="errmsg6"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="board{$i}_reentry_to_next_status">
                                    {if {$MODULE_STATUS['table_status']} eq 'no'}
                                        {sprintf(lang('board1_reentry_to_next_status'), $i + 1)}:
                                    {else}
                                        {sprintf(lang('table_reentry_to_next_status'), $i + 1)}:
                                    {/if}
                                    </label>
                                <div class="col-sm-3">
                                    <select class="form-control" name ="board{$i}_reentry_to_next_status"  id ="board{$i}_reentry_to_next_status" tabindex="10" title="{lang('board1_reentry_to_next_status')}" onchange="changeBoardVisibility(this.value, {$i});
                                            set_cleanup_flag({$obj_arr_board[$i]["board_width"]}, this.value);">
                                        <option value="yes" {if $obj_arr_board[$i]["re_entry_to_next_status"]=='yes'} selected="true"{/if}>{lang('yes')}</option>
                                        <option value="no" {if $obj_arr_board[$i]["re_entry_to_next_status"]=='no'} selected="true"{/if}>{lang('no')}</option>
                                    </select>
                                    <span id="errmsg6"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>

                        </div>
                        {if $obj_arr_board[$i]["re_entry_to_next_status"] eq 'no'}
                            {$display_status = 'none'}
                        {/if}
                        {$i = $i + 1}
                    {/foreach}
                {/if}

                {if  $MLM_PLAN=='Unilevel' && $MODULE_STATUS['sponsor_commission_status'] == "yes"}
                    <div class="form-group">                        
                        <label class="col-sm-2 control-label" for="depth_ceiling">{if $MLM_PLAN=="Board"} {lang('depth_ceiling_board')} {else} {lang('depth_ceiling')} {/if}: </label>
                        <div class="col-sm-3">
                            <input type="text" tabindex="17" name ="depth_ceiling" id ="depth_ceiling" value="{$obj_arr["depth_ceiling"]}" maxlength="2" {*{if $MLM_PLAN == 'Matrix'}onblur="set_cleanup_flag({$obj_arr["depth_ceiling"]}, this.value);" {/if}*}>{form_error('depth_ceiling')}
                            <span id="errmsg10"></span>
                        </div> 
                        <span class="help-block"></span>
                    </div>
                {/if}

                <div id="matrix" name="matrix" style="display:{if $MLM_PLAN == "Matrix"} block{else} none{/if};">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="width_ceiling">{lang('width_ceiling')}: </label>
                        <div class="col-sm-3">
                            <input type="text" tabindex="18" name ="width_ceiling" id ="width_ceiling" value="{$obj_arr["width_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["width_ceiling"]}, this.value);">{form_error('width_ceiling')}
                            <span id="errmsg12"></span>
                        </div>
                        <span class="help-block"></span>
                    </div>
                            
                    {* <div class="form-group">                        
                        <label class="col-sm-2 control-label" for="depth_ceiling">{if $MLM_PLAN=="Board"} {lang('depth_ceiling_board')} {else} {lang('depth_ceiling')} {/if}: </label>
                        <div class="col-sm-3">
                            <input type="text" tabindex="17" name ="depth_ceiling" id ="depth_ceiling" value="{$obj_arr["depth_ceiling"]}" maxlength="2" {if $MLM_PLAN == 'Matrix'}onblur="set_cleanup_flag({$obj_arr["depth_ceiling"]}, this.value);" {/if}>{form_error('depth_ceiling')}
                            <span id="errmsg10"></span>
                        </div> 
                        <span class="help-block"></span>
                    </div>      *}  
                            
                            
                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky"  type="button" value="{lang('update')}" tabindex="19" name="setting" id="setting" title="{lang('update')}" onclick="checkPlanVariables();">{lang('update')}</button>
                    </div>
                </div>
                {form_close()}
                {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Board'}
                    <font style="padding-left: 20px;" color="red">{lang('update_plan_confirm_msg')} </font>
                    <br>
                    <br>
                {/if}
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();

    {for $i=0 to {$board_count} step +1}
        $("#board{$i}_width").keypress(function(e)
        {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
            {
                $("#board{$i}_width_err").html('{lang('digit_only')}').show().fadeOut(1200, 0);
                return false;
            }
        });
        
        $("#board{$i}_depth").keypress(function(e)
        {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
            {
                $("#board{$i}_depth_err").html('{lang('digit_only')}').show().fadeOut(1200, 0);
                return false;
            }
        });
        
        $("#board{$i}_name").keypress(function(e)
        {
            var flag = /[a-z0-9 ]/i.test(
                   String.fromCharCode(e.charCode || e.keyCode)
               ) || !e.charCode && e.keyCode  < 48;
            if(!flag) {
                $("#board{$i}_name_err").html('{lang('characters_only')}').show().fadeOut(1200, 0);
                return false;
            }
        });
    {/for}
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}