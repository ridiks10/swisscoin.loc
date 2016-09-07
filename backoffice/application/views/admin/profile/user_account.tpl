{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
{include file="admin/profile/user_search.tpl" name=""}
{if $posted}
    <div id="user_account"></div>
    <div id="username_val" style="display:none;">{$user_name}</div>
{/if}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
                                        jQuery(document).ready(function() {
                                            Main.init();
                                            ValidateUser.init();
                                        });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}