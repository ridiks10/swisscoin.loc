{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<style>
    .circle-img {
        border-radius: 100%;
        display: inline-block !important;
    }
</style>

<div style="text-align: right;">
    <a href="{$BASE_URL}user/ticket_system/my_ticket"> <font  style="font-weight: bold; font-size: 15px">Back</font></a>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i> {lang('view_tickets')}
    </div>
    <div class="panel-body">
        {if $ticket_count>0}

            {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal"  method="post"  name="reply" id="reply"')}
            <table class="table table-condensed table-hover">
                <tbody>
                <input type="hidden" name="ticket_id" id="ticket_id" value="{$ticket_arr['details0']['ticket_id']}">
                <tr>
                    <td width="30%"> {lang('ticket')} ID</td>
                    <td > : {$ticket_arr['details0']['ticket_id']} </td>
                   {* <td style="text-align: right;"></td>
                    <td></td>   *}        
                </tr>
                <tr>
                    <td width="30%"> {lang('ticket')}  {lang('status')}</td>
                    <td > : {$ticket_arr['details0']['status']}</td>
                    {*<td style="text-align: right;"></td>
                    <td></td>*} 
                </tr>
                <tr>
                    <td width="30%"> {lang('Created_on')}</td>
                    <td > : {$ticket_arr['details0']['created_date']} </td>
                    {*<td style="text-align: right;"></td>
                    <td></td> *}
                </tr>
                <tr>
                    <td width="30%"> {lang('updated')} Date</td>
                    <td > : {$ticket_arr['details0']['updated_date']} </td>
                    {*<td style="text-align: right;"></td>
                    <td></td> *}
                </tr>
                <tr>
                    <td width="30%"> {lang('last_replier')}</td>
                    <td > : {$ticket_arr['details0']['lastreplier']} </td>
                   {* <td style="text-align: right;"></td>
                    <td></td> *}
                </tr>
                <tr>
                    <td width="30%"> {lang('category')}</td>
                    <td > : {$ticket_arr['details0']['category']} </td>
                   {* <td style="text-align: right;"></td>
                    <td></td> *}
                </tr>
                <tr>
                    <td width="30%"> {lang('priority')}</td>
                    <td > : {$ticket_arr['details0']['priority_name']}</td>
                   {* <td style="text-align: right;"></td>
                    <td></td> *}
                </tr>
                {assign var=i value=1}
                <tr> <td colspan="2">
                        <div class="msg_container_base">
                            {if $cnt_row > 0}   
                                {foreach from=$ticket_reply item=v}
                                    {if $v.user_id==$user_id}
                                        <div class="row msg_container base_receive ">
                                            <div class="col-md-1 col-xs-1 avatar ">
                                                <img src='{$PUBLIC_URL}images/profile_picture/{$v.profile_pic}' class="img-responsive " >
                                            </div>
                                            <div class="col-md-11 col-xs-11">
                                                <div class="messages  msg_receive">
                                                    <p>{$v.message}</p>
                                                    {if {$v.file}}

                                                        <img src='{$BASE_URL}public_html/images/ticket_system/{$v.file}' alt='' width='50%;'>  
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>

                                    {else}

                                        <div class="row msg_container base_sent">
                                            <div class="col-md-11 col-xs-11">
                                                <div class="messages  msg_sent">
                                                    <p>{$v.message}</p>
                                                    {*<time datetime="2009-11-13T20:00">Timothy • 51 min</time>*}                                              
                                                    {if {$v.file}}
                                                        <img src='{$BASE_URL}public_html/images/ticket_system/{$v.file}' alt='' width='15%;' height='25%;'>                                
                                                    {/if}
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-xs-1 avatar ">
                                                <img src='{$PUBLIC_URL}images/profile_picture/{$v.profile_pic}' class="img-responsive ">
                                            </div>
                                        </div>
                                    {/if}
                                {/foreach}
                            {/if}
                        </div>   
                    </td>
                </tr> 
                {if $ticket_arr['details0']['status']!="Resolved"}
                    <tr>
                        <td width="30%">{lang('reply')}   <font color="#ff0000">*</font>   </td><td width='100%'>
                                <textarea tabindex="2" name='message' id='message' rows='5' cols='70'></textarea>
                            </td>
                       {* <td style="text-align: right;"></td>
                        <td></td>    *} 

                    </tr>
                    <tr>
                        <td width="30%">{lang('attachment')}   </td>
                        <td >  

                            <div class="col-sm-12">
                                <div data-provides="fileupload" class="fileupload fileupload-new">
                                    <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">{lang('select_file')}</span><span class="fileupload-exists">{lang('change')}</span>
                                        <input type="file" id="upload_doc" name="upload_doc" tabindex="3" >
                                    </span>
                                    <span class="fileupload-preview"></span>
                                    <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">
                                        ×
                                    </a>
                                </div>
                                <p class="help-block">
                                    <font color="gray">{lang('allowed_types')}{*{$tran_kb}({$tran_Allowed_types_are_gif_jpg_png_jpeg_JPG})*}</font>
                                </p>
                            </div>

                        </td>
                       {* <td style="text-align: right;"></td>
                        <td></td> *}
                    </tr>
                    <tr>
                        <td colspan='1'></td>
                        <td>
                            <button class="btn btn-bricky col-sm-2" type="submit"id="reply" value="reply" name="reply" tabindex="3">{lang('Submit')} {lang('reply')} </button>
                        </td>
                        {*<td colspan='2'></td>*}
                    </tr>
                {/if}
                </tbody>
            </table>
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