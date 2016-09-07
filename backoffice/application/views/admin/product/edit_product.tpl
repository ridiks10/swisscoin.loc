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
    <span id="confirm_msg">{$tran_Sure_you_want_to_edit_this_Product_There_is_NO_undo}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

<innerdashes>
    <hdash>
        <img src="{$PUBLIC_URL}images/1337773000_basket.png" border="0" />
        &nbsp;&nbsp;&nbsp;&nbsp;{$tran_edit_product}
        {if $HELP_STATUS}
            <a href="https://infinitemlmsoftware.com/help/edit-product" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png" /></buttons></a>
                {/if}
    </hdash>

    <cdash-inner>
        <!--update-->
        {if $action=="edit"}
            {form_open('', 'method="POST" name="proadd" id="proadd" onSubmit= "return validate_product_add(this);" class="niceform"')}
                <table  cellspacing="10" >
                    <tr>
                        <td width="180">Name of the Product :</td>
                        <td><input tabindex="1" type="text" name="prod_name" id="prod_name" size="35" value="{$pr_name}"/></td>
                    </tr>
                    <tr>
                        <td>Product ID :</td>
                        <td><input tabindex="2" type="text" name="product_id" id="product_id" size="35" value="{$pr_id_no}" readonly='true'/></td>
                    </tr>
                    <tr>
                        <td>Product Amount :</td>
                        <td><input tabindex="3" type="text" name="product_amount" id="product_amount" size="35" value="{$pr_value}"/>
                            <span id="errmsg1"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Pair Value</td>
                        <td><input tabindex="4" type="text" name="product_value" id="product_value" size="35" value="{$pr_pair_value}"/> 
                            <input tabindex="5" type="hidden" name="prod_id" id="prod_id" size="35" value="{$pr_id}"/>
                            <span id="errmsg2"></span></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td><td ><input tabindex="6" type="submit" name="update_prod" value="update Product"> </td>
                    </tr>
                </table>
            {form_close()}
            <br />
            <hr/>
        {/if}
        <!--update-->

        <table id="grid">
            <thead>
                <tr class="th">
                    <th data-field="No">No</th>
                    <th data-field="{$tran_product_id}">{$tran_product_id}</th>
                    <th data-field="{$tran_product_name}">{$tran_product_name}</th>
                    <th data-field="{$tran_product_amount}">{$tran_product_amount}</th>
                    <th data-field="{$tran_product_pair_value}">{$tran_product_pair_value}</th>
                    <th data-field="{$tran_product_status}">{$tran_product_status}</th>
                    <th data-field="{$tran_action}">{$tran_action}</th>
                </tr>
            </thead>           
            {if count($product_details)!=0}
                {assign var="i" value=0}
                {assign var="clr" value=""}
                <tbody>
                    {foreach from =$product_details item=v}
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
                            <td><a href="javascript:edit_prod({$id})"><img src="{$PUBLIC_URL}images/edit.png" title="Edit {$name}" style="border:none"></a></td>
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