<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('registration_email')}
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" name="mai_settings" id="mail_settings"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> 
                    </div>
                </div>

                <div class="form-group"> 
                    <label class="col-sm-2 control-label" >{lang('mail_status')} :<span class="symbol required"></span></label>
                    <div class="col-sm-3">
                        <select name="mail_status" id="mail_status">
                            <option value="yes" {if $reg_mail['mail_status']=='yes'}selected{/if}>{lang('yes')}</option>
                            <option value="no" {if $reg_mail['mail_status']=='no'}selected{/if}>{lang('no')}</option>
                        </select>
                    </div>
                </div>

            {if $LANG_STATUS=='yes'}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="lang_selector">
                        {lang('Select_a_Language')}:
                    </label>
                    <div class="col-sm-6">
                        <select  class="form-control"  id='lang_selector' onchange="set_language_id(this.value, 'email');" tabindex="1">
                            {foreach from=$lang_arr item=v}
                                {if $lang_id==$v.lang_id}
                                    <option value="{$v.lang_id}" selected="">{$v.lang_name}</option>
                                {else}
                                    <option value="{$v.lang_id}">{$v.lang_name}</option>
                                {/if}
                            {/foreach}
                        </select>
                        <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}"/>
                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}"/>
                    </div>
                </div>
            {/if}
            {if $LANG_STATUS=='no'}
                <input type="hidden" name="lang_id" id="lang_id" value="1"/>
            {/if}

                        
                        
                <div class="form-group"> 
                    <label class="col-sm-2 control-label" >{lang('subject')} :<span class="symbol required"></span></label>
                    <div class="col-sm-9">
                        <input class="form-control"  type="text"  name ="subject" id ="subject" value="{$reg_mail['subject']}"  maxlength="" autocomplete="Off" tabindex="2">
                        <span>{form_error('subject')}</span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label" for="mail_content">
                        {lang('mail_content')}:<span class="symbol required"></span>
                    </label>
                    <div class="col-sm-9">
                        <textarea id="mail_content"  name="mail_content" class="tinymce form-control" rows='10' tabindex="3">
                            {$reg_mail['content']}
                        </textarea>
                        <span>{form_error('mail_content')}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                    </label>
                    <div class="col-sm-9">
                        <label> <span class="symbol required"></span>{lang('mail_msg')}</label> 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                    </label>
                    <div class="col-sm-9">
                        <label>{lang('other_variables_that_you_can_use')}:</label>
                        <ul style="list-style: none; font-weight: bold;">
                           {* <li>{literal}{fullname}{/literal}</li>*}
                            <li>{literal}{username}{/literal}</li>
                            <li>{literal}{company_name}{/literal}</li>
                            <li>{literal}{company_address}{/literal}</li>
                            <li>{literal}{sponsor_username}{/literal}</li>
                           {* <li>{literal}{payment_type}{/literal}</li>*}
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" tabindex="3"   type="submit"  value="Update" name="reg_update" id="reg_update" >{lang('update')}</button>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>