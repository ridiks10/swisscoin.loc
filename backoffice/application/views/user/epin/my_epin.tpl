{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">           
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('epins')}
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
            {if count($pin_numbers)==0}
                <div class="panel-body">
                    <h4><center>{lang('no_epin_found')}</center></h4>
                </div>
            {else}
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('epins')}</th>
                                <th>{lang('amount')}</th>
                                <th>{lang('balance_amount')}</th>
                                <th>{lang('used_user')}</th>
                                <th>{lang('status')}</th>
                                <th>{lang('uploaded_date')}</th>
                                <th>{lang('expiry_date')}</th>
                            </tr>
                        </thead>
                        {* {if count($pin_numbers)!=0}*}
                        <tbody>    
                            {assign var="i" value=$start_id}
                            {assign var="class" value=""}
                            {foreach from=$pin_numbers item=v}

                                {if $i%2==0}

                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {if $v.used_user==""}
                                    {assign var="used_user" value="{lang('NULL')}"}
                                {else}
                                    {assign var="used_user" value="{$v.used_user}"}
                                {/if}
                                {if $v.status=="yes"}
                                    {assign var="stat" value="{lang('active')}"}
                                {else if $v.status=="expired"}
                                    {assign var="stat" value="{lang('expired')}"}
                                {else}
                                    {assign var="stat" value="{lang('used')}"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}" align="center" >

                                    <td>{$i}</td>
                                    <td>{$v.pin}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td>{$used_user}</td>
                                    <td>{$stat}</td>
                                    <td>{$v.pin_uploded_date}</td>
                                    <td>{$v.pin_expiry_date}</td>
                                </tr>
                            {/foreach}                
                        </tbody>
                        {*{else}                   
                        <tbody>
                        <tr><td colspan="12" align="center"><h4>{lang('no_epin_found')}</h4></td></tr>
                        </tbody> *}
                    {/if}

                </table>
                {$page_footer}
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