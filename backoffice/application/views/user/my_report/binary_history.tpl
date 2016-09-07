{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">        
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>    
</div> 
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('binary_history')}
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
            <div class="panel-body" style="overflow-x: hidden;"> 

                {form_open_multipart('', 'role="form" class="smart-wizard form-horizontal" name="searchform" id="searchform" method="post"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i>{lang('errors_check')}
                    </div>
                </div>                    
                <div class="row">
                    <div class="form-group"  >                            
                        <label class="col-sm-3 control-label" for="level">{lang('select_level')}: </label>
                        <div class="col-sm-3">                                    
                            <select name="level" id="level" tabindex="4" onChange="" class="form-control" style="width: 208px;">  
                                <option value="all">{lang('all')}</option>
                                {foreach from=$level_arr item=v}

                                    <option value="{$v}" {if $binary_level==$v}selected=""{/if}>{$v}</option>
                                {/foreach}
                            </select>  
                        </div>                           
                    </div>
                </div>     
                <div class="row">       
                    <div class="form-group">       
                        <div class="col-sm-2 col-sm-offset-3">       
                            <input class="btn btn-bricky" type="submit" id="user_details" value="{lang('view')}" name="user_details" tabindex="2" style="width: 71px;">
                        </div>
                    </div>
                </div>
                {form_close()} 
            </div>
        </div>
            
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('binary_history')}
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
            <div class="panel-body" style="overflow-x: hidden;">
                {if count($binary)>0}
                    {assign var=i value="{$start}"}
                    {assign var=class value=""}

                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>                                
                            <tr class="th" align="center">
                                <th>{lang('slno')}</th>
                                <th>{lang('level')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('name')}</th>
                                <th>{lang('enrollment_date')}</th>
                                <th>{lang('state')}</th>
                                <th>{lang('country')}</th>                                    
                            </tr>
                        </thead>
                        <tbody>                                
                            {foreach from=$binary item=v}
                                {$i=$i+1}
                                <tr>	
                                    <td>{$i}</td>
                                    <td>{$v.level}</td>
                                    <td>{$v.username}</td>
                                    <td>{$v.name}</td>
                                    <td>{$v.date_of_joining}</td>
                                    <td>{$v.state}</td>
                                    <td>{$v.country}</td>
                                </tr>	
                            {/foreach}
                        </tbody>
                    </table>
                    {$result_per_page}
                {else}
                    <table class="table table-striped table-bordered table-hover table-full-width">
                        <thead>                                
                            <tr class="th" align="center">
                                <th>{lang('slno')}</th>
                                <th>{lang('level')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('name')}</th>
                                <th>{lang('enrollment_date')}</th>
                                <th>{lang('state')}</th>
                                <th>{lang('country')}</th>                          
                            </tr>
                        </thead>
                        <tbody>  
                            <tr><td colspan="8" align="center"><h4 align="center">{lang('no_details_found')}</h4></td></tr>
                        </tbody>
                    </table>
                {/if}
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        ValidateMember.init();
    });
</script>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}