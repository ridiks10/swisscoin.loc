{if $LOG_USER_TYPE=='distributor'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
{/if}
<innerdashes>
    <hashes>       
    </hashes>
    <cdash-inner>
        <table align="center" width="50%">
            <tr>
                <td>
                    {form_open('', 'method="post" action="https://test.authorize.net/gateway/transact.dll"')}
                        {*               <form method='post' action="https://secure.authorize.net/gateway/transact.dll">*}
                        <input type='hidden' name="x_login" value="{$api_login_id}" />
                        <input type='hidden' name="x_fp_hash" value="{$fingerprint}" />
                        <input type='hidden' name="x_amount" value="{$amount}" />
                        <input type='hidden' name="x_fp_timestamp" value="{$fp_timestamp}" />
                        <input type='hidden' name="x_fp_sequence" value="{$fp_sequence}" />
                        <input type='hidden' name="x_version" value="3.1">
                        <input type='hidden' name="x_show_form" value="payment_form">
                        {*                   <input type='hidden' name="x_test_request" value="false" />*}
                        <input type='hidden' name="x_method" value="cc">
                        <input type='submit' value="Click here for the secure payment form" class="btn btn-red btn-block">
                    {form_close()}
                </td>
            </tr>
        </table>
    </cdash-inner>
</innerdashes>

{if $LOG_USER_TYPE=='distributor'}﻿
    {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{/if}

<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script> 

{if $LOG_USER_TYPE=='distributor'}﻿
    {include file="user/layout/page_footer.tpl" title="Example Smarty Page" name=""}
{else}
    {include file="admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}
{/if}


