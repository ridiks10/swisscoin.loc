{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"}
<div class="row"  >
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('add_new_webinars')}
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
                {form_open_multipart('','role="form" class="smart-wizard form-horizontal" name= "webinar-form"  id="webinar-form"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('date')}<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="date" id="date" type="text" size="20" maxlength="10" placeholder="yyyy-mm-dd" value="{if $edit == TRUE}{$webinar['webinar_date']}{else}{set_value('date')}{/if}">
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            </div>{form_error('date','<div style="color :red;">', '</div>')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('url')}<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <input  type="text" id="url" name="url" autocomplete="Off"  class="form-control" placeholder="{lang('url')}" value="{if $edit == TRUE}{$webinar['url']}{else}{set_value('url')}{/if}">{form_error('url','<div style="color :red;">', '</div>')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('webinar_username')}<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <input  type="text" id="user_name" name="user_name" autocomplete="Off"  class="form-control"  maxlength="50" placeholder="{lang('webinar_username')}" value="{if $edit == TRUE}{$webinar['username']}{else}{set_value('user_name')}{/if}">{form_error('user_name','<div style="color :red;">', '</div>')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('webinar_password')}</label>
                        <div class="col-sm-4">
                            <input  type="password" id="password" name="password" maxlength="50" autocomplete="Off"  class="form-control" placeholder="{lang('webinar_password')}" value="{if $edit == TRUE}{$webinar['password']}{else}{set_value('password')}{/if}">{form_error('password','<div style="color :red;">', '</div>')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="topic">{lang('topic')}<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <input  type="text" id="topic" name="topic" autocomplete="Off"  maxlength="50"  class="form-control" placeholder="{lang('topic')}" value="{if $edit == TRUE}{$webinar['topic']}{else}{set_value('topic')}{/if}">{form_error('topic','<div style="color :red;">', '</div>')}
                        </div>
                    </div>
                        
                        
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">{lang('description')}<span class="symbol required"></span></label>
                        <div class="col-sm-9">
                            <textarea id="txtDefaultHtmlArea" name="txtDefaultHtmlArea" autocomplete="Off"  class="ckeditor form-control" placeholder="{lang('description')}">{if $edit == TRUE}{$webinar['description']}{else}{set_value('password')}{/if}</textarea>{form_error('txtDefaultHtmlArea','<div style="color :red;">', '</div>')}
                            <span id="errmsg1"></span>
                        </div>
                    </div>
                            <div class="form-group">
                        <label class="col-sm-2 control-label" for="description">{lang('youtube_vimeo_embed')}<span class="symbol required"></span></label>
                        <div class="col-sm-9">
                            <textarea  type="text" id="video" name="video"  class="form-control">{if $edit == TRUE}{$webinar['video']}{else}{set_value('video')}{/if}</textarea>{form_error('video','<div style="color :red;">', '</div>')}
                            <span id="errmsg15"></span>
                        </div>
                    </div>
                            <label class="col-sm-2 control-label" for="topic">{lang('webinar_image')}<span class="symbol required"></span></label>
                            <div class="fileupload fileupload-new " data-provides="fileupload" >
                                
                                <div class="fileupload-new thumbnail " style="width: 250px; height: 250px;"><img src="{if $edit == TRUE}{$PUBLIC_URL}images/webinar_images/{$webinar['image']}{else}{set_value('')}{/if}" alt="">
                                </div>
                                
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 250px; max-height: 250px; line-height: 20px;"></div>
                                <div class="user-edit-image-buttons ">
                                    <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> {lang('select_image')}</span><span class="fileupload-exists"><i class="fa fa-picture"></i> {lang('change')}</span>
                                        <input type="file" id="userfile" name="userfile" >
                                    </span>
                                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                        <i class="fa fa-times"></i>{lang('remove')}
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-2" style="color:gray;font-style: italic; font-size:15px;">(max size:6 MB  file formats support:gif,jpg,png,jpeg)</div>
                    
                   <br/>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-3">
                            {if $edit == TRUE}
                                <button class="btn btn-bricky" type="submit" name="edit_webinar" id="edit_webinar"value="edit_webinar" >
                                    {lang('edit_webinar')}
                                </button>
                            {else}
                                <button class="btn btn-bricky" type="submit" name="add_webinar" id="add_webinar"value="add_webinar" >
                                    {lang('add_webinar')}
                                </button>{/if}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
    <script>
        jQuery(document).ready(function () {
            Main.init();
            DatePicker.init();
            $('.summernote').summernote({
            height: 300
            });
            
        });
    </script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}