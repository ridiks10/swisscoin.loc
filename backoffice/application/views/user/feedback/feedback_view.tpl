{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_your_company_name')}</span>  
    <span id="error_msg2">{lang('you_must_enter_the_user_name')}</span>        
    <span id="error_msg8">{lang('please_type_your_comments')}</span>            
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>    
    <span id="error_msg3">{lang('please_type_your_phone_no')}</span>        
    <span id="error_msg4">{lang('please_type_your_time_to_call')}</span>                  
    <span id="error_msg5">{lang('please_type_your_e_mail_id')}</span>
    <span id="error_msg6">{lang('digits_only')}</span>
    <span id="error_msg9">{lang('phone_number_should_be_atleast_5_digits_long')}</span>
    <span id="error_msg10">{lang('phone_number_cannot_be_longer_than_32_digits')}</span>
    <span id="error_msg11">{lang('email_format_is_incorrect')}</span>
    <span id="error_msg12">{lang('company_name_should_be_atleast_3_characters_long')}</span>
    <span id="error_msg13">{lang('company_name_cannot_be_greater_than_32_characters')}</span>
    <span id="error_msg14">{lang('email_cannot_be_greater_than_50_characters')}</span>
    <span id="confirm_msg">{lang('sure_you_want_to_delete_this_feedback_there_is_no_undo')}</span>
</div> 

{if $info_box}
<div class="panel panel-info">
      <div class="panel-heading"><i class="fa fa-info"></i>Info
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-refresh" href="#">
                            <i class="fa fa-refresh"></i>
                        </a>
                        <a class="btn btn-xs btn-link panel-expand" href="#">
                            <i class="fa fa-resize-full"></i>
                        </a>
                    </div></div>
      <div class="panel-body">{$info_box}</div>
</div>
{/if}


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
                {lang('feedback_view')}
            </div>
            <div class="panel-body">                   
                    {form_open('user/feedback/feedback_view','role="form" class="smart-wizard form-horizontal" method="post"  name="feedback_form" id="feedback_form" onSubmit="return validate_feedback()"')}
                    
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="company">{lang('company')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"   name="company" id="company"  autocomplete="Off" tabindex="2">{form_error('company')}
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="phone_no">{lang('phone_no')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"  name="phone_no" id="phone_no"   autocomplete="Off" tabindex="3">{form_error('phone_no')}
                            <span id="errmsg1"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="time_to_call">{lang('time_to_call')}:<span class="symbol required"></span></label>
                        <div class="col-sm-2">
                            <div class="input-group input-append bootstrap-timepicker timepick_mediuamsize">
                                <input class="form-control time-picker" tabindex="4" name="time_to_call" id="time_to_call" type="text" size="30" value="" />{form_error('time_to_call')}
                                <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">{lang('email')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"  name="email" id="email"  autocomplete="Off" tabindex="5">{form_error('email')}
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="comments">{lang('comments')}:<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <textarea rows="6" name="comments" id="comments" cols="22" tabindex="6" ></textarea>{form_error('comments')}
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="feedback_submit" id="feedback_submit" value="{lang('submit')}" tabindex="7">
                                {lang('submit')}
                            </button>
                        </div>
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
                            {assign var="path" value="{$BASE_URL}user/"}
                            {foreach from=$feedback item=v}
                                {assign var="feedback_id" value="{$v.feedback_id}"}

                                {if $i%2 == 0}
                                    {$class="tr2"}
                                {else}
                                    {$class="tr1"}
                                {/if}		
                                {$i = $i+1}
                                <tr class="{$class}" align="center" >
                                    <td>{counter}</td>
                                    <td>{$v.feedback_company}</td>
                                    <td>{$v.feedback_phone}</td>
                                    <td>{$v.feedback_time}</td>
                                    <td>{$v.feedback_email}</td>
                                    <td>{$v.feedback_remark}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs buttons-widget">
                                            <a href="javascript:delete_feedback({$feedback_id},'{$path}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.feedback_id}"><i class="fa fa-times fa fa-white"></i></a>
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
                            <tr><td colspan="12" align="center"><h4>{lang('no_feedback_found')}</h4></td></tr>
                        </tbody> 
                    {/if}
                        </table>

                    </div>
                </div>
            </div>
        </div>          
        {include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
        <script>
            jQuery(document).ready(function() {
                Main.init();
                TableData.init();

                ValidateUser.init();
                DateTimePicker.init();
            });
        </script>

        {include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}