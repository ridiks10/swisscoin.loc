{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('must_enter_keyword')}</span>                  
    <span id="error_msg5">{lang('You_must_enter_your_mobile_no')}</span>
    <span id="error_msg1">{lang('you_must_enter_your_name')}</span>
    <span id="error_msg6">{lang('You_must_enter_your_email')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<cdash-inner> 

    <div class="row" style="display:{$visible};"  >
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('edit_employee')}
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

                    {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal" method="post" id="edit_form" name="edit_form"  style="display: {$visibility}"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                {lang('image_upload')}
                            </label>
                            <div class="fileupload fileupload-new" data-provides="fileupload" >
                                <div class="col-sm-6">
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{$PUBLIC_URL}images/employee/{$file_name}" alt="">
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                    <div class="user-edit-image-buttons">

                                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> {lang('select_image')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> {lang('change')}</span>
                                            <input type="file" id="userfile" name="userfile" tabindex="4">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i>{lang('remove')}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {foreach from=$editdetails item=v}
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="full_name">{lang('first_name')} :<font color="#ff0000">*</font></label>
                                <div class="col-sm-4">
                                    <input  type="text"  name="first_name" id="first_name" size="30"  autocomplete="Off" value="{$v.user_detail_name}" maxlength="32" minlength="2" tabindex="1">
                                    <span id="username_box" style="display:none;"></span>
                                </div>
                                {form_error('first_name')}
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="full_name">{lang('last_name')} :<font color="#ff0000">*</font></label>
                                <div class="col-sm-4">
                                    <input  type="text"  name="last_name" id="last_name" size="30"  autocomplete="Off" value="{$v.user_detail_second_name}" maxlength="32" minlength="2" tabindex="2">
                                    <span id="username_box" style="display:none;"></span>
                                </div>
                                {form_error('last_name')}
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="mobile">{lang('mob_no_10_digit')} :<font color="#ff0000">*</font></label>
                                <div class="col-sm-6">
                                    <input name="mobile" id="mobile" type="text" maxlength="10" autocomplete="Off" tabindex="3" value="{$v.user_detail_mobile}" size="30" >
                                    <span id="username_box" style="display:none;"></span>
                                    <span id="errmsg3"></span>
                                </div>
                                {form_error('mobile')}
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="email">{lang('email')}:<font color="#ff0000">*</font></label>
                                <div class="col-sm-2">
                                    <input name="email" id="email" type="text"  autocomplete="Off" value="{$v.user_detail_email}"  size="30" tabindex="3">
                                    <span id="username_box" style="display:none;"></span>
                                </div>
                                {form_error('email')}
                            </div>
                        {/foreach}

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <p>
                                    <button class="btn btn-bricky" value="Update" tabindex="3" name="update" id="update" tabindex="5">
                                        {lang('update')}
                                    </button>
                                </p>
                            </div>

                        </div>
                    {form_close()}
                </div>
            </div>
        </div>   
    </div>  

</cdash-inner>                
{if $keyword}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('view_employee')} 
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
                            <tr class="th">
                                <th>{lang('no')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('first_name')}</th>
                                <th>{lang('last_name')}</th>
                                <th>{lang('mobile_no')}</th>
                                <th>{lang('email')}</th>                               
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        {if $count>0} 
                            {assign var="i" value=0}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="class" value=""}
                            <tbody>
                                {foreach from=$emp_detail item=v}
                                    {assign var="id" value="{$v.user_id}"}

                                    {if $i%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}

                                    <tr>
                                        <td>{$v.page_no}</td>
                                        <td>{$v.user_name}</td>
                                        <td>{$v.user_detail_name}</td>
                                        <td>{$v.user_detail_second_name}</td>
                                        <td>{$v.user_detail_mobile}</td>
                                        <td>{$v.user_detail_email}</td>

                                        <td>
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                <a href="#" onclick="edit_employee({$id}, '{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title=""><i class="fa fa-edit"></i></a>
                                                <a href="javascript:delete_employee({$id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title=""><i class="fa fa-times fa fa-white"></i></a>
                                            </div>
                                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                <div class="btn-group">
                                                    <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                        <i class="fa fa-cog"></i> <span class="caret"></span>
                                                    </a>
                                                    <ul role="menu" class="dropdown-menu pull-right">
                                                        <li role="presentation">
                                                            <a role="menuitem" tabindex="-1" href="#" onclick="edit_employee({$id}, '{$path}')">
                                                                <i class="fa fa-edit"></i>{lang('edit')}
                                                            </a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a role="menuitem" tabindex="-1" href="#" onclick="delete_employee({$id}, '{$path}')">
                                                                <i class="fa fa-times"></i> {lang('remove')}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {$i=$i+1}
                                {/foreach}
                            </tbody>
                        {else}                   
                            <tbody>
                                <tr><td colspan="12" align="center"><h4>{lang('No_User_Found')}</h4></td></tr>
                            </tbody> 
                        {/if}
                    </table>
                    {$pagination}

                </div>

            </div>
        </div>   
    </div>  
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function () {
        Main.init();
        DatePicker.init();
        TableData.init();
        ValidateMember.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}