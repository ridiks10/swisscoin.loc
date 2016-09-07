{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<innerdashes>
    <hdash>  
        <a href="{$BASE_URL}user/shopping/index">
            <div class='shop_btn' >{$tran_Back_to_Product_Categories}</div> 
        </a> 
        <table  width="50%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="70%" align="left">
                    <img src="{$PUBLIC_URL}images/1335698592_edit.png" border="0" />

                    <span id="jspdt">{$products_details['product']}</span>

                </td>
                <td width="16%" align="left">
                    <span id="msg" style="color:red"></span>
                </td>
                <td width="3%">
                    {if $prv >= $minId}
                        <a href="{$BASE_URL}user/shopping/view_details/{$prv}">
                            <div id="icon" class="prev_icon" ></div>
                        </a>
                    {else}
                        <a href="#"> 
                            <div id="icon" class="prev_icon" ></div>
                        </a>
                    {/if}

                </td>
                <td width="3%">
                    {if $nxt != ""}
                        {if $nxt <= $maxId}
                            <a href="{$BASE_URL}user/shopping/view_details/{$nxt}">
                                <div id="icon" class="next_icon" ></div>
                            </a>
                        {else}
                            <a href="#">  <div id="icon" class="next_icon" ></div>
                            </a>
                        {/if}
                    {else}
                        <a href="#">  <div id="icon" class="next_icon" ></div>
                        </a>
                    {/if}

                </td>
            </tr>
        </table>  

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
            <tr style="vertical-align:top;">
                <td>
                    <div id="left_detals">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <div id="product_view_lrge">
                                        <center>
                                            <ul id="popup_zoom">
                                                <li>
                                                    {$thumb_path1 =  $products_details['thumb1']}
                                                    {$thumb_path2 =  $products_details['thumb2']}
                                                    {$thumb_path3 =  $products_details['thumb3']}
                                                    {$img_path1 =  $products_details['image1']}
                                                    {$img_path2 =  $products_details['image2']}
                                                    {$img_path3 =  $products_details['image3']}


                                                    <img class="etalage_thumb_image" src="{$image_path}thumbs/{$thumb_path1}"/>
                                                    <img class="etalage_source_image" src="{$image_path}{$img_path1}"  />
                                                </li>
                                                <li>
                                                    <img class="etalage_thumb_image" src="{$image_path}thumbs/{$thumb_path2}" />
                                                    <img class="etalage_source_image" src="{$image_path}{$img_path2}" />
                                                </li>
                                                <li>
                                                    <img class="etalage_thumb_image" src="{$image_path}thumbs/{$thumb_path3}" />
                                                    <img class="etalage_source_image" src="{$image_path}{$img_path3}" />
                                                </li>
                                            </ul>
                                        </center>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div id="right_details">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <div style="width:425px;" class="head_products_categorised dottedborder_bottom google_font_caption" id="jspdtnm">
                                        {$products_details['product']}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="product_details">
                                        {form_open('', 'method="post" id="frm1" name="frm1" onsubmit="return getDetails(this)"')}
                                            <input type="hidden" id="nxtid" name="nxtid" value="{$nxt}"/>
                                            <input type="hidden" id="pdtid" name="pdtid" value="{$pid}"/>
                                            <input type="hidden" id="prvid" name="prvid" value="{$prv}"/>
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td height="30">
                                                        <b> {$tran_Brand} : <span class="orange_link" id="jsbrand"><a>&nbsp;&nbsp;{$products_details["brand"]}</a></span></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30">
                                                        <b> {$tran_Price}  : <span class="orange_link" id="jsprice"><a>&nbsp;&nbsp;$&nbsp;&nbsp;{number_format($products_details["price"], 2)}</a></span></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30">
                                                        <b>{$tran_Rate_of_Tax}: <span class="orange_link" id="jstax"><a>&nbsp;&nbsp;{number_format($products_details["tax"],2)}%</a></span></b>
                                                    </td>
                                                </tr>												
                                                <tr>
                                                    <td height="30">
                                                        <span class="label"><b>{$tran_Quantity} :</b></span> &nbsp;&nbsp; <input type="input" id="qty" style="width:129px;" value="1" class="field" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="60">
                                                        <input type="submit" class="red_btn" value="{$tran_Add_to_Cart}" name="add" id="add"/>
                                                        <input type="hidden" name="path" id="path" value="{{$BASE_URL}}"/>
                                                        <img src="{$BASE_URL}public_html/images/loader.gif" style="display:none" id="loader" name="loader"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        {form_close()}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!--tabs-->
                                    <div id="tab-container" class='tab-container'>
                                        <ul class='etabs'>
                                            <li class='tab'><a href="#tabs1-html">{$tran_Description}</a></li>
                                            <li class='tab'><a href="#tabs1-js">{$tran_Features}</a></li>
                                        </ul>
                                        <div class='panel-container'>
                                            <div id="tabs1-html">
                                                <table cellpadding="0" cellspacing="0" width="410px">

                                                    <tr>
                                                        <td>
                                                            <div id="jsdes">{$products_details["description"]}</div>
                                                        </td>                                                            
                                                    </tr>  
                                                </table>
                                            </div>
                                            <div id="tabs1-js">
                                                <table cellpadding="0" cellspacing="0" width="410px">
                                                    <tr>
                                                        <td>
                                                            <div id="jsfet">
                                                                {$products_details["features"]}
                                                            </div>
                                                        </td>                                                            
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--tabs-->
                                </td>
                            </tr>
                        </table>                                               
                    </div>
                </td>
            </tr>
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
