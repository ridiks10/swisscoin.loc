{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="errmsg">{lang('please_enter_a_username')}</span>
    <span id="errmsg1">{lang('please_enter_remarks')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>   {lang('upgrade_account')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="search_mem" id="search_mem"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}:<font color="#ff0000">*</font></label>
                        <div class="col-sm-3">
                            <input class="form-control"  type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" > {form_error('user_name')}

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="remarks">{lang('remarks')}<font color="#ff0000">*</font> </label>
                        <div class="col-sm-9">
                            <textarea   name="remarks" id="remarks" tabindex="2" ></textarea>{form_error('remarks')}
                            <span class="help-block" for="remarks"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">

                            <button class="btn btn-bricky"  type="submit" name="activate" id="activate" value="{lang('activate')}" tabindex="2" > {lang('activate')} </button>

                        </div>
                        <div class="col-sm-2 col-sm-offset-2">

                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">

                            <button class="btn btn-bricky"  type="submit" name="inactivate" id="inactivate" value="{lang('inactivate')}" tabindex="2" > {lang('inactivate')} </button>

                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>

    </div>

</div>    



{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function() {
        Main.init();
        //TableData.init();
        ValidateUpgradeMember.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}