{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

{*<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_package_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_package')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_package_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_package_there_is_no_undo')}</span>
</div>*}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>Edit
            </div>

            <div class="panel-body">
                {form_open('admin/swisscoin/foundation','role="form" class="smart-wizard form-horizontal"  method="post"')}

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="content">Content </label>
                    <div class="col-sm-9">
                        <textarea rows="12"  name="content" id="content" cols="22" tabindex="2" class="ckeditor form-control">{$content}</textarea><span class='validation_error'>{form_error('content')}</span>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-sm-2 col-sm-offset-2">

                        <button class="btn btn-bricky" tabindex="3" name="foundation_submit" type="submit" value="Update">Update</button>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">

                </div>
                {form_close()}
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('foundation')}
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
            <div class="panel-body" style="min-height: 230px; max-height: 230px;">
                <div class="col-sm-3"></div>
                <div class="col-sm-7">
                    {$content}
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
       // TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}