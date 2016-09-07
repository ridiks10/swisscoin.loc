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
</div>

<!-- start: PAGE CONTENT -->
<div class="row">
    <div class="col-sm-12">
        {form_open('','role="form" class="smart-wizard form-horizontal" name= "form_setting"  id="form_setting"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <div class="col-md-12">
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
            </div>
        </div>
        <div class="tabbable">
            <ul class="nav nav-tabs tab-green">
                <li class="{$tab2}">
                    <a href="#panel_tab3_example2" data-toggle="tab">{lang('commission_setting')}</a>
                </li>
                {if $MODULE_STATUS['referal_status']=="yes"}
                    <li class="{$tab3}"><a href="#panel_tab3_example3" data-toggle="tab">{lang('referal_amount')}</a>
                    </li>
                {/if}
                {if $MODULE_STATUS['opencart_status_demo']=="no"}
                    <li class="{$tab4}">
                        <a href="#panel_tab3_example4" data-toggle="tab">{lang('registration_amount')}</a>
                    </li>
                {/if}
                <li class="{$tab5}">
                    <a href="#panel_tab3_example5" data-toggle="tab">{lang('tax_setting')}</a>
                </li>

                <li class="{$tab6}">
                    <a href="#panel_tab3_example6" data-toggle="tab">{lang('transaction_fee')}</a>
                </li>
            </ul>

            <div class="tab-content">
                <input type="hidden" name="active_tab" id="active_tab" value="" >
                <div class="tab-pane{$tab2}" id="panel_tab3_example2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('commission_setting')}
                        </div>

                        <div class="panel-body">
                            {if $MLM_PLAN=="Binary"}
                                {if $obj_arr["pair_commission_type"] == "flat"}
                                    {$flat = 'checked="true"'}
                                    {$percent = ""}
                                {else}
                                    {$flat = ""}
                                    {$percent = 'checked="true"'}
                                {/if}

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="pair_commission_type" >{lang('type_of_commission')}: </label>
                                    <div class="col-sm-3">
                                        <input tabindex="20" onchange="change_pair_value_visibility(this.value);" type = 'Radio' Name ='pair_commission_type' id='pair_commission_type1' value= 'percentage'{$percent} title=""><label for="pair_commission_type"></label>{lang('percentage')}
                                        <input tabindex="21" onchange="change_pair_value_visibility(this.value);" type = 'Radio' Name ='pair_commission_type' id='pair_commission_type2' value= 'flat' {$flat} title="" ><label for="pair_commission_type2"></label>{lang('flat')}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="pair_price">
                                        <span id="pair_title">{lang('pair_price')}</span>
                                        <span class="span_pair_commission">{if $obj_arr["pair_commission_type"] == "percentage"}%{/if}</span>
                                        :
                                        <font color="#ff0000">*</font> </label>

                                    <div class="col-sm-3">
                                        <input type="text" name ="pair_price"  id ="pair_price" value="{number_format($obj_arr["pair_price"],2)}" tabindex="22">
                                        <span id="errmsg11"></span>
                                    </div>
                                </div>

                            {else if $MLM_PLAN=="Board"}
                                {assign var="display_status" value="block"}
                                {assign var="i" value="0"}
                                {foreach from=$obj_arr_board item=v}
                                    <div class="form-group" style="display: {$display_status};">
                                        <label class="col-sm-2 control-label" for="board1_commission">
                                            {if $MODULE_STATUS['table_status'] eq 'no'}
                                                {sprintf(lang('board1_commission'), $i + 1)}:
                                            {else}
                                                {sprintf(lang('table_commission'), $i + 1)}:
                                            {/if}
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="text" tabindex="23" name ="board{$i}_commission" id ="board{$i}_commission" value="{$obj_arr_board[$i]["board_commission"]}" >
                                            <span id="errmsg4"></span>
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                    {if $obj_arr_board[$i]["re_entry_to_next_status"] eq 'no'}
                                        {$display_status = 'none'}
                                    {/if}
                                    {$i = $i + 1}     
                                {/foreach}
                            {/if}

                            {if $MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes" }
                                <h3>{lang('level_commission')}</h3>

                                {if $obj_arr["level_commission_type"] == "flat"}
                                    {$flat = 'checked="true"'}
                                    {$percent = ""}
                                {else}
                                    {$flat = ""}
                                    {$percent = 'checked="true"'}
                                {/if}



                                <div class="form-group">

                                    <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
                                    <label class="col-sm-2 control-label" style="width:20%;" >{lang('type_of_commission')}: </label>
                                    <div class="col-sm-3">
                                        <input tabindex="25" type = 'Radio' name ='level_commission_type' id='level_commission_type1' value= 'percentage' {$percent} title="" onchange="change_level_commission_type(this.value);"><label for="level_commission_type1"></label>{lang('percentage')}
                                        <input tabindex="26" type = 'Radio' name ='level_commission_type' id='level_commission_type2' value= 'flat' {$flat} title="" onchange="change_level_commission_type(this.value);"><label for="level_commission_type2"></label>{lang('flat')}
                                    </div>
                                </div>

                                {$level_count = count($arr_level)}
                                {assign var=level value="0"}
                                {foreach from=$arr_level item=v}  
                                    {if $level < $obj_arr['depth_ceiling']}
                                        {$level = $level + 1}
                                        {$levl_perc = $v} 
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" style="width:20%;" for="level_per">                                                            
                                                {lang('level')} {$level} {lang('commission')}
                                                <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span>
                                                :
                                            </label>
                                            <div class="col-sm-3">
                                                <input tabindex="27" type="number" class="level_percentage" name ="level_percentage{$level}"  id ="level_per{$level}" value="{$levl_perc}" title=" "min="0" >
                                                <span id="errmsg4"></span>
                                            </div>
                                        </div>
                                    {/if}
                                {/foreach}               
                                <input type='hidden' name='level_count' id='level_count' value='{$level_count}'>

                            {/if}
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="28" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab3');">{lang('update')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

                {if $MODULE_STATUS['referal_status']=="yes"}
                    <div class="tab-pane{$tab3}" id="panel_tab3_example3">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>{lang('referal_amount')}
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="referal_amount">{lang('referal_amount')}:</label>
                                    <div class="col-sm-4">
                                        {$DEFAULT_SYMBOL_LEFT}
                                        <input tabindex="29" type="text" name="referal_amount" id="referal_amount" title="" value="{number_format($obj_arr["referal_amount"],2)}"/>{form_error('referal_amount')}
                                        <span id="errmsg6"></span>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="30" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab3')">{lang('update')}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}

                {if $MODULE_STATUS['opencart_status_demo'] == "no"}
                    <div class="tab-pane{$tab4}" id="panel_tab3_example4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-external-link-square"></i>{lang('registration_amount')}
                            </div>

                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="reg_amount" style="width:20%;">{lang('registration_amount')}:</label>
                                    <div class="col-sm-3">
                                        {$DEFAULT_SYMBOL_LEFT} <input tabindex="31" type="text" name ="reg_amount"  id ="reg_amount" value="{$obj_arr["reg_amount"]}" title="">{form_error('reg_amount')}
                                        <span id="errmsg3"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="32" name="setting" id="setting" style="margin-left:25%;" title="{lang('update')}" onclick="setHiddenValue('tab4')">{lang('update')}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                {/if}

                <div class="tab-pane{$tab5}" id="panel_tab3_example5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('tax_setting')}
                        </div>

                        <div class="panel-body">                                       


                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="service_charge">{lang('service_charge')}: </label>
                                <div class="col-sm-4">
                                    {$DEFAULT_SYMBOL_LEFT} <input type="text" tabindex="33" name ="service_charge" id ="service" value="{number_format($obj_arr["service_charge"],2)}" title="">{form_error('service')}
                                    <span id="errmsg1"></span>
                                </div>
                                <span class="help-block"></span>


                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="tds"> {lang('tds')}:</label>
                                <div class="col-sm-4">
                                    {$DEFAULT_SYMBOL_LEFT} <input type="text" name ="tds" tabindex="34" id ="tds" value="{number_format($obj_arr["tds"],2)}" title="">{form_error('tds')}
                                    <span id="errmsg2"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="35" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab5')">{lang('update')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane{$tab6}" id="panel_tab3_example6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('transaction_fee')}
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="trans_fee" style="width:20%;">{lang('transaction_fee')}:</label>
                                <div class="col-sm-4">
                                    {$DEFAULT_SYMBOL_LEFT} <input tabindex="36" type="text" name ="trans_fee"  id ="trans_fee" value="{math equation="x" x=$obj_arr["trans_fee"]}" title="" autocomplete="off">{form_error('trans_fee')}
                                    <span id="errmsg7"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="37" name="setting" id="setting" style="margin-left:25%;" title="{lang('update')}" onclick="setHiddenValue('tab6')">{lang('update')}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {form_close()}
    </div>
</div>

<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateConfiguration.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}


