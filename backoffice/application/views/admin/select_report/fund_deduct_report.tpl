
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

{*include file="../select_report/report_tab.tpl"  name=""*}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('fund_deduct')}
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
                {form_open('admin/report/fund_deduct_report_view','role="form" class="smart-wizard form-horizontal" method="post"  name="daily" id="daily" target="_blank"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group connected-group">
                            <label class="col-sm-2 control-label">
                                {lang('week_wise')}: <span class="symbol required"></span>
                            </label>
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="week" id="week" class="form-control">
                                        <option value="{lang('all')}">{lang('all')}</option>
                                        {for $i = 1;$i<=52;$i++}
                                            <option value="{$i}" {if date('W')== $i} selected {/if} >{$i}</option>                            {/for}                            
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="year" id="year" class="form-control">
                                            <option value="{lang('all')}">{lang('all')}</option>
                                            {for $i = date('Y'); $i >= 2000; $i--}
                                                <option value="{$i}" {if date('Y')== $i} selected {/if} >{$i}</option>
                                            {/for}                       
                                        </select>
                                    </div>        
                                </div>


                            </div>
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky"tabindex="3" type="submit" name="weekdate" value="{lang('search')}">{lang('search')}
                                </button> 
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