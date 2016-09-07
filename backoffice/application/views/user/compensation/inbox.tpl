
<div class="panel-body">
    <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
    <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
        <thead>
            <tr class="th">            
                <th> {lang('no')}</th>
                <th>{lang('compensation_title')}</th>
                <th>{lang('date')}</th>
                <th>{lang('action')}</th>
            </tr>
        </thead>
        {if $compensation_count>0}
            <tbody>
                {assign var=i value=1}            
                {foreach from=$compensation_details item=v}
                    {$id = $v.compensation_id} 
                    <tr>
                        <td>
                            {$i}
                        </td>
                        <td>
                            <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')" data-toggle="modal" style='color:#C48189;'> {$v.compensation_title}</a>
                        </td>
                        <td>
                             {$v.compensation_date}
                        </td>
                        <td>
                             <a href="{$BASE_URL}user/compensation/view_all_compensation/view" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.compensation_title}">view</a
                        </td>
                    </tr>
                    {$i=$i+1}	   
                {/foreach}
            </tbody>      

        {else}                   
            <tbody>
                <tr><td colspan="12" align="center"><h4>{lang('You_have_no_compensation_in_inbox')}</h4></td></tr>
            </tbody> 
        {/if}
    </table>

</div>

