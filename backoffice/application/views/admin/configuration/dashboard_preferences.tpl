{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg1">{lang('values_greater_than_0')}</span>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs tab-green">

                <li class="{$_tabs['tab1']}">
                    <a href="#panel_tab1_example1" data-toggle="tab">{lang('update_swisscoin')}</a>
                </li>
                <li class="{$_tabs['tab2']}">
                    <a href="#panel_tab2_example2" data-toggle="tab">{lang('update_splitindicator')}</a>
                </li>
                <li class="{$_tabs['tab3']}">
                    <a href="#panel_tab3_example3" data-toggle="tab">{lang('update_skg')}</a>
                </li>
                <li>
                    <a href="#panel_tab4_example4" data-toggle="tab">{lang('assign_splits')}</a>
                </li>
            </ul>

            <input type="hidden" id="active_tab" name="active_tab">
            {form_open('','role="form" class="smart-wizard form-horizontal" name= "dashboard_preferences"  id="dashboard_preferences"')}
            <div class="tab-content">

                <div class="tab-pane {$_tabs['tab1']}" id="panel_tab1_example1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('swisscoin')}
                        </div>

                        <div class="panel-body">
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label" for="swisscoin_value">{lang('swisscoin')}<span class="symbol required"></span>:</label>

                                <div class="col-sm-3">
                                    <input tabindex="31" maxlength="10" type="text" name="swisscoin_value" id="swisscoin_value" value="{$_data['swiss_val']}" title="" class="form-control">
                                    <span id="errmsg3">{form_error('swisscoin_value')}</span>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="32" name="setting" id="setting" style="margin-left:25%;" title="{lang('update')}" onclick="setHiddenValue('tab1')">{lang('update')}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane {$_tabs['tab2']}" id="panel_tab2_example2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('splitindicator')}
                        </div>

                        <div class="panel-body">
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label" for="splitindicator_value">{lang('splitindicator')} %<span class="symbol required"></span>:</label>

                                <div class="col-sm-3">
                                    <input tabindex="31" maxlength="10" type="text" name="splitindicator_value" id="splitindicator_value" value="{$_data['split_val']}" title="" class="form-control">
                                    <span id="errmsg3">{form_error('splitindicator_value')}</span>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="32" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab2')">{lang('update')}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane {$_tabs['tab3']}" id="panel_tab3_example3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-external-link-square"></i>{lang('SKG')}
                        </div>

                        <div class="panel-body">
                            <div class="form-group clearfix">
                                <label class="col-sm-2 control-label" for="ac_skg_v">{lang('SKG')} <span class="symbol required"></span>:</label>

                                <div class="col-sm-3">
                                    <input tabindex="31" maxlength="10" type="text" name="ac_skg_v" id="ac_skg_v" value="{$_data['skg_value']}" title="" class="form-control">
                                    <span id="errmsg3">{form_error('skg_value')}</span>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-bricky"  type="submit" value="{lang('update')}" tabindex="32" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab3')">{lang('update')}</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="panel_tab4_example4">
                    <h1>{lang('Assign splits')}</h1>
                    <hr>
                    <a id="run" class="btn btn-primary">Run script</a>
                    <a id="stop" class="btn btn-danger" style="display:none;">Stop script</a>
                    <hr>
                    <a id="restart" class="btn btn-warning">Restart (reset)</a>
                    <hr>
                    <p style="margin-top:10px">State: <span id="state">waiting for action...</span></p>
                    <p style="margin-top:10px"><span id="done">0</span> / <span id="total">0</span></p>
                    <hr>
                    <div style="margin-top:10px" class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width:0%;">
                        </div>
                    </div>
                    <div id="result" style="margin-top:10px">
                    </div>
                </div>
            </div>
            {form_close()}


        </div>
    </div>
</div>

<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    var ajaxurl = "{$ADMIN_AJAX_URL}/assign_splits";
    var restarturl = "{$ADMIN_AJAX_URL}/restart_splits";
</script>
<script>
    jQuery(document).ready(function () {
        Main.init();
        //ValidateDashboardPreferences.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}


