{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}


<script>
    $(function () {
        var $input_tagator1 = $('#input_tagator1');
        var $activate_tagator1 = $('#activate_tagator1');
        $activate_tagator1.click(function () {
            if ($input_tagator1.data('tagator') === undefined) {
                $input_tagator1.tagator({
                    autocomplete: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth'],
                    useDimmer: true
                });
                $activate_tagator1.val('destroy tagator');
            } else {
                $input_tagator1.tagator('destroy');
                $activate_tagator1.val('activate tagator');
            }
        });
        $activate_tagator1.trigger('click');
    });
</script>
<style>
    .circle-img {
    border-radius: 100%;
    display: inline-block !important;
}
    .base_sent .messages.msg_sent {
        width: 800px;
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
        padding: 29px;
        height: auto;
        overflow: hidden;
    }
    .messages.msg_receive {
        margin: 0;
        max-width: 800px;
    }

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('ticket')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>

            <div class="panel-body">
                <table class="table table-striped borderless">
                    <tbody>
                        <tr  style="border-top: none;">
                            <td style="width:30%;">{lang('tracking_id')}</td>
                            <td style="width:30%;font-weight:bold;">: {$ticket['ticket_id']}</td>
                            <td style="width:20%;text-align: right;"></td>
                            <td style="width:20%;"></td>
                        </tr>
                        <tr >
                            <td>{lang('User_id')}</td>
                            <td style="font-weight:bold;"> : {$ticket['user']}</td>
                            <td style="text-align: right;"></td>
                            <td></td>
                        </tr>

                        <tr >
                            <td>{lang('Subject')}</td>
                            <td style="font-weight:bold;">: {$ticket['subject']}</td>
                            <td style="text-align: right;"></td>
                            <td></td>
                        </tr>
                      
                        <tr>
                            <td>{lang('Created_on')} </td>
                            <td>: {$ticket['created_date']}</td>
                            <td style="text-align: right;"> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{lang('updated')}</td>
                            <td>: {$ticket['updated_date']}</td>
                            <td style="text-align: right;"></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>{lang('ticket')} {lang('status')} </td>
                            <td>: <span id='status_name'>{$ticket['status']}</span></td>
                            <td style="text-align: right;"><label for="sel3">{lang('change_status_to')} </label></td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control btn-xs" id="sel3" onchange="changeStatus({$ticket['id']});">
                                        <option value="" >-click to select-</option>
                                        {foreach from=$ticket_status item=v}
                                            <option value="{$v.id}">{$v.status}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{lang('Category')}</td>
                            <td>: <span id='category_name'>{$ticket['category']}</span></td>
                            <td style="text-align: right;"><label for="sel2">{lang('Change_category_to')}</label></td>
                            <td>

                                <div class="form-group">
                                    <select class="form-control btn-xs" id="sel2" onchange="changeCategory({$ticket['id']});">
                                        <option value="">-click to select-</option>
                                        {foreach from=$ticket_category item=v}
                                            <option value="{$v.id}">{$v.category_name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{lang('Priority')}</td>
                            <td>: <span id='priority_name'>{$ticket['priority']}</span></td>
                            <td style="text-align: right;"> <label for="sel1">{lang('change_priority_to')} </label></td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control btn-xs" id="sel1" onchange="changePriority({$ticket['id']});">
                                        <option value="">-click to select-</option>
                                        {foreach from=$ticket_priority item=v}
                                            <option value="{$v.id}">{$v.priority}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>{lang('Assignee')} </td>
                            <td>:<span id='assignee_name'> {$ticket['assignee']}</span></td>
                            <td style="text-align: right;"> <label for="sel1">{lang('Change_assignee_to')} </label></td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control btn-xs" id="sel4" onchange="changeAssignee({$ticket['id']});">
                                        <option value="">-click to select-</option>
                                        {foreach from=$employee_details item=v}
                                            <option value="{$v.user_id}">{$v.user_name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot> 
                        <tr>
                            <td>{lang('tags')}:</td> 
                            <td colspan="2">
                                <input id="activate_tagator2" type="text" class="tagator form-control" value="{$ticket['tags']}" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="{$ticket_tags}">
                            </td>  
                            <td>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-xs" id="btn-update" onclick='updateTags({$ticket['id']});'>{lang('update')}</button>
                                </span>
                            </td> 
                        </tr>
                        <tr>
                            <td>{lang('comment')}:</td> 
                            <td colspan="2">
                                <textarea  id="comments" type="text" class="form-control input-sm chat_input" name='comments'></textarea>
                            </td>  
                            <td>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-xs" id="btn-addcomment" onclick='addComments({$ticket['id']});'>{lang('Add')}</button>
                                </span>

                            </td> 
                        </tr>
                    </tfoot>
                </table> 

                <div class="row">
                    <div class="col-xs-12 col-md-12">

                        <div class="msg_container_base">


                            {foreach from=$ticket_replies item=v}


                                {if $ticket['user_id']== $v.user_id}

                                    <div class="row msg_container base_receive ">

                                        <div class="col-md-1 col-xs-1 avatar ">
                                            <img src='{$BASE_URL}public_html/images/profile_picture/{$v.profile_pic}' class="img-responsive ">
                                        </div>
                                        <div class="col-md-11 col-xs-11">
                                            <div class="messages  msg_receive">
                                                <p>{$v.message}</p>

                                                {if $v.attachments }

                                                    <img src='{$BASE_URL}public_html/images/ticket_system/{$v.attachments}' alt='' width='50%;'>  

                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                {else}

                                    <div class="row msg_container base_sent">

                                        <div class="col-md-11 col-xs-11">
                                            <div class="messages  msg_sent">
                                                <p>{$v.message}</p>

                                                {if $v.attachments }

                                                    <img src='{$BASE_URL}public_html/images/ticket_system/{$v.attachments}' alt='' width='50%;' >                                
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-xs-1 avatar ">
                                            <img src='{$BASE_URL}public_html/images/profile_picture/{$v.profile_pic}' class="img-responsive ">
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                       {* <form id="message" name="message"  enctype="multipart/form-data" method='post' action="{$BASE_URL}admin/ticket_system/ticket/{$ticket['ticket_id']}">*}
                       {form_open_multipart("",'role="form" class="smart-wizard form-horizontal" method="post"  name="upload" id="upload"')}
                            <div class="panel-footer">
                                <div class="input-group col-md-12 col-xs-12">

                                    <textarea  id="btn-input" type="text" class="form-control input-sm chat_input" name='message' id='message'></textarea>


                                </div>
                                <div class="input-group col-md-6 col-xs-6">
                                    <div class="col-sm-12">
                                        <div data-provides="fileupload" class="fileupload fileupload-new">
                                            <span class="btn btn-file btn-light-grey"><i class="fa fa-paperclip"></i> <span class="fileupload-new">{lang('attach_file')} </span><span class="fileupload-exists">{lang('change')}</span>
                                                <input type="file" id="upload_doc" name="upload_doc"  >
                                            </span>
                                            <span class="fileupload-preview"></span>
                                            <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#"> ×
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="input-group col-md-6 col-xs-6">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" id="btn-chat" name="message_send"  id="message_send" value='ok'> {lang('send')}</button>
                                    </span>
                                </div>
                            </div>
                          {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateMessage.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}




