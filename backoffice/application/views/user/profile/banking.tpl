{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('please_enter_bankname')}</span> 
    <span id="error_msg2">{lang('please_enter_branch_name')}</span>        
    <span id="error_msg3">{lang('please_enter_ifsc')}</span>  
    <span id="error_msg4">{lang('please_enter_acc_no')}</span>
    <span id="error_msg5">{lang('special_chars_not_allowed')}</span>
    <span id="error_msg6">{lang('digits_only')}</span>

</div>      

<style>
    .val-error {
        color:rgba(249, 6, 6, 1);
        {*		    transition-delay:0s;*}
        opacity:1;
    }
</style>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
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
                {lang('my_banking')}
            </div>
            <div class="panel-body">
                <div class="form-group col-sm-8">
                    <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}user" >
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    <input type="hidden" id="path_root" name="path_root" value="{$BASE_URL}">
                    <label class="col-sm-4 control-label lable-grey">
                        {lang('action_selection')}
                    </label>
                    <div class="col-sm-6">
                        {form_open('', 'method="post"')}
                            <select name="action" id="action"   class="form-control " onchange="ChooseOption()" >
                                <option value="">{lang('select_one_option')}</option>
                                <option value="payout_request">{lang('payout_request')}</option>
                                <option value="fund_transfer">{lang('fund_transfer')}</option>

                            </select>
                        {form_close()}
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
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
                {lang('my_banking')}
            </div>
            <div class="panel-body">

                {form_open('', 'role="form" class="smart-wizard form-horizontal" id="banking_form" name="banking_form"  method="post"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                        </div>
                    </div>
                    <div class="form-group col-sm-8">
                        <label class="col-sm-4 control-label lable-grey">
                            {lang('bank_name')}  
                        </label>
                        <div class="col-sm-6">
                            <input  class="form-control" name="bank" id="bank" type="text" tabindex='1' size="8"  placeholder="" value="{$banking_details['user_detail_nbank']}" />
                            {if isset($error['bank'])}<span class='val-error' >{$error['bank']} </span>{/if}
                        </div>
                    </div>



                    <div class="form-group col-sm-8">

                        <label class="col-sm-4 control-label lable-grey">
                            {lang('branch_name')}  
                        </label>

                        <div class="col-sm-6">
                            <input  class="form-control" name="branch" id="branch" type="text" tabindex='2' size="8" placeholder="" value="{$banking_details['user_detail_nbranch']}" />
                            {if isset($error['branch'])}<span class='val-error' >{$error['branch']} </span>{/if}

                        </div> 


                    </div>


                    <div class="form-group col-sm-8">
                        <label class="col-sm-4 control-label lable-grey">
                            {lang('ifsc_code')}  
                        </label>
                        <div class="col-sm-6">
                            <input  class="form-control" name="ifsc" id="ifsc" type="text" tabindex='3' size="10"  placeholder="" value="{$banking_details['user_detail_ifsc']}" />
                            {if isset($error['ifsc'])}<span class='val-error' >{$error['ifsc']} </span>{/if}
                        </div>
                    </div>

                    <div class="form-group col-sm-8">
                        <label class="col-sm-4 control-label lable-grey">
                            {lang('bank_account_number')}  
                        </label>
                        <div class="col-sm-6">
                            <input  class="form-control" name="acc_no" id="acc_no" type="text" tabindex='4' size="20"  placeholder="" value="{$banking_details['user_detail_acnumber']}" />
                            {if isset($error['acc_no'])}<span class='val-error' >{$error['acc_no']} </span>{/if}
                        </div>
                    </div>
                    <div class="form-group col-sm-8">
                        <div class="col-sm-8 col-sm-offset-4">


                            <button class="btn btn-bricky" type="submit" name="save"  id="save" value="{lang('save')}" tabindex="5">{{lang('save')}}</button>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

<script>
    jQuery(document).ready(function() {
        Main.init();
        ValidateBanking.init();
    });
</script>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
