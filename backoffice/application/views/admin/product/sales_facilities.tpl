{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_product_identifying_number')}</span>
    <span id="error_msg">{lang('you_must_enter_your_product_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_your_product_amount')}</span>
    <span id="error_msg4">{lang('you_must_enter_your_product_pair_value')}</span>
    <span id="validate_msg">{lang('enter_digits_only')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('digits_only')}</span>
    <span id="confirm_msg_inactivate">{lang('Sure_you_want_to_inactivate_this_Product_There_is_NO_undo')}</span>
    <span id="confirm_msg_edit">{lang('Sure_you_want_to_edit_this_Product_There_is_NO_undo')}</span>
    <span id="confirm_msg_activate">{lang('Sure_you_want_to_Activate_this_Product_There_is_NO_undo')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    <span id="validate_msg_img1">{lang('you_must_select_a_product_name')}</span>
    <span id="validate_msg_img2">{lang('you_must_select_a_product_image')}</span>
    <span id="error_msg7">{lang('you_should_enter_token_no')}</span>
    <span id="error_msg8">{lang('you_should_enter_splits')}</span>
    <span id="error_msg9">{lang('you_should_enter_academy_level')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="tabbable ">
            <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                {form_open('admin/product/sales_facilities','class="smart-wizard form-horizontal" role="form" id="proadd"')}
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('manage_prod')}
                        </div> 
                        <div class="panel-body"> 
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="prod_name">{lang('product_name')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input tabindex="1" type="text" name="prod_name" id="prod_name" size="20" value="{$pr_name}" title="" autocomplete="off" class="form-control"/>
                                    <span name ='form_err'>{form_error('prod_name')}</span>
                                </div>					    
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="prod_amount">{lang('amount')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    {$DEFAULT_SYMBOL_LEFT}<input tabindex="2" type="text" name="prod_amount" id="prod_amount" size="20" value="{number_format($pr_value*$DEFAULT_CURRENCY_VALUE,2)}"  autocomplete="off" class="form-control"/>{$DEFAULT_SYMBOL_RIGHT}
                                    <span id="errmsg1"></span>
                                    <span name ='form_err'>{form_error('prod_amount')}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="prod_stock">{lang('quantity')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input tabindex="7" type="text" name="prod_stock" id="prod_stock" size="20" value="{$academy_level}"  autocomplete="off" class="form-control"/> 
                                    <span id="errmsg2"></span>
                                    <span name ='form_err'>{form_error('prod_stock')}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-4">
                                    {if $action=="edit"}
                                        {*<input type="hidden" name="prod_id" id="prod_id" size="35" value="{$pr_id}"/>*}
                                        <button class="btn btn-bricky" type="submit" name="update_prod"  id="update Product" value="update Product" tabindex="">{lang('update_prod')}</button>
                                    {else}
                                       {* <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">*}
                                        <button class="btn btn-bricky" type="submit" name="submit_prod"  id="submit_prod" value="add product" tabindex="5">{lang('add_prod')}</button>
                                    {/if}
                                </div>
                            </div>
                            {*<input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">*}
                        </div>
                    </div>
               
                {form_close()}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>{lang('prod_available')}
                    </div> 
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        {form_open('admin/product/sales_facilities', 'role="form" class="smart-wizard form-horizontal" id="proad" name="proad"')}

                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                            <thead>
                                <tr  align="center" >
                                    <th style="width:10%">{lang('si_no')}</th>
                                    <th style="width:40%">{lang('product_name')}</th>
                                    <th style="width:20%">{lang('amount')}</th> 
                                    <th style="width:20%">{lang('quantity')}</th>
                                    <th style="width:10%">{lang('action')}</th>
                                </tr>
                            </thead>
                            {if count($product_details)!=0}
                                {assign var="i" value=0}
                                <tbody>
                                    {foreach from=$product_details item=v}
                                        {assign var="class" value=""}

                                        {if $i%2==0}
                                            {$clr='tr1'}
                                        {else}
                                            {$clr='tr2'}
                                        {/if}
                                        {assign var="id" value="{$v.product_id}"}
                                        {assign var="name" value="{$v.product_name}"}
                                        {assign var="amount" value="{$v.product_value}"}
                                        {assign var="quantity" value="{$v.product_qty}"}
                                        {assign var="active" value="{$v.active}"}

                                        <tr class="{$class}" >
                                            <td align="center">{$i}</td>
                                            <td>{$name}</td>
                                            <td>{$DEFAULT_SYMBOL_LEFT}{$amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>   
                                            <td>{$quantity}</td>
                                            <td align="center">
                                                {if $active=='yes'}
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <a href="javascript:edit_prod({$id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')}"><input type="hidden" name="edit_product" id="edit_prod" size="35" />
                                                            <i class="fa fa-edit"></i></a>

                                                        <!--Inactivate Product start-->
                                                        <a href="javascript:inactivate_prod({$id})" onclick=""  class="btn btn-primary tooltips" data-placement="top" data-original-title="{lang('inactivate')}">
                                                            <span style="display:none" id="error_msg_activate">{lang('Sure_you_want_to_inactivate_this_Product_There_is_NO_undo')}</span>
                                                            <i class="glyphicon glyphicon-remove-circle"></i>
                                                        </a>
                                                        <!--Inactivate Product end-->
                                                    {else}
                                                        <!--Activate Product start-->

                                                        <a href="javascript:activate_prod({$id})" class="btn btn-green tooltips" data-placement="top" data-original-title="{lang('activate')}"><i class="glyphicon glyphicon-ok-sign"></i></a>

                                                        <span style="display:none" id="error_msg_activate">{lang('Sure_you_want_to_Activate_this_Product_There_is_NO_undo')}</span>

                                                        </a>
                                                        <!--Activate Product end-->
                                                    {/if}                                                                                      
                                                </div>

                                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                    {if $active=='yes'} 
                                                        <div class="btn-group">
                                                            <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                                <i class="fa fa-cog"></i> <span class="caret"></span>
                                                            </a>

                                                            <ul role="menu" class="dropdown-menu pull-right">
                                                                <li role="presentation">
                                                                    <a role="menuitem"  href="javascript:edit_prod({$id})">
                                                                        <i class="fa fa-edit"></i> Edit {$name}
                                                                    </a>
                                                                </li>

                                                                <li role="presentation">
                                                                    <a role="menuitem"  href="javascript:inactivate_prod({$id})" >
                                                                        <i class="fa fa-edit"></i> Inactive {$name}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    {/if}
                                                </div>
                                            </td>
                                        </tr>
                                        {$i=$i+1}
                                    {/foreach}             
                                </tbody>
                            {else}
                                <tbody>
                                    <tr><td colspan="8" align="center"><h4 align="center">{lang('no_prod_found')}</h4></td></tr>
                                </tbody>
                            {/if}
                        </table>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  

