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

                <li class="{$tab1}">
                    <a href="#panel_tab3_example4" data-toggle="tab">{lang('direct_bonus')}</a>
                </li>
                <li class="{$tab2}">
                    <a href="#panel_tab3_example5" data-toggle="tab">{lang('fast_start_bonus')}</a>
                </li>
                <li class="{$tab3}">
                    <a href="#panel_tab3_example2" data-toggle="tab">{lang('matching_bonus')}</a>
                </li>
                <li class="{$tab5}">
                    <a href="#panel_tab3_example9" data-toggle="tab">{lang('team_bonus')}</a>
                </li>
                <li class="{$tab4}">
                    <a href="#panel_tab3_example1" data-toggle="tab">{lang('diamond_pool')}</a>
                </li>
                {* <li class="{$tab6}">
                <a href="#panel_tab3_example6" data-toggle="tab">{lang('transaction_fee')}</a>
                </li>*}
            </ul>
            <input type="hidden" name="active_tab" id="active_tab" value="" >
            <div class="tab-content">
                <div class="tab-pane {$tab1}" id="panel_tab3_example4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('direct_bonus')}
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="db_percentage" >{lang('direct_bonus')} %<span class="symbol required"></span>:</label>
                                
                                <div class="col-sm-3">
                                    <input tabindex="31" maxlength="10" type="text" name ="db_percentage"  id ="db_percentage" value="{$obj_arr["db_percentage"]}" title="" class="form-control" >{form_error('db_percentage')}
                                    <span id="errmsg3"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="32" name="setting" id="setting" style="margin-left:25%;" title="{lang('update')}" onclick="setHiddenValue('tab1')">{lang('update')}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane {$tab2}" id="panel_tab3_example5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('fast_start_bonus')}
                        </div>

                        <div class="panel-body">                                       

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="fsb_percentage"> {lang('fast_start_bonus')} %<span class="symbol required"></span>:</label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control"  name ="fsb_percentage" tabindex="34" id ="fsb_percentage" value="{$obj_arr["fsb_percentage"]}" title="">{form_error('fsb_percentage')}
                                    <span id="errmsg4"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="fsb_required_firstliners"> {lang('required_firstliners')}<span class="symbol required"></span>:</label>
                                <div class="col-sm-4">
                                    <input type="number"  class="form-control" name ="fsb_required_firstliners" tabindex="34" id ="fsb_required_firstliners" maxlength="10" min="1"  max="100" value="{$obj_arr["fsb_required_firstliners"]}" title="">{form_error('rfsb_required_firstliners')}
                                    <span id="errmsg6"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="fsb_firstliners_pack"> {lang('firstliners_pack')}<span class="symbol required"></span>:</label>
                                <div class="col-sm-4" >   
                                    <select name="fsb_firstliners_pack" id="fsb_firstliners_pack" tabindex="35"  class="form-control" >
                                        {*{if $pack_count>0}
                                            {$package_arr}
                                        {else}
                                            <option value="" >{lang('fsb_firstliners_pack')}</option>   
                                        {/if} *}
                                         {foreach from=$package_arr item=v}
                                               
                                                <option value="{$v.product_id}"   {if $obj_arr["fsb_firstliners_pack"]== $v.product_id} selected=""{/if}>{$v.product_name}</option>   
                                            {/foreach}
                                    </select>        
                                    <span id="errmsg7"></span>
                                </div>
                            </div>  

                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="fsb_accumulated_turn_over_1">{lang('accumulated_turn_over')} 5000 BV<span class="symbol required"></span>: </label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" tabindex="33" name ="fsb_accumulated_turn_over_1" id ="fsb_accumulated_turn_over_1" value="{$obj_arr["fsb_accumulated_turn_over_1"]}" title="">{form_error('accumulated_turn_over_1')}
                                    <span id="errmsg5"></span>
                                </div>{form_error('fsb_accumulated_turn_over_1')}
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">

                                <label class="col-sm-2 control-label" for="fsb_accumulated_turn_over_2">{lang('accumulated_turn_over')} 10000 BV<span class="symbol required"></span>: </label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" tabindex="33" name ="fsb_accumulated_turn_over_2" id ="fsb_accumulated_turn_over_2" value="{$obj_arr["fsb_accumulated_turn_over_2"]}" title="">{form_error('fsb_accumulated_turn_over_2')}
                                    <span id="errmsg5"></span>
                                </div>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="35" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab2')">{lang('update')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane {$tab3}" id="panel_tab3_example2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('matching_bonus')}
                        </div>

                        <div class="panel-body">
                            {if $MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes" }
                                {* <h3>{lang('level_commission')}</h3>*}

                                {if $obj_arr["level_commission_type"] == "flat"}
                                    {$flat = 'checked="true"'}
                                    {$percent = ""}
                                {else}
                                    {$flat = ""}
                                    {$percent = 'checked="true"'}
                                {/if}
                                <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
                                <input type="hidden" name="level_commission_type" id="level_commission_type" value="percentage">

                                {*<div class="form-group" style="display:none;">
 
                                 
                                <label class="col-sm-2 control-label" style="width:20%;" >{lang('type_of_commission')}: </label>
                                <div class="col-sm-3" >
                                <input tabindex="25" type = 'Radio' name ='level_commission_type' id='level_commission_type1' value= 'percentage' {$percent} title="" onchange="change_level_commission_type(this.value);"><label for="level_commission_type1"></label>{lang('percentage')}
                                <input tabindex="26" type = 'Radio' name ='level_commission_type' id='level_commission_type2' value= 'flat' {$flat} title="" onchange="change_level_commission_type(this.value);"><label for="level_commission_type2"></label>{lang('flat')}
                                </div>
                                </div>*}

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="mb_minimum_pack"> {lang('minimum_pack_required')} <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3" >   
                                        <select name="mb_minimum_pack" id="mb_minimum_pack" tabindex="35"  class="form-control" >
                                            {*{if $pack_count>0}
                                                {$package_arr}
                                            {else}
                                                <option value="" >{lang('select_pack')}</option>   
                                            {/if} *}


                                            {foreach from=$package_arr item=v}
                                               
                                                <option value="{$v.product_id}"   {if $obj_arr["mb_minimum_pack"]== $v.product_id} selected=""{/if}>{$v.product_name}</option>   
                                            {/foreach}


                                        </select>        
                                        <span id="errmsg7"></span>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="mb_required_firstliners"> {lang('required_firstliners')} <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="mb_required_firstliners" tabindex="34" id ="mb_required_firstliners" maxlength="10" min="1"  max="100" value="{$obj_arr["mb_required_firstliners"]}" title="">{form_error('mb_required_firstliners')}
                                        <span id="errmsg6"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="mb_first_line_minimum_pack"> {lang('first_line_minimum_pack_required')} <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3" >   
                                        <select name="mb_first_line_minimum_pack" id="mb_first_line_minimum_pack" tabindex="35"  class="form-control" >
                                            {*{if $pack_count>0}
                                                {$package_arr}
                                            {else}
                                                <option value="" >{lang('select_pack')}</option>   
                                            {/if} *}
                                             {foreach from=$package_arr item=v}
                                               
                                                <option value="{$v.product_id}"   {if $obj_arr["mb_first_line_minimum_pack"]== $v.product_id} selected=""{/if}>{$v.product_name}</option>   
                                            {/foreach}
                                        </select>        
                                        <span id="errmsg7"></span>
                                    </div>
                                </div>  

                                {$level_count = count($arr_level)}
                                {assign var=level value="0"}
                                {foreach from=$arr_level item=v}  
                                    {if $level < $obj_arr['depth_ceiling']}
                                        {$level = $level + 1}
                                        {$levl_perc = $v} 
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" {*style="width:20%;"*} for="level_per">                                                            
                                                {$level} {lang('level')} Bonus
                                                <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span><span class="symbol required"></span>:
                                            </label>
                                            <div class="col-sm-3">
                                                <input tabindex="27" type="number" {*class="level_percentage"*} name ="level_percentage{$level}"  class="form-control" id ="level_per{$level}" value="{$levl_perc}" title=" "min="0"  max="100" >
                                                <span id="errmsg14"></span>
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
                <div class="tab-pane {$tab5}" id="panel_tab3_example9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('team_bonus')}
                        </div>

                        <div class="panel-body">
                           
                               
                              

                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_required_firstliners"> {lang('required_firstliners')} <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_required_firstliners" tabindex="34" id ="tb_required_firstliners" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_required_firstliners"]}" title="">{form_error('tb_required_firstliners')}
                                        <span id="errmsg6"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_first_line_minimum_pack"> {lang('first_line_minimum_pack_required')} <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3" >   
                                        <select name="tb_first_line_minimum_pack" id="tb_first_line_minimum_pack" tabindex="35"  class="form-control" >
                                            {*{if $pack_count>0}
                                                {$package_arr}
                                            {else}
                                                <option value="" >{lang('select_pack')}</option>   
                                            {/if} *}
                                             {foreach from=$package_arr item=v}
                                               
                                                <option value="{$v.product_id}"   {if $obj_arr["tb_first_line_minimum_pack"]== $v.product_id} selected=""{/if}>{$v.product_name}</option>   
                                            {/foreach}
                                        </select>        
                                        <span id="errmsg7"></span>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_1000"> {lang('from')} 1000 BV % <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_1000" tabindex="34" id ="tb_1000" maxlength="10" min="1" max="100" value="{$obj_arr["tb_1000"]}" title="">{form_error('tb_1000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_5000"> {lang('from')} 5000 BV % <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_5000" tabindex="34" id ="tb_5000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_5000"]}" title="">{form_error('tb_5000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_10000"> {lang('from')} 10000 BV % <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_10000" tabindex="34" id ="tb_10000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_10000"]}" title="">{form_error('tb_10000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_25000"> {lang('from')} 25000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_25000" tabindex="34" id ="tb_25000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_25000"]}" title="">{form_error('tb_25000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_50000"> {lang('from')} 50000 BV % <span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_50000" tabindex="34" id ="tb_50000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_50000"]}" title="">{form_error('tb_50000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_100000"> {lang('from')} 100000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_100000" tabindex="34" id ="tb_100000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_100000"]}" title="">{form_error('tb_100000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_250000"> {lang('from')} 250000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_250000" tabindex="34" id ="tb_250000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_250000"]}" title="">{form_error('tb_250000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_500000"> {lang('from')} 500000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_500000" tabindex="34" id ="tb_500000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_500000"]}" title="">{form_error('tb_500000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_1000000"> {lang('from')} 1000000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_1000000" tabindex="34" id ="tb_1000000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_1000000"]}" title="">{form_error('tb_1000000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_5000000"> {lang('from')} 5000000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_5000000" tabindex="34" id ="tb_5000000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_5000000"]}" title="">{form_error('tb_5000000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="tb_10000000"> {lang('from')} 10000000 BV %<span class="symbol required"></span>:</label>
                                    <div class="col-sm-3">
                                        <input type="number"  class="form-control" name ="tb_10000000" tabindex="34" id ="tb_10000000" maxlength="10" min="1"  max="100" value="{$obj_arr["tb_10000000"]}" title="">{form_error('tb_10000000')}
                                        {*<span id="errmsg6"></span>*}
                                    </div>
                                </div>


                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="28" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab5');">{lang('update')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="tab-pane {$tab4}" id="panel_tab3_example1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('diamond_pool')}
                        </div>

                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="dp_percentage" >{lang('diamond_pool')} % <span class="symbol required"></span>:</label>
                                <div class="col-sm-3">
                                    <input tabindex="31" maxlength="10" type="text" name ="dp_percentage"  id ="dp_percentage" value="{$obj_arr["dp_percentage"]}" title="" class="form-control" >{form_error('dp_percentage')}
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


