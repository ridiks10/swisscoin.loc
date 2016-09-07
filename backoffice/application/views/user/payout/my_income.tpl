
{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">        
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('income')}
            </div>
            <div class="panel-body">
                {assign var="count" value = count($binary)}
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                        <tr class="th">
                            <th class="hidden-xs">S.No.</th>
                            <th class="hidden-xs">{lang('paid_date')}</th>
                            <th class="hidden-xs">{lang('paid_amount')}</th>    
                            <th>{lang('status')}</th>
                        </tr>
                    </thead>
                    {if $count>0} 
                        {assign var="i" value =1}
                        {assign var="status" value = ""}
                        {assign var="class" value = ""}
                        <tbody>
                            {foreach from=$binary item=v}
                                <tr class="{$class}">        
                                    <td class="hidden-xs" >{$i} </td>                            
                                    <td class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;{$v.paid_date}</td>
                                     <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td class="hidden-xs">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$v.paid_type}</td>                                  
                                </tr>
                                {$i=$i+1}

                            {/foreach}
                        </tbody>
                    </table>
                {else}
                    <tbody>
                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_income_found')}</h4></td></tr>
                    </tbody>
                    </table>
                {/if}

            </div>
        </div>
    </div>
</div>


{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{if $count>0} 
    <script>
        jQuery(document).ready(function() {
            Main.init();
            TableData.init();
            ValidateUser.init();
        });
    </script>
{else}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            ValidateUser.init();
        });
    </script>
{/if}
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}