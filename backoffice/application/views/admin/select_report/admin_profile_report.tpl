{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{*include file="../select_report/report_tab.tpl"  name=""*}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_a_valid_user_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_count')}</span>
    <span id="error_msg9">{lang('digits_only')}</span>
    <span id="error_msg4">{lang('you_must_enter_count_from')}</span>
    <span id="error_msg5">{lang('you_must_enter_count')}</span>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('profile_report')}
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
                {form_open('admin/report/profile_report_view','role="form" class="smart-wizard form-horizontal" method="post"  name="searchform" id="searchform" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">
                            {lang('select_user_name')}:
                        </label>
                        <div class="col-sm-6">
                            <input tabindex="1" type="text" autocomplete="Off" id="user_name" name="user_name">
                            <br>{if $error_count && isset($error_array['user_name'])}{$error_array['user_name']}{/if}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="2"   type="submit" id="profile_update" name="profile_view" value="{lang('view')}"  > {lang('view')}</button>
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
                <i class="fa fa-external-link-square"></i> {lang('profile_report')}   
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
                {form_open('admin/report/profile_report','role="form" class="smart-wizard form-horizontal"  name="searchform1" id="searchform1" target="_blank" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>{lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="count">
                            {lang('enter_count')}:
                        </label>
                        <div class="col-sm-6">
                            <input tabindex="3" type = "text" name = "count" id = "count">
                        {if $error_single_count && isset($error_array_count['count'])}{$error_array_count['count']}{/if}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" tabindex="4"   type="submit" id="profile" name="profile" value="{lang('view')}"  > {lang('view')}</button> 

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
                <i class="fa fa-external-link-square"></i>{lang('profile_report')} 
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
                {form_open('admin/report/profile_report_multiple_count','role="form" class="smart-wizard form-horizontal"   name="from_to_form" id="from_to_form" method="post" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="count_from">
                            {lang('enter_count_start_from')}:
                        </label>
                        <div class="col-sm-6">
                            <input tabindex="5" type = "text" name = "count_from" id = "count_from">
                        {if $error_profile_count && isset($error_array_profile_count['count_from'])}{$error_array_profile_count['count_from']}{/if}
                    </div> 
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="count_to">
                        {lang('enter_count')}:
                    </label>
                    <div class="col-sm-6">
                        <input tabindex="6" type = "text" name = "count_to" id = "count_to">
                    {if $error_profile_count && isset($error_array_profile_count['count_to'])}{$error_array_profile_count['count_to']}{/if}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="7"   type="submit" name="profile_from" id="profile_from" value="{lang('view')}"  >{lang('view')}</button>
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
        ValidateUser.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}