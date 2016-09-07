{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('place_an_order_for_each_guest')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {if count($guest_arr)!=0}
                    {assign var="path" value="{$BASE_URL}user/"}
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('guest_name')}</th>
                                <th>{lang('orders')}</th>
                                <th>{lang('amount')}</th>
                                <th style="width: 30%;text-align: center;">{lang('address')}</th>
                                <th style="width: 30%;text-align: center;">{lang('order')}</th>

                                <th style="width: 30%;text-align: center;">{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach from=$guest_arr item=v}
                                <tr>
                                    <td>{Counter}</td>
                                    <td>{$v.first_name},{$v.last_name}</td>
                                    <td>{if $v.count==""}0{else}{$v.count}{/if}</td>
                                    <td>{if $v.amount==""}{$DEFAULT_SYMBOL_LEFT}0{$DEFAULT_SYMBOL_RIGHT}{else}{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}{/if}</td>
                                    <td>{$v.first_name} {$v.last_name}</br>{$v.address}</br>{$v.city}</td>
                                    <td>    <div class="form-group"  style="float: left; width: 100px;">
                                            <a href="javascript:select_product({$v.id},'{$path}')">
                                                <input type="button" name="order" id="order" class="btn btn-bricky" value="{lang(order_product)}" >
                                            </a>
                                        </div></td>
                                    <td>
                                        {if $v.count!=""} 
                                            <div class="form-group"  style="padding-left: 48%;">
                                                <div class="">
                                                    <a href="javascript:edit_order({$v.id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" ><i class="fa fa-edit"></i></a>
                                                    <a href="javascript:delete_order({$v.id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="Delete Order"><i class="glyphicon glyphicon-remove-circle"></i></a>                                    
                                                </div> 
                                            </div>
                                        {else}<b><span align="center"> NA</span></b>

                                        {/if}                                  
                                    </td>
                                </tr>                                     
                            {/foreach}
                        </tbody>
                    </table>
                {else}
                    <center>
                        {lang('no_invited_guests')} !!!
                    </center>
                {/if}
         {*       <div class="form-group"  style="float: left; text-align: left; width: 100px;">
                    <div class="col-sm-2 col-sm-offset-12">
                        <a href="../party/create_guest/enter_order">
                            <button class="btn btn-bricky" tabindex="2"  name="create" id="create" type="button" value="Add Guest And Invite to Party" >{lang('add_guest_and_invite_to_party')}</button></a>
                    </div>
                </div> *}  

                <div class="form-group"  style="float: center; text-align: left; width: 100px;">
                    <div class="col-sm-2 col-sm-offset-12">
                        <a href="../myparty/party_portal">
                            <button class="btn btn-bricky" tabindex="2"  name="back" id="back" type="button" value="back" >{lang('back_to_party_portal')}</button></a>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateCreateHost.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}