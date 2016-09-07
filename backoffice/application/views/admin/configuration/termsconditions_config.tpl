<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('terms_and_conditions')}
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
                        {lang('terms_and_conditions')}:<font color="#ff0000">*</font>
                    </label>
                    <div class="col-sm-9">
                        <textarea id="txtDefaultHtmlArea1"  name="txtDefaultHtmlArea1" class="ckeditor form-control"  tabindex="2">
                            {$terms}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" tabindex="3"  name="content_submit" id="content_submit" type="submit" value="{lang('update')}" > {lang('update')}</button>

                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>