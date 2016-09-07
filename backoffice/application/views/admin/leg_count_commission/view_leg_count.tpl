{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{$tran_You_must_enter_user_name}</span>
    <span id="error_msg2">{$tran_you_must_enter_new_transaction_password}</span>
    <span id="error_msg3">{$tran_transaction_password_length_should_be_more_than_8}</span>
    <span id="error_msg4">{$tran_reenter_new_transaction_password}</span>                     
    <span id="error_msg5">{$tran_new_transaction_password_mismatch}</span>        
    <span id="error_msg6">{$tran_you_must_select_a_username}</span>        
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>

</div>	

<div id="user_account"></div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>    {lang('level_commission')} 
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
            <div id="username_val" style="display:none;">{$user_name}</div>
            <div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>
            <div class="panel-body">
                {form_open('', 'role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    {if !isset($smarty.post.leg_count_view)}
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}:</label>
                            <div class="col-sm-3">
                                <input class="form-control"  type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="1" >

                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" type="submit" id="view" value="{lang('submit')}" name="view" tabindex="2">
                                    {lang('submit')}
                                </button>
                            </div>
                        </div>
                    {/if}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">


                    {if $arr_len>0} 
                        <div class="form-group">
                            <center><h3>{lang('level_commission')} :{$user_name}</h3></center>
                            <input type="hidden" id="temp_path" name="temp_path" value="{$PUBLIC_URL}">

                        </div>

                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr class="th" align="center">
                                    <th>{lang('level')}</th>
                                    <th>{lang('members')}</th>
                                    <th>{lang('amount')}</th>

                                </tr>
                            </thead>
                            <tbody>
                                {assign var="k" value ="1"}
                                {assign var="total_leg_tot" value ="0"}
                                {assign var="total_amount_tot" value ="0"}
                                {foreach from=$leg_level item=v}

                                    {if $k%2==0} 
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}   
                                    {$level   = $v.level-1}
                                    {$tot_leg = $v.persons}
                                    {$tot_amt = round($v.amount,2)}


                                    {$total_leg_tot = $total_leg_tot+$tot_leg}
                                    {$total_amount_tot = $total_amount_tot+$tot_amt}

                                    {*{$z=$first+$i}*}
                                    <tr class="{$class}" >
                                        <td align="center">{$level}</td>
                                        <td align="center"> {$tot_leg}</td>
                                        <td align="center"> {$tot_amt}</td>

                                    </tr>
                                    {$k = $k+1}
                                    {*{$count=$k} *} 
                                {/foreach}
                                {$class='total'}
                                <tr  class='{$class}' align='left' >

                                    <td align="center"><b>{lang('total')}</b></td>
                                    <td align="center"><b> {$total_leg_tot}</b></td>
                                    <td align="center"><b> {$total_amount_tot}</b></td>
                                </tr> 
                            </tbody>
                        </table>
                    {/if}
                    <div id='contact-form'> 
                        <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                            <thead>
                                <tr class="th" align="center">
                                    <th align="center">{lang('slno')}</th>
                                    <th width="200px" align="center">{lang('userid_fullname')}</th>
                                    <th align="center"><b>{lang('users')}</b></th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                {assign var="k" value ="1"} 
                                {$left_leg_tot = 0} 
                                {$right_leg_tot = 0}
                                {$left_carry_tot = 0}
                                {$right_carry_tot = 0}
                                {$total_leg_tot = 0}
                                {*for($k=0;$k<count($user_leg_detail);$k++)*} 
                                {foreach from=$user_leg_detail item=v}  
                                    {if $k%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}      
                                    {$user_id  = $v.user_id}
                                    {$user_name_id  = $v.user_name_id}
                                    <tr class="{$class}" align="center" >

                                        <td>{$k}</td>
                                        <td>{$v.user_name_id}</td> 

                                        <td><input type='image' name='user_id$k'  class='contact' onclick='setvalue({$user_id})' src='{$PUBLIC_URL}images/1358421714_magnifier.png'>


                                        </td>
                                    </tr>
                                    {$k = $k+1}
                                    {*{$count=$k} *} 
                                {/foreach}
                                {$class='total'}
                            <input type='hidden' name='selectid' value=''>
                            <tr  class='{$class}' align='left' >
                                <td colspan='3'><b></b></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
<!-- end: PAGE CONTENT -->




{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
    {*                                        ValidateUser.init();*}
        TableData.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}