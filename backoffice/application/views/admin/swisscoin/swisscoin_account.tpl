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
                <i class="fa fa-external-link-square"></i>{lang('swisscoin_account')}
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
             <div class="panel-body" style="min-height: 200px; max-height: 200px;">
                <div class="col-sm-3"></div>
                <div class="col-sm-7">
                     <img src="{$PUBLIC_URL}images/coming-soon-stamp.png" width="400px;" height="120px;"> 
                    
                </div>
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