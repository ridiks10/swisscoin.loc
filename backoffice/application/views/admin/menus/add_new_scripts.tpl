{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_scripts_there_is_no_undo')}</span>
    <span id="errmsg">{lang('please_enter_link_name')}</span>
    <span id="errmsg1">{lang('please_enter_script_name')}</span>
    <span id="errmsg2">{lang('please_enter_script_type')}</span>
    <span id="errmsg3">{lang('please_enter_script_loc')}</span>
    <span id="errmsg4">{lang('please_enter_script_order')}</span>
    <span id="errmsg5">{lang('please_enter_script_status')}</span>
    <span id="errmsg6">{lang('please_enter_link_name')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>   {lang('add_new_scripts')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="search_script" id="search_script"')}
                    <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="link_name">{lang('link_name')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input class="form-control"  type="text" id="link_name" name="link_name" autocomplete="Off" tabindex="1" value="{$link_name}"> {form_error('link_name')}

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky"  type="submit" name="search" id="search" value="{lang('search')}" tabindex="2" > {lang('search')} </button>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-bricky"  type="submit" name="add_link" id="add_link" value="{lang('add_link')}" tabindex="2" > {lang('add_link')} </button>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div> 

{if $script_flag}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
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
                    {lang('add_script')}
                </div>
                <div class="panel-body">
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="script_form" id="script_form"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="link_name">{lang('link_name')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <input class="form-control"  type="text"  name="link_name" id="link_name"  value="{$link_name}" tabindex="1" readonly="">
                                {form_error('link_name')}

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="script_name">{lang('script_name')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <input class="form-control"  type="text"  name="script_name" id="script_name"  value="{$script_name}" tabindex="1" autocomplete="off">
                                {form_error('script_name')}

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="script_type">{lang('script_type')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <select name="script_type" id="script_type" tabindex="1"  class="form-control">
                                    <option value="">{lang('select_script_type')}</option>
                                    <option value="css" {if $script_type=="css"}selected=""{/if}>css</option>
                                    <option value="js" {if $script_type=="js"}selected=""{/if}>js</option>
                                    <option value="plugins/css" {if $script_type=="plugins/css"}selected=""{/if}>plugins/css</option>
                                    <option value="plugins/js" {if $script_type=="plugins/js"}selected=""{/if}>plugins/js</option>
                                </select>
                                <span id="errmsg1"></span> {form_error('script_type')}

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="script_loc">{lang('script_loc')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <select name="script_loc" id="script_loc" tabindex="1"  class="form-control">
                                    <option value="">{lang('select_script_loc')}</option>
                                    <option value="header" {if $script_loc=="header"}selected=""{/if}  >header</option>
                                    <option value="footer" {if $script_loc=="footer"}selected=""{/if} >footer</option>
                                </select> 
                                <span id="errmsg2"></span>{form_error('script_loc')}

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="script_order">{lang('script_order')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <input class="form-control"  type="text" id="script_order" name="script_order" autocomplete="Off" tabindex="4" value="{$script_order}">
                                <span id="errmsg2"></span>{form_error('script_order')}

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="script_status">{lang('script_status')}<span class="symbol required"></span></label>
                            <div class="col-sm-3">
                                <select name="script_status" id="script_status" tabindex="1"  class="form-control">
                                    <option value="yes" {if $script_status=="yes"}selected=""{/if}  >{lang('enabled')}</option>
                                    <option value="no" {if $script_status=="no"}selected=""{/if} >{lang('disabled')}</option>
                                </select> 
                                <span id="errmsg2"></span>{form_error('script_status')}

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                {if $script_id==""}
                                    <button class="btn btn-bricky"tabindex="3" name="script_submit" type="submit" value="Submit">{lang('submit')}</button>
                                {else}
                                    <button class="btn btn-bricky" tabindex="3" name="script_update" type="submit" value="Update" style="background-color:#84A031; border-color:#84A031; font-weight:bold;">{lang('update')}</button>
                                    <input name="script_id" id="script_id" type="hidden"  value="{$script_id}"/>
                                {/if}

                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}

{if $flag}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {lang('script_details')} 
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
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="script_details" id="script_details"')}
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr class="th" align="center">
                                    <th >{lang('no')}</th>
                                    <th >{lang('script_name')}</th>
                                    <th >{lang('script_type')}</th>
                                    <th >{lang('script_loc')}</th>
                                    <th >{lang('script_order')}</th>                            
                                    <th >{lang('script_status')}</th>
                                    <th >{lang('action')}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {assign var="path" value="{$BASE_URL}admin/"}
                                {assign var="scripts_count" value=count($scripts)}
                                {if $scripts_count!=0}

                                    {assign var="i" value=0}
                                    {assign var="class" value=""}
                                    {foreach from=$scripts item=v}

                                        {if $i%2==0}
                                            {$class='tr1'}
                                        {else}
                                            {$class='tr2'}
                                        {/if}

                                        {$i=$i+1}

                                        <tr class="{$class}" align="center" >
                                            <td>{$i}</td>
                                            <td> {$v.script_name}</td>
                                            <td>{$v.script_type}</td>
                                            <td> {$v.script_loc}</td>
                                            <td>{$v.script_order} </td>
                                            <td> 
                                                {if $v.script_status=='yes'}
                                                    {lang('enabled')}
                                                {else if $v.script_status=='no'}
                                                    {lang('disabled')}
                                                {/if}
                                            </td>
                                            <td>
                                                <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                    <a href="javascript:edit_scripts({$v.id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-edit"></i></a>

                                                </div>
                                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </a>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li role="presentation">
                                                                <a role="menuitem" tabindex="-1" href="javascript:edit_scripts({$v.id},'{$path}')">
                                                                    <i class="fa fa-edit"></i> {lang('edit')}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    {/foreach}   
                                {else}
                                    <tr class="tr1" align="center" >
                                        <td colspan="7">
                                            <h3> {lang('No_Scripts_Found')}</h3>
                                        </td>
                                    </tr>
                                {/if}             
                            </tbody>
                        </table>
                        <div class="col-sm-2">
                            <button class="btn btn-bricky"  type="submit" name="add_script" id="add_script" value="{lang('add_script')}" tabindex="2" > {lang('add_script')} </button>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>       
{/if}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateScripts.init();
        TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}