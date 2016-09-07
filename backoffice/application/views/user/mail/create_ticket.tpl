<div id="span_js_messages" style="display:none;"> 
    <span id="error_msg1">{lang('subject_is_required')}</span>
    <span id="error_msg2">{lang('priority_is_required')}</span>
    <span id="error_msg3">{lang('category_is_required')}</span>
    <span id="error_msg4">{lang('message_is_required')}</span>    
</div>
<style>
    .val-error {
        color:rgba(249, 6, 6, 1);
        opacity:1;
    }
</style>

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
                {lang('Create_ticket')}           </div>
            <div class="panel-body">
               
                    
                  {form_open_multipart('user/mail/ticket_system', 'role="form" class="smart-wizard form-horizontal" name="site_config" id="site_config" enctype="multipart/form-data"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="col-sm-2 control-label">
                            {lang('subject')} <span class="symbol required"></span> 
                        </label>
                        <div class="col-sm-4">
                            <input type="text" name="subject" id="subject" class="form-control" tabindex="1" {if isset($create_ticket_arr['subject'])} value="{$create_ticket_arr['subject']}"{/if}/>
                            {if isset($validation_error['subject'])}<span class='val-error' >{$validation_error['subject']} </span>{/if}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            {lang('Priority')}  <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-4" >                                 
                            <select name="priority" id="priority" type="text" class="form-control" tabindex="2"> 

                                {if isset($create_ticket_arr['priority']) && $create_ticket_arr['priority']!=""}
                                    <option value="">{lang('Select_priority')}</option>

                                    <option value="3"  {if $create_ticket_arr['priority']=="3"}selected{/if}>{lang('Low')}</option>                                  

                                    <option value="2" {if $create_ticket_arr['priority']=="2"}selected{/if}>{lang('Medium')}</option>

                                    <option value="1" {if $create_ticket_arr['priority']=="1"}selected {/if}>{lang('High')}</option>


                                {else}
                                    <option value="">{lang('Select_priority')}</option>
                                    <option value="3">{lang('Low')}</option>
                                    <option value="2">{lang('Medium')}</option>
                                    <option value="1">{lang('High')}</option>
                                {/if}
                            </select>  
                            {if isset($validation_error['priority'])}<span class='val-error' >{$validation_error['priority']} </span>{/if}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="subject">{lang('Category')} : <font color="#ff0000">*</font> </label>
                        <div class="col-sm-4">
                            <select tabindex="3" name="category" type="text" id="category" class="form-control" >
                                <option value="">{lang('Select_type')}</option>
                                {foreach from=$category_arr item=v}
                                    {if isset($create_ticket_arr['category']) && $create_ticket_arr['category']!="" && $v.cat_id == $create_ticket_arr['category']}
                                        <option value="{$v.cat_id}" selected>{$v.cat_name}</option>
                                    {/if}   
                                    <option value="{$v.cat_id}">{$v.cat_name}</option>
                                {/foreach}
                            </select>
                            {if isset($validation_error['category'])}<span class='val-error' >{$validation_error['category']} </span>{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message">{lang('Message_to_admin')} : <font color="#ff0000">*</font></label>
                        <div class="col-sm-4">
                            <textarea tabindex="4" name='message' id='message' rows='11' cols='35' class="form-control" >{if isset($create_ticket_arr['message'])}{$create_ticket_arr['message']}{/if}</textarea>
                            {if isset($validation_error['message'])}<span class='val-error' >{$validation_error['message']} </span>{/if}
                        </div>

                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message">{lang('attachment')} :</label>
                        <div class="col-sm-3">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <span class="">
                                    <input type="file" id="upload_doc" name="upload_doc" tabindex="5" >
                                </span>
                                <span class="fileupload-preview"></span>

                            </div>
                            <p class="help-block">
                                <font color="#ff0000">{lang('kb')}({lang('Allowed_types_are_gif_jpg_png_jpeg_JPG')})</font>
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit"id="usersend" value="submit" name="usersend" tabindex="6">{lang('Submit')}</button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateTicket.init();
    });
</script>

