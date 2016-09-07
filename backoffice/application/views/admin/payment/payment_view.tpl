{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {$tran_payment}
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


                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                        <tr class="th" align="center">

                            <th>{$tran_payment_method}</th>
                            <th>{$tran_status}</th>                                   
                            <th>{$tran_action}</th> 
                        </tr>

                    </thead>


                    <tbody>
                        {assign var="i" value = 0}                          
                        {foreach from=$details item=v}

                        {form_open('', 'name="payment_details"  id="payment_details" method="post"')}
                            {foreach from=$module_status item=m}                              

                                <tr>
                                    <td>{$v.payment_type}<input type="hidden" name="payment_type_id{$i}" id="payment_type_id" value="{$v.id}"></td>

                                    <td>
                                        {if $v.payment_type=="E-pin"}
                                            {$m.pin_status}<input type="hidden" name="status{$i}" id="status{$i}" value="{$v.status}">
                                        {else if $v.payment_type=="E-Wallet"}{$m.ewallet_status}<input type="hidden" name="status{$i}" id="status{$i}" value="{$v.status}">
                                        {else}{$v.status}<input type="hidden" name="status{$i}" id="status{$i}" value="{$v.status}">
                                        {/if}</td>                       
                                    <td>
                                        {if $v.status=="no"}
                                            <button class="btn btn-bricky" type="submit" id="activate" value="activate" name="activate" >
                                                {$tran_enable}<input type="hidden" name="activate{$i}" id="activate{$i}" value="activate{$i}">
                                            </button>
                                        {else}
                                            <button class="btn btn-bricky" type="submit" id="inactivate" value="inactivate" name="inactivate" >
                                                {$tran_disable}<input type="hidden" name="inactivate{$i}" id="inactivate{$i}" value="inactivate{$i}">
                                            </button>
                                        {/if}
                                    </td>
                                </tr>

                                {$i=$i+1}
                            {/foreach}
                        {form_close()}
                    {/foreach}
                    </tbody>   
                </table>
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}