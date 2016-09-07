{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}


<div id="span_js_messages" style="display:none;">
    
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('upload_materials')}
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                    <thead>
                        <tr class="th">
                            <th>{lang('sl_no')}</th>
                            <th>{lang('file_title')}</th>
                            <th>{lang('uploaded_date')}</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        {if $file_details_count!=0}
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
                                <tr class="{$class}">
                                    <td>{$i}</td>
                                    <td><!--<a href="<div class='dialog'  style='display:none; overflow:scroll;'> <iframe src='./public_html/images/document/{*$v.file_title*}'></iframe></div>">--><a href="../../public_html/images/document/{$v.doc_file_name}">{$v.file_title}</a></td>
                                    <td>{$v.uploaded_date}</td>
                                    
                                </tr>                    
                            {/foreach}
                        </tbody>
                        <counter></counter>
                        {else}
                        <tr><td colspan="6" align="center"><h4>{lang('No_Materials_Found')}</h4></td></tr>
                                {/if}
                    </tbody>
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
       // ValidateUser.init();
       // DateTimePicker.init();
    });
</script>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}