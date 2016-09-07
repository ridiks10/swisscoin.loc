{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}




<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-12">
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
                    <h3>User details</h3>
                </center>
                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                    <tr class="th" align="center">
                        <th class="col-sm-1">User ID</th>
                        <th class="col-sm-1">User name</th>
                        <th class="col-sm-2">Total Tokens</th>
                        <th class="col-sm-2">Deducted Tokens</th>
                        <th class="col-sm-2">Result Tokens</th>
                        <th class="col-sm-2">Deduct Tokens</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="tr2" align="center">
                            <td>{$user.id}</td>
                            <td>{$user.name}</td>
                            <td>{$user.total_tokens}</td>
                            <td>{$user.deducted_tokens}</td>
                            <td>{$user.total_tokens - $user.deducted_tokens}</td>
                            <td>
                                {form_open('','role="form" class="smart-wizard form-horizontal" name= "deduct_token_amount_form"  id="deduct_token_amount_form"')}
                                <input type="text" name="amount" />
                                <input type="hidden" name="user_id" value="{$user.id}" />
                                <button class="btn btn-bricky" style="margin-left: 17px;" type="submit" name="deduct_token_amount" id="get_data" value="Submit" tabindex="2">Deduct</button>
                                {form_close()}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        //ValidateUser.init();
    });
    jQuery(document).ready(function() {
        jQuery("#user_name, #to_user_name, #new_user_name, .username-auto-ajax").autocomplete({
            source: document.getElementById('base_url').value + "admin/ajax/autocomplete",
            minLength: 3
        });
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}


