{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div class="col-sm-12 col-sm-offset-9">

    <a href="{$BASE_URL}user/mail/ticket_system"> <font  style="font-weight: bold; font-size: 15px">{lang('Back_To_Ticket_System')}</font></a>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('view_ticket')}
    </div>
    <div class="panel-body">

        {if $ticket_count>0}
           {form_open_multipart('user/mail/ticket_system', 'role="form" class="smart-wizard form-horizontal"  name="reply" id="reply" method="post" action="" enctype="multipart/form-data"')}      
               
                <table class="table table-condensed table-hover">
                    <tbody>
                    <input type="hidden" name="ticket_id" id="ticket_id" value="{$ticket_arr['details0']['ticket_id']}">
                    <tr>
                        <td width="40px">{lang('Ticket_tracking_ID')}    </td><td width="50px"> : {$ticket_arr['details0']['ticket_id']} </td>

                    </tr>
                    <tr>
                        <td width="40px">{lang('Ticket_Status')}     </td><td width="50px"> : {if $ticket_arr['details0']['status']=='0'}<font color="#ff0000">{lang('New')}</font> [<a class="btn btn-xs btn-link panel-refresh" href="../markResolved/{$ticket_arr['details0']['id']}">{lang('Marked_as_resolved')}</a>]
    {else if $ticket_arr['details0']['status']=='4'}{lang('Inprogress')}{else if $ticket_arr['details0']['status']=='1'}{lang('Waiting_Reply')}{else if $ticket_arr['details0']['status']=='2'}{lang('Replied')}{else if $ticket_arr['details0']['status']=='5'}{lang('OnHold')}{else}{lang('Resolved')}{/if}</td>

</tr>
<tr>
    <td width="40px">{lang('Created_on')}      </td><td width="50px"> : {$ticket_arr['details0']['created_date']} </td>

</tr>
<tr>
    <td width="40px">{lang('Updated_date')}      </td><td width="50px"> : {$ticket_arr['details0']['updated_date']} </td>

</tr>
<tr>
    <td width="40px">{lang('Last_replier')}       </td><td width="50px"> : {$ticket_arr['details0']['lastreplier']} </td>

</tr>
<tr>
    <td width="40px">{lang('Category')}       </td><td width="50px"> : {$ticket_arr['details0']['category']} </td>

</tr>
<tr>
    <td width="40px">{lang('Priority')}       </td><td width="50px"> : {if $ticket_arr['details0']['priority']=='3'}{lang('Low')}{else if $ticket_arr['details0']['priority']=='2'}{lang('Medium')}{else if $ticket_arr['details0']['priority']=='1'}{lang('High')} {else if $ticket_arr['details0']['priority']=='2'}{lang('Medium')}{/if}</td>

</tr>
{if $ticket_arr['details0']['attachments']!=''}
    <tr>
        <td width="40px">{lang('attachment')}       </td><td width="50px"> : <a href="{$BASE_URL}../ticket_system/attachments/{$ticket_arr['details0']['attachments']}" target="_blank"><img width="100" src="{$BASE_URL}../ticket_system/attachments/{$ticket_arr['details0']['attachments']}"></a></td>
    </tr>
{/if}
{assign var=i value=1}
{assign var=clr value=""}
{assign var=id value=""}
{assign var=msg_id value=""}
{assign var=user_name value=""}
{if $cnt_row > 0}
    {foreach from=$ticket_reply item=v}

        <tr>
            <td width="280px"><b>{lang('Message')}({$v.date}  {lang('from')} : {if isset($v.user)}{($v.user)}{else}Staff{/if}) </b></td>
            <td width="140px">{$v.message}</td>
            {if $v.attachments != ""}
                <td>  
                    <a href="{$BASE_URL}../ticket_system/attachments/{$v.attachments}" target="_blank"><img src="{$BASE_URL}../ticket_system/attachments/{$v.attachments}" width="100"></a>  
                </td>
            {/if}
        </tr>
    {/foreach}
{/if}
{if $ticket_arr['details0']['status']!=3}
    <tr>
        <td width="140px">{lang('Reply')}   <font color="#ff0000">*</font>   </td><td width="50px"> : <div class="col-sm-3">
                <textarea tabindex="2" name='message' id='message' rows='10' cols='40'></textarea>
            </div></td>

    </tr>
    <tr>
        <td width="140px">{lang('attachment')} <font color="#ff0000">*</font> </td><td width="50px">  
            {* <div class="col-sm-5">
            <input type="file" id="upload_doc" name="upload_doc" tabindex="2"><font color="#ff0000">{$tran_kb}({$tran_Allowed_types_are_gif_jpg_png_jpeg_JPG})</font>
            </div>*}

            <div class="col-sm-7">
                <div data-provides="fileupload" class="fileupload fileupload-new">
                    <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">{lang('Select_file')}</span><span class="fileupload-exists">{lang('Change')}</span>
                        <input type="file" id="upload_doc" name="upload_doc" tabindex="3" >
                    </span>
                    <span class="fileupload-preview"></span>
                    <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">
                        ×
                    </a>
                </div>
                <p class="help-block">
                    <font color="#ff0000">{lang('kb')}({lang('Allowed_types_are_gif_jpg_png_jpeg_JPG')})</font>
                </p>
            </div>





        </td>
    </tr>
    <tr>
        <td>
        </td>
        <td>
            <button class="btn btn-bricky col-sm-5" type="submit"id="reply" value="reply" name="reply" tabindex="3">{lang('Submit_Reply')} </button>
        </td>
    </tr>
{/if}
</tbody>
</table>
{*{if $ticket_arr['details0']['status']!=3}  
<div class="form-group">
<label class="col-sm-2 control-label" for="message">
</label>
<div class="col-sm-4">
<button class="btn btn-bricky" type="submit"id="reply" value="reply" name="reply" tabindex="3">Submit Reply</button>
</div>
</div>
{/if}*}
  {form_close()}
{/if}
</div>


</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateUser.init();

    });

</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}