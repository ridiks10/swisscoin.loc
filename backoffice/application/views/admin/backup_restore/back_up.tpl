{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('title_needed')}</span>
    <span id="validate_msg2">{lang('you_must_select_a_file')}</span>
</div>
        
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('restore_defaults')}
            </div>
            <div class="panel-body">
                {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal"  method="post"  name="upload_materials" id="upload_materials"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>		  
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" name="restore" id="restore"  value="{lang('restore_defaults')}" tabindex="3"> {lang('restore_defaults')} </button>
                        </div>
                    </div>  
                {form_close()}
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