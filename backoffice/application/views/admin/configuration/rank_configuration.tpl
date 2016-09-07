{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">

    <span id="confirm_msg_inactivate">{lang('sure_you_want_to_inactivate_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_edit">{lang('sure_you_want_to_edit_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_activate">{lang('sure_you_want_to_activate_this_rank_there_is_no_undo')}</span>
    <span id="confirm_msg_delete">{lang('sure_you_want_to_delete_this_rank_there_is_no_undo')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg1">{lang('you_must_enter_rank_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_referal_count')}</span>
    <span id="error_msg3">{lang('you_must_enter_rank_achivers_bonus')}</span>
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
                </div>
                {lang('rank_settings')}
            </div>
            <div class="panel-body">
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="rank_form" id="rank_form"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="rank_name">{lang('rank_name')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"  name="rank_name" id="rank_name"  value="{$rank_name}" tabindex="1">
                            <span id="errmsg3"></span>{form_error('rank_name')}

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="ref_count">{lang('referal_count')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"   name="ref_count" id="ref_count"  autocomplete="Off" tabindex="2" value="{$referal_count}" ><span id="errmsg1"></span> {form_error('ref_count')}

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="rank_achievers_bonus">{lang('rank_achieved_bonus')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"   name="rank_achievers_bonus" id="rank_achievers_bonus"  autocomplete="Off" tabindex="3" value="{$rank_bonus}" ><span id="errmsg2"></span>{form_error('rank_achievers_bonus')}

                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            {if $edit_id==""}
                                <button class="btn btn-bricky"tabindex="3" name="rank_submit" type="submit" value="Submit">{lang('submit')}</button>
                            {else}
                                <button class="btn btn-bricky" tabindex="3" name="rank_update" type="submit" value="Update" style="background-color:#84A031; border-color:#84A031; font-weight:bold;">{lang('update')}</button>
                                <input name="rank_id" id="rank_id" type="hidden"  value="{$rank_id}"/>
                            {/if}

                        </div>
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('rank_details')}
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

                {assign var=i value="0"}

                {assign var=class value=""}

                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>
                                <th>{lang('rank_name')}</th>
                                <th>{lang('referal_count')}</th>
                                <th>{lang('rank_achieved_bonus')}</th>
                                <th>{lang('rank_status')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        {if $count>0}
                        <tbody>{assign var="m" value="0"}
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {foreach from=$rank_details item=v}
                                {assign var="rank_id" value="{$v.rank_id}"}

                                {if $i%2 == 0}
                                    {$class="tr2"}
                                {else}
                                    {$class="tr1"}
                                {/if}		
                                {$i = $i+1}

                                <tr class="{$class}" align="center" >
                                    <td>{$m}</td>
                                    <td>{$v.rank_name}</td>
                                    <td>{$v.referal_count}</td>
                                    <td>{$v.rank_bonus}</td>
                                    <td>{$v.rank_status}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:delete_rank({$v.rank_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title={lang('delete')}>
                                                <i class="fa fa-times fa fa-white"></i>
                                            </a>

                                            {if $v.rank_status=="active"}
                                                <a href="javascript:edit_rank({$v.rank_id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-edit"></i></a>                                       
                                                <a href="javascript:inactivate_rank({$v.rank_id},'{$path}')" onclick=""  class="btn btn-primary tooltips" data-placement="top" data-original-title="{lang('inactivate')}">
                                                    <i class="glyphicon glyphicon-remove-circle"></i>
                                                </a>
                                            {else}
                                                <a href="javascript:activate_rank({$v.rank_id},'{$path}')" onclick=""  class="btn btn-primary tooltips" data-placement="top" data-original-title={lang('activate')}>
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </a>
                                            {/if}
                                        </div>   
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">

                                                


                                                    {if $v.rank_status=="active"}
                                                        <li role="presentation">
                                                            <a role="menuitem" tabindex="1" href="javascript:edit_rank({$v.rank_id},'{$path}')">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li role="presentation">
                                                            <a role="menuitem" tabindex="1" href="javascript:inactivate_rank({$v.rank_id},'{$path}')">
                                                                <i class="fa fa-remove"></i> Inactive
                                                            </a>
                                                        </li>
                                                    {else}
                                                        <li role="presentation">
                                                            <a role="menuitem" tabindex="1" href="javascript:activate_rank({$v.rank_id},'{$path}')">
                                                                <i class="fa fa-check-circle-ok"></i> Activate
                                                            </a>
                                                        </li>
                                                    {/if}
                                               
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="1" href="javascript:delete_rank({$v.rank_id},'{$path}')">
                                                            <i class="fa fa-remove"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>

                                </tr>{$m = $m+1}
                            {/foreach}                
                        </tbody>
                        {else}
                                <tbody>
                                    <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_Rank_Details_Found')}</h4></td></tr>
                                </tbody>                            
                            {/if}  
                    </table>

            </div>
        </div>
    </div>
</div>     



{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        Validateconfig.init();

    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}