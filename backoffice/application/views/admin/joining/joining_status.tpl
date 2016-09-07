{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="errmsg1">{$LANG['You_must_select_a_date']}</span>
    <span id="error_msg">{$LANG['You_must_select_from_date']}</span>
    <span id="error_msg1">{$LANG['You_must_select_to_date']}</span>
    <span id="errmsg4">{$LANG['You_must_Select_From_To_Date_Correctly']}</span>
    <span id="error_msg3">{$LANG['You_must_select_a_date']}</span>
    <span id="row_msg">{$LANG['rows']}</span>
    <span id="show_msg">{$LANG['shows']}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i> {$LANG['total_joining_count']} :
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
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">{$LANG['total_joining_count']}: </label> {$total_count}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{$LANG['daily_joining']}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post" name="daily" id="daily"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {$LANG['errors_check']}
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="date">{$LANG['date']}<font color="#ff0000">*</font> </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="date" id="date" type="text" tabindex="1" size="20" maxlength="10"  value="" >
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky"tabindex="2" name="dailydate" type="submit" value="{$LANG['submit']}"> {$LANG['submit']} </button>

                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
            <div class="panel-body">
                {if $date1 != "" && $date2 == ""}
                    <br />
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1" width="100%">
                        <thead>
                            <tr class="th">
                                <th>{$LANG['user_name']}</th>
                                <th>{$LANG['status']}</th>
                                <th>{$LANG['sponser_name']}</th>
                                <th>{$LANG['date_of_joining']}</th>                           
                            </tr>
                        </thead>
                        {if count($daily_joinings) != 0}
                            {assign var="i" value=0}
                            {assign var="class" value=""}
                            {assign var="status" value=""}
                            <tbody>
                                {foreach from=$daily_joinings item=v}
                                    {if $i%2==0}
                                        {$class='tr1'}
                                    {else}
                                        {$class='tr2'}
                                    {/if}

                                    {if $v.active=="yes"}
                                        {$stat="{$LANG['active']}"}
                                    {else}
                                        {$stat="{$LANG['blocked']}"}
                                    {/if}

                                    <tr>
                                        <td>{$v.user_name}</td>
                                        <td>{$stat}</td>
                                        <td>{$v.father_user}</td>
                                        <td>{$v.date_of_joining}</td>
                                    </tr>

                                    {$i=$i+1}
                                {/foreach}
                            </tbody>
                        </table>

                    {else}                        
                        <tbody>
                            <tr><td colspan="8" align="center"><h4>{$LANG['user_not_found']}</h4></td></tr>
                        </tbody>
                        </table>
                    {/if}


                {/if}
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{$LANG['weekly_joining']}
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
                {form_open('', 'role="form" class="smart-wizard form-horizontal" method="post"  name="weekly_join" id="weekly_join"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {$LANG['errors_check']}.
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date1">{$LANG['date']} 1<font color="#ff0000">*</font> </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="3" size="20" maxlength="10"  value="" >
                                <label for="week_date1" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="week_date2">{$LANG['date']} 2<font color="#ff0000">*</font> </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input data-date-format="yyyy-mm-dd" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="4" size="20" maxlength="10"  value="" >
                                <label for="week_date2" class="input-group-addon"> <i class="fa fa-calendar"></i> </label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky"tabindex="5" name="weekdate" type="submit" value="{$LANG['submit']}"> {$LANG['submit']} </button>

                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
        <div class="panel-body">
            {if $date1 != "" && $date2 != ""}
                <br />
                <table  class="table table-striped table-bordered table-hover table-full-width" id="sample_1" width="100%">
                    <thead>
                        <tr class="th">

                            <th  >{$LANG['user_name']}</th>
                            <th  >{$LANG['status']}</th>
                            <th >{$LANG['sponser_name']}</th>
                            <th  >{$LANG['date_of_joining']}</th>
                        </tr>
                    </thead>
                    {if count($weekly_joinings)!=0}
                        {assign var="i" value=0}
                        {assign var="class" value=""}
                        {assign var="status" value=""}
                        <tbody>
                            {foreach from=$weekly_joinings item=v}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}

                                {if $v.active=="yes"}
                                    {$stat="{$LANG['active']}"}
                                {else}
                                    {$stat="{$LANG['blocked']}"}
                                {/if}

                                <tr>
                                    <td>{$v.user_name}</td>
                                    <td>{$stat}</td>
                                    <td>{$v.father_user}</td>
                                    <td>{$v.date_of_joining}</td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}                    
                        {else}                        
                        <tbody>
                            <tr><td colspan="8" align="center"><h4>{$LANG['user_not_found']}</h4></td></tr>
                        </tbody>

                    {/if}

                </table>


            {/if}
        </div>
    </div>
</div>



{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{if count($daily_joinings) != 0 || count($weekly_joinings)!=0}
    <script>
        jQuery(document).ready(function() {
            Main.init();
        {* TableData.init();*}
            DatePicker.init();
            ValidateUser.init();
        });
    </script>
{else}
    <script>
        jQuery(document).ready(function() {
            Main.init();
            DatePicker.init();
            ValidateUser.init();

        });
    </script>
{/if}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}