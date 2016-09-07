{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="row_msg">rows</span>
    <span id="show_msg">shows</span>
</div>


<div id="fade"></div>
<div id="trigger"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                   User Bv
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

                {if count($top_earners)>0}
                    <a href={$BASE_URL}admin/excel/create_excel_top_earners_report>{lang('create_excel')}</a>

                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th" align="center">
                                <th width="10%" >Si No</th>
                               
                                <th width="30%">{lang('user_name')}</th>
                                 <th width="30%">{lang('name')}</th>
                                {*<th >{lang('current_balance')}</th>
                                <th >{lang('total_earnings')}</th>
                                <th >{lang('action')}</th>*}
                                <th width="30%">Accumulated BV</th>

                            </tr>
                        </thead>
                        <tbody>         

                            {assign var="i" value=0}                   
                            {foreach from=$top_earners item=v}                        

                                {if $i%2 == 0}
                                    {$tr_class="tr1"}	 
                                {else}
                                    {$tr_class="tr2"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$tr_class}"{* align="center"*} >
                                    <td>{$i}</td>
                                    <td>{$v.user_name}</td>
                                    <td>{if $v.name}{$v.name}{else} NA{/if}</td>
                                    <td>{$v.bv}</td>
                                    {*<td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.current_balance*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_earnings*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>*}
                                   {* <td>
                                        {form_open('admin/ewallet/my_ewallet','method="post"')}
                                            <button value="{$v.user_name}" class="btn btn-bricky top-btn" name="user_name" type="submit">{lang('details')}</button>
                                        {form_close()}
                                    </td>*}

                                </tr>

                            {/foreach}   
                        </tbody>
                    </table>
                {else}
                    <div align="center">{lang('no_top_earners')}</div>
                {/if}



            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();


    });
</script>
{*{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}*}