{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<style>

    .box{
        min-height:335px;
        border:solid 1px #ccc;
    }
    .box ul {
        padding-top: 10px;
        margin:0px
    }
    .box ul li{
        padding-top: 0px;
        margin:0px
    }
    .box-hd{
        border-bottom: solid 1px #ccc;
        min-height: 40px;
        padding-top: 10px;
        font-size: 16px;
        text-align: center;
        {*color: #F5F5FF;
        background-color: #02A8F3;*}
        color: black;
        background-color:#E4E5E6;
    }
    .but {
    width: 100px;
    height: 35px;
    background-color: rgba(0, 122, 255, 0.84);
    text-align: center;
    padding-top: 2px;
    float: right;
    margin-right: 10px;
    color: #FFF;
    margin-top: 15px;
    margin-bottom: 10px;
    text-transform: capitalize;
}
.but:hover {
    background-color: rgba(0, 122, 255, 0.68);
}
   .nav>li {
    position: relative;
    display: block;
    float: left !important;
}
.btn111 {
    background: #2B2B2B;
    border: 1px solid #000 !important;
    margin: 9px 10px 10px 0px;
    color: white;
    padding: 7px 10px 7px 10px;
    text-align: center;
}
.btn111 a:hover {
    color: #E2E2CB !important;
    text-decoration: none !important;
}
.btn111 a {
  color: #fff !important;
}
.pdtitle {
    background-color: #2b3646;
    min-height: 40px;
    padding-top: 10px;
    padding-left: 5px;
    color: #fff;
}
.pdhd {
    float: left;
    margin-top: 0px;
    margin-left: 10px;
}
.close {
    width: 25px;
    height: 25px;
    background: #fff;
    float: right;
    margin-right: 9px;
    margin-top: -3px;
    color: #fff !important;
}
.prdctdecout {
    background-color: rgba(199, 207, 209, 0.93);
    min-height: 68px;
    padding-top: 10px;
    padding-left: 10px;
    color: #fff;
}

/*.navbar1 {
    /*background-color: rgb(2, 168, 243);
    background: transparent url("../images/header.jpg") repeat scroll 0% 0%;*/
   /* background-color:  rgb(122,188,255) !important;
    background: -moz-linear-gradient(top, #7ABCFF 21%, #60ABF8 50%, #60ABF8 100%) !important;
    background: -webkit-linear-gradient(top, rgba(122,188,255,1) 21%,rgba(96,171,248,1) 50%,rgba(96,171,248,1) 100%) !important;
    background: linear-gradient(to bottom, #7ABCFF 21%,#60ABF8 50%,#60ABF8 100%) !important;
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#60abf8',GradientType=0 ) !important;
}*/
.navbar1 {
    background: transparent linear-gradient(to bottom, #2b3643 21%, #364150 50%, #2b3643 100%) repeat scroll 0% 0% !important;
    
}
.nav > li > a:hover, .nav > li > a:focus {
    text-decoration: none;
    background-color: #3F4F62 !important;
    color: #fff !important;
    font-weight: bold;
    text-transform: capitalize;
}
.nav > li > a {
    position: relative;
    display: block;
    padding: 10px 15px;
   
    font-weight: bold;
    text-transform: capitalize;
}
button#purchase {
    background: #2B3643 ;
}
button#purchase:hover{
   background: #4F5358;

}
</style>
<div class="col-sm-12" style="padding: 0px;margin: 0px;">
    
<div class="navbar1">
  <div class="navbar-inner">
      <div class="container" style="border-left: 1px solid rgba(217, 217, 217, 0) !important;
    border-bottom: 1px solid rgba(217, 217, 217, 0.08) !important;">
      
      <div class="nav-collapse">
          <ul class="nav" style="float:left;">
              <li class="active"><a href="product_purchase" style=" color: #fff !important;">purchase</a></li>
          <li class=""><a href="mycart" style=" color: #fff !important;">cart</a></li>                  
          
        </ul>    
            <ul class="nav pull-right">
          <li class="divider-vertical"></li>
          <li class="dropdown" id='mycart_list'>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style=" color: #fff !important;">My Cart <b class="glyphicon glyphicon-shopping-cart"></b></a>
            <ul class="dropdown-menu" style="margin-left: -170px;min-width: 270px; max-width: 270px; margin-top: 12px;">
               {if $user_cart}
                        {$total=0}
                {foreach $user_cart as $cart}
                    {$total= $total + $cart['qty']*$cart['price']}
                <div class="col-sm-12" style="padding:0px; margin: 14px 0px 70px 0px;">
                                        <div class="col-sm-4" style="width:100px;float:left;"><img src="{$BASE_URL}public_html/images/package/{$cart['product_image']}" class="img-responsive"></div>
                                        <div class="col-sm-8" style="width:160px;float:left;padding:0px">{$cart['name']}<br> {$cart['price']} × {$cart['qty']}</div>

            </div>
                {/foreach}
               
            
             {$amount_payable=$total}


                        <li class="cart_text"><a href="#">SUB-TOTAL :  {number_format($total,2)}</a></li>
                            

                        <li class="cart_text"><a href="#">TOTAL :  {number_format($amount_payable,2)}</a></li>
            <li class="divider"></li>
            <div class="col-sm-12">
                                    <div class="col-sm-6" style="padding: 0px;">
                                        <p class="btn111 btn-add">
                                            <a href="mycart">View cart</a>
                                        </p>
                                    </div>
                                    <div class="col-sm-6" style="padding: 0px;">
                                        <p class="btn111 btn-add">
                                            <a href="confirm">Checkout</a>
                                        </p>
                                    </div>
            </div>
            {else}
                  Your shopping cart is empty...
            {/if}
            </ul>
          </li>
        </ul>
      </div><!-- /.nav-collapse -->
    </div>
  </div><!-- /navbar-inner -->
</div>
    
    
</div>

<input type="hidden" name="product_qty" value="1" id="product_qty">

<div class="row" style="margin-top:10px;">
    {for $i=0;$i<$pack_count;$i++}
        {form_open('', 'role="form" class="smart-wizard form-horizontal" name="purchase_product" id="purchase_product" method="post"')}
        <div class="col-sm-3" style="margin-top: 10px;">
            <div class="box">
                  <div class="box-hd"> € {$all_packs[$i]['product_value']}</div>
                <div style="text-align:center;"><img src="{$PUBLIC_URL}images/package/{$all_packs[$i]['image']}" style="width:210px;height:170px;"></div>
                <ul>
                    {*<li><img src="{$PUBLIC_URL}images/package/{$all_packs[$i]['image']}" style="width:20%;height:20%;"></li>*}
                    <li>{$all_packs[$i]['product_name']}</li>
                    <li><font color="#ff0000">{lang('tokens')}</font>:{$all_packs[$i]['tokens']}</li>
                </ul>
                <input type="hidden" name="bv_value" id="bv_value" value="{$all_packs[$i]['bv_value']}">
                <input type="hidden" name="product_value" id="product_value" value="{$all_packs[$i]['product_value']}">
                <input type="hidden" name="tokens" id="tokens" value="{$all_packs[$i]['tokens']}">
                <input type="hidden" name="product_id" id="product_id" value="{$all_packs[$i]['product_id']}">
                <input type="hidden" name="user_id" id="user_id" value="{$user_id}">
               <button class="but" type="button" onclick="addToCart({$all_packs[$i]['product_id']});" name="purchase"  id="purchase" style="    border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;">Add to Cart</button>

            </div>
        </div>  
        {form_close()}
    {/for}
</div>
{* </div>
</div>
</div>
</div>*}
<div id="flash_msg"></div>
{*{/if}*}
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    {*        TableData.init();*}
    });
</script>
<script>
     jQuery('body').on('click','.mfk_wrap .close',function() { jQuery('.mfk_wrap').hide(); });
</script>


{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}