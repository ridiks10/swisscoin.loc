{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_user_name_length')}</span>
    <span id="validate_msg2">{lang('user_name_length_should_be')}</span>
    <span id="validate_msg3">{lang('you_must_enter_user_name_prefix')}</span>
    <span id="validate_msg4">{lang('invalid_user_name_prefix')}</span>  
    <span id="user_name_config">{$username_config['prefix']}</span>
</div>



<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('user_name_configuration')}
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

                {form_open('','role="form" class="smart-wizard form-horizontal" name="username_config_form" id="username_config_form"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>

                <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">

                <table class="table-full-width" id="sample_1">
                    <tr>
                        <td width="200">{lang('select_a_user_name_type')}:</td>
                        <td>
                            <input tabindex="1" type="radio" name="user_name_type" id="Dynamic" value="dynamic" {if $username_config["type"] == "dynamic"} checked {/if}  />
                            <label for="Dynamic"></label>
                            {lang('Dynamic')}
                            <input type="radio" tabindex="1" name="user_name_type" id="Static" value="static" {if $username_config["type"] == "static"} checked {/if}  /> 
                            <label for="Static"></label>
                            {lang('Static')}{form_error('user_name_type')}
                        </td>
                    </tr>
                    {if $username_config["type"] == "dynamic"}
                        <tr id="user_type_div"  style="display: none;">

                            <td width="200">{lang('user_name_length')}:<font color="#ff0000">*</font></td>
                            <td><input tabindex="2" type="text" name ="length" id ="length" value="{$username_config["length"]}" maxlength="2" title="{lang('user_length_title')}"><span id="errmsg1"></span></td>
                        </tr>
                    {else}
                        <tr id="user_type_div"  style="display: none;">

                            <td width="200">{lang('user_name_length')}:<font color="#ff0000">*</font></td>
                            <td><input tabindex="2" type="text" name ="length" id ="length" value="{$username_config["length"]}" maxlength="2" title="{lang('user_length_title')}"><span id="errmsg1"></span>{form_error('length')}</td>
                        </tr>
                    {/if}
                    {if $username_config["type"] == "dynamic"}
                        <tr id="user_type_div1"  style="display: none;">     
                            <td>{lang('do_you_want_user_name_prefix')}:</td>
                            <td><input tabindex="3" type="radio" name="prefix_status" id="yes" value="yes"  {if $username_config["prefix_status"] == "yes"} checked {/if} title="{lang('You_can_set_the_username_prefix')}"  /> 
                                <label for="yes"></label>{lang('yes')}
                                <input tabindex="3" type="radio" name="prefix_status" id="no" value="no" {if $username_config["prefix_status"] == "no"} checked {/if} title="{lang('The_username_do_not_have_a_character_prefix')}" onclick="hide_prefix()"/> <label for="no"></label>{lang('no')} {form_error('prefix_status')}</td>
                        </tr>
                    {else}
                        <tr id="user_type_div1"  style="display: none;" >     
                            <td>{lang('do_you_want_user_name_prefix')}:</td>
                            <td><input tabindex="3" type="radio" name="prefix_status" id="yes" value="yes"  {if $username_config["prefix_status"] == "yes"} checked {/if} title="{lang('You_can_set_the_username_prefix')}"  /> <label for="yes"></label>{lang('yes')}<input tabindex="3" type="radio" name="prefix_status" id="no" value="no" {if $username_config["prefix_status"] == "no"} checked {/if} title="{lang('The_username_do_not_have_a_character_prefix')}" /> <label for="no"></label>{lang('no')} </td>
                        </tr>
                    {/if}
                    <tr id="prefix_div"  style="display:none;"> </tr>


                    <tr>
                    <tr>
                        <td></td>
                        <td>


                            <button class="btn btn-bricky" tabindex="4"   type="submit" value="{lang('update')}" name="update" id="update" > {lang('update')}</button>


                        </td></tr>
                    </tr>
                </table>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateContentManagement.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
