{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('leg_count')}
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
                        <tr class="th" align="center">
                        <tr class="th"> 
                            <th>{lang('no')}</th>
                            <th>{lang('userid_fullname')}</th>
                            <th>{lang('left_point')}</th>
                            <th>{lang('right_point')}</th>
                            <th>{lang('left_carry')}</th>
                            <th>{lang('right_carry')}</th>
                            <th>{lang('total_pair')}</th>
                            <th><b>{lang('amount')}</b></th>
                        </tr>

                    </thead>

                    {if count($user_leg_detail)!=0}

                        {assign var="left_leg_tot" value ="0"}
                        {assign var="right_leg_tot" value ="0"}
                        {assign var="left_carry_tot" value ="0"}
                        {assign var="right_carry_tot" value ="0"}
                        {assign var="total_leg_tot" value ="0"}
                        {assign var="total_leg_tot" value ="0"}
                        {assign var="total_amount_tot" value ="0"}
                        {assign var="k" value ="0"}
                        {assign var="class" value =""}
                        <tbody>
                            {foreach from=$user_leg_detail item=v}

                                {assign var="left" value ="{$v.left}"}
                                {assign var="right" value ="{$v.right}"}
                                {assign var="left_carry" value ="{$v.left_carry}"}
                                {assign var="right_carry" value ="{$v.right_carry}"}
                                {assign var="tot_leg" value ="{$v.total_leg}"}
                                {assign var="tot_amt" value ="{$v.total_amount}"}

                                {$left_leg_tot = $left_leg_tot+$left}
                                {$right_leg_tot = $right_leg_tot+$right}
                                {$left_carry_tot = $left_carry_tot+$left_carry}
                                {$right_carry_tot = $right_carry_tot+$right_carry}
                                {$total_leg_tot = $total_leg_tot+$tot_leg}
                                {$total_amount_tot =$total_amount_tot+ $tot_amt}

                                {if $k%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                <tr align="center" >
                                    <td>{counter}</td>
                                    <td>{$v.user}-{$v.detail}</td>
                                    <td>{$left}</td>
                                    <td>{$right}</td>
                                    <td>{$left_carry}</td>
                                    <td>{$right_carry}</td>
                                    <td>{$tot_leg}</td>
                                    <td>{$tot_amt}</td>
                                </tr>

                                {$k=$k+1}

                            {/foreach}

                            {$class='total'}

                            <tr class="{$class}" align="center" >
                                <td><b></b></td>
                                <td><b>{lang('total')}</b></td>
                                <td><b>{$left_leg_tot}</b></td>
                                <td><b>{$right_leg_tot}</b></td>
                                <td><b>{$left_carry_tot}</b></td>
                                <td><b>{$right_carry_tot}</b></td>
                                <td><b>{$total_leg_tot}</b></td>
                                <td><b>{$total_amount_tot}</b></td>
                            </tr>



                        </tbody>


                    {else}
                        <h3>{lang('no_leg_count_found')}</h3>
                    {/if}          
                </table>

            </div>
        </div>
    </div>
</div>              



{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();

    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}