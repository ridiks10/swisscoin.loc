{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="validate_msg1">{lang('enter_subject')}</span>
    <span id="validate_msg2">{lang('enter_mail_content')}</span>
    <span id="validate_msg3">{lang('enter_mail_number')}</span>
    <span id="validate_msg4">{lang('enter_mail_send_date')}</span>
</div>
<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    {lang('auto_responder_settings')}
                </div>
                <div class="panel-body">
                    {form_open('admin/configuration/auto_responder_settings' , 'role="form" class="smart-wizard form-horizontal" method="post"  name="mail_auto_settings" id="mail_auto_settings"')}
                    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}admin/">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('mail_number')}:<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name ="mail_num" id ="mail_num" tabindex="1">

                                <option value="NA" selected>{lang('select_number')}</option>

                                {for $num=0 to 15}
                                    {if $num==$mail_details['mail_id']}
                                        <option value="{$num}" selected>{$num}</option>
                                    {else}
                                        <option value="{$num}">{$num}</option>
                                    {/if}
                                {/for}
                            </select>
                            {form_error('mail_num')}
                            {*<input  type="text"  name ="mail_num" id ="mail_num"value="{$mail_details['mail_id']}" maxlength="" autocomplete="Off" tabindex="1">
                            <span id="username_box" style="display:none;"></span>*}
                        </div>
                    </div>

                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" >{lang('subject')} :<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input class="form-control"  type="text"  name ="subject" id ="subject"value="{if $count>0}{$mail_details['subject']}{/if}" autocomplete="Off" tabindex="2">



                        </div>
                        {form_error('subject')}
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="mail_content">
                            {lang('mail_content')} :<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-9">
                            <textarea id="mail_content"  name="mail_content" class="tinymce form-control"  tabindex="3"  rows='10'>
                            {if $count>0}{$mail_details['content']}{/if}
                        </textarea>{form_error('mail_content')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="date">
                        {lang('mail_send_date')} :<span class="symbol required"></span>
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control" name="date_to_send" id ="date_to_send" tabindex="4">


                            <option value="NA" selected>{lang('select_date')}</option>

                            {for $date=0 to 120}
                                {if $date==$mail_details['date_to_send']}
                                    <option value="{$date}" selected>{$date}</option>
                                {else}
                                    <option value="{$date}">{$date}</option>
                                {/if}
                            {/for}
                        </select>
                        {form_error('date_to_send')}
                    </div>
                    {*<div class="col-sm-3">
                    <div class="input-group">
                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" id="date_to_send" name="date_to_send" type="text" tabindex="4" size="20" maxlength="10"  value="" >
                    <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                    </div>
                    </div>*}
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">

                    </label>
                    <div class="col-sm-9">
                        <label> <span class="symbol required"></span>{lang('mail_msg')}</label> 
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Update" name="update" id="update" >{lang('update')}</button>                                
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
                <i class="fa fa-external-link-square"></i> 
                {lang('auto_responder_details')}
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
                <table border="0" align="center" width="100%" class="table table-striped table-bordered table-hover table-full-width" id="" >
                    <thead>
                        <tr class="th" >
                            <th>{lang('no')}</th>
                            <th>{lang('mail_id')}</th>
                            <th>{lang('subject')}</th>
                            <th>{lang('mail_send_date')}</th>
                            <th>{lang('edit')}</th>
                            <th>{lang('delete')}</th>

                        </tr>
                    </thead>
                    {if $count>0}
                        <tbody>
                            {assign var="i" value="0"}
                            {assign var="class" value=""}{assign var="i" value=0}
                            {foreach from=$mail_data item=v}


                                <tr>   {$i=$i+1}                                
                                    <td>{$i}</td>
                                    <td>{$v.mail_id}</td>
                                    <td>{$v.subject}</td>
                                    <td>{$v.date_to_send}</td>
                                    <td><a class="btn btn-primary" href="#" onclick="edit_auto_respnder({$v.mail_id})"><i class="fa fa-times fa fa-pencil "></i></a></td>
                                    <td><a class="btn btn-bricky" href="#" onclick="delete_auto_respnder({$v.mail_id})"><i class="fa fa-times fa fa-white"></i></a></td>

                                </tr>
                                
                            {/foreach}
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_Auto_responder_Detail_Found')}</h4></td></tr>
                        </tbody>                            
                    {/if} 
                </table>
            </div>
        </div>

    </div>
</div>
<font color="red">NB:{lang('available_in_live_sites_only')} </font>            
</div>
{*{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}*}
<script>
    jQuery(document).ready(function() {
        Main.init();
        validate_auto_responder.init();
        TableData.init();


    });
</script>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}