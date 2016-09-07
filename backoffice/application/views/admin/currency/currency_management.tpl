{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_title')}</span>
    <span id="validate_msg2">{lang('enter_code')}</span>
    <span id="validate_msg3">{lang('enter_value')}</span>
    <span id="validate_msg4">{lang('enter_symbol_left')}</span>
    <span id="validate_msg5">{lang('enter_symbol_right')}</span>
    <span id="validate_msg6">{lang('enter_decimal')}</span>
    <span id="validate_msg7">{lang('enter_status')}</span>
    <span id="error_msg6">{lang('sure_you_want_to_delete_this_currency_there_is_no_undo')}</span>
    <span id="error_msg7">{lang('sure_you_want_to_edit_this_currency')}</span>
    <span id="error_msg8">{lang('sure_you_want_to_set_this_currency_is_default')}</span>

    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('add_currency')}
            </div>
            <div class="panel-body">
                {form_open('','name="currency_entry" id="currency_entry" class="smart-wizard form-horizontal" method="post"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('currency_title')} :<font color="#ff0000" >*</font> </label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="currency_title" id ="currency_title" value="" autocomplete="Off" tabindex="2">{form_error('currency_title')}
                            <span id="errmsg1"></span>
                        </div> 
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('currency_code')} :<font color="#ff0000">*</font></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="currency_code" id ="currency_code" value="" autocomplete="Off" tabindex="3">{form_error('currency_code')}
                            <span id="errmsg2"></span>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('currency_value')} :<font color="#ff0000">*</font></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="currency_value" id ="currency_value" value="" autocomplete="Off" tabindex="4">{form_error('currency_value')}
                            <span id="errmsg3"></span>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('symbol_left')} :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="symbol_left" id ="symbol_left" value="" autocomplete="Off" tabindex="5">{form_error('symbol_left')}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('symbol_right')} :</label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="symbol_right" id ="symbol_right" value="" autocomplete="Off" tabindex="6">{form_error('symbol_right')}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('status')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-4">
                            <select class="form-control" name ="status" id ="mail_num" tabindex="7">
                                <option value="" >{lang('please_select')}</option>
                                <option value="enabled" >{lang('enabled')}</option>
                                <option value="disabled" >{lang('disabled')}</option>
                            </select>{form_error('status')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="8"   type="submit"  value="Update" name="update" id="update" >{lang('update')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('currency_management')}
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

                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th" align="center">
                            <th >{lang('no')}</th>
                            <th >{lang('currency_title')}</th>
                            <th >{lang('currency_code')}</th>
                            <th >{lang('currency_value')}</th>
                            <th >{lang('symbol_left')}</th>
                            <th >{lang('symbol_right')}</th>                               
                            <th >{lang('action')}</th>
                        </tr>
                    </thead>
                    {if count($currency_details)>0}
                        <tbody>                       
                            {assign var="i" value=1}                   
                            {assign var="ii" value=0}                   
                            {foreach from=$currency_details item=v}                        
                                {if $i%2 == 0}
                                    {$tr_class="tr1"}	 
                                {else}
                                    {$tr_class="tr2"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$tr_class}" align="center" >
                                    <td>{$ii}</td>
                                    <td>{$v.title}</td>
                                    <td>{$v.code}</td>
                                    <td>{$v.value}</td>            
                                    <td>{$v.symbol_left}</td>      
                                    <td>{$v.symbol_right}</td>   
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <!--Default Currency start-->  

                                            {if $v.default_id}
                                                <a href="javascript:setdefault_currency({$v.id})" class="btn btn-green tooltips" data-placement="top" data-original-title="Default">
                                                    <i class="glyphicon glyphicon-ok-sign"></i>   </a>
                                                {else}
                                                <a href="javascript:setdefault_currency({$v.id})" class="btn btn-green tooltips" data-placement="top" data-original-title="{$v.title} {lang('set_as_default')}">
                                                    <i class="glyphicon glyphicon-remove-circle"></i></a>
                                                {/if}
                                            <span style="display:none" id="error_msg8"></span>
                                            <!--Edit Currency start-->
                                            <a href="javascript:edit_currency({$v.id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')} {$v.title}"> <span style="display:none" id="error_msg7"></span>
                                                <i class="fa fa-edit"></i></a> 
                                            <!--Delete Currency start-->
                                            <a href="javascript:delete_currency({$v.id})" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.title}">
                                                <span style="display:none" id="error_msg6"></span>
                                                <i class="fa fa-times fa fa-white"></i>
                                            </a>
                                        </div>                                      
                                    </td>
                                </tr>{$ii = $ii+1}
                            {/foreach}   
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_currency')}</h4></td></tr>
                        </tbody>
                    {/if}
                </table>
                <div > 
                    <div class="form-group"> 

                        <div class="col-sm-4 col-sm-offset-4">
                            <div class="form-group col-sm-2"> 
                                {form_open('admin/currency/automatic_currency_conversion', 'method="post"')}
                                    <button type='submit'  id='edit' name='set_default' value="set_default" class="btn btn-bricky">{lang('convert_currency')}</button>
                                {form_close()}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        validate_multy_currency.init();
        TableData.init();


    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  