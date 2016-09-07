<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">

                {if count($user_board) >0}

                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('slno')}</th>
                                <th>{lang('date_of_joining')}</th>
                                <th>{$langs['board_id']}</th>
                                <th>{$langs['board_username']}</th>
                                <th>{$langs['board_split']}</th>
                                <th>{$langs['view_board']}</th>
                            </tr>
                        </thead>

                        {assign var="board_id" value=""}
                        {assign var="serail_no" value=""}
                        {assign var="top_id" value=""}
                        {assign var="encr_id" value=""}
                        {assign var="date_of_joining" value=""}
                        {assign var="split_Status" value=""}
                        {assign var="board_user_name" value=""}
                        {assign var="table_no" value=""}
                        {assign var="k" value="{$page}"}
                        {assign var="class" value=""}
                        <tbody>
                            {foreach from=$user_board item=v}

                                {if $v.split_status=='NO'}
                                    {$split_Status = $tran_no}
                                {elseif  $v.split_status=='YES'}
                                    {$split_Status = $tran_yes}
                                {else}
                                    {$split_Status = $v.split_status}
                                {/if}

                                {$board_id = $v.id}
                                {$top_id = $v.top_id}
                                {$encr_id = $v.encr_id}
                                {$date_of_joining = $v.date_of_joining}
                                {$serail_no = $v.seriel_no}
                                {$table_no = $v.table_no}
                                {$user_name = $v.user_name}
                                {$board_user_name = $v.user_name}

                                {if $k % 2 == 0}
                                    {$class = "class= 'tr2'"}
                                {else}
                                    {$class = "class = 'tr1'"}
                                {/if}
                                {$k = $k + 1}
                                <tr {$class} >
                                    <td>{$k}</td>
                                    <td>{$date_of_joining}</td>
                                    <td>#{$serail_no}</td>
                                    <td>{$board_user_name}</td>
                                    <td>{$split_Status}</td>
                                    <td>
                                        <a id="element_1" href="{$BASE_URL}admin/tree/board_view/{$table_no}/{$encr_id}"   toptions="width = 1000, height = 500, type = iframe, title ={lang('Club_View')}, layout = quicklook, shaded = 1" target="_blank">
                                            <img id="element_1" alt="{lang('Club_View')}" height='48px' width='48px' src="{$PUBLIC_URL}images/active.gif" title="{lang('view')}" >
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                    {$result_per_page}
                {else}
                    <h3 align ='center'> {lang('invalid_user_id_or_not_found')} </h3>
                {/if} 
            </div>
        </div>
    </div>
</div>