{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 

    <span id="validate_msg1">{lang('enter_title')}</span>
    <span id="validate_msg2">{lang('enter_code')}</span>
    <span id="validate_msg3">{lang('enter_value')}</span>
    <span id="validate_msg4">{lang('enter_symbol_left')}</span>
    <span id="validate_msg5">{lang('enter_symbol_right')}</span>
    <span id="validate_msg6">{lang('enter_decimal')}</span>
    <span id="validate_msg7">{lang('enter_status')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                Edit Language
            </div>
            <div class="panel-body">
                {form_open('', 'name="lang_entry" id="lang_entry" class="smart-wizard form-horizontal" method="post"')}
                    <input type="hidden" id="lang_id" name="lang_id" value="{$lang_details['lang_id']}">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('lang_code')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="lang_code" id ="lang_code" value="{$lang_details['lang_code']}" autocomplete="Off" tabindex="2">{form_error('lang_code')}
                        </div> 
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('lang_name')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="lang_name" id ="lang_name" value="{$lang_details['lang_name']}" autocomplete="Off" tabindex="2">{form_error('lang_name')}



                        </div>

                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('lang_name_in_english')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="lang_name_in_english" id ="lang_name_in_english" value="{$lang_details['lang_name_in_english']}" autocomplete="Off" tabindex="2">{form_error('lang_name_in_english')}
                        </div>
                    </div>                    
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('status')}:<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name ="status" id ="status" tabindex="1">


                                <option value="yes" {if $lang_details['status']=='yes'} selected="" {/if}>{lang('enabled')}</option>
                                <option value="no" {if $lang_details['status']=='no'} selected="" {/if} >{lang('disabled')}</option>

                            </select>

                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Update" name="update" id="update" >{lang('update')}</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        validate_multy_language.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""} 