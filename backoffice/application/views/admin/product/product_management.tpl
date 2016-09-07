{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_product_identifying_number')}</span>
    <span id="error_msg">{lang('you_must_enter_your_product_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_your_product_amount')}</span>
    <span id="error_msg4">{lang('you_must_enter_your_product_pair_value')}</span>
    <span id="validate_msg">{lang('enter_digits_only')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_digits_only')}</span>
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
                {form_open_multipart('admin/product/product_management','class="smart-wizard form-horizontal" role="form" id="proadd"')}
                {if $action=="edit"}
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('manage_product')}
                        </div> 
                        <div class="panel-body"> 
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="prod_name">{lang('name_of_the_product')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input  type="text" name="prod_name" id="prod_name" size="20" value="{$pr_name}" title="" autocomplete="off" class="form-control" maxlength="30" readonly="true"/>
                                    <span name ='form_err'>{form_error('prod_name')}</span>
                                </div>					    
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="product_amount">{lang('product_amount')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3 {*col-sm-offset-1*}">
                                    <input  type="text" name="product_amount" id="product_amount" size="20" value="{$pr_value}" title="{lang('Actual_amount_of_the_product')}" autocomplete="off" class="form-control" maxlength="10"/>
                                    <span id="errmsg1"></span>
                                    <span name ='form_err'>{form_error('product_amount')}</span>
                                </div>
                            </div>
                            {if $pair_value_visible == 'yes'}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="pair_value">{lang('pair_value')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-3">
                                        <input  type="text" name="pair_value" id="pair_value" size="20" value="{$pair_value}" title="{lang('product_pair_value')}" autocomplete="off" class="form-control" maxlength="10"/> 
                                        <span id="errmsg2"></span>
                                        <span name ='form_err'>{form_error('pair_value')}</span>
                                    </div>
                                </div>
                            {/if}
                            {if $bv_value_visible == 'yes'}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="bv_value">{lang('bv_value')}:<font color="#ff0000">*</font></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="bv_value" id="bv_value" size="20" value="{$bv_value}" title="{lang('bv_value')}" autocomplete="off" class="form-control" maxlength="10"/> 
                                        <span id="errmsg2"></span>
                                        <span name ='form_err'>{form_error('bv_value')}</span>
                                    </div>
                                </div>
                            {/if}
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="no_of_token">{lang('no_of_token')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input type="text" name="no_of_token" id="no_of_token" size="20" value="{$no_of_token}" title="{lang('bv_value')}" autocomplete="off" class="form-control" maxlength="10"/> 
                                    <span id="errmsg3"></span>
                                    <span name ='form_err'>{form_error('no_of_token')}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="splits">{lang('splits')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input  type="text" name="splits" id="splits" size="20" value="{$splits}" title="{lang('bv_value')}" autocomplete="off" class="form-control" maxlength="10"/> 
                                    <span id="errmsg7"></span>
                                    <span name ='form_err'>{form_error('splits')}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="academy_level">{lang('academy_level')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <input  type="text" name="academy_level" id="academy_level" size="20" value="{$academy_level}" title="{lang('bv_value')}" autocomplete="off" class="form-control" maxlength="10"/> 
                                    <span id="errmsg9"></span>
                                    <span name ='form_err'>{form_error('academy_level')}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="product_id"> Package Image:<font color="#ff0000">*</font></label>
                                <div class="col-sm-3">
                                    <div class="fileupload fileupload-new " data-provides="fileupload" >

                                        <div class="fileupload-preview fileupload" ></div>
                                        <div class="user-edit-image-buttons">
                                            <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>

                                                <input type="file" id="userfile" name="userfile"  value="" >
                                            </span>
                                            <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                                <i class="fa fa-times"></i>Remove
                                            </a>
                                        </div>
                                    </div>
                                </div><div  style="color:gray;font-style: italic; font-size:15px;">(max width:1024px, max height:768px max size:4MB  file formats support:gif,jpg,png,jpeg)</div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-4">
                                    {if $action=="edit"}
                                        <input type="hidden" name="prod_id" id="prod_id" size="35" value="{$pr_id}"/>
                                        <button class="btn btn-bricky" type="submit" name="update_prod"  id="update Product" value="update Product" >{lang('update_Product')}</button>
                                    {else}
                                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                                        <button class="btn btn-bricky" type="submit" name="submit_prod"  id="submit_prod" value="add product" >{lang('add_product')}</button>
                                    {/if}
                                </div>
                            </div>
                            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                        </div>
                    </div>
                {/if}
                {form_close()}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>{lang('product_available')}
                    </div> 
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        {form_open('admin/product/product_management', 'role="form" class="smart-wizard form-horizontal" id="proad" name="proad"')}
                        {*<div class="panel panel-default">
                        <div class="panel-body">
                        <div class="col-sm-3">
                        <input tabindex="6" type="radio" id="status_active" name="pro_status" value="yes" checked {if $sub_status=='yes'}checked='1'{/if} /><label for="val"></label>{lang('active_product')}
                        </div>

                        <div class="col-sm-3">
                        <input tabindex="7" type="radio" name="pro_status" id="status_inactive" value="no" {if $sub_status=='no'}checked='1'{/if} /><label for="valid"></label>{lang('inactive_product')}
                        </div>

                        <div class="col-sm-3">
                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                        <button class="btn btn-bricky" type="submit" name="refine"  id="refine" value="add product" tabindex="8">{lang('refine')}</button>
                        </div>
                        </div>
                        </div>*}



                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                            <thead>
                                <tr class="th" align="center">
                                    <th>No</th>
                                    <th>{lang('product_name')}</th>
                                    <th>Image</th> 
                                    <th>{lang('product_amount')}</th> 
                                        {if $pair_value_visible == 'yes'}
                                        <th>{lang('pair_value')}</th>
                                        {/if}
                                        {if $bv_value_visible == 'yes'}
                                        <th>{lang('bv_value')}</th>
                                        {/if}
                                    <th>{lang('no_of_token')}</th>
                                    <th>{lang('splits')}</th>
                                    <th>{lang('academy_level')}</th>
                                        {* <th>{lang('product_status')}</th>*}
                                    <th>{lang('action')}</th>
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
                                        {assign var="active" value="{$v.active}"}
                                        {assign var="date" value="{$v.date_of_insertion}"}
                                        {assign var="prod_value" value="{$v.product_value}"}
                                        {assign var="bv_value" value="{$v.bv_value}"}
                                        {assign var="pair_value" value="{$v.pair_value}"}
                                        {assign var="no_of_tokens" value="{$v.num_of_tokens}"}
                                        {assign var="splits" value="{$v.splits}"}
                                        {assign var="academy_level" value="{$v.academy_level}"}
                                        {assign var="image" value="{$v.image}"}

                                        {if $active=='yes'}
                                            {$status=lang('active')}
                                        {else}
                                            {$status=lang('inactive')}
                                        {/if}
{$i=$i+1}
                                        <tr class="{$class}" align="center" >
                                            <td>{$i}</td>
                                            <td>{$name}</td>
                                            <td><img src="{$PUBLIC_URL}images/package/{$image}" alt="{$name}" style="width:80px;height:80px;"></td>
                                           {* <td>{$prod_value}</td>*}
                                            <td>{$DEFAULT_SYMBOL_LEFT}{$prod_value*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>
                                            {if $pair_value_visible == 'yes'}
                                                <td>{$pair_value}</td>
                                            {/if}
                                            {if $bv_value_visible == 'yes'}
                                                <td>{$bv_value}</td>
                                            {/if}
                                            <td>{$no_of_tokens}</td>
                                            <td>{$splits}</td>
                                            <td>{$academy_level}</td>

                                            {* <td>{$status}</td>*}
                                            <td>
                                                {if $active=='yes'}
                                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                        <a href="javascript:edit_prod({$id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')}"><input type="hidden" name="edit_product" id="edit_prod" size="35" />
                                                            <i class="fa fa-edit"></i></a>

                                                        <!--Inactivate Product start-->
                                                        {* <a href="javascript:inactivate_prod({$id})" onclick=""  class="btn btn-primary tooltips" data-placement="top" data-original-title="{lang('inactivate')}">
                                                        <span style="display:none" id="error_msg_activate">{lang('Sure_you_want_to_inactivate_this_Product_There_is_NO_undo')}</span>
                                                        <i class="glyphicon glyphicon-remove-circle"></i>
                                                        </a>*}
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
                                        
                                    {/foreach}             
                                </tbody>
                            {else}
                                <tbody>
                                    <tr><td colspan="8" align="center"><h4 align="center">{lang('no_product_found')}</h4></td></tr>
                                </tbody>
                            {/if}
                        </table>
                        {$result_per_page}
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
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

