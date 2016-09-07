{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"}

<div id="span_js_messages" style="display:none;">    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span> 
</div> 

<div class="row"  >
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {lang('webinar_list')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-responsive" id="sample_1">
                    <thead>
                        <tr>
                            <th>Si No</th>
                            <th>{lang('url')}</th>
                            <th>{lang('webinar_username')}</th>
                            {*<th>{lang('webinar_password')}</th>*}
                            <th>{lang('topic')}</th>
                            <th>{lang('description')}</th>
                            <th>{lang('link')}</th>
                            <th style="width:15%">{lang('action')}</th>
                        </tr>
                    </thead>
                    <tbody>{assign var="i" value=0}
                        {foreach from=$webinars item=v}
                            <tr>{$i=$i+1}
                                <td>{$i}</td>
                                <td>{$v.url}</td>
                                <td>{$v.username}</td>
                               {* <td>{$v.password}</td>*}
                                <td>{$v.topic}</td>
                                <td>{$v.description|truncate:300:"...":true}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myLink" onclick="show_link('{$v.webinar_id}','{$user_name}');"><span class="glyphicon glyphicon glyphicon-pushpin" aria-hidden="true"></span></button>
                                </td>
                                <td>
                                    <a class="btn btn-bricky" href="remove_webinar/{$v.webinar_id}">
                                        <span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </a>
                                    <a class="btn btn-primary" href="new_webinars/{$v.webinar_id}">
                                        <span class="glyphicon glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{lang('webinar_link')}</h4>
            </div>
            <div class="modal-body" id="show_link_div">
                
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
    });
    function show_link(id,username){
    var url = '{$BASE_URL}../webinar/'+id+'/'+username;
    $('#show_link_div').html(url);
    }
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}