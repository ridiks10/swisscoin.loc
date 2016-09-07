{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_select_an_amount')}</span> 
    <span id="error_msg1">{lang('you_must_enter_count')}</span>
    <span id="error_msg2">{lang('you_must_select_a_product_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_your_product_amount')}</span>
    <span id="error_msg4">{lang('please_enter_any_keyword_like_pin_number_or_pin_id')}</span>
    <span id ="error_msg6">{lang('you_must_select_a_date')}</span>
    <span id ="error_msg7">{lang('past_expiry_date')}</span>
    <span id="validate_msg">{lang('enter_digits_only')}</span>
    <span id="validate_msg1">{lang('digits_only')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$LANG['PATH_TO_ROOT_DOMAIN']}">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>

</div>

<div class="row">
    <div class="col-sm-12">
        <div class="tabbable ">
            <ul id="myTab3" class="nav nav-tabs tab-green">
                <li class="{$tab1}">
                    <a href="#panel_tab4_example1" data-toggle="tab">
                        <i class="pink fa fa-dashboard"></i> {lang('add_new_epin')}
                    </a>
                </li>
                <li class="{$tab2}">
                    <a href="#panel_tab4_example2" data-toggle="tab">
                        <i class="blue fa fa-user"></i>{lang('search_epin')}
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                    <p>
                        {include file="admin/epin/generate_epin.tpl"  name=""}
                    </p>
                </div>

                <div class="tab-pane{$tab2}" id="panel_tab4_example2">
                    <p>
                        {include file="admin/epin/search_epin.tpl"  name=""}
                    </p>
                </div>

            </div> 
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        DatePicker.init();
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
