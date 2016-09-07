{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<innerdashes>

    <hdash>   
        <img src="{$PUBLIC_URL}images/1335698592_edit.png" border="0" />
        {$tran_Product_Categories}
        {if $HELP_STATUS}
            <a href="https://infinitemlmsoftware.com/help/feedback" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png" /></buttons>
            </a>
        {/if}

    </hdash>

    <cdash-inner>


        <div id="shoping_cart">
            <div id="caption_head" class="caption">

                <table align="center" width="95%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50">
                            <div id="icon" class="shoping_cart"></div>
                        </td>
                        <td width="88%" align="left">
                            {$tran_Shopping_Cart}
                        </td>
                    </tr>
                </table>

            </div>
            <div class="cart_lines dottedborder_bottom">
                {$tran_Total_Items} : <span id="items">{$items}</span>
            </div>
            <div class="cart_lines dottedborder_bottom">
                {$tran_Amount} : <span class="orange_link"><a>$ <span id="amount">{number_format($amount, 2)}</span></a></span>
            </div>
            <div class="cart_lines_btn ">

                <table width="208" cellpadding="0" cellspacing="0" >
                    <tr>
                        <td>
                            <a href="{$BASE_URL}user/shopping/my_cart">
                                <div class="black_link" style="float:left">
                                    {$tran_View_Cart}
                                </div>
                            </a>
                        </td>

                    </tr>
                </table>
                </center>
            </div>
        </div>

        <table cellpadding="0" cellspacing="0" >
            <tr>
                {assign var="i" value=1}
                {$cat_count = count($categories)}
                {if $cat_count >0}
                    {foreach from=$categories item=v}

                        <td>
                            <div class="box_ecommerce">
                                <div class="head_products dottedborder_bottom google_font_caption">
                                    {$v.category}
                                </div>
                                <div id="product_view">
                                    <a href="{$BASE_URL}user/shopping/products/{$v.id}">
                                        <div align="center"><img src="{$image_path}categories/{$v.image}" height=150 width=125/>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </td>	

                        {if $i % 4 == 0}
                        </tr> <tr>
                        {/if}
                        {$i=$i+1}
                    {/foreach}
                </tr>
            {else}
                {$tran_No_Category_Found}
            {/if}

        </table>

    </cdash-inner>
</innerdashes>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
