{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
    <span id="row_msg">rows</span>
    <span id="show_msg">shows</span>
</div>
{if isset($details)}

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i> {$details['0']['username']}
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

                    {form_open('', 'name="verify_registration1" id="verify_registration1" method="post"')}

                    <table class="table table-striped table-bordered table-hover table-full-width" id="">

                        <tr class="tr2"  >
                            <th width="35%">Document</th>
                            <th width="35%">Details</th>
                            <th width="30%">Status</th>
                        </tr>
                        <tr class="tr2" >
                            <td> ID/PASSPORT</td>
                            <td>
                                {if $details['0']['passport_proof'] != ''}
                                    <a href="{$PUBLIC_URL}images/kyc/{$details['0']['passport_proof']}" target="_blank"> View Document</a>    
                                {else}
                                    Documents Not Submitted
                                {/if}
                            </td>
                            <td>
                                {if $details['0']['passport_status'] == 'not_submitted'}
                                    <font color="yellow">Documents Not Submitted</font>
                                {elseif $details['0']['passport_status'] == 'verified'}
                                    <font color="green">Verified</font>
                                {elseif $details['0']['passport_status'] == 'reject'}
                                    <font color="red">Rejected</font>
                                {elseif $details['0']['passport_status'] == 'submit'}
                                    <font color="blue">Pending for Verification</font>
                                    <input type="checkbox" name="passport" id="passport" class="verify"/>
                                {/if}
                            </td>
                        </tr>
                        <tr class="tr2" >
                            <td> PROOF OF ADDRESS</td>
                            <td>
                                {if $details['0']['address_proof'] != ''}
                                    <a href="{$PUBLIC_URL}images/kyc/{$details['0']['address_proof']}" target="_blank"> View Document</a>

                                {else}
                                    Documents Not Submitted
                                {/if}
                            </td>
                            <td>
                                {if $details['0']['address_status'] == 'not_submitted'}
                                    <font color="yellow">Documents Not Submitted</font>
                                {elseif $details['0']['address_status'] == 'verified'}
                                    <font color="green">Verified</font>
                                {elseif $details['0']['address_status'] == 'reject'}
                                    <font color="red">Rejected</font>
                                {elseif $details['0']['address_status'] == 'submit'}
                                    <font color="blue">Pending for Verification</font>
                                    <input type="checkbox" name="address" id="address" class="verify"/>
                                {/if}
                            </td>
                        </tr>

                    </table>


                    {if $details['0']['address_status'] == 'verified' && $details['0']['passport_status'] == 'verified'}
                    
                    {else}
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-4">
                                <button class="btn btn-bricky" tabindex="1" name="confirm_doc" id="confirm_doc" type="submit" value="{$details['0']['id']}"> {lang('accept')} </button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-bricky" tabindex="1" name="reject_doc" id="reject_doc" type="submit" value="{$details['0']['id']}"> {lang('reject')} </button>
                            </div>                        
                        </div>
                    {/if}
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4"><span id="err_message" style="color:red"></span></div>
                    </div>

                    {form_close()}
                </div>
            </div>
        </div>
    </div>

{/if}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>  {lang('verify_bankdata')}
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
                <div id="transaction" type="hidden">
                    <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div id="div1"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{lang('close')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {form_open('', 'name="verify_registration" id="verify_registration" method="post"')}
                {if count($res)>0}

                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                            <tr class="th" align="center">

                                <th width="10%">{lang('no')}</th>
                                <th width="60%">{lang('user_name')}</th>
                                <th width="30%">View Details</th>
                            </tr>
                        </thead>
                        {assign var="i" value=0}
                        {assign var="class" value=""}

                        <tbody>
                            {foreach from=$res item="v"}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$class}"  >
                                    <td align="center">{$i}</td>
                                    <td >{$v.username}</td>
                                    <td align="center"> 
                                        <div class="form-group">
                                            <div class="col-sm-1 col-sm-offset-5">
                                                <button class="btn btn-blue"tabindex="1" name="confirm" id="confirm" type="submit" value="{$v.user_id}"> View  </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            {/foreach}                
                        </tbody>    
                    </table>

                {else}
                    <h4 align="center">There is no details found</h4>          
                {/if} 
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function () {
        Main.init();
        TableData.init();

        $("#verify_registration1").submit(function (event) {
            if ($('#verify_registration1 input:checked').length <= 0) {
                $('#err_message').text('Please check checkbox.');
                event.preventDefault();
            }
        });
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}