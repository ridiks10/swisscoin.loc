{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}


<div id="span_js_messages" style="display:none;">    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<style>
input#button-login {
    background: #d2322d;
}
input#button-login:hover {
    background-color: rgba(210, 50, 45, 0.77);
}
input#checkout {
    background: rgb(50, 118, 177);
}
input#checkout:hover {
    background: rgba(50, 118, 177, 0.83);
}
input#button-login1 {
    background: rgb(50, 118, 177);
}
input#button-login1:hover {
    background-color: rgba(50, 118, 177, 0.83);
}
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>  {*{lang('packs')}*}My Cart
            </div>
            <div class="panel-body">
                <div >   
                    <div class="row" style="margin:0px">         
                          {if $all_packs}
                        <div id="content" class="col-sm-12">     
                            {*<h3>My Cart</h3>       *}         
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-center"><b>Image</b></td>
                                            <td class="text-left"><b>Package</b></td>

                                            <td class="text-left"><b>Quantity</b></td>
                                            
                                            <td class="text-right"><b>Price</b></td>
                                            <td class="text-right"><b>Total</b></td>
                                        </tr>
                                    </thead>

                                    {$total=0}
                                    {$i=0} 
                                    {foreach $all_packs as $pack}  
                                        <form role="form" method="post"  name="create_form" id="create_form" action="">
                                            {$sub_total=$pack['qty']*$pack['price']}                              
                                           {* {$sub_total=$pack['product_value']*1}    *}                           
                                            <input type="hidden" name="product_id" value="{$pack['id']}" id="product_id">
                                            {*<input type="hidden" name="rowid" value="{$pack['product_id']}" id="rowid">*}
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <img src="{$BASE_URL}public_html/images/package/{$pack['product_image']}" width="80px" />
                                                    </td>
                                                    <td class="text-left">
                                                        <small>{$pack['name']}</small>
                                                        

                                                    </td>

                                                    <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                                                            <input maxlength="3" name="qty" id="qty-{$pack['id']}" type="number" min="1"  value="{$pack['qty']}" size="4" class="form-control" style="min-height: 33px;">
                                                            <span class="input-group-btn">
                                                               {* <input type="submit"  value="Edit" id="update_cart" name="update_cart" data-toggle="tooltip" title="" class="btn btn-primary" style="margin-left: 5px;"><i class="glyphicon glyphicon-refresh" style="color: white;"></i>*}
                                                                <button type="button" onclick="updateCart({$pack['id']})" data-toggle="tooltip" title="" class="btn btn-primary"  style="margin-left: 5px;"><i class="glyphicon glyphicon-refresh" style="color: white;"></i></button>
                                                                <button type="button" onclick="removeCart({$pack['id']})" data-toggle="tooltip" title="" class="btn btn-danger"  style="margin-left: 5px;"><i class="glyphicon glyphicon-remove" style="color: white;"></i></button></span></div></td>
                                                   
                                                    <td class="text-right">{*<img style="width: 20px; position: absolute;" src="{$PUBLIC_URL}images/cross.png">*}{$DEFAULT_SYMBOL_LEFT} {$pack['price']} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                    <td class="text-right">{$DEFAULT_SYMBOL_LEFT} {$sub_total} {$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                            </tbody>                                
                                             {$total=$total+$sub_total}
                                            {$i=$i+1} 
                                        </form>
                                    {/foreach}	
                                </table>
                            </div>
                        </div>        

                    </div> 
                    
                    {$first_purchase_charge=0}
                    {$amount_payable=$total}

                    <div class="row" style="margin:0px">
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table table-hover">
                                <tbody><tr>
                                        <td class="text-right"><strong>Sub-Total:</strong></td>
                                        <td class="text-right"> {$DEFAULT_SYMBOL_LEFT} {number_format($total,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                    {if $first_purchase_status == 'yes'}
                                        
                                        {$first_purchase_charge = 25}
                                            <tr>
                                                <td class="text-right"><strong>Enrolment:</strong></td>
                                                <td class="text-right">{$DEFAULT_SYMBOL_LEFT} {number_format($first_purchase_charge,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                            </tr>
                                        {$amount_payable=$total+$first_purchase_charge}
                                    {/if}
                                    <tr>
                                        <td class="text-right"><strong>Total:</strong></td>
                                        <td class="text-right">{$DEFAULT_SYMBOL_LEFT} {number_format($amount_payable,2)} {$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="buttons">                
                        <a href="{$BASE_URL}admin/purchase/product_purchase"><input type="button" value="Continue Shopping" id="button-login1" data-loading-text="Loading..." class="pull-left btn111 btn-add " style="padding: 7px 25px 7px 25px;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" /></a>
                            
                        <a href="{$BASE_URL}admin/purchase/confirm"><input type="button" value="Checkout" name="checkout" id="checkout" data-loading-text="Loading..." class="pull-right btn111 btn-add "  style="padding: 7px 25px 7px 25px;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" /></a>
                            
                        <a href="{$BASE_URL}admin/purchase/clearCart"><input type="button" value="Clear Cart" id="button-login" data-loading-text="Loading..." class="pull-right btn111 btn-add "  style="padding: 7px 25px 7px 25px;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" /></a>
                    </div>
                     {else}
                    <style>
                        .footer{
                            position:fixed!important;
                            bottom:0;
                        }
                    </style>
                    <div id="content" class="col-sm-12">     
                       {* <h3>My Cart </h3>   *}
                        <div class="buttons">
                            <center> Your shopping cart is empty...</center>
                             <a href="{$BASE_URL}admin/purchase/product_purchase"><input type="button" value="Continue Shopping" id="button-login" data-loading-text="Loading..." class="pull-left btn111 btn-add " style="padding: 7px 25px 7px 25px;background: #3276b1;border: 0px solid #000 !important;margin: 9px 10px 10px 0px;color: white;" /></a>
                        </div>
                    </div>
                     {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{*{/if}*}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
    {*        TableData.init();*}
    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  