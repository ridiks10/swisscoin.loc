{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}




<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-12" style="padding:0px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> Search user by name
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
                    {form_open('','role="form" class="smart-wizard form-horizontal" name= "search_mem"  id="search_mem"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i>  You have some form errors. Please check below.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">Select Username<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input type="text" id="user_name" name="user_name" autocomplete="off" tabindex="1" class="ui-autocomplete-input"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" type="submit" name="get_data" id="get_data" value="Submit" tabindex="2">
                                Submit
                            </button>
                        </div>
                    </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('search_by_date')}
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

                {form_open('','role="form" class="smart-wizard form-horizontal" name="weekly_join" id="weekly_join" method="post"')}

                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="week_date1">{lang('from_date')}<span class="symbol required"></span></label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="1" size="20" maxlength="10" required>
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="week_date2">{lang('to_date')}<span class="symbol required"></span></label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="2" size="20" maxlength="10" required  >
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" id="weekdate" value="profile_update" name="weekdate" tabindex="3">
                            {lang('submit')}
                        </button>
                    </div>
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>


    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>User details
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

                <center>
                    <h3>Package detailed stats</h3>
                </center>
                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                    <tr class="th" align="center">
                        <th>№</th>
                        <th class="col-sm-1">{lang('date')}</th>
                        <th class="col-sm-1">{lang('user_name')}</th>
                        <th class="col-sm-2">{lang('package_name')} / {lang('quantity')}</th>
                        <th class="col-sm-2">{lang('total_amount')}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$details item=v}
                        <tr class="" align="center">
                            <td class="col-sm-1">{$offset++}</td>
                            <td>{$v.date}</td>
                            <td>{$v.user_name}</td>
                            <td>{$v.product_name} / {$v.quantity}</td>
                            <td>{$v.total_amount}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4 col-sm-offset-8">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {$links}
            </ul>
        </nav>
    </div>
</div>
<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        DatePicker.init();
    });
    jQuery(document).ready(function() {
        jQuery("#user_name, #to_user_name, #new_user_name, .username-auto-ajax").autocomplete({
            source: document.getElementById('base_url').value + "admin/ajax/autocomplete",
            minLength: 3
        });
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}


