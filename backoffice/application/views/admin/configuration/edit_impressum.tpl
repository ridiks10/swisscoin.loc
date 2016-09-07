<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('edit_impressum')}
            </div>
            <div class="panel-body">
            {form_open_multipart('admin/configuration/content_management','role="form" class="smart-wizard form-horizontal" name= "edit_footer_impressum" id= "edit_footer_impressum"')}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="footer_impressum_content">
                        Impressum:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="footer_impressum_content"  name="footer_impressum_content" class="ckeditor form-control"  tabindex="2">
                            {$footer_impressum}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-bricky col-sm-offset-2" name="update_button" id="footer_impressum" type="submit" value="Update"> Update</button>
                </div>
            {form_close()}
            </div>
        </div>
    </div>
</div>
</div>