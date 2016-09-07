<div id="span_js_messages" style="display: none;">
    <span id="error_msg4">{$LANG['please_enter_any_keyword_like_pin_number_or_pin_id']}</span>
    <span id="row_msg">{$LANG['rows']}</span>
    <span id="show_msg">{$LANG['shows']}</span>
</div>   
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('search_pin_numbers')}
    </div> 
    <div class="panel-body">
        {form_open_multipart('','role="form" class="smart-wizard form-horizontal" id="search_epin" name="search_epin"')}
        <div class="col-md-12">
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> {lang('errors_check')}
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-2 control-label" for="keyword">{lang('search_pin')}<font color="#ff0000">*</font>:</label>
            <div class="col-sm-3">
                <input tabindex="1" type="text" name="keyword" id="keyword" size="20" value=""  onKeyUp="ajax_showOptions(this, 'getCountriesByLetters', 'no', event, 'epin')"  
                       title="" autocomplete="off"/>
                <span class="val-error">{form_error('keyword')}</span>
            </div>

        </div> 

        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <button class="btn btn-bricky" name="search_pin" id="search_pin" value="{lang('search_pin_numbers')}" tabindex="2">
                    {lang('search_pin_numbers')}
                </button>
            </div>
        </div>
        <br />            
        {form_close()}
    </div>
</div>

{if $search_pin_flag}
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i>{lang('epins')}
        </div> 
        <div class="panel-body">
            {assign var="i" value=1}
            {assign var="j" value=0}
            <table class="table table-striped table-bordered table-hover table-full-width" id="">

                <thead>
                    <tr class="th" align="center">
                        <th>{lang('no')}</th>
                        <th>{lang('epin')}</th>
                        <th>{lang('amount')}</th>
                        <th>{lang('pin_balance_amount')}
                        <th>{lang('status')}
                        <th>{lang('allocated_user')}</th>
                        <th>{lang('uploaded_date')}</th>
                        <th>{lang('expiry_date')}</th>
                    </tr>
                </thead>
                {if $search_pin_count}
                    <tbody>
                        {foreach from=$search_pin_details item=v}
                            <tr>
                                <td>{$i}</td>
                                <td>{$search_pin_details["detail$j"].pin_number} </td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{$search_pin_details["detail$j"].pin_amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT} </td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{$search_pin_details["detail$j"].pin_balance_amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT} </td>
                                <td>{if $search_pin_details["detail$j"].status=='yes'}{lang('active')}{else}{lang('inactive')}{/if} </td>
                                <td>{$search_pin_details["detail$j"].allocated_user_id} </td>
                                <td>{$search_pin_details["detail$j"].pin_uploaded_date} </td>
                                <td>{$search_pin_details["detail$j"].pin_expiry_date} </td>

                            </tr>
                        {/foreach}
                    </tbody>
                {else}
                    <tbody>
                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('your_account_have_no_active_epin')}</h4></td></tr>
                    </tbody>                            
                {/if}  
            </table>
        </div>
    </div>
{/if}

<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('search_pin_numbers')}
    </div> 
    <div class="panel-body">
        {form_open('','role="form" class="smart-wizard form-horizontal" id="search_pin_amount" name="search_pin_amount"  method="post"')}

        <div class="col-md-12">
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> {lang('errors_check')}
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="product">{lang('amount')}<font color="#ff0000">*</font>:</label>                    
            <div class="col-sm-3">
                <select name="amount" id="amount"  tabindex="3" class="form-control" >
                    <option value="">{lang('select_amount')}</option>
                    {assign var=i value=0}
                    {foreach from=$amount_details item=v}
                        <option value="{$v.amount}">{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</option>
                        {$i = $i+1}
                    {/foreach}
                </select> 
                <span class="val-error">{form_error('amount')}</span>
            </div>
        </div>               


        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-2">
                <button class="btn btn-bricky" name="search_pin_pro" id="search_pin_pro" value="upload" tabindex="4">
                    {lang('search_pin_numbers')}
                </button>
            </div>
        </div>        
        {form_close()}
    </div>
</div>

{if $search_pin_amount_flag}
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-external-link-square"></i>{lang('epins')}
        </div> 
        <div class="panel-body">
            {assign var="i" value=1}
            {assign var="j" value=0}
            <table class="table table-striped table-bordered table-hover table-full-width" id="">

                <thead>
                    <tr class="th" align="center">
                        <th>{lang('no')}</th>
                        <th>{lang('epin')}</th>                               
                        <th>{lang('amount')}</th>
                        <th>{lang('pin_balance_amount')}
                        <th>{lang('status')}
                        <th>{lang('allocated_user')}</th>
                        <th>{lang('uploaded_date')}</th>
                        <th>{lang('expiry_date')}</th>
                    </tr>
                </thead>
                {if $search_pin_count }
                    <tbody>
                        {foreach from=$search_pin_details item=v}

                            <tr>
                                <td>{$i}</td>
                                <td>{$search_pin_details["detail$j"].pin_number} </td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{$search_pin_details["detail$j"].pin_amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT} </td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{$search_pin_details["detail$j"].pin_balance_amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT} </td>
                                <td>{if $search_pin_details["detail$j"].status=='yes'}{lang('active')} {else}{lang('inactive')}{/if} </td>
                                <td>{if !($search_pin_details["detail$j"].allocated_user_id)}NA{else} {$search_pin_details["detail$j"].allocated_user_id}{/if}</td>
                                <td>{$search_pin_details["detail$j"].pin_uploaded_date} </td>
                                <td>{$search_pin_details["detail$j"].pin_expiry_date} </td>
                                {$j=$j+1}
                                {$i=$i+1}
                            </tr>
                        {/foreach}
                    </tbody>
                {else}
                    <tbody>
                        <tr><td colspan="8" align="center"><h4 align="center"> {lang('your_account_have_no_active_epin')}</h4></td></tr>
                    </tbody>                            
                {/if} 
            </table>         
        </div>
    </div>
{/if}