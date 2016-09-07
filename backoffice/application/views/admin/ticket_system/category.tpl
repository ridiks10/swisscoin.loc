{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}

<div id="span_js_messages" style="display: none;">
    <span id="row_msg">rows</span>
    <span id="show_msg">shows</span>    
</div>


{if isset($create_new) OR isset($edit_status)}

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{if isset($edit_status)} {lang('edit_cateory')}{else} {lang('add_new_category')}{/if}
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>

                        <a class="btn btn-xs btn-link panel-expand" href="#">
                            <i class="fa fa-resize-full"></i>
                        </a>
                    </div>
                </div>

                {* <form role="form" class="smart-wizard form-horizontal" id="category" name="category" method="post" >*}
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="category" id="category"')}
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{lang('category_name')}<span style="color:grey; font-style: italic; "> (max 40 chars)</span> :<font color="#ff0000">*</font></label>
                        <div class="col-sm-4">
                            <input name="name" type="text" id="name" size="20" maxlength="40"  autocomplete="Off" class="form-control"  {if isset($edit_status)} value='{$edit_name}'
                            {/if}  />
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="employee">{lang('asiigned_to_me')}<font color="#ff0000" >*</font> </label>
                    <div class="col-sm-4">

                        <input placeholder="Type employee name here" class="form-control username-auto-ajax" type="text" id="employee" name="employee" autocomplete="Off" tabindex="2" {if isset($edit_status)} value='{$edit_assignee}'
                               {/if}/>
                               <span class="help-block" for="user_name"></span>
                        </div>
                    </div>
                    {if isset($edit_status)}
                        <div class="form-group">
                            <input type="hidden" name='edit_id' value='{$edit_id}'/>
                            <div class="col-sm-4 col-sm-offset-3">
                                <input name="edit" type="submit" id="edit" value="Edit category" class="btn btn-primary"  />
                            </div>

                        </div>
                    {else} 
                        <div class="form-group">

                            <div class="col-sm-4 col-sm-offset-3">
                                <input name="create" type="submit" id="create" value="Create category" class="btn btn-primary"  />
                            </div>

                        </div>
                    {/if}
                </div>
                {*</form>*}
                {form_close()}
            </div>
        </div>
    </div>
    {/if}

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>{lang('manage_categories')}

                    </div>
                    <div class="panel-body">
                        {if $category}
                            <table class="table table-striped table-bordered table-hover table-full-width dataTable" id="sample_1">
                                <thead>
                                    <tr class="th">
                                        <th width="30%">{lang('category_name')}</th>
                                        <th width="10%">{lang('tickets')} </th>
                                        <th width="30%">{lang('graph')}</th>
                                        <th width="30%">{lang('options')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {assign var="class" value=""}
                                    {assign var="i" value=0}
                                    {foreach from=$category item=v}

                                        {if $i%2==0}
                                            {$class='tr1'}
                                        {else}
                                            {$class='tr2'}
                                        {/if}
                                        {$i=$i+1}
                                        <tr class="{$class}">
                                            <td><strong>{$v.category_name}</strong></td>
                                            <td>{$v.ticket_count}</td>
                                            <td><div class="progress">
                                                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{$v.ticket_per}" aria-valuemin="0" aria-valuemax="100" style="width:{$v.ticket_per}%">
                                                        {$v.ticket_count}
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align:center;">

                                                {if $v.status == 1}  
                                                    <button type="button" class="btn btn-danger" title="Inactivate {$v.category_name}" onclick="deleteCategory({$v.id});">
                                                        <span class="glyphicon glyphicon-remove"></span> 
                                                    </button>
                                                {else}
                                                    <button type="button" class="btn btn-green" title="Activate {$v.category_name}" onclick="activateCategory({$v.id});">
                                                        <span class="glyphicon glyphicon-ok"></span> 
                                                    </button>
                                                {/if}    

                                                <button type="button" class="btn btn-primary small" title="Edit {$v.category_name}" onclick="editCategory({$v.id});">
                                                    <span class="glyphicon glyphicon-edit"></span> 
                                                </button>

                                            </td>
                                        </tr>                    
                                    {/foreach}
                                </tbody>

                            </table>
                        {/if}
                        <div style="text-align:right;">

                            <button type="button" class="btn btn-warning" title="Add new category " onclick="addNewCategory();">
                                <span class="glyphicon glyphicon-plus"></span>{lang('add_new_category')}
                            </button> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
        <script>
            jQuery(document).ready(function () {
                Main.init();
                ValidateCtegory.init();
            });
        </script>
        {include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}




