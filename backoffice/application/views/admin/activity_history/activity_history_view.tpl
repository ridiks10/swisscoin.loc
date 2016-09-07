{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('activity_history')}{*<b>{if $user_name!="admin"} {$user_name}{/if}</b>*}
            </div>
            <div class="panel-body"> 
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                        <tr class="th">
                            <th><b>{lang('id')}</b></th>
                            <th><b>{lang('date')}</b></th>
                            <th><b>{lang('username')}</b></th>
                            <th><b>{lang('ip_address')}</b></th>
                            <th><b>{lang('activity')}</b></th>
                        </tr>
                    </thead>
                    {if $details_count>0}
                        <tbody>
                            {assign var="root" value="{$BASE_URL}admin/"}
                            {foreach from=$activity_details item=v}
                                <tr>
                                    <td>{$start++}</td>                                  
                                    <td>{$v.date}</td> 
                                    {if $v.activity == 'new user registered'}
                                    <td>{$v.username}</td> 
                                    {else}
                                    <td>{$v.username_done}</td> 
                                    {/if}
                                    <td>{$v.ip}</td> 
                                    {if lang($v.activity)}
                                       <td>{lang($v.activity)}</td>
                                    {else}
                                       <td>{$v.activity}</td>  
                                    {/if}
                                </tr>
                            {/foreach}
                        </tbody>

                    </table>
                    {$result_per_page}    
                {else}
                    <tbody>
                        <tr><td colspan="13" align="center" ><h4 align="center">{lang('no_data')}</h4></td></tr>
                    </tbody>
                    </table> 
                {/if}
            </div>
        </div>
    </div>
</div>
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            ValidateUser.init();
            TableData.init();
        });
    </script>
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}