{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;">
    <span id="row_msg">rows</span>
    <span id="show_msg">shows</span>    
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">           
            <div class="panel-heading"> <i class="fa fa-cog"></i>{lang('configuration')}  
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="{$tab1}"><a href="#status" data-toggle="pill"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            {lang('status')}   </a></li>
                    <li class="{$tab2}"><a href="#tags" data-toggle="pill"><i class="fa fa-tag" aria-hidden="true"></i>
                            {lang('tags')}    </a></li>   
                    <li class="{$tab3}"><a href="#priority" data-toggle="pill"><i class="fa fa-tasks" aria-hidden="true"></i>
                            {lang('Priority')}    </a></li>
                </ul>
                <div class="tab-content col-md-12">
                    <div class="tab-pane {$tab1}" id="status" >
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {lang('status')}  {lang('configuration')}   
                                    </div>
                                    {*<form role="form" class="smart-wizard form-horizontal"  method="post" name='new_status' id='new_status' >*}
                                     {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="new_status" id="new_status"')}
                                        <div class="panel-body">

                                            <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1" style="width:80%;"  align="center">
                                                <thead>
                                                    <tr class="th">
                                                        <th width="10%">Sl No</th>
                                                        <th width="60%">{lang('status')}  </th>
                                                        <th width="30%" >{lang('action')}  </th>
                                                    </tr>
                                                </thead>
                                                {if $ticketstatus}
                                                    <tbody>
                                                        {assign var="class" value=""}
                                                        {assign var="i" value=0}
                                                        {foreach from=$ticketstatus item=v}
                                                            {if $i%2==0}
                                                                {$class='tr1'}
                                                            {else}
                                                                {$class='tr2'}
                                                            {/if}
                                                            {$i=$i+1}
                                                            <tr class="{$class}">
                                                                <td>{$i}</td>
                                                                <td>{$v.status}</td>
                                                                <td style="text-align:center;">

                                                                    {if $v.active == 1}
                                                                        <button type="button" class="btn btn-danger btn-xs" title="Inactivate {$v.status}" onclick="deleteStatus({$v.id});">
                                                                            <span class="glyphicon glyphicon-remove"></span>  {lang('Inactivate')} 
                                                                        </button>
                                                                    {else} 

                                                                        <button type="button" class="btn btn-green btn-xs" title="Activate {$v.status}" onclick="activateStatus({$v.id});">
                                                                            <span class="glyphicon glyphicon-ok"></span>  {lang('Activate')} 
                                                                        </button>
                                                                    {/if}
                                                                </td>
                                                            </tr>                    
                                                        {/foreach}
                                                    </tbody>
                                                {/if}
                                                <tfoot id='status'>

                                                </tfoot>

                                            </table>

                                            <div style="text-align:right;">

                                                <button type="button" class="btn btn-warning btn-xs" title="Add new status " onclick="addNewStatus();">
                                                    <span class="glyphicon glyphicon-plus"></span>Add new status'} 
                                                </button> 

                                            </div>
                                        </div>

                                     {form_close()}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane {$tab2}" id="tags">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {lang('tags')}  {lang('configuration')} 
                                    </div>
                                   {* <form role="form" class="smart-wizard form-horizontal"  method="post" name='new_tag' id='new_tag' >*}
                                    {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="new_tag" id="new_tag"')}
                                        <div class="panel-body">

                                            <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1" style="width:80%;"  align="center">
                                                <thead>
                                                    <tr class="th">
                                                        <th width="10%">Sl No</th>
                                                        <th width="60%">{lang('tags')} </th>
                                                        <th width="30%" >{lang('action')}   </th>
                                                    </tr>
                                                </thead>
                                                {if $tickettags}
                                                    <tbody>
                                                        {assign var="class" value=""}
                                                        {assign var="i" value=0}
                                                        {foreach from=$tickettags item=v}

                                                            {if $i%2==0}
                                                                {$class='tr1'}
                                                            {else}
                                                                {$class='tr2'}
                                                            {/if}
                                                            {$i=$i+1}
                                                            <tr class="{$class}">
                                                                <td>{$i}</td>
                                                                <td>{$v.tag}</td>
                                                                <td style="text-align:center;">


                                                                    {if $v.active == 1}
                                                                        <button type="button" class="btn btn-danger btn-xs" title="Inactivate {$v.tag}" onclick="deleteTag({$v.id});">
                                                                            <span class="glyphicon glyphicon-remove"></span>  {lang('Inactivate')} 
                                                                        </button>
                                                                    {else} 

                                                                        <button type="button" class="btn btn-green btn-xs" title="Activate {$v.tag}" onclick="activateTag({$v.id});">
                                                                            <span class="glyphicon glyphicon-ok"></span>  {lang('Activate')} 
                                                                        </button>
                                                                    {/if}



                                                                </td>
                                                            </tr>                    
                                                        {/foreach}
                                                    </tbody>
                                                {/if}
                                                <tfoot id='tag'>

                                                </tfoot>

                                            </table>

                                            <div style="text-align:right;">
                                                <button type="button" class="btn btn-warning btn-xs" title="Add new tag " onclick="addNewTag();">
                                                    <span class="glyphicon glyphicon-plus"></span>Add new  {lang('tag')}
                                                </button> 
                                            </div>
                                        </div>
                                    {form_close()}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane {$tab3}" id="priority">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        {lang('Priority')}  {lang('configuration')}   
                                    </div>
                                   {* <form role="form" class="smart-wizard form-horizontal"  method="post" name='new_priority' id='new_priority' >*}
                                    {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="new_priority" id="new_priority"')}
                                        <div class="panel-body">

                                            <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1" style="width:80%;"  align="center">
                                                <thead>
                                                    <tr class="th">
                                                        <th width="10%">Sl No</th>
                                                        <th width="70%">{lang('Priority')}   </th>
                                                        <th width="20%" >{lang('action')}    </th>
                                                    </tr>
                                                </thead>
                                                {if $ticketpriority}
                                                    <tbody>
                                                        {assign var="class" value=""}
                                                        {assign var="i" value=0}
                                                        {foreach from=$ticketpriority item=v}

                                                            {if $i%2==0}
                                                                {$class='tr1'}
                                                            {else}
                                                                {$class='tr2'}
                                                            {/if}
                                                            {$i=$i+1}
                                                            <tr class="{$class}">
                                                                <td>{$i}</td>
                                                                <td>{$v.priority}</td>
                                                                <td style="text-align:center;">


                                                                    {if $v.active == 1}
                                                                        <button type="button" class="btn btn-danger btn-xs" title="Inactivate {$v.priority}" onclick="deletePriority({$v.id});">
                                                                            <span class="glyphicon glyphicon-remove"></span>  {lang('Inactivate')} 
                                                                        </button>
                                                                    {else} 

                                                                        <button type="button" class="btn btn-green btn-xs" title="Activate {$v.priority}" onclick="activatePriority({$v.id});">
                                                                            <span class="glyphicon glyphicon-ok"></span>  {lang('Activate')} 
                                                                        </button>
                                                                    {/if}



                                                                </td>
                                                            </tr>                    
                                                        {/foreach}
                                                    </tbody>
                                                {/if}
                                                <tfoot id='priority'>

                                                </tfoot>

                                            </table>

                                            <div style="text-align:right;">

                                                <button type="button" class="btn btn-warning btn-xs" title="Add new priority" onclick="addNewPriority();">
                                                    <span class="glyphicon glyphicon-plus"></span>Add new {lang('Priority')} 
                                                </button> 
                                            </div>
                                        </div>
                                    {form_close()}
                                </div>
                            </div>
                        </div>
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
        ValidatePriority.init();
        ValidateStatus.init();
        ValidateTag.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}