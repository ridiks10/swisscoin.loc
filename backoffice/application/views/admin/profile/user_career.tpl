{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{$tran_rows}</span>
    <span id="show_msg">{$tran_shows}</span>
</div>

<div class="row"  >
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> Career Achivers
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
                <div class="row">
                    <div class="col-sm-5">
                        <div class="btn-group-vertical">

                            {foreach from=$ranks item=v} 
                                {form_open('','role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                                <button  name="rank_id" value="{$v.id}" type="submit" style="width:100%;" {if $v.id ==$career_id} class="btn btn-active"{else}class="btn btn-default"{/if} >
                                    {$v.leadership_rank} <span class="badge">{if $v.count > 0}{$v.count}{/if}</span>
                                </button>

                                {form_close()}
                            {/foreach}
                        </div>

                    </div>

                    <div class="col-sm-7">

                        {if $achievers}
                            <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1" width="100%">
                                <thead>
                                    <tr class="th" align="center">
                                        <th width="20%">Sl No</th>
                                        <th>Username</th>
                                        <th>Name, Vorname</th>
                                       {* <th>Career</th>*}
                                    {*<th>Action</th>*}
                                    </tr>
                                </thead>
                                <tbody> 
                                    {assign var="i" value=0}
                                    
                                    {foreach from=$achievers item=v}
                                        {$i=$i+1}
                                        <tr>
                                            <td>{$i}</td>
                                            <td>{$v.user_name}</td>
                                            <td>{$v.realname}</td>
                                            {*<td>{$v.rank_name}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="auto" title="Activate Rank" onclick="activate_rank('{$v.id}')">
                                                    <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                </button>
                                                <button type="button" class="btn btn-bricky" data-toggle="tooltip" data-placement="auto" title="Discard Rank" onclick="deactivate_rank('{$v.id}')">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                </button>                                    
                                            </td>*}
                                        </tr>
                                    {/foreach}                            
                                </tbody>
                            </table>
                        {else}
                            <p><h3>There is no achievers for this career..</h3></p>
                                    
                        {/if}
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- end: PAGE CONTENT -->
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
