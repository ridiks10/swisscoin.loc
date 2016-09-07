{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_package_title')}</span>
    <span id="error_msg1">{lang('you_must_enter_package')}</span>
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_package_there_is_no_undo')}</span>
    <span id="confirm_msg2">{lang('sure_you_want_to_delete_this_package_there_is_no_undo')}</span>
</div>

<div class="row">
    <div class="alert alert-success" style="display: none;" id="success_msg_xhr">Request has been completed!</div>
    <div class="alert alert-danger" style="display: none" id="error_msg_xhr">Something went wrong!</div>

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>Tokens
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
                {if $arr_count!=0}
                    <h2>{lang('history')}</h2>
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th">
                                <th>{lang('no')}</th>
                                {*<th>{lang('package_date')}</th> *}
                                <th>{lang('package_price')}</th>
                                <th>{lang('package_name')}</th>
                                <th>{lang('package_token')}</th>
                                <th>{lang('token_per_pack')} / {lang('quantity')}</th>
                                <th>{lang('package_splits')}</th>
                                <th>{lang('in_mining')}</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>

                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {assign var="i" value=0}
                            {foreach from=$package_details item=v}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                   {* <td>{$v.package_date}</td>*}
                                     <td>{$DEFAULT_SYMBOL_LEFT}{$v.package_price*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    <td>{$v.package_name}</td>
                                   
                                   
                                    <td>{$v.package_token}</td>
                                    <td>{$v.token_per_one} / {$v.quantity}</td>
                                    <td>{$v.package_assigned_split}/{$v.package_splits}</td>
                                    <td>{$v.package_mining}</td>

                               
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                    </table>
                {else}
                    <h4 align="center">{lang('no_package_found')}</h4>
                {/if}
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>Open Tokens
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
                {if $arr_count!=0 && $has_open}
                    <h2>{lang('open_tokens')}</h2>
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                        <tr class="th">
                            <th>{lang('no')}</th>
                            {*<th>{lang('package_date')}</th> *}
                            <th>{lang('package_price')}</th>
                            <th>{lang('package_name')}</th>
                            <th>{lang('package_token')}</th>
                            <th>{lang('token_per_pack')} / {lang('quantity')}</th>
                            <th>{lang('package_splits')}</th>
                            <th>{lang('in_mining')}</th>


                        </tr>
                        </thead>
                        <tbody>

                        {assign var="class" value=""}
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {assign var="i" value=0}
                        {foreach from=$package_details item=v}
                            {if $v.package_mining eq "YES"}
                                {continue}
                            {/if}
                            {if $i%2==0}
                                {$class='tr1'}
                            {else}
                                {$class='tr2'}
                            {/if}
                            {$i=$i+1}
                            <tr class="{$class}">
                                <td>{$i}</td>
                                {* <td>{$v.package_date}</td>*}
                                <td>{$DEFAULT_SYMBOL_LEFT}{$v.package_price*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</td>
                                <td>{$v.package_name}</td>


                                <td>{$v.package_token}</td>
                                <td>{$v.token_per_one} / {$v.quantity}</td>
                                <td>{$v.package_assigned_split}/{$v.package_splits}</td>
                                <td>{$v.package_mining}</td>


                            </tr>
                        {/foreach}
                        </tbody>
                        <counter></counter>
                    </table>
                {else}
                    <h4 align="center">{lang('no_package_found')}</h4>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
       // TableData.init();

    });

</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}