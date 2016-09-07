{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_company_name')}</span>
    <span id="validate_msg2">{lang('non_valid_file')}</span>
    <span id="validate_msg3">{lang('only_png_jpg')}</span>
    <span id="validate_msg4">{lang('you_must_enter_email')}</span>
    <span id="validate_msg5">{lang('you_must_enter_valid_email')}</span>
    <span id="validate_msg15">{lang('you_must_enter_valid_url')}</span>
    <span id="validate_msg6">{lang('you_must_enter_phone')}</span>
    <span id="validate_msg7">{lang('you_must_enter_valid_phone')}</span>
    <span id="validate_msg8">{lang('you_must_enter_the_company_address')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <ul class="nav nav-tabs tab-green">
                <li class="{$tab1}">
                    <a href="#panel_tab3_example1" data-toggle="tab">{lang('site_information')}</a>
                </li>
                {*<li class="{$tab2}">
                    <a href="#panel_tab3_example2" data-toggle="tab">{lang('select_theme')}</a>
                </li>*}   
            </ul>              

            <div class="tab-content">
                <input type="hidden" name="active_tab" id="active_tab" value="" >

                <div class="tab-pane{$tab1}" id="panel_tab3_example1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>
                            {lang('site_information')}
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
                            {form_open_multipart('admin/configuration/site_information','role="form" class="smart-wizard form-horizontal" method="post"  name="site_config" id="site_config"')}
                            {if $preset_demo eq 'yes'}
                                <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_in_preset_demos')} </font>
                                <br>
                                <br>
                            {/if}
                            <div class="col-md-12">
                                <div class="errorHandler alert alert-danger no-display">
                                    <i class="fa fa-times-sign"></i> {lang('errors_check')}
                                </div>
                            </div>

                            <div class="form-group" style='display:none;' >
                                <label class="col-sm-2 control-label" for="img_logo">{lang('site_url')}:<font color="#ff0000">*</font> </label>
                                <div class="col-sm-5">
                                    <input  type="text"  name="lead_url" id="lead_url"  autocomplete="Off"  tabindex="1" value="{$site_info_arr["lead_url"]}" class="form-control" > <span id="errmsg15"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="co_name">{lang('company_name')}:<font color="#ff0000">*</font> </label>
                                <div class="col-sm-4">
                                    <input  type="text"  name="co_name" id="co_name"    autocomplete="Off" tabindex="2" value="{$site_info_arr["co_name"]}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="company_address">{lang('company_address')}:<font color="#ff0000">*</font> </label>
                                <div class="col-sm-6">
                                    <textarea  name="company_address" id="company_address" tabindex="3" rows="6" cols="35"   autocomplete="Off" >{$site_info_arr["company_address"]}</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="def_lan" id="def_lan" value="{$default_lang}" />
                            <div class="form-group">
                                <label class="col-sm-2 control-label" > {lang('logo')}:</label>

                                <div class="fileupload fileupload-new col-sm-4" data-provides="fileupload" >
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{$PUBLIC_URL}images/logos/{$site_info_arr["logo"]}" alt="" value="{$site_info_arr["logo"]}">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                    <div class="user-edit-image-buttons">
                                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> {lang('select_image')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
                                            <input type="file" id="img_logo" name="img_logo" tabindex="6" value="{$site_info_arr["logo"]}">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i>Remove
                                        </a>
                                    </div>
                                        <div  style="color:gray;font-style: italic; font-size:15px;">(max width: 178px height: 73px )</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" > {lang('icon')}:</label>

                                <div class="fileupload fileupload-new col-sm-4" data-provides="fileupload" >
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{$PUBLIC_URL}images/logos/{$site_info_arr["favicon"]}" alt="" value="{$site_info_arr["favicon"]}">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                    <div class="user-edit-image-buttons">
                                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> {lang('select_image')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>                                           
                                            <input type="file" id="favicon" name="favicon" tabindex="5" value="{$site_info_arr["favicon"]}">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i>Remove
                                        </a>
                                    </div>
                                        <div  style="color:gray;font-style: italic; font-size:15px;">(max width: 16px height: 16px )</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="email">{lang('email')}:<font color="#ff0000">*</font> </label>
                                <div class="col-sm-4">
                                    <input  type="text"  name="email" id="email"   autocomplete="Off" tabindex="7" value="{$site_info_arr["email"]}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="img_logo">{lang('phone')}: </label>
                                <div class="col-sm-4">
                                    <input  type="text"  name="phone" id="phone"   autocomplete="Off"  tabindex="8" maxlength="12" value="{$site_info_arr["phone"]}" class="form-control"> <span id="errmsg1"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky" name="site" id="site" value="{lang('update')}" tabindex="9" {if $preset_demo eq 'yes'}disabled{/if}>
                                        {lang('update')}
                                    </button>
                                </div>
                            </div>
                            {form_close()}
                        </div>
                    </div>
                </div>
                <div class="tab-pane{$tab2}" id="panel_tab3_example2">

                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        {lang('select_theme')}
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
                    <div class="panel-body" style="overflow: hidden;">
                        {form_open('admin/configuration/site_information','role="form" class="smart-wizard form-horizontal" method="post"  name="site_config" id="site_config"')}
                        <div class="row">
                            <input type="hidden" name="active_tab" id="active_tab" value="" >
                            <div class="form-group">
                                <label class="col-sm-4" for="admin_def_theme">
                                    <h5>{lang('admin_theme')}:</h5>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">  
                                    {$i=1}
                                    {foreach from=$admin_themes item=v}
                                        <div class="col-sm-3">
                                            <div class="col-sm-12">  
                                                <input type="radio" name="admin_def_theme" value="{$v.name}" {if $v.default} checked {/if} tabindex="{$i}">
                                                {strtoupper($v.name)}
                                            </div>  
                                            <div class="col-sm-12">
                                                <img style="padding-top: 10px; max-width: 300px; width: 100%;" src='{$PUBLIC_URL}images/themes/{$v.icon}' id="admin_theme">
                                            </div>  
                                        </div>
                                        {$i = $i+1}
                                    {/foreach}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4" for="user_def_theme">
                                    <h5>{lang('user_theme')}:</h5>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">   
                                    {foreach from=$user_themes item=v}
                                        <div class="col-sm-3">
                                            <div class="col-sm-12">  
                                                <input type="radio" name="user_def_theme" value="{$v.name}" {if $v.default} checked {/if}  tabindex="{$i}">
                                                {strtoupper($v.name)}
                                            </div>  
                                            <div class="col-sm-12">  
                                                <img style="padding-top: 10px; max-width: 300px; width: 100%;"  src='{$PUBLIC_URL}images/themes/{$v.icon}' id="user_theme">
                                            </div>  
                                        </div>
                                        {$i = $i+1}
                                    {/foreach}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-5 col-sm-offset-2 ">
                                    <button class="btn btn-bricky" name="update_theme" id="update_theme" value="update_theme" tabindex="12">
                                        {lang('update')}
                                    </button>
                                </div> 
                            </div>
                            {form_open()}
                        </div>
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
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
