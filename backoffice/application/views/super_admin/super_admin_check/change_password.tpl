{include file="super_admin/layout/header.tpl" name=""}
{*{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/menu.tpl" name=""}*}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                Change Password
            </div>
            <div class="panel-body">
                {form_open('', 'name="change_password" id="change_password" class="smart-wizard form-horizontal" method="post"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Change Password" name="change_password" id="change_password" style="width: 162px; margin-left: 122px;">Change Password</button>                                
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
      {*  {if $reg_count}
        validate_delete_reason.init();
        {/if}*}

    });
</script>

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  