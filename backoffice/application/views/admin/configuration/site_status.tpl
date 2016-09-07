{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}




<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('site_status')}
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
                {form_open('', 'id="form_setting" method="post" name="form_setting"')}
                    <table width="50%" cellspacing="5" cellpadding="5" border="0" align="left">
                        <tbody>
                            <tr>
                                <td>
                                    {lang('Site_status')}
                                </td>
                                <td>
                                    <select name="site_status" style="width: 80%">
                                        <option selected="" value="active">
                                            {lang(' Active')}
                                        </option>
                                        <option value="maintenance">
                                            {lang(' Maintenance')}
                                        </option>
                                    </select>
                                    {form_error('site_status')}
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('Maintenance_Content')}</td>                                <td>
                                    <textarea id="content" name="content" rows="10" cols="22"></textarea>{form_error('content')}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <input id="setting" type="submit" name="setting" tabindex="7" value="update"></input>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
