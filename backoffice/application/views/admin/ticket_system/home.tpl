{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}


<div class="row ggg">
    <div class="col-sm-3" style="background:white;">
        <a href="{$BASE_URL}admin/ticket_system/tickets/all" target="_blank"> 
            <div class="core-box">
                <div class="heading">
                    <i class="clip-copy-2 circle-icon circle-teal"></i>
                    <h2>{lang('total_tickets')}</h2>
                </div>
                <div class="content" style="text-align:center;margin-top: 0px;">
                    <h2>{$total_ticket}</h2>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-3" style="background:white;">
        <a href="{$BASE_URL}admin/ticket_system/tickets/progress" target="_blank"> 
            <div class="core-box">
                <div class="heading">
                    <i class="clip-file circle-icon circle-green "></i>
                    <h2>{lang('in_progress')}</h2>
                </div>
                <div class="content" style="text-align:center;margin-top: 0px;">
                    <h2>{$inprogress_ticket}</h2>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-3" style="background:white;">
        <a href="{$BASE_URL}admin/ticket_system/tickets/critical" target="_blank"> 
            <div class="core-box">
                <div class="heading">
                    <i class="clip-file-2 circle-icon circle-bricky"></i>
                    <h2>{lang('critical')}</h2>
                </div>
                <div class="content" style="text-align:center;margin-top: 0px;">
                    <h2>{$critical_ticket}</h2>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-3" style="background:white;">
        <a href="{$BASE_URL}admin/ticket_system/tickets/new" target="_blank"> 
            <div class="core-box " >
                <div class="heading">
                    <i class="clip-file-plus circle-icon circle-warning"></i>
                    <h2>{lang('new_ticket')}</h2>
                </div>
                <div class="content" style="text-align:center;margin-top: 0px;">
                    <h2>{$new_ticket}</h2>
                </div>
               
            </div>
        </a>
    </div>
</div>

<input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
<input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('show_tickets')}
                <div class="panel-tools">
                   
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            {*<form role="form" class="smart-wizard form-horizontal" id="show_ticket" name="show_ticket" method="post" >*}
            {form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="show_ticket" id="show_ticket"')}
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="category_name">{lang('category')}:</label>
                        <div class="col-sm-8">
                            <select name="category_name" id="category_name" class="form-control">
                                <option value="">-select category-</option>
                                {foreach from=$category item=v}

                                    <option value="{$v.id}">{$v.category_name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tag-name">{lang('tag')}:</label>
                        <div class="col-sm-8">
                            <select name="tag-name" id="tag-name" class="form-control ">
                                <option value="">-select tag-</option>
                                {foreach from=$tags item=v}
                                    <option value="{$v.tag}">{$v.tag}</option>
                                 
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-4">
                            <input name="category_submit" type="submit" id="category_submit" value="Show" class="btn btn-primary"  />
                        </div>
                    </div>
                </div>
           {form_close()}
        </div>
    </div>
 
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('find_ticket')}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>

            {*<form role="form" class="smart-wizard form-horizontal" id="search_ticket_form" name="search_ticket_form" method="post" >*}{form_open('','role="form" class="smart-wizard form-horizontal" method="post" name="search_ticket_form" id="search_ticket_form"')}
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-sm-6">
                            {lang('search_for')}
                            <input type="text" name="search_text" id="search_text" class="form-control">
                        </div>
                        <div class="col-sm-6">
                           {lang('search_in')}
                            <select name="search_item" id="search_item" class="form-control">
                                <option value="ticket_id">{lang('ticket_id')}</option>
                                <option value="name">{lang('user_id')}</option>
                                <option value="assignee_name">{lang('Assignee')}</option>
                                <option value="email">{lang('Email')}</option>
                                <option value="subject">{lang('Subject')}</option>
                            </select>

                        </div>

                    </div>
                    <div id="more_search_type" style="display:none;">
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="name">{lang('category_name')} :</label>
                            <div class="col-sm-6">
                                <select name="tckt_category" id="tckt_category" class="form-control">
                                    <option value="">-select {lang('category')}-</option>
                                    {foreach from=$category item=v}

                                        <option value="{$v.id}">{$v.category_name}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="name">{lang('date')}:</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date" id="week_date" type="text" tabindex="2" size="20" maxlength="10"  value="" autocomplete="off">
                                    <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="name">{lang('search_within')}:</label>
                            <div class="col-sm-6">

                                <label><input type="checkbox"  value="1" name="s_my" id="s_my">{lang('asiigned_to_me')}</label>
                                <br>
                                <label><input type="checkbox"  value="1" name="s_ot" id="s_ot">{lang('assigned_to_other')}</label>
                                <br>
                                <label><input type="checkbox"  value="1" name="s_un" id="s_un">{lang('unassigned_ticket')}</label>
                                <br>
                                <label><input type="checkbox" value="1" name="archive" id="archive">{lang('only_taged_tickets')}</label>
                            </div>
                        </div>
                      
                    </div>

                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-4">
                            <input name="ticket_search" type="submit" id="ticket_search" value="Search" class="btn btn-primary"  /> | <a role="menuitem" name="more_option" id="more_option" href="javascript:show_more()">{lang('more_opt')}</a> <a role="menuitem"  href="javascript:show_less()" name="less_option" id="less_option" style="display: none;">{lang('less_opt')}</a>
                        </div>
                    </div>

                </div>
           {form_close()}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                <div class="panel-tools">
                    
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div> 
                {if isset($panel_title)} {$panel_title}{else} {lang('open_tickets')}{/if}

            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    {if $count>0}
                        <thead>
                            <tr align="center">
                                <th  width="6%">Sl No</th>
                                <th  width="12%">{lang('ticket_id')}</th>
                                <th  width="10%">{lang('updated')}</th>
                                <th  width="10%">{lang('user_id')}</th>
                                <th  width="18%">{lang('subject')}</th>
                                <th  width="9%">{lang('status')}</th>
                                <th  width="10%">{lang('category')}</th>
                                <th  width="10%">{lang('last_replier')}</th>
                                <th  width="9%">{lang('priority')}</th>
                                <th  width="6%">{lang('timeline')}</th>

                            </tr>
                        </thead>
                        <tbody>
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$tickets item=v}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                <tr class="{$class}"  >
                                    <td>{counter}</td>
                                    <td><a href='ticket/{$v.ticket_id}'>{$v.ticket_id}</a></td>
                                    <td>{$v.updated}</td>
                                    <td>{$v.name}</td>
                                    <td>{$v.subject}</td>
                                    <td>{$v.status}</td>
                                    <td>{$v.category_name}</td>
                                    <td>{$v.last_replier}</td>
                                    <td>{$v.priority_name} </td>
                                    <td><a href="javascript:show_timeline('{$v.ticket_id}')" onclick=""  class="btn btn-primary tooltips" data-placement="top" title="timeline"><i class="glyphicon glyphicon-fullscreen"></i></a></td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        {else} 
                        <h3>There is no tickets found...</h3>
                    {/if}
                    </tbody>
                </table>

                {$result_per_page}
            </div>
        </div>
    </div>
</div>

<style> 
    .core-box h2 {
        margin: 0;
    }
    .core-box {
        margin-bottom: 20px;
        padding: 15px;
        max-width: 95%;
        margin: auto;
        border: 1px solid #ccc;
        display: block;
        padding-bottom: 10px;
        box-shadow: 3px 3px 9px 0px rgba(102, 102, 102, 0.17);
    }
    .row.ggg .col-sm-3 {
        padding: 0;
    }
    .row.ggg {
        margin-bottom: 16px;
    }
    .core-box .content {
        padding-left: 0;
    }
    .circle-icon.circle-warning{
        background-color:#f0ad4e;
        border-color:#eea236;
        color: #ffffff;
    }
    .row.ggg a{
        text-decoration: none;
    }

    .row.ggg a:hover .core-box {
        border: 1px solid grey;
    }
</style>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {

        DatePicker.init();
        ValidateSearch.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}

