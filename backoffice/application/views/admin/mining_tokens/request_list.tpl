{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

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
                <i class="fa fa-external-link-square"></i> {lang('mining_release')}
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
            {if $count > 0 }
            <div class="panel-body">
                <div id="transaction" type="hidden">
                    <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="div1"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                        <tr class="th" align="center">
                        <tr class="th" align="center">
                            <th>{lang('no')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('request_date')}</th>
                            <th>{lang('requested_tokens')}</th>
                            <th>{lang('coins')}</th>
                            <th>Token per pack / Quantity / Splits </th>
                            <th>{lang('package_name')}</th>
                            <th>{lang('action')}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach from=$mining_details item="v"}
                            <tr class="" align="center" >
                                <td>{counter}</td>
                                <td>{$v.user_name}</td>
                                <td>{$v.request_date}</td>
                                <td>{$v.requested_tokens}</td>
                                <td>{$v.tokens_to_mining}</td>
                                <td>{$v.token_per_pack} / {$v.quantity} / {$v.assigned_splits}</td>
                                <td>{$v.package_name}</td>
                                <td>
                                    <button class="btn btn-success">release</button>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky disabled" tabindex="1" name="release_payout" id="release_payout" type="submit" value="release_payout"> {lang('release')} </button>
                        </div>
                    </div>
            </div>
            {else}
                <h5 align="center">No Details Found</h5>
            {/if}
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
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
//        TableData.init();
//        ValidatePayoutRelease.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}