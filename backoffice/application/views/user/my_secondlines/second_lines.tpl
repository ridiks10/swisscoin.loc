{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;"> 
    <span id="error_msg">{lang('you_must_enter_user_name')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>    
</div> 

<div class="row">
    <div class="col-sm-12">


        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('secondline')}
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
              
                {assign var=class value=""}

                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>                                
                        <tr class="th" align="center">
                            <th>{lang('slno')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('name')}</th>
                            <th>{lang('enrollment_date')}</th>
                            <th>{lang('email')}</th>                                  
                        </tr>
                    </thead>
                    <tbody>  
                        {if !empty($secondline_users)}{assign var="i" value=0 }
                            {foreach from=$secondline_users item=v}

                                <tr>	{$i=$i+1}
                                    <td>{$i}</td>
                                    <td>{$v.user_name}</td>
                                    <td>{if $v.user_detail_name=='' && $v.user_detail_second_name==''}NA{else}{$v.user_detail_name} {$v.user_detail_second_name}{/if}</td>
                                    <td>{$v.date_of_joining}</td>
                                    <td>{$v.user_detail_email}</td>
                                </tr>	
                            {/foreach} 
                        {else}
                             <tr style="text-align: center">
                                 <td colspan="5"> {lang('not_found')}</td>
                           
                            </tr>
                            
                        {/if}
                    </tbody>
                </table>
              

            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();
    {* ValidateMember.init();
    ValidateUser.init();*}
    });
</script>
{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}