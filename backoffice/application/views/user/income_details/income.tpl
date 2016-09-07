{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
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
                {lang('income_details')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="feedback_form" id="feedback_form"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    {assign var=i value="0"}
                    {assign var=class value=""}
                    

                        <table class="table table-striped table-bordered table-hover table-full-width" id="">
                            <thead>
                                <tr class="th" align="center">
                                    <th>{lang('no')}</th>
                                    <th>{lang('user_name')}</th>
                                    <th>{lang('amount_type')}</th>
                                    <th>{lang('amount')}</th>
                                </tr>
                            </thead>
                            {if count($amount)>0}
                            <tbody>
                                {foreach from=$amount item=v}
                                    {if $i%2 == 0}
                                        {$class="tr2"}
                                    {else}
                                        {$class="tr1"}
                                    {/if}		
                                    {$i = $i+1}
                                    {if $v.amount_type == 'leg'}
                                        {$v.amount_type = $tran_binary}
                                    {/if}
                                    <tr class="{$class}" align="center" >
                                        <td>{counter}</td>
                                        <td>{$v.from_id}</td>
                                        <td>{$v.amount_type}</td>
                                        <td>{$DEFAULT_SYMBOL_LEFT} {number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                {/foreach}
                                <tr><td colspan="3" style="text-align: right"><b>{lang('amount_total')}</b></td><td style="text-align: center"><b>{$DEFAULT_SYMBOL_LEFT} {$v.tot_amount*$DEFAULT_CURRENCY_VALUE} {$DEFAULT_SYMBOL_RIGHT}</b></td></tr>                                	
                            </tbody>
                        {else}
                            <tbody>
                                <tr><td colspan="12" align="center"><h4>{lang('no_income_details_were_found')}</h4></td></tr>
                            </tbody>
                        {/if}
                    </table>

                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
        jQuery(document).ready(function() {
        Main.init();
    TableData.init();

    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}