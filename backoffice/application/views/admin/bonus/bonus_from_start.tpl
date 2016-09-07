{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}


    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>Bonus Details
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
                    <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
                        <thead>
                            <tr class="th">
                            <th width="10%">Si No</th>
                            <th width="30%">Date</th>
                            <th width="30%">Type</th>
                            <th width="30%">Amount</th>
                            </tr>
                        </thead>
                        {if !empty($bonus_details)}
                             {assign var="i" value=0}
                            {foreach from=$bonus_details item=v}
                                
                                
                                {if $v.amount_type =='direct_bonus'}
                                    {$amount_type='Direct Bonus'}
                                {elseif $v.amount_type =='team_bonus'}
                                    {$amount_type='Team Bonus'}
                                {elseif $v.amount_type =='matching_bonus'}
                                    {$amount_type='Matching Bonus'}
                                {elseif $v.amount_type =='fast_start_bonus'}
                                    {$amount_type='Fast Start Bonus'}
                                    {else}
                                        {$amount_type='Bonus'}
                                    {/if}
                                

                                <tr>{$i=$i+1}
                                    <td>{$i}</td>
                                    <td>{$v.date_of_submission}</td>
                                    <td>{$amount_type}</td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                </tr>	
                            {/foreach} 
                            <tr><td colspan="3" style="text-align: right"><b>{lang('amount_total')}</b></td><td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($v.tot_amount*$DEFAULT_CURRENCY_VALUE,2)}{$DEFAULT_SYMBOL_RIGHT}</b></td></tr>
                        {else}
                             <tr style="text-align: center">
                                 <td colspan="4">No Bonus Details Found</td>
                            </tr>
                        {/if}
                    </table>
                </div>
            </div>
        </div>
    </div>


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function () {
        Main.init();
       {* ValidateUser.init();*}
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}