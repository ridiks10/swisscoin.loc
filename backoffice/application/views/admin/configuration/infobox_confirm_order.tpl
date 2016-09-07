<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('confirm_order_info_box')}
            </div>
            <div class="panel-body">     
                {form_open_multipart('admin/configuration/content_management','role="form" class="smart-wizard form-horizontal" name= "form_setting" id= "form_setting"')}
                {if $LANG_STATUS=='yes'}
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="lang_selector">
                            {lang('Select_a_Language')} 
                        </label>
                        <div class="col-sm-6">
                            <select  class="form-control"  id='lang_selector' onchange="set_language_id(this.value, 'letter');" tabindex="1">
                                {foreach from=$lang_arr item=v}
                                    {if $lang_id==$v.lang_id}
                                        <option value="{$v.lang_id}" selected="">{$v.lang_name}</option>
                                    {else}
                                        <option value="{$v.lang_id}">{$v.lang_name}</option>
                                    {/if}
                                {/foreach}
                            </select>{form_error('lang_selector')}
                            <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}"/>
                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}"/>
                        </div>
                    </div>
                {/if}
                {if $LANG_STATUS=='no'}
                    <input type="hidden" name="lang_id" id="lang_id" value="1"/>
                {/if}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea1">
                        Payza:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea1"  name="txtDefaultHtmlArea1" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_payza}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea2">
                        Payeer:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea2"  name="txtDefaultHtmlArea2" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_payeer}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea3">
                       Sepa:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea3"  name="txtDefaultHtmlArea3" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_sepa}
                        </textarea>
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea4">
                       Swift:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea4"  name="txtDefaultHtmlArea4" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_swift}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea5">
                       Bitcoin:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea5"  name="txtDefaultHtmlArea5" class="ckeditor form-control"  tabindex="2">
                            {$info_box_bitcoin}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea6">
                       E-Wallet:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea6"  name="txtDefaultHtmlArea6" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_e_wallet}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea7">
                       Cash Account:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea7"  name="txtDefaultHtmlArea7" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_cash_acc}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="txtDefaultHtmlArea8">
                       Trading Account:
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea8"  name="txtDefaultHtmlArea8" class="ckeditor form-control"  tabindex="2">
                            {$info_box_con_trade_acc}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" name="info_con_submit" id="info_con_submit" type="submit" value="{lang('update')}" > {lang('update')}</button>

                    </div>
                </div>
                {form_close()}
            </div>
        </div>
</div>