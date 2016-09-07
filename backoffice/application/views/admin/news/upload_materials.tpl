{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('title_needed')}</span>
    <span id="validate_msg2">{lang('you_must_select_a_file')}</span>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('information_center')}
            </div>
            <div class="panel-body">
                {form_open_multipart('admin/news/upload_materials','role="form" class="smart-wizard form-horizontal"  name="upload_materials" id="upload_materials"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="file_title">{lang('File_Title')}:<font color="#ff0000">*</font> </label>
                    <div class="col-sm-3">
                        <input tabindex="1" name="file_title" id="file_title" type="text" size="30" value="" class="form-control"/>{form_error('file_title')}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="product_id"> {lang('Select_A_file')}:<font color="#ff0000">*</font></label>
                    <div class="col-sm-10">
                        <div class="fileupload fileupload-new" data-provides="fileupload" >

                            <div class="user-edit-image-buttons">
                                <span class="btn btn-light-grey"><span class="fileupload-new"><i class="fa fa-picture"></i></span>
                                    <input type="file" id="upload_doc" name="upload_doc" tabindex="2">
                                </span>
                                <div>&nbsp;<br/></div>
                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i>Remove
                                </a>
                            </div><span class="help-block" for="upload_doc"></span>
                        </div>
                        {*<font color="#ff0000">{lang('kb')}({lang('Allowed_types_are_pdf_ppt_docs_xls_xlsx')})</font>*}
<div  style="color:gray;font-style: italic; font-size:15px;">({lang('kb')}, {lang('Allowed_types_are_pdf_ppt_docs_xls_xlsx')})</div>
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" name="upload_submit" id="upload_submit"  value="{lang('upload')}" tabindex="3"> {lang('upload')} </button>
                    </div>
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
                <i class="fa fa-external-link-square"></i>{lang('information_center')}
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th">
                            <th>{lang('no')}</th>
                            <th>{lang('File_Title')}</th>
                            <th>{lang('uploaded_date')}</th>
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {if $arr_count!=0}
                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="i" value=0}
                            {foreach from=$file_details item=v}
                                {assign var="id" value="{$v.id}"}

                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td>{$v.file_title}</td>
                                    <td>{$v.uploaded_date}</td>
                                    <td> 
                                        <div class=""><!--visible-md visible-lg hidden-sm -->
                                            <a href="javascript:delete_docs({$id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete {$v.file_title}"><i class="fa fa-times fa fa-white"></i></a>
                                        </div>


                                    </td>
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                        {else}
                        <tr><td colspan="6" align="center"><h4>{lang('No_Materials_Found')}</h4></td></tr>
                                {/if}
                    </tbody>
                </table>
            </div>                        
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateNewsUpload.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}