{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('You Must Enter Depth Ceiling')}</span>
    <span id="error_msg1">{lang('digits_only')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

<!-- start: PAGE CONTENT -->

{if $MLM_PLAN =="Binary"}

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('setting_depth')}
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
                    {form_open('', 'role="form" class="smart-wizard form-horizontal" name="set_depth_width" id="set_depth_width" method="post"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="depth_value">{lang('depth_value')}:<font color="#ff0000">*</font></label>
                            <div class="col-sm-6">
                                <input  type="text"  name="depth_value" id="depth_value" value="{$obj_arr["depth_ceiling"]}" tabindex="1" >
                                <span id="username_box" style="display:none;"></span><span id="error_msg1"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" tabindex="4"   type="submit"  value="{lang('update')}" name="update" id="update" tabindex="3"> {lang('update')}</button>
                            </div>
                        </div>  
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/if}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateSettings.init();
        
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}