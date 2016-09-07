<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-ticket"></i>
                <div class="panel-tools">
                </div>
                {lang('create_ticket')} 
            </div>
            <div class="panel-body">
               {* <form role="form" class="smart-wizard form-horizontal"  name="compose" id="compose" method="post" action="" enctype="multipart/form-data">*}
                    {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal"  method="post"  name="compose" id="compose"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>  {lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 control-label">
                            {lang('Subject')} <span class="symbol required"></span> 
                        </label>
                        <div class="col-sm-4">
                            <!--<input tabindex="1" name="subject" type="text" id="subject" size="35"   />-->
                            <input type="text" name="subject" id="subject" class="form-control" tabindex="1" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            {lang('priority')}  <span class="symbol required"></span>
                        </label>
                        <div class="col-sm-4" >                                    
                            <select name="priority" id="priority" type="text" class="form-control" tabindex="2"> 
                                <option value="">Select {lang('priority')}</option>
                                {foreach from=$priority_arr item=v}
                                    <option value="{$v.priority_id}">{$v.priority}</option>
                                {/foreach}

                            </select>  
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="subject">{lang('category')} : <font color="#ff0000">*</font> </label>
                        <div class="col-sm-4">
                            <!--<input tabindex="1" name="subject" type="text" id="subject" size="35"   />-->
                            <select tabindex="3" name="category" type="text" id="category" class="form-control" >
                                <option value="">Select {lang('category')}</option>
                                {foreach from=$category_arr item=v}
                                    <option value="{$v.cat_id}">{$v.cat_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="message">{lang('message')}  : <font color="#ff0000">*</font></label>
                        <div class="col-sm-6">
                            <textarea tabindex="4" name='message' id='message' rows='8' cols='35' class="form-control" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="message">{lang('attachment')} :</label>


                        <div class="col-sm-8">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">Select {lang('file')} </span><span class="fileupload-exists">{lang('change')} </span>
                                    <input type="file" id="upload_doc" name="upload_doc" tabindex="3" >
                                </span>
                                <span class="fileupload-preview"></span>
                                <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">
                                    ×
                                </a>
                            </div>
                            <p class="help-block">
                                <font style="font-color:gray;"><i>({lang('allowed_types')})</i></font>
                            </p>
                        </div>    
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-4">
                            <button class="btn btn-bricky" type="submit" id="usersend" value="submit" name="usersend" tabindex="6">{lang('Submit')} </button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>


<script>
    jQuery(document).ready(function () {
        Main.init();
       ValidateCreateTicket.init();
    });

</script>
