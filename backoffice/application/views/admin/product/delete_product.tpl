{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<innerdashes>
    <cdash-inner>
        {include file="admin/product/product_tab.tpl"  name=""}
    </cdash-inner>
</innerdashes>
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{$tran_you_must_enter_your_product_name}</span>
    <span id="error_msg2">{$tran_you_must_enter_your_product_identifying_number}</span>
    <span id="error_msg3">{$tran_you_must_enter_your_product_amount}</span>
    <span id="error_msg4">{$tran_you_must_enter_your_product_pair_value}</span>
    <span id="validate_msg">{$tran_enter_digits_only}</span>
    <span id="validate_msg1">{$tran_digits_only}</span>
    <span id="confirm_msg">{$tran_Sure_you_want_to_delete_this_Product_There_is_NO_undo}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>  
<innerdashes>
    <hdash>
        <img src="{$PUBLIC_URL}images/1337773000_delete-basket.png" border="0" />
        &nbsp;&nbsp;&nbsp;&nbsp;{$tran_delete_product}
        {if $HELP_STATUS}
            <a href="https://infinitemlmsoftware.com/help/delete-product" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png" /></buttons></a>
                {/if}
    </hdash>
    <cdash-inner>
        <table id="grid">
            <thead>
                <tr class="th">
                    <th>No</th>
                    <th>{$tran_product_id}</th>
                    <th >{$tran_product_name}</th>
                    <th>{$tran_product_amount}</th>
                    <th >{$tran_product_pair_value}</th>
                    <th>{$tran_product_status}</th>
                    <th>{$tran_action}</th>
                </tr>
            </thead>
            {if  count($product_details)!=0}
                {assign var="clr" value=""}
                {assign var="i" value=0}
                <tbody>
                    {foreach from=$product_details item=v}

                        {if $i%2==0}
                            {$clr='tr1'}
                        {else}
                            {$clr='tr2'}
                        {/if}
                        {assign var="id" value="{$v.product_id}"}
                        {assign var="name" value="{$v.product_name}"}
                        {assign var="active" value="{$v.active}"}
                        {assign var="date" value="{$v.date_of_insertion}"}
                        {assign var="prod_id" value="{$v.prod_id}"}
                        {assign var="prod_value" value="{$v.product_value}"}
                        {assign var="pair_value" value="{$v.pair_value}"}

                        {if $active=='yes'}
                            {$status=$tran_active}
                        {else}
                            {$status=$tran_inactive}
                        {/if}
                        <tr>
                            <td>{$i}</td>
                            <td>{$prod_id}</td>
                            <td>{$name}</td>
                            <td>{$prod_value}</td>
                            <td>{$pair_value}</td>
                            <td>{$status}</td>
                            <td><a href="javascript:delete_prod({$id})"><img src="{$PUBLIC_URL}images/delete.png" title="Delete {$name}" style="border:none;"></a></td>
                        </tr>
                        {$i=$i+1}
                    {/foreach}
                </tbody>
                <counter></counter>
                {else}
                <tr><td colspan="6" align="center"><h4>No Product Found</h4></td></tr>
            {/if}
        </table>
    </cdash-inner>
</innerdashes>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}