{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg">{lang('you_must_enter_e_pin_length')}</span>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>   {lang('e_pin_configuration')}
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
                {form_open('','role="form" class="smart-wizard form-horizontal" name="pin_config_form" id="pin_config_form"')}

                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>


                {if $MODULE_STATUS['product_status']=='no'}
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="pin_value">{lang('value_of_e_pin')}:</label>
                        <div class="col-sm-6">
                            <input  type="text"  name="pin_value" id="pin_value" value="{$pin_config["pin_amount"]}" title="Purchase value of one E-Pin" autocomplete="Off" >
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>
                {/if}

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pin_maxcount">{lang('maximun_active_e_pin')}:</label>
                    <div class="col-sm-6">
                        <input  type="text"  name ="pin_maxcount" id ="pin_maxcount" value="{$pin_config["pin_maxcount"]}" maxlength="5"  title="{lang('the_maximum_no_of_active_e_pin_at_a_time')}." autocomplete="Off" tabindex="2" >
                        <span id="username_box" style="display:none;"></span>{form_error('pin_maxcount')}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pin_character">{lang('e_pin_character_set')}:{$pin_config["pin_character_set"]}</label>

                    <div class="col-sm-6">

                        <label class="radio-inline" for="pin_character"><input tabindex="3"   type="radio" name="pin_character" id="alphabet" value="alphabet" {if $pin_config["pin_character_set"] == "alphabet"}checked {/if}/>
                            {lang('alphabets')}</label>
                        <label class="radio-inline"  for="status_no"><input tabindex="3"  type="radio"  name="pin_character" id="numeral" value="numeral" {if $pin_config["pin_character_set"] == "numeral"} checked {/if} />
                            {lang('numerals')}  </label> 
                        <label class="radio-inline"  for="status_no"><input tabindex="3"  type="radio" name="pin_character" id="alphanumeric" value="alphanumeric" {if $pin_config["pin_character_set"] == "alphanumeric"} checked {/if} />
                            {lang('alphanumerals')} </label> {form_error('pin_character')}

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" tabindex="4"   type="submit"  value="{lang('update')}" name="update" id="update" > {lang('update')}</button>                                
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">                    
               <i class="fa fa-external-link-square"></i> {lang('add_new_epin_amount')}
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
                {form_open('','id="epin_amount" name="epin_amount"')}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pin_amount">{lang('epin_amount')}:</label>
                    <div class="col-sm-3">
                        <input tabindex="11" type="text" name ="pin_amount"  id ="reg_amount" value="" title="" required="true" data-rule-number="true" ><span class="val-error">{form_error('pin_amount')}</span>
                        <span id="errmsg3"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3">
                        <button class="btn btn-bricky"  type="submit" value="add_amount" tabindex="12" name="add_amount" id="add_amount"  >{lang('add')}</button>
                    </div>
                    {* <button class="btn btn-bricky"  type="submit" value="delete_amount" tabindex="12" name="delete_amount" id="delete_amount"  >{$delete}</button>*}
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">                    
               <i class="fa fa-external-link-square"></i> {lang('epin')}
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
                {* {if $pin_amounts!=""}*}
                {if $count>0}
                    <table class="table table-striped table-bordered table-hover table-full-width" id="">
                        <thead>
                            <tr class="th" align="center">
                                <th>{lang('no')}</th>

                                <th>{lang('epin_amount')}</th>

                                <th width="40%">{lang('action')}</th>
                            </tr>
                        </thead>

                        <tbody>                       
                            {assign var="i" value=0}
                            {assign var="pin" value=""}
                            {assign var="tr_class" value=""}
                            {assign var="root" value="{$BASE_URL}admin/"}
                            {foreach from=$pin_amounts item=v}                        

                                {if $i%2 == 0}
                                    {$tr_class="tr1"}	 
                                {else}
                                    {$tr_class="tr2"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$tr_class}" align="center" >
                                    <td align="center">{$i}</td>
                                    <td align="center">{$v.amount}</td>
                                    <td align="center">
                                        {form_open('','method="post"')}
                                        <input type="hidden" value='{$v.id}' id="pin_id" name="pin_id">
                                        <button class="btn btn-bricky"  type="submit" value="delete_amount" tabindex="12" name="delete_amount" id="delete_amount"  >{lang('delete')}</button>
                                        {form_close()}
                                    </td></tr>

                            {/foreach}   
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('no_epin_found')}</h4></td></tr>
                        </tbody>                            
                    {/if}  
                </table>
                {*{else}
                <div align="center">{$LANG['no_epin_found']}</div>
                {/if}*}



            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateUser.init();
        // DateTimePicker.init();
        TableData.init();

    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  