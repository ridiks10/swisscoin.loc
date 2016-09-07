<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('inbox')}
    </div>

    <div class="panel-body">



        <div id="span_js_messages" style="display:none;">
            <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
        </div>
        <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
        <table  class="table table-hover" id="sample-table-1">
            <thead>
                <tr class="th">            
                    <th>{lang('from')}</th>
                    <th>{lang('subject')}</th>
                    <th>{lang('date')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var=i value=1}
                {assign var=clr value=""}
                {assign var=id value=""}
                {assign var=msg_id value=""}
                {assign var=user_name value=""}
                {if $cnt_adminmsgs > 0}
                    {foreach from=$adminmsgs item=v}

                        {if $v.read_msg=='yes'}
                            {$id = $v.id}                        
                            <tr>
                                <td>
                                    {$user_name = $v.user_name}
                                    <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" data-toggle="modal" style='color:#C48189;'>  {$user_name}</a>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" data-toggle="modal" style='color:#C48189;'> {$v.mailadsubject}</a>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-link panel-config" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" data-toggle="modal" style='color:#C48189'> {$v.mailadiddate}</a>
                                </td>                   
                                <td class="center">
                                    {$msg_id=$v.id}
                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                        <a href="#" onclick="deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                                    </div>
                                    <div class="visible-xs visible-sm hidden-md hidden-lg">
                                        <div class="btn-group">
                                            <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                <i class="fa fa-cog"></i> <span class="caret"></span>
                                            </a>
                                            <ul role="menu" class="dropdown-menu pull-right">
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" href="#" onclick="deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')">
                                                        <i class="fa fa-times"></i> Remove
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {$i=$i+1}	

                        {else}	   
                            {$id=$v.id}                        
                            <tr>
                                <td>
                                    {$user_name = $v.user_name}
                                    <a id="usernam{$id}" class="btn btn-xs btn-link panel-config" data-toggle="modal" href="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" data-toggle="modal" style='color: #007AFF;'><b>{$user_name}</b></a>
                                </td>
                                <td>
                                    <a id="sbjct{$id}" class="btn btn-xs btn-link panel-config" data-toggle="modal" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" style='color:#007AFF;'> <b>{$v.mailadsubject}</b></a>
                                </td>
                                <td>                        
                                    <a id="addate{$id}" class="btn btn-xs btn-link panel-config" data-toggle="modal" href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" style='color: #007AFF;'> <b>{$v.mailadiddate}</b></a>
                                </td>
                                <td class="center">
                                    {$msg_id=$v.id}
                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                        <a href="#" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
                                    </div>
                                    <div class="visible-xs visible-sm hidden-md hidden-lg">
                                        <div class="btn-group">
                                            <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                <i class="fa fa-cog"></i> <span class="caret"></span>
                                            </a>
                                            <ul role="menu" class="dropdown-menu pull-right">
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" href="#" onclick="javascript:deleteMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'admin', '{$BASE_URL}admin')">
                                                        <i class="fa fa-times"></i> Remove
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {$i=$i+1}
                        {/if}

                    {/foreach}
                {else}
                <tbody><tr><td align="center" colspan="4"><b>{lang('You_have_no_mails_in_inbox')}</b></td></tr></tbody>
            {/if}
            </tbody>
        </table>
        {$result_per_page}
    </div>
</div>
