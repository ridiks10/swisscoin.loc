{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_workshop_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_workshop')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_workshop_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_workshop_there_is_no_undo')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('add_workshop_and_events')}
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
                
                      {form_open_multipart('admin/workshop/add_workshop','role="form" class="smart-wizard form-horizontal"  name="upload_workshop" id="upload_workshop"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="workshop_title">{lang('headline')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-3">
                        <input  name="workshop_title" id="workshop_title" type="text" minlength="3" maxlength="30" size="30" value="{$workshop_title}" class="form-control"/>{form_error('workshop_title')}
                        <span class="help-block" for="workshop_title"></span>
                    </div>
                </div>



                {*<div class="form-group">
                    <label class="col-sm-2 control-label" for="workshop_desc">{lang('workshop_description')}<font color="#ff0000">*</font> </label>
                    <div class="col-sm-9">
                        <textarea class="ckeditor form-control"  id="workshop_desc"  name="workshop_desc"  tabindex="2" >{$workshop_desc}</textarea>
                    </div>
                    <span class="help-block" for="workshop_desc"></span>
                </div>*}
                     <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_id"> {lang('Select_A_file')}<font color="#ff0000"> *</font></label>
                    <div class="col-sm-8">
                        <div class="fileupload fileupload-new" data-provides="fileupload" >

                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey"><span class="fileupload-new"><i class="fa fa-picture"></i></span>
                                   <input type="file" id="userfile" name="userfile" >
                                </span>
                               <div  style="color:gray;font-style: italic; font-size:15px;">(max size:6 MB  file formats support:gif,jpg,png,jpeg)</div>
                            </div><span class="help-block" for="upload_doc"></span>
                        </div>
                       

                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="link">{lang('link')} <font color="#ff0000"> *</font></label>
                    <div class="col-sm-3">
                        <input  name="link" id="link" type="text" value="" class="form-control" maxlength="300"/>{form_error('link')}
                        <span class="help-block" for="link"></span>
                    </div>
                </div>
      
                         
                <div class="form-group">

                    <div class="col-sm-2 col-sm-offset-2">
                        {if $edit_id==""}
                            <button class="btn btn-bricky" name="workshop_submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                        {else}
                            <button class="btn btn-bricky"  name="workshop_update" type="submit" value="{lang('update')}" style="background-color:#84A031; border-color:#84A031; font-weight:bold;"> {lang('update')}</button>
                            <input name="workshop_id" id="workshop_id" type="hidden"  value="{$workshop_id}"/>
                        {/if}
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
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
                <i class="fa fa-external-link-square"></i>{lang('workshop_details')}
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
                {if $arr_count!=0}
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th">
                                <th>{lang('no')}</th>
                                <th>{lang('date')}</th>
                                <th>{lang('workshop_title')}</th>
                                <th>{lang('image')}</th>  
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="i" value=0}
                            {foreach from=$workshop_details item=v}
                                {assign var="workshop_id" value="{$v.workshop_id}"}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.workshop_date}</td>
                                    <td>{$v.workshop_title}</td>
                                    <td>{$v.workshop_image}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="{$path}workshop/add_workshop/edit/{$workshop_id}" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')} {$v.workshop_title}"><i class="fa fa-edit"></i></a>
                                            <a href="{$path}workshop/add_workshop/delete/{$workshop_id}" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.workshop_title}"><i class="fa fa-times fa fa-white"></i></a>
                                            <a href="{$path}workshop/view_workshop/view/{$workshop_id}" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.workshop_title}">view</a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">
                                                    <li role="presentation">
                                                        <a role="menuitem"  href="javascript:edit_workshop({$workshop_id},'{$path}')">
                                                            <i class="fa fa-edit"></i> {lang('edit')}
                                                        </a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a role="menuitem"  href="javascript:delete_workshop({$workshop_id},'{$path}')">
                                                            <i class="fa fa-times"></i> {lang('remove')}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                    </table>
                {else}
                    <h4 align="center">{lang('no_workshop_found')}</h4>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
{*        ValidateUser.init();*}

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}