{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_compensation_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_compensation')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_compensation_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_compensation_there_is_no_undo')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('add_compensation_and_events')}
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
                
                      {form_open_multipart('admin/compensation/add_compensation','role="form" class="smart-wizard form-horizontal"  name="upload_compensation" id="upload_compensation"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="compensation_title">{lang('headline')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-3">
                        <input  name="compensation_title" id="compensation_title" type="text"  value="{$compensation_title}" class="form-control" maxlength="50"/>{form_error('compensation_title')}
                        <span class="help-block" for="compensation_title"></span>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-2 control-label" for="compensation_desc">{lang('compensation_description')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-9">
                        <textarea class="ckeditor form-control"  id="compensation_desc"  name="compensation_desc"  >{$compensation_desc}</textarea>{form_error('compensation_desc')}
                         <span id="errmsg1"></span>
                    </div>
                     
                   {* <span class="help-block" for="compensation_desc"></span>*}
                </div>
                     <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_id"> {lang('select_image')}</label>
                    <div class="col-sm-10">
                        <div class="fileupload fileupload-new" data-provides="fileupload" >

                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey"><span class="fileupload-new"><i class="fa fa-picture"></i></span>
                                   <input type="file" id="userfile" name="userfile" >
                                </span>
                                <div>&nbsp;<br/></div>
                               {* <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>Remove
                                </a>*}
                            </div><span class="help-block" for="upload_doc"></span>
                        </div>
                        <div  style="color:gray;font-style: italic; font-size:15px;">(max size:4 MB  file formats support:gif,jpg,png,jpeg)</div>

                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="link">{lang('link')} </label>
                    <div class="col-sm-3">
                        <input  name="link" id="link" type="text" value="{$compensation_link}"  class="form-control"/>{form_error('link')}
                        <span class="help-block" for="link"></span>
                    </div>
                </div>
      
                         
                <div class="form-group">

                    <div class="col-sm-2 col-sm-offset-2">
                        {if $edit_id==""}
                            <button class="btn btn-bricky" id="compensation_submit" name="compensation_submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                        {else}
                            <button class="btn btn-bricky"  id="compensation_update" name="compensation_update" type="submit" value="{lang('update')}" style="background-color:#84A031; border-color:#84A031; font-weight:bold;"> {lang('update')}</button>
                            <input name="compensation_id" id="compensation_id" type="hidden"  value="{$compensation_id}"/>
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
                <i class="fa fa-external-link-square"></i>{lang('compensation_details')}
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
                                <th>{lang('compensation_title')}</th>
                                <th>{lang('image')}</th>  
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="i" value=0}
                            {foreach from=$compensation_details item=v}
                                {assign var="compensation_id" value="{$v.compensation_id}"}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.compensation_date}</td>
                                    <td>{$v.compensation_title}</td>
                                    <td>{$v.compensation_image}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:edit_compensation({$compensation_id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')} {$v.compensation_title}"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:delete_compensation({$compensation_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.compensation_title}"><i class="fa fa-times fa fa-white"></i></a>
                                            <a href="javascript:view_compensation({$compensation_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.compensation_title}">view</a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">
                                                    <li role="presentation">
                                                        <a role="menuitem"  href="javascript:edit_compensation({$compensation_id},'{$path}')">
                                                            <i class="fa fa-edit"></i> {lang('edit')}
                                                        </a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a role="menuitem"  href="javascript:delete_compensation({$compensation_id},'{$path}')">
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
                    <h4 align="center">{lang('no_compensation_found')}</h4>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}