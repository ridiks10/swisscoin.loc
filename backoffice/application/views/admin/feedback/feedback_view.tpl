{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg">{lang('sure_you_want_to_delete_this_feedback_there_is_no_undo')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div> 
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('feedback_details')}
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
                                <th>{lang('visitors_name')}</th>
                                <th>{lang('company')}</th>
                                <th>{lang('phone_no')}</th>
                                <th>{lang('time_to_call')}</th>
                                <th>{lang('email')}</th>
                                <th>{lang('comments')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        {if count($feedback)!=0}
                        <tbody>
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {foreach from=$feedback item=v}
                                {assign var="feedback_id" value="{$v.feedback_id}"}

                                {if $i%2 == 0}
                                    {$class="tr2"}
                                {else}
                                    {$class="tr1"}
                                {/if}		
                                {$i = $i+1}
                                <tr class="{$class}" align="center" >
                                    <td>{$i}</td>
                                    <td>{$v.feedback_name}</td>
                                    <td>{$v.feedback_company}</td>
                                    <td>{$v.feedback_phone}</td>
                                    <td>{$v.feedback_time}</td>
                                    <td>{$v.feedback_email}</td>
                                    <td>{$v.feedback_remark}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs buttons-widget">
                                            <a  href="javascript:delete_feedback({$feedback_id},'{$path}')"class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.feedback_name}"><i class="fa fa-times fa fa-white"></i></a>
                                        </div>
                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">
                                                    <!--delete PIN start-->
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="javascript:delete_feedback({$feedback_id},'{$path}')">
                                                            <i class="fa fa-times fa fa-white"></i>{lang('delete')}
                                                        </a>
                                                    </li>
                                                    <!--delete PIN end-->
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}                
                        </tbody>
                    
                {else}
                    <tbody>
                                    <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_feedback_found')}</h4></td></tr>
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

        ValidateUser.init();
        TableData.init();
        DateTimePicker.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}