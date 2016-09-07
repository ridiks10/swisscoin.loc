{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg1">{lang('you_must_enter_username')}</span>
</div>

{*<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('Matching_bonus')}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" id="user_name" name="user_name"  onKeyUp="ajax_showOptions(this, 'getCountriesByLetters', 'no', event)" autocomplete="Off" tabindex="1">
                             <input class="form-control" type="hidden" id="bonus_type" name="bonus_type" value="matching_bonus">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky" type="submit" id="select" value="select" name="select" tabindex="2">
                                {lang('select')}
                            </button>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>*}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('matching_bonus')} 
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
                    <center><h3>{lang('matching_bonus')} : {$user_name} </h3></center>
                    <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
                        <thead>
                            <tr class="th">
                                <th>Si No</th>
                            {*<th>{lang('from')}</th>*}
                            
                           
                            <th>{lang('date_of_submission')}</th>
                            <th>From User</th>
                            <th>{lang('amount_payable')}</th>
                            </tr>
                        </thead>
                        {if !empty($matching_bonus_details)}
                             {assign var="i" value=0}
                            {foreach from=$matching_bonus_details item=v}

                                <tr>
                                    <td>{$offset_bonus++}</td>
                                   {* <td>{$v.user_name}</td>*}
                                    
                                    <td>{$v.date_of_submission}</td>
                                    <td>{$v.from_user}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                </tr>	
                            {/foreach} 
                            <tr><td colspan="3" style="text-align: right"><b>{lang('amount_total')}</b></td><td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td></tr>
                        {else}
                             <tr style="text-align: center">
                                 <td colspan="4"> {lang('matching_not_found')}</td>
                           
                            </tr>
                            
                        {/if}
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

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateUser.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}