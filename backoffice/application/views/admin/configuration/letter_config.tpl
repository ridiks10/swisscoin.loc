<div class="row" class="hidden-xs" >
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>    {lang('welcome_letter')}
            </div>
            <div class="panel-body">
                {form_open_multipart('admin/configuration/letter_config','role="form" class="smart-wizard form-horizontal" name= "form_setting" id= "form_setting"')}
                    {if $LANG_STATUS=='yes'}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="lang_selector">
                                {lang('Select_a_Language')}:
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
                        <label class="col-sm-2 control-label" for="company_name">
                            {lang('company_name')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" name ="company_name" id ="company_name" value="{$letter_arr["company_name"]}" title="Eg: IOSS LLP" tabindex="2" />{form_error('company_name')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="company_add">
                            {lang('company_address')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-6">
                            <textarea name ="company_add"  id ="company_add" class="form-control"  rows="10" cols="25"  title="{lang('from_address')}" tabindex="3">{$letter_arr["address_of_company"]}</textarea>{form_error('company_add')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="txtDefaultHtmlArea">
                            {lang('main_matter')}:
                        </label>
                        <div class="col-sm-9">
                            <textarea class="ckeditor form-control"  id="txtDefaultHtmlArea"  name="txtDefaultHtmlArea" title="{lang('main_matter')}" tabindex="4">{$letter_arr["main_matter"]}</textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="product_matter">
                            {lang('matter_for_product_release')}:
                        </label>
                        <div class="col-sm-9">
                            <textarea name ="product_matter" tabindex="6" id ="product_matter" class="ckeditor form-control"  title="{lang('replay_message_for_welcome_letter')}">{$letter_arr["productmatter"]}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="product_matter">
                            {lang('place')}:<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" tabindex="7" name ="place" id ="place" value="{$letter_arr["place"]}" title="Eg: CALICUT">{form_error('place')}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="8"  name="setting" id="setting" type="submit" value="{lang('update')}" > {lang('update')}</button>

                        </div>
                    </div>
                    {form_close()}
            </div>
        </div>
    </div>
</div>