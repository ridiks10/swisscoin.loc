
<div class="panel-body">
    <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
    <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
        <thead>
            <tr class="th">            
                <th> {lang('no')}</th>
                <th>{lang('news_title')}</th>
                <th>{lang('date')}</th>
                <th>{lang('action')}</th>
            </tr>
        </thead>
        {if $news_count>0}
            <tbody>
                {assign var=i value=1}            
                {foreach from=$news_details item=v}
                    {$id = $v.news_id} 
                    <tr>
                        <td>
                            <a id=""{* class="btn btn-xs btn-link panel-config"*} {*href ="#panel-config{$id}" *}{*onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')"*} {*data-toggle="modal"*} {*style='color:#C48189;'*}>  </a>{$i}
                        </td>
                        <td>
                            <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')" data-toggle="modal" style='color:#C48189;'> {$v.news_title}</a>
                        </td>
                        <td>
                            <a {*class="btn btn-xs btn-link panel-config"*} {*href ="#panel-config{$id}" *}{*onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')"*} {*data-toggle="modal"*} {*style='color:#C48189'*}> </a>{$v.news_date}
                        </td>
                        <td>
                             <a href="javascript:view_user_news({$id},'{$BASE_URL}')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="{lang('delete')} {$v.news_title}">view</a
                        </td>
                    </tr>
                    {$i=$i+1}	
                {/foreach}
            </tbody>      

        {else}                   
            <tbody>
                <tr><td colspan="12" align="center"><h4>{lang('You_have_no_news_in_inbox')}</h4></td></tr>
            </tbody> 
        {/if}
    </table>

</div>

