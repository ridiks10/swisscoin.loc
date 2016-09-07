
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

{*include file="../select_report/report_tab.tpl"  name=""*}

<div id="span_js_messages" style="display: none;"> 
    <span id="error_msg">{lang('You_must_enter_user_name')}</span>    
</div>


{if $user_type=='admin'}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('bank_statement')}
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
                    {form_open('admin/report/bank_statement','role="form" class="smart-wizard form-horizontal" method="post"  name="daily" id="daily" target="_blank"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">
                                {lang('select_user_name')} <span class="symbol required"></span>
                            </label>
                            <div class="col-sm-6">
                                <input tabindex="1" type="text" id="user_name" name="user_name" autocomplete="Off" >
                                <br>{if $error_count && isset($error_array['user_name'])}{$error_array['user_name']}{/if}

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky"tabindex="3" type="submit" name="bank_stmnt" value="{lang('view')}">{lang('view')} </button>                        </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{else}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{lang('bank_statement')}
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
                    {form_open('admin/report/bank_statement','role="form" class="smart-wizard form-horizontal" method="post"  name="daily" id="daily" target="_blank"')}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user_name">
                                {lang('select_user_name')} <span class="symbol required"></span>
                            </label>
                            <div class="col-sm-6">
                                <input tabindex="1" type="text" id="user_name" name="user_name" autocomplete="Off" >

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">

                                <button class="btn btn-bricky"tabindex="3" type="submit" name="bank_stmnt_user" value="{lang('view_bank_statement_report')}">{lang('view_bank_statement_report')} </button>                        </div>
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
        ValidateUser.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}