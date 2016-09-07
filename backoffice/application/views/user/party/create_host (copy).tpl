{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
 <span id="confirm_msg_edit">{lang('confirm_msg_edit')}</span>
 <span id="validate_msg1">{lang('please_enter_first_name')}</span>
 <span id="validate_msg2">{lang('please_enter_last_name')}</span>
 <span id="validate_msg3">{lang('please_enter_address')}</span>
 <span id="validate_msg4">{lang('please_enter_city')}</span>
 <span id="validate_msg5">{lang('please_enter_sate')}</span>
 <span id="validate_msg6">{lang('please_enter_zip')}</span>
 <span id="validate_msg7">{lang('please_enter_phone_no')}</span>
 <span id="validate_msg8">{lang('please_enter_email')}</span>
 <span id="validate_msg9">{lang('You_must_select_country')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('host_management')}
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
                <form role="form" class="smart-wizard form-horizontal"  action=""  method="post"    name="create_host" id="create_host" >
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                
              <div class="row">    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="firstname">
                            {lang('first_name')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" name="firstname" id="firstname" value="{$first_name}" tabindex="1"/>
                            </div>{form_error('firstname')}
                        </div>
                    </div>
             </div>
              <div class="row">    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="lastname">
                            {lang('last_name')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" name="lastname" id="lastname" value="{$last_name}" tabindex="2">
                            </div>{form_error('lastname')}
                        </div>
                    </div> 
              </div>              
                 <div class="row">    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="address">
                            {lang('address')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <textarea rows="4" name="address" id="address"  cols="20" style="background-color:#ffffff;  border:1px; border-style:solid;border-color:#d6d6d6;" tabindex="3">{$address}</textarea>
                            </div>{form_error('address')}
                        </div>
                    </div>
                 </div>
                <div class="row">    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            {lang('city')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
			    <div class="input-group">
                            <input type="text" name="city" id="city" value="{$city}" tabindex="4">
                        </div>{form_error('city')}
                         </div>
                 </div>
		</div>
                 
         <div class="row">    
                    <div class="form-group">
                         <label class="col-sm-2 control-label" for="state">
                            {lang('state')}:
                        </label>
                        <div class="col-sm-3" id="state1">
                            <select name="state" id="state" class="form-control"  tabindex="5">
                                <option value="">{$states}</option>
                            </select>
                        </div>                      
                    </div>
             </div>                            
                 <div class="row">    
                    <div class="form-group">
                       <label class="col-sm-2 control-label" for="zip">
                            {lang('zip')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" name="zip" id="zip" value="{$zip}" tabindex="6">
                            </div>{form_error('zip')}
                        </div>
                    </div> 
                </div>
                            <div class="row">    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="country">
                            {lang('country')}:<span class="symbol required"></span>
                        </label>
                            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}user" tabindex="1">
                        <div class="col-sm-3">
                            <select name="country" id="country" class="form-control" tabindex="7" onChange="">
                               
                              {foreach from=$countries item=v}                                 
                                  <option value="{$v.country_id}">{$v.name}</option>                                                                                                                                                                                       
                                {/foreach}
                            </select>{form_error('country')}
                      </div>
                    </div>
                </div>
             
                 <div class="row">           
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="phone">
                            {lang('phone')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" name="phone" id="phone" value="{$phone}" tabindex="8">
                            </div>{form_error('phone')}
                        </div>
                    </div>
                 </div>
                <div class="row">           
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">
                            {lang('email')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" name="email" id="email" value="{$email}" tabindex="9">
                            </div>{form_error('email')}
                        </div>
                    </div>                                            
                 </div>
                    {if $action=="edit"}
                    <div class="row"> 
                        <div class="form-group"  style="float: left; width: 255px;">
                            <div class="col-sm-2 col-sm-offset-8">
                                <button class="btn btn-bricky" tabindex="10" name="change" id="change"  type="submit"  value="Save Changes"  >{lang('save_changes')} </button>
                            </div>
                        </div>


                        <div class="form-group"  style="float: left; text-align: left; width: 150px;">
                            <div class="col-sm-2 col-sm-offset-9">
                                <a href="../../host_manager">
                                    <button class="btn btn-light-grey" tabindex="11"  name="cancel" id="cancel" type="button" value="Cancel" ta >{lang('cancel')} </button></a>
                            </div>
                        </div>
                       </div>

                            {else}
                                <div class="row"> 
                                 <div class="form-group"  style="float: left; width: 255px;">
                            <div class="col-sm-2 col-sm-offset-8">
                                <button class="btn btn-bricky" tabindex="10" name="submit" id="submit"  type="submit"  value="Add Host" >{lang('add_host')} </button>
                            </div>
                        </div>


                        <div class="form-group"  style="float: left; text-align: left; width: 100px;">
                            <div class="col-sm-2 col-sm-offset-9">
                                <a href="host_manager">
                                    <button class="btn btn-light-grey" tabindex="11"  name="cancel" id="cancel" type="button" value="Cancel" >{lang('cancel')}</button></a>
                            </div>
                        </div>                              
                                </div> 

                            {/if}  

                            </form>
                    </div>
            </div>
        </div>
    </div>
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            //DatePicker.init();
            ValidateCreateHost.init();
        });
    </script>
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}