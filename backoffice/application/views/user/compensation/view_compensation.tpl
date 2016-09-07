{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('info/compensation')}
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
                <!-- start: INBOX DETAILS FORM -->
                {assign var=i value=1}
                {assign var=id value=""}
                {foreach from=$compensation_details item=v}
                    {$id = $v.compensation_id}
                    <div class="modal fade" id="panel-config{$id}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title">{lang('compensation_details')}</h4>
                                </div>
                                <div class="modal-body">
                                    <table cellpadding="0" cellspacing="0" align="center">
                                        <tr>
                                            <td>
                                                <b>{lang('compensation_title')} :</b> {$v.compensation_title}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="th">
                                                <b>{lang('date')} :</b> {$v.compensation_date}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="80%"  style="padding-top: 10px;">
                                                <b>{lang('compensation_description')} :</b> <h6><p style="text-align: justify;line-height: 20px;"> {$v.compensation_desc}</p></h6>
                                            </td>
                                        </tr>
                                        {if $v.compensation_image !=''}
                                        <tr>
                                            <td width="80%"  style="padding-top: 10px;">
                                                <b>{lang('compensation_image')} :</b> <h6><img src="{$PUBLIC_URL}images/compensation/{$v.compensation_image}" width='500px' height='300px'></h6>
                                            </td>
                                        </tr>
                                        {/if}
                                        {if $v.link !=''}
                                        <tr>
                                            <td width="80%"  style="padding-top: 10px;">
                                                <b>{lang('click_here')} :</b> <h6><p style="text-align: justify;line-height: 20px;"><a href="{$v.link}"> {$v.link}</a></p></h6>
                                            </td>
                                        </tr>
                                        {/if}
                                    </table>
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                {/foreach}                
                <!-- /.modal -->
                <!-- end: INBOX DETAILS FORM --> 
                {include file="user/compensation/inbox.tpl"  name=""}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();

    });

</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
