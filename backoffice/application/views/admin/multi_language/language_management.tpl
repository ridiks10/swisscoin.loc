{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_title')}</span>
    <span id="validate_msg2">{lang('enter_code')}</span>
    <span id="validate_msg3">{lang('enter_value')}</span>
    <span id="validate_msg7">{lang('enter_status')}</span>
    <span id="error_msg6">{lang('sure_you_want_to_delete_this_language_there_is_no_undo')}</span>
    <span id="error_msg7">{lang('sure_you_want_to_edit_this_language')}</span>
    <span id="error_msg8">{lang('sure_you_want_to_set_this_language_is_default')}</span>

    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

{if $DEMO_STATUS != 'yes'}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    {lang('add_language')}
                </div>
                <div class="panel-body">
                    {form_open('', 'name="language_entry" id="language_entry" class="smart-wizard form-horizontal" method="post"')}

                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group"> 
                            <label class="col-sm-2 control-label" >{lang('lang_code')} :<span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <input class="form-control"  type="text"  name ="lang_code" id ="lang_code" value="" autocomplete="Off" tabindex="2">{form_error('lang_code')}
                            </div>
                        </div>
                        <div class="form-group"> 
                            <label class="col-sm-2 control-label" >{lang('lang_name')} :<span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <input class="form-control"  type="text"  name ="lang_name" id ="lang_name" value="" autocomplete="Off" tabindex="3">{form_error('lang_name')}
                            </div> 
                        </div>
                        <div class="form-group"> 
                            <label class="col-sm-2 control-label" >{lang('lang_name_in_english')} :<span class="symbol required"></span></label>
                            <div class="col-sm-6">
                                <input class="form-control"  type="text"  name ="lang_name_in_english" id ="lang_name_in_english" value="" autocomplete="Off" tabindex="4">{form_error('lang_name_in_english')}
                            </div> 
                        </div>
                        <div class="form-group"> 
                            <label class="col-sm-2 control-label" >{lang('status')}:<span class="symbol required"></span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name ="status" id ="mail_num" tabindex="5">
                                    <option value="" >{lang('please_select')}</option>
                                    <option value="yes" >{lang('enabled')}</option>
                                    <option value="no" >{lang('disabled')}</option>
                                </select>{form_error('status')}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" tabindex="6"   type="submit"  value="Update" name="update" id="update" >{lang('update')}</button>                                
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('multi_lang_management')}
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
                {if count($language_details)>0} 
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th >{lang('sl_no')}</th>
                                <th >{lang('lang_code')}</th>
                                <th >{lang('lang_name')}</th>                           
                                <th >{lang('lang_name_in_english')}</th>
                                <th >{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>                       
                            {assign var="i" value=0}                   
                            {foreach from=$language_details item=v}                        
                                {if $i%2 == 0}
                                    {$tr_class="tr1"}	 
                                {else}
                                    {$tr_class="tr2"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$tr_class}" align="center" >
                                    <td>{$i}</td>
                                    <td>{$v.lang_code}</td>
                                    <td>{$v.lang_name}</td> 
                                    <td>{$v.lang_name_in_english}</td>      
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <!--Default Language start-->  
                                            {if $v.default_id}
                                                <a href="javascript:void();" class="btn btn-green tooltips" data-placement="top" data-original-title="Default">
                                                    <i class="glyphicon glyphicon-ok-sign"></i>  
                                                </a>
                                            {else}
                                                <a href="javascript:set_default_language({$v.lang_id})" class="btn btn-green tooltips" data-placement="top" data-original-title="Set {$v.lang_name} as default">
                                                    <i class="glyphicon glyphicon-remove-circle"></i>
                                                </a>
                                            {/if}
                                            <span style="display:none" id="error_msg8"></span>
                                            <!--Edit LANGUAGE start-->
                                            <a href="javascript:edit_language({$v.lang_id})" class="btn btn-teal tooltips" data-placement="top" data-original-title="Edit {$v.lang_name}"> <span style="display:none" id="error_msg7"></span>
                                                <i class="fa fa-edit"></i></a> 
                                            <!--Delete LANGUAGE start-->
                                            <a href="javascript:delete_language({$v.lang_id})" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete {$v.lang_name}">
                                                <span style="display:none" id="error_msg6"></span>
                                                <i class="fa fa-times fa fa-white"></i>
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            {/foreach}   
                        </tbody>
                    </table>
                    {form_close()}
                {else}
                    <div align="center">{lang('no_language')}</div>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        validate_multy_language.init();
        TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""} 