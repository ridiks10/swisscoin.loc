{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">  
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
     <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('download_document')}
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
                        <tr class="th" align="center">
                            <th><center>{lang('sl_no')}</center></th>
                   
                    <th><center>{lang('date')}</center></th>
                    <th><center>{lang('name')}</center></th>
                   
                    </tr>
                    </thead>
                    {if $arr_count!=0}
                        <tbody>
                            {assign var="class" value=""}
                            {assign var="path" value="{$BASE_URL}user/"}
                            {assign var="i" value=0}
                            {foreach from=$file_details item=v}
                                {assign var="id" value="{$v.id}"}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}" align="center" >
                                    <td>{$i}</td>
                                    <!--<td>{$v.file_title}</td>-->
                                    <td>{$v.uploaded_date}</td>
                                    <td>{$v.file_title}</td>
                                   
                                </tr>                    
                            {/foreach}
                        </tbody>
                    {else}                   
                        <tbody>
                            <tr><td colspan="12" align="center"><h4>{lang('no_data')}</h4></td></tr>
                        </tbody> 
                    {/if}
                </table>
            </div>                        
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        ValidateUserr.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}