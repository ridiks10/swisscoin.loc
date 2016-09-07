{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_company_name')}</span>
    <span id="validate_msg2">{lang('you_must_company_address')}</span>
    <span id="validate_msg3">{lang('you_must_enter_main_matter')}</span>
    <span id="validate_msg4">{lang('you_must_enter_product_matter')}</span>
    <span id="validate_msg5">{lang('you_must_enter_place')}</span>   
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            {form_open_multipart('admin/configuration/content_management','role="form" class="smart-wizard form-horizontal" name= "form_setting"  id="form_setting"')}
            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                </div>
            </div>
            <div class="tabbable">

                <ul class="nav nav-tabs tab-green">
                    <li class="{$tab1}">
                        <a href="#panel_tab3_example1" data-toggle="tab">{lang('welcome_letter')}</a>
                    </li>
                    <li class="{$tab2}">
                        <a href="#panel_tab3_example2" data-toggle="tab">{lang('terms_and_conditions')}</a>
                    </li>
                    <li class="{$tab3}">
                        <a href="#panel_tab3_example3" data-toggle="tab">{lang('info_box_setting')}</a>
                    </li>
                    <li class="{$tab4}">
                        <a href="#panel_tab3_example4" data-toggle="tab">{lang('confirm_order_info_box')}</a>
                    </li>
                    <li class="{$tab5}">
                        <a href="#panel_tab4_example5" data-toggle="tab">{lang('edit_impressum')}</a>
                    </li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane in {$tab1}" id="panel_tab3_example1">
                        {include file="admin/configuration/letter_config.tpl"  name=""}
                    </div>
                    <div class="tab-pane {$tab2}" id="panel_tab3_example2">
                        {include file="admin/configuration/termsconditions_config.tpl"  name=""}
                    </div>
                    <div class="tab-pane {$tab3}" id="panel_tab3_example3">
                        {include file="admin/configuration/infobox_config.tpl"  name=""}
                    </div>
                    <div class="tab-pane {$tab4}" id="panel_tab3_example4">
                        {include file="admin/configuration/infobox_confirm_order.tpl"  name=""}
                    </div>
                    <div class="tab-pane {$tab5}" id="panel_tab4_example5">
                        {include file="admin/configuration/edit_impressum.tpl"  name=""}
                    </div>

                </div> 
            </div> 
            {form_close()}
        </div> 
    </div> 
</div> 
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        //ValidateContentManagement.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}