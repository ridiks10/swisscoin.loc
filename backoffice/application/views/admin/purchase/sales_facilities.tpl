{include file="admin/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<style>

    .box{
        min-height:155px;
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
        color: blue;
        background-color: rgba(204, 204, 204, 0.39);
    }
    .but {
        width: 100px;
        height: 35px;
        background-color: rgba(61, 148, 0, 0.8);
        text-align: center;
        padding-top: 7px;
        float: right;
        margin-right: 10px;
        color: #fff;
        margin-top: 15px;
        margin-bottom: 10px;
    }

</style>


<div id="span_js_messages" style="display:none;">    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row" >
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('select_user')} 
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
                {form_open_multipart('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="user_name">{lang('select_user_id')}:<span class="symbol required"></span></label>
                    <div class="col-sm-3">
                        <input placeholder="" class="form-control" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" >

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" id="get_user" value="get_user" name="get_user" tabindex="2">
                            {lang('view')}
                        </button>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{*{if $flag}*}
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
                    </div>  {lang('active_packs')} : <font color="#ff0000">{$user_name}</font>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <tr class="tr1" align="center" >
                            <td>{$current_pack['name']}</td>
                            <td>{$current_pack['tokens']}</td>
                        </tr>
                        <tr class="tr1" align="center" >
                            <td>{$current_pack['product_value']} €</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                    </div>  {lang('packs')}
                </div>
                <div class="panel-body">
                    <div class="row" style="margin-top:10px;">
                        {for $i=0;$i<$pack_count;$i++}
                            {form_open('', 'role="form" class="smart-wizard form-horizontal" name="purchase_product" id="purchase_product" method="post"')}
                            <div class="col-sm-3" style="margin-top: 10px;">
                                <div class="box">
                                    <div class="box-hd"> {$all_packs[$i]['product_value']} €</div>
                                    <ul>
                                        <li>{$all_packs[$i]['product_name']}</li>
                                        <li><font color="#ff0000">{lang('tokens')}</font>:{$all_packs[$i]['tokens']}</li>
                                    </ul>
                                    <input type="hidden" name="bv_value" id="bv_value" value="{$all_packs[$i]['bv_value']}">
                                    <input type="hidden" name="product_value" id="product_value" value="{$all_packs[$i]['product_value']}">
                                    <input type="hidden" name="tokens" id="tokens" value="{$all_packs[$i]['tokens']}">
                                    <input type="hidden" name="product_id" id="product_id" value="{$all_packs[$i]['product_id']}">
                                    <input type="hidden" name="user_id" id="user_id" value="{$user_id}">
                                    <button class="but" type="submit" name="purchase"  id="purchase" value="{lang('buy_now')}">{lang('buy_now')}</button>

                                </div>
                            </div>
                            {form_close()}
                        {/for}
                    </div>
                </div>
            </div>
        </div>
    </div>
{*{/if}*}
{include file="admin/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
    });
</script>

{include file="admin/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}