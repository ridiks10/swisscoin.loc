{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('you_must_enter_keyword_to_search')}</span>                  
    <span id="error_msg5">{lang('You_must_enter_your_mobile_no')}</span>
    <span id="error_msg1">{lang('you_must_enter_your_name')}</span>
    <span id="error_msg6">{lang('You_must_enter_your_email')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>   {lang('search_employee')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="search_mem" id="search_mem"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="keyword">{lang('keyword')}: </label>
                        <div class="col-sm-3">
                            <input placeholder="{lang('Username_or_Name')}.."type="text" name="keyword" id="keyword" size="50" tabindex="1" autocomplete="off">
                        </div>
                        {form_error('keyword')}
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                            <p>
                                <button class="btn btn-bricky"  type="submit" name="search_employee" id="search_employee" value="{lang('search_employee')}" tabindex="2" > {lang('search_employee')} 
                                </button>
                            </p>
                        </div>

                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                        {form_close()}
                        {form_open('','role="form" class="smart-wizard form-horizontal" method="post"  name="view_mem" id="view_mem"')}
                            <div class="col-sm-2 col-sm-offset-1">
                                <p>
                                    <button class="btn btn-bricky" name="view_all" id="view_all" value="{lang('view_all')}"   tabindex="2" style="margin-left: 10px;"> {lang('view_all')} 
                                    </button>
                                </p>
                            </div>
                        {form_close()}
                    </div>
            </div>
        </div>

    </div>

</div>    
{if $flag}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('search_employee')} 
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

                    <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
                        <thead>
                            <tr class="th">
                                <th>Sl.No</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('first_name')}</th>
                                <th>{lang('last_name')}</th>
                                <th>{lang('mobile_no')}</th>
                                <th>{lang('email')}</th>
                            </tr>
                        </thead>
                        {if $count>0}
                            {assign var="i" value=0}
                            {assign var="class" value=""}
                            <tbody>
                                {foreach from=$emp_detail item=v}
                                    {if $i%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}
                                    <tr>
                                        <td>{$v.page_no}</td>
                                        <td>{$v.user_name}</td>
                                        <td>{$v.user_detail_name}</td>
                                        <td>{$v.user_detail_second_name}</td>
                                        <td>{$v.user_detail_mobile}</td>
                                        <td>{$v.user_detail_email}</td>
                                    </tr>
                                    {$i=$i+1}
                                {/foreach}
                            </tbody>
                        {else}
                            <tbody>
                                <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_User_Found')}</h4></td></tr>
                            </tbody>
                        {/if}
                    </table>
                    {$result_per_page}

                </div>
            </div>
        </div>   
    </div>  
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function() {
        Main.init();
        DatePicker.init();
        TableData.init();
        ValidateMember.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}