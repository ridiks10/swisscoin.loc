{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}

<style>
    .circle-img {
        border-radius: 100%;
        display: inline-block !important;
    }

    .base_sent .messages.msg_sent {
        width: 100%;
        float: right;
    }
    .footlin > li > img {
        width: auto;
    }
    .input-group.col-md-12.col-xs-12 {
        margin-bottom: 20px;
    }
    .panel-footer {
        background-color: #F5F5F5;
        border-top: 1px solid #DDD;
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;

        height: auto;
        overflow: hidden;
    }
    .messages.msg_receive {
        margin: 0;
        max-width: 100%;
    }

</style>
<div class="row">
    <div class="col-sm-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('ticket')}
            </div>
            <div class="panel-body">

                {if $ticket_count>0}           
                    {*    <form role="form" class="smart-wizard form-horizontal"  name="reply_form" id="reply_form" method="post" action="{$BASE_URL}admin/employee/reply_ticket" enctype="multipart/form-data">*}

                    {form_open_multipart("{$BASE_URL}admin/employee/reply_ticket",'role="form" class="smart-wizard form-horizontal" method="post"  name="reply_form" id="reply_form"')}
                    <input type="hidden" id="ticket_pass_id" name="ticket_pass_id" value="{$ticket_arr['details0']['ticket_id']}">
                    <table class="table table-condensed table-hover">
                        <tbody>
                            <tr  style="border-top: none;">
                                <td width="20%">{lang('tracking_id')}</td>
                                <td width="30%" style="font-weight:bold;">: {$ticket_arr['details0']['ticket_id']}</td>
                                <td  width="20%"style="text-align: right;"></td>
                                <td width="30%" style="text-align: left;"></td>
                            </tr>

                            <tr >
                                <td>{lang('Subject')}</td>
                                <td style="font-weight:bold;">: {$ticket_arr['details0']['subject']}</td>
                                <td style="text-align: right;"></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>{lang('Created_on')}  </td>
                                <td>: {$ticket_arr['details0']['created_date']}</td>
                                <td style="text-align: right;"> </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{lang('updated')}</td>
                                <td>: {$ticket_arr['details0']['updated_date']}</td>
                                <td style="text-align: right;"></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>{lang('ticket')} {lang('status')}</td>
                                <td>: <span id='status_name'>{$ticket_arr['details0']['status']}</span></td>
                                <td ><label for="sel3">{lang('change_status_to')} </label></td>
                                <td>

                                    <select class="form-control btn-xs" id="sel3" onchange="changeTicketStatus('{$ticket_arr['details0']['id']}');">
                                        <option value="" >-click to select-</option>
                                        {foreach from=$all_status item=v}
                                            <option value="{$v.status_id}">{$v.status}</option>
                                        {/foreach}
                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td>{lang('Category')}</td>
                                <td>: {$ticket_arr['details0']['category']}</td>
                                <td style="text-align: right;"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{lang('priority')}</td>
                                <td>: {$ticket_arr['details0']['priority_name']}</td>
                                <td style="text-align: right;"></td>
                                <td></td>
                            </tr>

                            {assign var=i value=1}
                            {assign var=clr value=""}
                            {assign var=id value=""}
                            {assign var=msg_id value=""}
                            {assign var=user_name value=""}
                            <tr> <td colspan="4">
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
                                                                    <img src='{$BASE_URL}public_html/images/ticket_system/{$v.file}' alt='' width='40%;' >  

                                                                {/if}
                                                            </div>
                                                        </div>
                                                    </div>
                                                {else}
                                                    <div class="row msg_container base_sent">
                                                        <div class="col-md-11 col-xs-11">
                                                            <div class="messages  msg_sent">
                                                                <p>{$v.message}</p>                                           
                                                                {if {$v.file}}
                                                                    <img src='{$BASE_URL}public_html/images/ticket_system/{$v.file}' alt='' width='40%;'>                                
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
                                    <td >{lang('reply')}  <font color="#ff0000">*</font>   </td>
                                    <td colspan='3'> <div>
                                            <textarea  name='message' id='message' rows="8" cols='70'></textarea>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td >{lang('attach_file')} </td>
                                    <td colspan='3'>  
                                        
                                        <div class="col-sm-12">
                                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                                <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i> <span class="fileupload-new">{lang('select_file')}</span><span class="fileupload-exists">{lang('change')}</span>
                                                    <input type="file" id="upload_doc" name="upload_doc" tabindex="3" >
                                                </span>
                                                <span class="fileupload-preview"></span>
                                                <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#"> ×</a>
                                            </div>
                                            <p class="help-block">
                                                {*<font color="#ff0000">{$tran_kb}({lang('allowed_types')})</font>*}
                                            </p>
                                        </div>
                                    </td>


                                </tr>
                                <tr>
                                    <td colspan='1'></td>
                                    <td>
                                        <button class="btn btn-bricky col-sm-5" type="submit"id="reply" value="reply" name="reply" tabindex="3">{lang('Submit')} {lang('reply')}</button>
                                    </td> 
                                    <td colspan='2'></td>
                                </tr>
                            {/if}
                        </tbody>
                    </table>

                    {form_close()}
                {/if}
            </div>
        </div>
    </div>

</form>
</div> 
</div>
</div>  

</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateTicket.init();
        ValidateMessage.init();
        ValidateUser.init();

    });

</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}


