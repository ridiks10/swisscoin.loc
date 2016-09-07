{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_party_name')}</span>        
    <span id="error_msg2">{lang('select_image')}</span>        
    <span id="error_msg3">{lang('select_host')}</span>        
    <span id="error_msg4">{lang('select_country')}</span>                  
    <span id="error_msg5">{lang('please_enter_first_name')}</span>
    <span id="error_msg6">{lang('please_enter_last_name')}</span>
    <span id="error_msg7">{lang('please_enter_address')}</span>
    <span id="error_msg8">{lang('please_enter_city')}</span>
    <span id="error_msg9">{lang('please_enter_sate')}</span>
    <span id="error_msg10">{lang('please_enter_zip')}</span>
    <span id="error_msg11">{lang('please_enter_phone_no')}</span>
    <span id="error_msg12">{lang('please_enter_email')}</span>
    <span id="error_msg13">{lang('select_date')}</span>
    <span id="error_msg14">{lang('select_time')}</span>
    <span id="validate_msg15">{lang('alpha_numeric_values_only')}</span>
    <span id="validate_msg16">{lang('digits_only')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('setup_party')}
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
                    {form_open_multipart('user/party_setup/create_party','name="setup_party" id="setup_party" method="POST" class="smart-wizard form-horizontal"  enctype="multipart/form-data"')}
                    
                    <input type="hidden" id="public_url" name="public_url" value="{$PUBLIC_URL}">
                    <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i>{lang('step')} {lang('one')}:{lang('party_name_and_image')}

                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="party_name">{lang('party_name')}:<font color="#ff0000">*</font></label>
                                        <div class="col-sm-6">
                                            <input  type="text"  name="party_name" id="full_name"   autocomplete="Off" tabindex="1" {if isset($party_setup_arr['party_name'])} value="{$party_setup_arr['party_name']}"{/if}>
                                            <span id="username_box" style="display:none;"></span>
                                            {form_error('party_name')}
                                        </div>                                
                                    </div>                                   
                                    <br>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="party_name">{lang('party_image')}:
                                        </label>
                                        <div class="fileupload fileupload-new col-sm-4" data-provides="fileupload" >
                                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{$PUBLIC_URL}images/party_image/party_image.png" alt="" value="party_image.png">
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                            <div class="user-edit-image-buttons">
                                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> {lang('select_image')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
                                                    <input type="file" id="image1" name="image1" tabindex="2" value="party_image.png" title="Use .png,.jpg,.gif files">
                                                </span>
                                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                                    <i class="fa fa-times"></i>{lang('remove')}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-external-link-square"></i> {lang('step')} {lang('two')}:{lang('select_host')}

                                </div>
                                <div class="panel-body">
                                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}user">
                                    <div class="form-group">
                                        <div class="col-sm-1 control-label" for="host1"><input type="Radio" name="host" id="host1"  value="old" checked="true" onclick="show_exist()" tabindex="3"/>
                                            <span id="username_box" style="display:none;"></span></div>
                                        <div class="col-sm-6">
                                            {lang('choose_an_existing_host')}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="host_id"></label>
                                        <div class="col-sm-4">
                                            <div id="select_host" class="space">
                                                <select name="host_id" id="host_id" class="form-control" tabindex="4"/>
                                                <option value="">{lang('select_host_name')}</option>
                                                {if isset($party_setup_arr['host_party_name'])} 
                                                    <option value="{$party_setup_arr['host_id']}" selected>{$party_setup_arr['host_party_name']}</option>      

                                                {/if}
                                                {if count($host_arr)!=0}
                                                    {foreach from=$host_arr item=v}
                                                        <option value="{$v.id}">{$v.first_name},{$v.last_name}</option>
                                                    {/foreach}
                                                {/if}
                                                </select>
                                            </div>
                                            {form_error('host_id')}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-1 control-label" for="host3">
                                            <input type="Radio" name="host" id="host3"  value="iam"  onclick="hide_new()" tabindex="5"/>
                                            <span id="username_box" style="display:none;"></span></div>
                                        <div class="col-sm-6">
                                            {lang('i_am_the_host')}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-1 control-label" for="host2">
                                            <input type="Radio" name="host" id="host2"  value="new" onclick="show_new()" tabindex="6"/>
                                            <span id="username_box" style="display:none;"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            {lang('create_a_new_host')}
                                        </div>
                                    </div>
                                    <div id="new_host" style="display:none" class="space">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="first_name">{lang('first_name')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-6">
                                                            <input  type="text"  name="first_name" id="first_name"   autocomplete="Off" tabindex="7">
                                                            <span id="errormsg8"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="last_name">{lang('last_name')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-6">
                                                            <input  type="text"  name="last_name" id="last_name"   autocomplete="Off" tabindex="8">
                                                            <span id="errormsg9"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="host_address">{lang('address')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-3">
                                                            <textarea rows="6" name="host_address" id="host_address" cols="19" tabindex="9" ></textarea>
                                                            <span id="errormsg6"></span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="host_phone">{lang('phone')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-6">
                                                            <input  type="text"  name="host_phone" id="host_phone"   autocomplete="Off" maxlength="10" tabindex="10">
                                                            <span id="errormsg13">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row"> 
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="host_country">{lang('country')}:<font color="#ff0000">*</font></label>
                                                        <div class="col-sm-5">
                                                            <select name="host_country" id="host_country" class="form-control" onChange="getAllStatessSetup(this.value)" tabindex="11" style="width: 179px;margin-left:-15px;">
                                                                <option value="">{lang('select_country')}</option>
                                                                {foreach from=$countries item=v}                                 
                                                                    <option value="{$v.country_id}">{$v.country_name}</option>                                                                                                                                                                                       
                                                                {/foreach}
                                                            </select>
                                                            <span id="username_box" style="display:none;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="state">{lang('state')}:</label>
                                                        <div class="col-sm-5">
                                                            <select name="state" id="state" class="form-control" tabindex="12" style="width: 179px;margin-left:-15px;">
                                                                <option value="">{lang('select_state')}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> 

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="host_city">{lang('city')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-9">
                                                            <input  type="text"  name="host_city" id="host_city"   autocomplete="Off" tabindex="13">
                                                            <span id="errormsg7"></span>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="host_zip">{lang('zip')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-9">
                                                            <input  type="text"  name="host_zip" id="host_zip"   autocomplete="Off" tabindex="14" maxlength="6" >
                                                            <span id="errormsg10"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="host_email">{lang('email')}:<font color="#ff0000">*</font></label>
                                                        <div class="row col-sm-6">
                                                            <input  type="text"  name="host_email" id="host_email"   autocomplete="Off" tabindex="15">
                                                            <span id="username_box" style="display:none;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="height: 36%;">
                                    <i class="fa fa-external-link-square"></i>{lang('step')} {lang('three')}:{lang('enter_the_date_and_time_of_the_party')}

                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">  {lang('from')}:<font color="#ff0000">*</font></label>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="from_date" id="from_date" type="text" tabindex="16" {if isset($party_setup_arr['from_date'])} value="{$party_setup_arr['from_date']}"{/if} >
                                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                                    </div>
                                                    {form_error('from_date')}
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="col-sm-6 input-group input-append bootstrap-timepicker">
                                                    <div class="input-group">
                                                        <input type="text" id="timepicker1" name="from_time" title="Select TIME" class="form-control time-picker" tabindex="17" {* {if isset($party_setup_arr['timepicker1'])} value="{$party_setup_arr['timepicker1']}"{/if}*}/>                               
                                                        {form_error('timepicker1')}
                                                        <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" >{lang('to')}:<font color="#ff0000">*</font></label>

                                                <div class="col-sm-6">
                                                    <div class="input-group">
                                                        <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="to_date" id="to_date" type="text" tabindex="18" {if isset($party_setup_arr['to_date'])} value="{$party_setup_arr['to_date']}"{/if} >
                                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                                    </div>
                                                    {form_error('to_date')}
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-6 input-group input-append bootstrap-timepicker">
                                                    <div class="input-group">
                                                        <input type="text" tabindex="19" id="timepicker2" name="to_time" title="Select TIME" class="form-control time-picker" {*{if isset($party_setup_arr['timepicker2'])} value="{$party_setup_arr['timepicker2']}"{/if}*}/>                                   
                                                        {form_error('timepicker2')}  
                                                        <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="height: 36%;">
                                    <i class="fa fa-external-link-square"></i> {lang('step')} {lang('four')}:{lang('enter_the_address_where_this_party_will_be_held')}             
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-sm-1 control-label" for="address1"> <input type="Radio" name="address" id="address1" checked="true" value="host_address" onclick="hide_new_address()" tabindex="20">
                                            <span id="username_box" style="display:none;"></span></div>
                                        <div class="col-sm-6">

                                            {lang('use_the_hosts_address')}:
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-1 control-label" for="address2"><input type="Radio" name="address" id="address2" value="user_address" onclick="hide_new_address()" tabindex="21"/>
                                            <span id="username_box" style="display:none;"></span></div>
                                        <div class="col-sm-6">
                                            {*{lang('use_the_consultants_address')} *}{lang(use_the_owner_address)}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-1 control-label" for="address3"> <input type="Radio" name="address" id="address3" value="new_address" onclick="show_new_address()" tabindex="22"/>
                                            <span id="username_box" style="display:none;"></span></div>
                                        <div class="col-sm-6">

                                            {lang('create_a_new_address')}:
                                        </div>
                                    </div>

                                    <div id="new_address" style="display:none" class="space">
                                        <div class="col-md-12">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="address_new">{lang('address')}:<font color="#ff0000">*</font> </label>
                                            <div class="col-sm-6">
                                                <textarea rows="6" name="address_new" id="address_new" cols="22" tabindex="23"  style="width: 182px;">{if isset($party_setup_arr['address_new'])}{$party_setup_arr['address_new']}{/if}</textarea>
                                                <span id="errormsg4"></span>
                                                <span id="username_box" style="display:none;"></span>
                                            </div> {form_error('address_new')}
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="country">{lang('country')}:<font color="#ff0000">*</font></label>
                                            <div class="col-sm-4">
                                                <select name="country" id="country" class="form-control" onChange="getAllStatessNewAdd(this.value)" tabindex="24" style="width: 182px;">
                                                    <option value="">{lang('select_country')}</option>
                                                    {foreach from=$countries item=v}                                 
                                                        <option value="{$v.country_id}">{$v.country_name}</option>   
                                                    {/foreach}                                                  
                                                </select>
                                                <span id="username_box" style="display:none;"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="new_state">{lang('state')}:</label>
                                            <div class="col-sm-4">
                                                <select name="new_state" id="new_state" class="form-control" tabindex="25" style="width: 182px;">
                                                    <option value="">{lang('select_state')}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="city">{lang('city')}:<font color="#ff0000">*</font></label>
                                            <div class="col-sm-6">
                                                <input  type="text"  name="city" id="city"   autocomplete="Off" tabindex="26" {if isset($party_setup_arr['city'])} value="{$party_setup_arr['city']}"{/if}>
                                                <span id="errormsg5"></span>
                                                <span id="username_box" style="display:none;"></span>
                                                {form_error('city')}
                                            </div>
                                        </div>

                                        <div  id="state_div" >

                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="zip">{lang('zip')}:<font color="#ff0000">*</font></label>
                                            <div class="col-sm-6">
                                                <input  type="text"  name="zip" id="zip" maxlength="6"  autocomplete="Off" tabindex="27" {if isset($party_setup_arr['zip'])} value="{$party_setup_arr['zip']}"{/if} >
                                                {form_error('zip')}
                                                <span id="errormsg11"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="phone">{lang('phone')}:<font color="#ff0000">*</font></label>
                                            <div class="col-sm-6">
                                                <input  type="text"  name="phone" id="phone"   autocomplete="Off"  maxlength="10" tabindex="28" {if isset($party_setup_arr['phone'])} value="{$party_setup_arr['phone']}"{/if}>
                                                {form_error('phone')}
                                                <span id="errormsg12"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="email">{lang('email')}:<font color="#ff0000">*</font></label>
                                            <div class="col-sm-6">
                                                <input  type="text"  name="email" id="email"   autocomplete="Off" tabindex="29" {if isset($party_setup_arr['email'])} value="{$party_setup_arr['email']}"{/if}>
                                                {form_error('email')}
                                                <span id="username_box" style="display:none;"></span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="height: 36%;">
                                    <i class="fa fa-external-link-square"></i> {lang('step')}{lang('five')} :{lang('complete_the_party_setup')} !

                                </div>
                                <div class="panel-body">
                                    <table class="space">
                                        <tr>
                                            <td class="middle">
                                                {lang('click_the_button')}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-indent:200px">
                                                <input class="btn btn-bricky" type="submit" name="submit" id="submit"value="{lang('setup_my_party')}!" tabindex="30">                                                        
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function () {
        Main.init();
        DatePicker.init();
        validateParty.init();

    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}