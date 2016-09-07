{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_news_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_news')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_news_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_news_there_is_no_undo')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('info/news')}
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

                {form_open_multipart('admin/news/add_news','role="form" class="smart-wizard form-horizontal"  name="upload_news" id="upload_news"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="news_title">{lang('headline')}<font color="#ff0000"> *</font> </label>
                    <div class="col-sm-3">
                        <input tabindex="1" class="form-control" name="news_title" id="news_title" type="text" size="30" value="{$news_title}" maxlength="100"/>{form_error('news_title')}
                        <span class="help-block" for="news_title"></span>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-sm-2 control-label" for="news_desc">{lang('news_description')} <font color="#ff0000"> *</font> </label>
                    <div class="col-sm-9">
                        <textarea class="ckeditor form-control"  id="news_desc"  name="news_desc"  tabindex="2" >{$news_desc}</textarea>{form_error('news_desc')}
                    </div>
                    <span class="help-block" for="news_desc"></span>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_id"> Upload Image</label>
                    <div class="col-sm-5">
                        <div class="fileupload fileupload-new " data-provides="fileupload" >
                            {* <div class="fileupload-new thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"><img src="{$PUBLIC_URL}images/subdomain_logo/{$site_details["logo"]}" alt="" value="">
                            </div>*}
                            <div class="fileupload-preview fileupload" ></div>
                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Upload Image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>

                                    <input type="file" id="userfile" name="userfile" tabindex="3" value="" >
                                </span>
                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>Remove
                                </a>
                            </div>
                        </div><div  style="color:gray;font-style: italic; font-size:15px;">(max size:2MB  file formats support:gif,jpg,png,jpeg)</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="link">{lang('link')}</label>
                    <div class="col-sm-3">
                        <input tabindex="4" class="form-control"  name="link" id="link" type="text" size="30" value="{$news_title}"/>{form_error('link')}
                        <span class="help-block" for="link"></span>
                    </div>
                </div>


                <div class="form-group">

                    <div class="col-sm-2 col-sm-offset-2">
                        {if $edit_id==""}
                            <button class="btn btn-bricky"tabindex="5" name="news_submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                        {else}
                            <button class="btn btn-bricky" tabindex="5" name="news_update" type="submit" value="{lang('update')}" style="background-color:#84A031; border-color:#84A031; font-weight:bold;"> {lang('update')}</button>
                            <input name="news_id" id="news_id" type="hidden"  value="{$news_id}"/>
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
                <i class="fa fa-external-link-square"></i>{lang('info/news')}
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
                                <th>Si {lang('no')}</th>
                                <th>{lang('date')}</th>
                                <th>{lang('news_title')}</th>
                                <th>{lang('image')}</th>  
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="i" value=0}
                            {foreach from=$news_details item=v}
                                {assign var="news_id" value="{$v.news_id}"}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.news_date}</td>
                                    <td>{$v.news_title}</td>
                                    <td>{$v.news_image}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:edit_news({$news_id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')} {$v.news_title}"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:delete_news({$news_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.news_title}"><i class="fa fa-times fa fa-white"></i></a>
                                            <a href="javascript:view_news({$news_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.news_title}">view</a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="javascript:edit_news({$news_id},'{$path}')">
                                                            <i class="fa fa-edit"></i> {lang('edit')}
                                                        </a>
                                                    </li>
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="javascript:delete_news({$news_id},'{$path}')">
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
                    <h4 align="center">{lang('no_news_found')}</h4>
                {/if}
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