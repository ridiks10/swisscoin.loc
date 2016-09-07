{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg">{lang('you_must_enter_e_pin_length')}</span>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="tabbable ">
                <ul class="nav nav-tabs tab-green">
                    <li class="{$tab1}">
                        <a href="#panel_tab1_example1" data-toggle="tab">{lang('registration_email')}</a>
                    </li>
                    <li class="{$tab2}">
                        <a href="#panel_tab2_example1" data-toggle="tab">{lang('payout_release_mail')}</a>
                    </li>
                    {*<li class="{$tab3}">
                    <a href="#panel_tab3_example1" data-toggle="tab">{lang('forgot_password_mail')}</a>
                    </li>*}


                </ul>

                <div class="tab-content">
                    <div class="tab-pane {$tab1}" id="panel_tab1_example1">
                        {include file="admin/configuration/registration_mail.tpl"  name=""}
                    </div>
                    <div class="tab-pane {$tab2}" id="panel_tab2_example1">
                        {include file="admin/configuration/payout_release_mail.tpl"  name=""}
                    </div>
                </div> 
            </div> 
        </div>
    </div>
</div>


{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
<script>
    jQuery(document).ready(function() {
        Main.init();
        //ValidateUser.init();
        // TableData.init();


    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  