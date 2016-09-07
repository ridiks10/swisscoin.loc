<?php
/**
 * FIXME: need to update this. the best solution will be to move this ...code to action itself
 */
class url_scripts_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function getURLScripts($url_id) {
        $script_arr = array();
        if ($url_id == 1) {
            $script_arr[0]['name'] = "validate_forgot_reset.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 2) {
            $script_arr[0]['name'] = "tabs.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "cookie-based-jquery-tabs.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "jquery.cookie.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_login.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 3) {
            $script_arr[0]['name'] = "validate_employee_login.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "login_employee.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 5) {
            $script_arr[0]['name'] = "validate_reset_pass.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 6) {
            $script_arr[0]['name'] = "validate_email.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 7) {
            $script_arr[0]['name'] = "tooltip/standalone.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "tooltip/tooltip-generic.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "flot/jquery.flot.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "flot/jquery.flot.pie.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "live_ticker.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 8) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "tabs_pages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 9) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jQuery-Smart-Wizard/js/jquery.smartWizard.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "ckeditor/ckeditor.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "ckeditor/contents.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "configuration.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "validate_configuration.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 10) {
            $script_arr[0]['name'] = "validate_mail_settings.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "jseditor/getfilename.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "jseditor/editor.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "editor/text_area_toolbar.css";
            $script_arr[3]['type'] = "css";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "editor/jHtmlArea.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "jseditor/jHtmlArea.ColorPickerMenu-0.7.0.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "editor/jHtmlArea.ColorPickerMenu.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "jseditor/HtmlArea-0.7.0.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "jseditor/jHtmlArea-0.7.0.min.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "ckeditor/ckeditor.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "ckeditor/contents.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "validate_mail.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 11) {
            $script_arr[0]['name'] = "autoComplete.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "select2/select2.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "select2/select2.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "table-data.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "ajax-dynamic-list.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "user_summary_header.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 12) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 13) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "table-data.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ajax-dynamic-list.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_feed.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "select2/select2.min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "select2/select2.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "misc.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "ajax.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "autoComplete.css";
            $script_arr[11]['type'] = "css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "messages.css";
            $script_arr[12]['type'] = "css";
            $script_arr[12]['loc'] = "header";
        }

        if ($url_id == 14) {
            $script_arr[0]['name'] = "messages.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "select2/select2.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "validate_rank_configuration.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 15) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 16) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_configurate.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 17) {
            $script_arr[0]['name'] = "jquery-ui.min.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_mail_settings.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 18) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 19) {
//            $script_arr[0]['name'] = "validate_register.js";
//            $script_arr[0]['type'] = "js";
//            $script_arr[0]['loc'] = "footer";
            $script_arr[0]['name'] = "state.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "calendar-win2k-cold-1.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "register_link.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jscalendar/calendar.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jscalendar/calendar-setup.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "jscalendar/lang/calendar-en.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "style-popup.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "validate_new_register.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
//            $script_arr[8]['name'] = "profile_update.js";
//            $script_arr[8]['type'] = "js";
//            $script_arr[8]['loc'] = "footer";
            $script_arr[8]['name'] = "form-wizard.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 20) {
            $script_arr[0]['name'] = "validate_register_board.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "register.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "register_link.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "register_without_pin.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "register_board_link_without_pin.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "state.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "calendar-win2k-cold-1.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "jscalendar/calendar.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "jscalendar/calendar-setup.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "jscalendar/lang/calendar-en.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "custom.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "style-popup.css";
            $script_arr[11]['type'] = "css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "profile_update.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "form-wizard.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 21) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_change_username.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 22) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "stateprof.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_profile_user.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "profile_update.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "user_summary_header.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]["name"] = "select2/select2.css";
            $script_arr[12]["type"] = "plugins/css";
            $script_arr[12]["loc"] = "header";
            $script_arr[13]["name"] = "datepicker/css/datepicker.css";
            $script_arr[13]["type"] = "plugins/css";
            $script_arr[13]["loc"] = "header";
            $script_arr[14]['name'] = "date_time_picker.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 23) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 24) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_change_password.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 25) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "select2/select2.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "select2/select2.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "table-data.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 26) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "style.css";
            $script_arr[3]['type'] = "css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "select2/select2.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "jquery-ui.min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "datepicker/css/datepicker.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "Epinvalidation.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 27) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "misc.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "select2/select2.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "select2/select2.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "table-data.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "tabs_pages.css";
            $script_arr[11]['type'] = "css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "validate_epin.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "date_time_picker.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "datepicker/css/datepicker.css";
            $script_arr[14]['type'] = "plugins/css";
            $script_arr[14]['loc'] = "header";
            $script_arr[15]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[15]['type'] = "plugins/css";
            $script_arr[15]['loc'] = "header";
            $script_arr[16]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[16]['type'] = "plugins/js";
            $script_arr[16]['loc'] = "footer";
            $script_arr[17]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[17]['type'] = "plugins/js";
            $script_arr[17]['loc'] = "footer";
        }

        if ($url_id == 28) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "select2/select2.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "table-data.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 29) {
            $script_arr[0]['name'] = "validation_pin_request.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 30) {
            $script_arr[0]['name'] = "select2/select2.css";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "tabs_pages.css";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "jquery-ui.min.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_epin.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 31) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "datepicker/css/datepicker.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "select2/select2.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "select2/select2.min.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "table-data.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "Epinvalidation.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 32) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_ewallet_fund.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ewallet.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 33) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_fund_management.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 34) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_ewallet_fund.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 35) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "user_summary_header.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "datepicker/css/datepicker.css";
            $script_arr[10]['type'] = "plugins/css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "date_time_picker.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 36) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "datepicker/css/datepicker.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "date_time_picker.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "validate_ewallet_mytransfer.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "select2/select2.css";
            $script_arr[10]['type'] = "plugins/css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "select2/select2.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 37) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "select2/select2.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "table-data.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "tabs_pages.css";
            $script_arr[11]['type'] = "css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "jquery-ui.min.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "validate_product.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 38) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "select2/select2.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "select2/select2.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "table-data.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "user_summary_header.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 39) {
            $script_arr[0]['name'] = "select2/select2.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_payout_release.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "MailBox.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 40) {
            $script_arr[0]['name'] = "validate_payout_release.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 41) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list_employee.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "validate_employee_password.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "autoComplete.css";
            $script_arr[3]['type'] = "css";
            $script_arr[3]['loc'] = "header";
        }

        if ($url_id == 42) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "style.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "datepicker/css/datepicker.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "date_time_picker.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "employee_register.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 43) {
            $script_arr[0]['name'] = "validate_employee_search.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "select2/select2.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "table-data.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 44) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list_employee.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_employee.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 45) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_admin_profile.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 46) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "datepicker/css/datepicker.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_joining.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 47) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 49) {
            $script_arr[0]['name'] = "datepicker/css/datepicker.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "date_time_picker.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_sales.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 50) {
            $script_arr[0]['name'] = "datepicker/css/datepicker.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "date_time_picker.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "validate_sales.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 51) {
            $script_arr[0]['name'] = "validate_joining.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "datepicker/css/datepicker.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 52) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "datepicker/css/datepicker.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_payoutt.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 53) {
            $script_arr[0]['name'] = "validate_mail.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "MailBox.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "custom.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "style-popup.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "validate_mail_management.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap3-wysihtml5.min.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "blue.css";
            $script_arr[9]['type'] = "css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "mail_box.css";
            $script_arr[10]['type'] = "css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "bootstrap3-wysihtml5.all.min.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "icheck.min.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "header";
        }

        if ($url_id == 54) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "tabs_pages.css";
            $script_arr[4]['type'] = "CSS";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "jquery-ui.min.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_sms.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "send_sms.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "jquery.wordcount.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 55) {
            $script_arr[0]['name'] = "validate_sms.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 56) {
            $script_arr[0]['name'] = "select2/select2.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "ajax.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "ajax-dynamic-list.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "autoComplete.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "user_summary_header.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
        }

        if ($url_id == 57) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "style.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "style_pop_up.css";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "top_up-min.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "tabs_pages.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "jquery-ui.min.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "select2/select2.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[10]['type'] = "plugins/css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "select2/select2.min.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[13]['type'] = "plugins/js";
            $script_arr[13]['loc'] = "header";
            $script_arr[14]['name'] = "table-data.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "header";
            $script_arr[15]['name'] = "validate_select_user.js";
            $script_arr[15]['type'] = "js";
            $script_arr[15]['loc'] = "footer";
        }

        if ($url_id == 58) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "style_tree.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "easyTooltip.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "tree/zoom.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 59) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui/jquery-ui-1.10.1.custom.min.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "dynatree/src/skin-vista/ui.dynatree.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "jquery-ui/jquery-ui-1.10.1.custom.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "dynatree/src/jquery.dynatree.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_select_user.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
        }

        if ($url_id == 61) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "style_tree.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "easyTooltip.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "tree/zoom.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 62) {
            $script_arr[0]['name'] = "date_time_picker.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_feed.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "select2/select2.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "datepicker/css/datepicker.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[10]['type'] = "plugins/css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "footer";
        }

        if ($url_id == 63) {
            $script_arr[0]['name'] = "validate_income.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "select2/select2.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "table-data.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "ajax.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "ajax-dynamic-list.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "autoComplete.css";
            $script_arr[9]['type'] = "css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "user_summary_header.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 64) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ckeditor/ckeditor.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ckeditor/contents.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "validate_news.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "MailBox.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
        }

        if ($url_id == 65) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "tabs_pages.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "jquery-ui.min.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_news.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "misc.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 66) {
            $script_arr[0]['name'] = "select2/select2.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "style-popup.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "misc.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 67) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "validate_change_passcode.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 68) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_reset_pass.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 69) {
            $script_arr[0]['name'] = "user_summary_header.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax-dynamic-list.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "table-data.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "select2/select2.css";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[6]['type'] = "css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "select2/select2.min.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "jquery-ui.min.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "misc.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "messages.css";
            $script_arr[12]['type'] = "css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "validate_epin.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 70) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 71) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "select2/select2.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "table-data.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "datepicker/css/datepicker.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "date_time_picker.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[12]['type'] = "plugins/css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[13]['type'] = "plugins/css";
            $script_arr[13]['loc'] = "header";
            $script_arr[14]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[14]['type'] = "plugins/js";
            $script_arr[14]['loc'] = "footer";
            $script_arr[15]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[15]['type'] = "plugins/js";
            $script_arr[15]['loc'] = "footer";
        }

        if ($url_id == 72) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 73) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "messages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "ajax.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "summernote/build/summernote.css";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "jquery-validation/dist/jquery.validate.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "jQuery-Smart-Wizard/js/jquery.smartWizard.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_banking.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 74) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 75) {
            $script_arr[0]['name'] = "edit_script.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_scripts.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "validate_pppp.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "test_js.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ghfdfh";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "sdfs.js";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 76) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jQuery-Smart-Wizard/js/jquery.smartWizard.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "ckeditor/ckeditor.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "ckeditor/contents.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "configuration.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "validate_configuration.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "select2/select2.css";
            $script_arr[10]['type'] = "plugins/css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "select2/select2.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[13]['type'] = "plugins/js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[14]['type'] = "plugins/js";
            $script_arr[14]['loc'] = "footer";
            $script_arr[15]['name'] = "table-data.js";
            $script_arr[15]['type'] = "js";
            $script_arr[15]['loc'] = "footer";
            $script_arr[16]['name'] = "validate_configurate.js";
            $script_arr[16]['type'] = "js";
            $script_arr[16]['loc'] = "footer";
            $script_arr[17]['name'] = "tinymce/js/tinymce/tinymce.min.js";
            $script_arr[17]['type'] = "plugins/js";
            $script_arr[17]['loc'] = "footer";
            $script_arr[18]['name'] = "tinymice.js";
            $script_arr[18]['type'] = "js";
            $script_arr[18]['loc'] = "footer";
        }

        if ($url_id == 77) {
            $script_arr[0]['name'] = "MailBox.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "custom.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "style-popup.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "misc.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "ajax.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "jquery.dataTables";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "tabs_pages.css";
            $script_arr[12]['type'] = "css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "jquery-ui.min.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 78) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
        }

        if ($url_id == 79) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
        }

        if ($url_id == 80) {
            $script_arr[0]['name'] = "validate_auto_responder.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "auto_responder.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "tinymce/js/tinymce/tinymce.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "tinymice.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "select2/select2.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
        }

        if ($url_id == 81) {
            $script_arr[0]['name'] = "validate_multy_currency.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "select2/select2.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
        }

        if ($url_id == 82) {
            $script_arr[0]['name'] = "validate_multy_currency.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 83) {
            $script_arr[0]['name'] = "jquery.simplemodal.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "contact.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.css";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "contact.css";
            $script_arr[9]['type'] = "css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "ajax-dynamic-list.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "autoComplete.css";
            $script_arr[11]['type'] = "css";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "ajax.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "user_summary_header.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
        }

        if ($url_id == 84) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "ajax-dynamic-list.js";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "autoComplete.css";
            $script_arr[3]['type'] = "css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "validate_mail.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "jseditor/getfilename.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "jseditor/editor.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "editor/text_area_toolbar.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "editor/jHtmlArea.css";
            $script_arr[8]['type'] = "css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "jseditor/HtmlArea-0.7.0.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "jseditor/jHtmlArea-0.7.0.min.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "ckeditor/ckeditor.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "ckeditor/contents.css";
            $script_arr[13]['type'] = "plugins/css";
            $script_arr[13]['loc'] = "header";
            $script_arr[14]['name'] = "validate_mail_management.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 85) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "autoComplete.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "ajax.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "MailBox.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "custom.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "style-popup.css";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
        }

        if ($url_id == 86) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_multy_language.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }
        if ($url_id == 87) {
            $script_arr[0]['name'] = "validate_ticket.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 88) {
            $script_arr[0]['name'] = "table-data.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "tabs_pages.css";
            $script_arr[3]['type'] = "css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "jquery.dataTables";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "ajax.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "select2/select2.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "select2/select2.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
        }

        if ($url_id == 89) {
            $script_arr[0]['name'] = "jquery-ui.min.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "tabs_pages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "jquery.dataTables";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "select2/select2.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "select2/select2.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "jquery-ui.min.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "jquery.dataTables";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "validate_invite.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "header";
            $script_arr[12]['name'] = "tinymce/js/tinymce/tinymce.min.js";
            $script_arr[12]['type'] = "plugins/js";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "tinymice.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "header";
            $script_arr[14]['name'] = "invites.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "header";
            $script_arr[15]['name'] = "ckeditor/ckeditor.js";
            $script_arr[15]['type'] = "plugins/js";
            $script_arr[15]['loc'] = "footer";
            $script_arr[16]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[16]['type'] = "plugins/js";
            $script_arr[16]['loc'] = "footer";
            $script_arr[17]['name'] = "ckeditor/contents.css";
            $script_arr[17]['type'] = "plugins/css";
            $script_arr[17]['loc'] = "header";
        }

        if ($url_id == 90) {
            $script_arr[0]['name'] = "select2/select2.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "table-data.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "select2/select2.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "tinymice.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "tinymce/js/tinymce/tinymce.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "validate_invite_config.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "ckeditor/ckeditor.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "ckeditor/contents.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
        }

        if ($url_id == 91) {
            $script_arr[0]['name'] = "validate_invite_config.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "tinymce/js/tinymce/tinymce.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "tinymice.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        }

        if ($url_id == 92) {
            $script_arr[0]['name'] = "validate_invite_wallpost.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ckeditor/ckeditor.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ckeditor/contents.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
        }

        if ($url_id == 93) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }

        if ($url_id == 94) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "tabs_pages.css";
            $script_arr[4]['type'] = "css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "jquery-ui.min.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }

        if ($url_id == 95) {
            $script_arr[0]['name'] = "MailBox.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 96) {
            $script_arr[0]['name'] = "ckeditor/ckeditor.js";
            $script_arr[0]['type'] = "plugins/js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_mail.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "MailBox.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        }
        if ($url_id == 97) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 99) {
            $script_arr[0]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "date_time_picker.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "datepicker/css/datepicker.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "autoComplete.css";
            $script_arr[5]['type'] = "css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "ajax-dynamic-list.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "ajax.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 100) {
            $script_arr[0]['name'] = "validate_multy_language.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "select2/select2.css";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 101) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_board_configuration.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 103) {
            $script_arr[0]['name'] = "ajax-dynamic-list.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_party.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "datepicker/css/datepicker.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "date_time_picker.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "state.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
        }

        if ($url_id == 104) {
            $script_arr[0]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[0]['type'] = "plugins/js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ajax-dynamic-list.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 105) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_party.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 106) {
            $script_arr[0]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }

        if ($url_id == 107) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "host.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "state.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "validate_party.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 108) {
            $script_arr[0]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 109) {
            $script_arr[0]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "ajax.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "ajax-dynamic-list.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "autoComplete.css";
            $script_arr[10]['type'] = "css";
            $script_arr[10]['loc'] = "header";
            $script_arr[11]['name'] = "select2/select2.css";
            $script_arr[11]['type'] = "plugins/css";
            $script_arr[11]['loc'] = "header";
        }

        if ($url_id == 110) {
            $script_arr[0]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 111) {
            $script_arr[0]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "table-data.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jquery-ui.min.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "host.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_create_host.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "validate_setup_party.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 112) {
            $script_arr[0]['name'] = "select2/select2.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "select2/select2.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "table-data.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "tabs_pages.css";
            $script_arr[7]['type'] = "css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "jquery-ui.min.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "host.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "validate_create_host.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "state.js";
            $script_arr[11]['type'] = "js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "misc.js";
            $script_arr[12]['type'] = "js";
            $script_arr[12]['loc'] = "footer";
            $script_arr[13]['name'] = "ajax-dynamic-list.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "ajax.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 113) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "host.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "state.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "validate_party.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }

        if ($url_id == 114) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "state.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ajax-dynamic-list.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ajax.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "select2/select2.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "select2/select2.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "table-data.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "tabs_pages.css";
            $script_arr[12]['type'] = "css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "jquery-ui.min.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "host.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 115) {
            $script_arr[0]['name'] = "validate_create_host.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "state.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "misc.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ajax-dynamic-list.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ajax.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "select2/select2.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
            $script_arr[6]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "select2/select2.min.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[8]['type'] = "plugins/js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[9]['type'] = "plugins/js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "table-data.js";
            $script_arr[10]['type'] = "js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "tabs_pages.css";
            $script_arr[12]['type'] = "css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "jquery-ui.min.js";
            $script_arr[13]['type'] = "js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "host.js";
            $script_arr[14]['type'] = "js";
            $script_arr[14]['loc'] = "footer";
        }

        if ($url_id == 116) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_activate_deactivate.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }

        if ($url_id == 117) {
            $script_arr[0]['name'] = "validate_depth.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 118) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 119) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_mail_management.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "validate_mail.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ckeditor/ckeditor.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "ckeditor/contents.css";
            $script_arr[5]['type'] = "plugins/css";
            $script_arr[5]['loc'] = "header";
        }

        if ($url_id == 120) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "tree/zoom.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 121) {
            $script_arr[0]['name'] = "validate_employee_login.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "login_employee.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "validate_configuration.js";
            $script_arr[2]['type'] = "js";
            $script_arr[2]['loc'] = "footer";
        }
        if ($url_id == 122) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 123) {

            $script_arr[0]['name'] = "validate_joining.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "datepicker/css/datepicker.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[2]['type'] = "plugins/css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "date_time_picker.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
        }
        if ($url_id == 124) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 125) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "datepicker/css/datepicker.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }

        if ($url_id == 126) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "tabs_pages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "footer";
        }
        if ($url_id == 130) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "validate_career.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
        }
        if ($url_id == 129) {
            $script_arr[0]['name'] = "news_letter.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 128) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "misc.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "ckeditor/ckeditor.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "ckeditor/contents.css";
            $script_arr[6]['type'] = "plugins/css";
            $script_arr[6]['loc'] = "header";
            $script_arr[7]['name'] = "MailBox.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[8]['type'] = "plugins/css";
            $script_arr[8]['loc'] = "header";
            $script_arr[9]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[9]['type'] = "plugins/css";
            $script_arr[9]['loc'] = "header";
            $script_arr[10]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[11]['type'] = "plugins/js";
            $script_arr[11]['loc'] = "footer";
            $script_arr[12]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[12]['type'] = "plugins/css";
            $script_arr[12]['loc'] = "header";
            $script_arr[13]['name'] = "select2/select2.min.js";
            $script_arr[13]['type'] = "plugins/js";
            $script_arr[13]['loc'] = "footer";
            $script_arr[14]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[14]['type'] = "plugins/js";
            $script_arr[14]['loc'] = "footer";
            $script_arr[15]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[15]['type'] = "plugins/js";
            $script_arr[15]['loc'] = "footer";
            $script_arr[16]['name'] = "table-data.js";
            $script_arr[16]['type'] = "js";
            $script_arr[16]['loc'] = "footer";
            $script_arr[17]['name'] = "select2/select2.css";
            $script_arr[17]['type'] = "plugins/css";
            $script_arr[17]['loc'] = "header";
        }
        if ($url_id == 131) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "purchase_shopping.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
//            $script_arr[4]['name'] = "profile_update.js";
//            $script_arr[4]['type'] = "js";
//            $script_arr[4]['loc'] = "header";
        }

        if ($url_id == 134) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[1]['type'] = "plugins/css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "jQuery-Smart-Wizard/js/jquery.smartWizard.js";
            $script_arr[4]['type'] = "plugins/js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "ckeditor/ckeditor.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "ckeditor/contents.css";
            $script_arr[7]['type'] = "plugins/css";
            $script_arr[7]['loc'] = "header";
            $script_arr[8]['name'] = "configuration.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
            $script_arr[9]['name'] = "validate_webinar.js";
            $script_arr[9]['type'] = "js";
            $script_arr[9]['loc'] = "footer";
            $script_arr[10]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[10]['type'] = "plugins/js";
            $script_arr[10]['loc'] = "footer";
            $script_arr[11]["name"] = "select2/select2.css";
            $script_arr[11]["type"] = "plugins/css";
            $script_arr[11]["loc"] = "header";

            $script_arr[12]["name"] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[12]["type"] = "plugins/css";
            $script_arr[12]["loc"] = "header";

            $script_arr[13]["name"] = "select2/select2.min.js";
            $script_arr[13]["type"] = "plugins/js";
            $script_arr[13]["loc"] = "footer";

            $script_arr[16]["name"] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[16]["type"] = "plugins/js";
            $script_arr[16]["loc"] = "footer";

            $script_arr[14]["name"] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[14]["type"] = "plugins/js";
            $script_arr[14]["loc"] = "footer";

            $script_arr[15]["name"] = "table-data.js";
            $script_arr[15]["type"] = "js";
            $script_arr[15]["loc"] = "footer";
            $script_arr[16]["name"] = "datepicker/css/datepicker.css";
            $script_arr[16]["type"] = "plugins/css";
            $script_arr[16]["loc"] = "header";
            $script_arr[17]['name'] = "date_time_picker.js";
            $script_arr[17]['type'] = "js";
            $script_arr[17]['loc'] = "footer";
        }
        if ($url_id == 136) {
            $script_arr[0]['name'] = "misc.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ckeditor/ckeditor.js";
            $script_arr[1]['type'] = "plugins/js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "ckeditor/adapters/jquery.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "ckeditor/contents.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "validate_news.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
            $script_arr[5]['name'] = "MailBox.js";
            $script_arr[5]['type'] = "js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "validate_webinar.js";
            $script_arr[6]['type'] = "js";
            $script_arr[6]['loc'] = "footer";
        }
        if ($url_id == 137) {
            $script_arr[0]['name'] = "tooltip/standalone.css";
            $script_arr[0]['type'] = "css";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "tooltip/tooltip-generic.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "flot/jquery.flot.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
            $script_arr[3]['name'] = "flot/jquery.flot.pie.js";
            $script_arr[3]['type'] = "plugins/js";
            $script_arr[3]['loc'] = "footer";
        }
        if ($url_id == 139) {
            $script_arr[0]['name'] = "validate_webinar.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 143) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "select2/select2.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "select2/select2.min.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[7]['type'] = "plugins/js";
            $script_arr[7]['loc'] = "footer";
            $script_arr[8]['name'] = "table-data.js";
            $script_arr[8]['type'] = "js";
            $script_arr[8]['loc'] = "footer";
//            $script_arr[9]['name'] = "user_summary_header.js";
//            $script_arr[9]['type'] = "js";
//            $script_arr[9]['loc'] = "footer";
        }


        if ($url_id == 142) {
            $script_arr[0]["name"] = "select2/select2.css";
            $script_arr[0]["type"] = "plugins/css";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[1]["type"] = "plugins/css";
            $script_arr[1]["loc"] = "header";

            $script_arr[2]["name"] = "select2/select2.min.js";
            $script_arr[2]["type"] = "plugins/js";
            $script_arr[2]["loc"] = "footer";

            $script_arr[3]["name"] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[3]["type"] = "plugins/js";
            $script_arr[3]["loc"] = "footer";

            $script_arr[4]["name"] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[4]["type"] = "plugins/js";
            $script_arr[4]["loc"] = "footer";
            $script_arr[5]["name"] = "table-data.js";
            $script_arr[5]["type"] = "js";
            $script_arr[5]["loc"] = "footer";
        }

        if ($url_id == 144) {
            $script_arr[0]['name'] = "validate_configuration.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "tabs_pages.css";
            $script_arr[1]['type'] = "css";
            $script_arr[1]['loc'] = "footer";
        }

        if ($url_id == 146) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }
        if ($url_id == 147) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }
        if ($url_id == 151) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }
        if ($url_id == 152) {
            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "footer";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_select_user.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "footer";
            $script_arr[4]['name'] = "user_summary_header.js";
            $script_arr[4]['type'] = "js";
            $script_arr[4]['loc'] = "footer";
        }
        if ($url_id == 149) {
//            $script_arr[0]['name'] = "jspdf.js";
//            $script_arr[0]['type'] = "js";
//            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 141) {

//           $script_arr[0]['name'] = "autoComplete.css";
//            $script_arr[0]['type'] = "css";
//            $script_arr[0]['loc'] = "header";
//            $script_arr[1]['name'] = "ajax.js";
//            $script_arr[1]['type'] = "js";
//            $script_arr[1]['loc'] = "footer";
//            $script_arr[2]['name'] = "select2/select2.css";
//            $script_arr[2]['type'] = "plugins/css";
//            $script_arr[2]['loc'] = "header";
//            $script_arr[3]['name'] = "DataTables/media/css/DT_bootstrap.css";
//            $script_arr[3]['type'] = "plugins/css";
//            $script_arr[3]['loc'] = "header";
//            $script_arr[4]['name'] = "select2/select2.min.js";
//            $script_arr[4]['type'] = "plugins/js";
//            $script_arr[4]['loc'] = "footer";
//            $script_arr[5]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
//            $script_arr[5]['type'] = "plugins/js";
//            $script_arr[5]['loc'] = "footer";
//            $script_arr[6]['name'] = "DataTables/media/js/DT_bootstrap.js";
//            $script_arr[6]['type'] = "plugins/js";
//            $script_arr[6]['loc'] = "footer";
//            $script_arr[7]['name'] = "table-data.js";
//            $script_arr[7]['type'] = "js";
//            $script_arr[7]['loc'] = "footer";
        }
        if ($url_id == 148) {

//           $script_arr[0]['name'] = "autoComplete.css";
//            $script_arr[0]['type'] = "css";
//            $script_arr[0]['loc'] = "header";
//            $script_arr[1]['name'] = "ajax.js";
//            $script_arr[1]['type'] = "js";
//            $script_arr[1]['loc'] = "footer";
//            $script_arr[2]['name'] = "select2/select2.css";
//            $script_arr[2]['type'] = "plugins/css";
//            $script_arr[2]['loc'] = "header";
//            $script_arr[3]['name'] = "DataTables/media/css/DT_bootstrap.css";
//            $script_arr[3]['type'] = "plugins/css";
//            $script_arr[3]['loc'] = "header";
//            $script_arr[4]['name'] = "select2/select2.min.js";
//            $script_arr[4]['type'] = "plugins/js";
//            $script_arr[4]['loc'] = "footer";
//            $script_arr[5]['name'] = "DataTables/media/js/jquery.dataTables.min.js";
//            $script_arr[5]['type'] = "plugins/js";
//            $script_arr[5]['loc'] = "footer";
//            $script_arr[6]['name'] = "DataTables/media/js/DT_bootstrap.js";
//            $script_arr[6]['type'] = "plugins/js";
//            $script_arr[6]['loc'] = "footer";
//            $script_arr[7]['name'] = "table-data.js";
//            $script_arr[7]['type'] = "js";
//            $script_arr[7]['loc'] = "footer";
        }
        if ($url_id == 150) {
            $script_arr[0]['name'] = "purchase_shopping.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if($url_id == 154){
            $script_arr[0]['name'] = "ckeditor/ckeditor.js";
            $script_arr[0]['type'] = "plugins/js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_id == 158) {
            $script_arr[0]['name'] = "confirm_orded.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }

        if ($url_id == 160) {

            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "ajax-dynamic-list.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "header";

            $script_arr[2]["name"] = "autoComplete.css";
            $script_arr[2]["type"] = "css";
            $script_arr[2]["loc"] = "header";

            $script_arr[3]["name"] = "datepicker/css/datepicker.css";
            $script_arr[3]["type"] = "plugins/css";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[4]["type"] = "plugins/css";
            $script_arr[4]["loc"] = "header";

            $script_arr[5]["name"] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[5]["type"] = "plugins/js";
            $script_arr[5]["loc"] = "footer";

            $script_arr[6]["name"] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[6]["type"] = "plugins/js";
            $script_arr[6]["loc"] = "footer";

            $script_arr[7]["name"] = "date_time_picker.js";
            $script_arr[7]["type"] = "js";
            $script_arr[7]["loc"] = "footer";

            $script_arr[8]["name"] = "validate_search.js";
            $script_arr[8]["type"] = "js";
            $script_arr[8]["loc"] = "header";

            $script_arr[9]["name"] = "misc.js";
            $script_arr[9]["type"] = "js";
            $script_arr[9]["loc"] = "footer";
        }
        if ($url_id == 161) {

            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "tick_faq.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "header";
        }
        if ($url_id == 162) {


            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "tick_category.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "header";

            $script_arr[2]["name"] = "ajax-dynamic-list_employee.js";
            $script_arr[2]["type"] = "js";
            $script_arr[2]["loc"] = "footer";

            $script_arr[3]["name"] = "autoComplete.css";
            $script_arr[3]["type"] = "css";
            $script_arr[3]["loc"] = "header";
        }
        if ($url_id == 163) {
            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "tick_category.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "header";
        }
        if ($url_id == 166) {

            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";
        }
        if ($url_id == 167) {

            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "misc.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";

            $script_arr[2]["name"] = "ajax-dynamic-list_employee.js";
            $script_arr[2]["type"] = "js";
            $script_arr[2]["loc"] = "footer";

            $script_arr[3]["name"] = "autoComplete.css";
            $script_arr[3]["type"] = "css";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "validate_ticket_assign.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";
        }
        if ($url_id == 165) {
            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "misc.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";

            $script_arr[2]["name"] = "ajax-dynamic-list_employee.js";
            $script_arr[2]["type"] = "js";
            $script_arr[2]["loc"] = "footer";

            $script_arr[3]["name"] = "autoComplete.css";
            $script_arr[3]["type"] = "css";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "validate_ticket_assign.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";
        }
        if ($url_id == 164) {
            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "tagging-ticket.css";
            $script_arr[1]["type"] = "css";
            $script_arr[1]["loc"] = "header";

            $script_arr[2]["name"] = "tag-ticket.js";
            $script_arr[2]["type"] = "js";
            $script_arr[2]["loc"] = "header";

            $script_arr[3]["name"] = "ticket_message.js";
            $script_arr[3]["type"] = "js";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[4]["type"] = "plugins/css";
            $script_arr[4]["loc"] = "header";

            $script_arr[5]["name"] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[5]["type"] = "plugins/css";
            $script_arr[5]["loc"] = "header";

            $script_arr[6]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[6]["type"] = "plugins/js";
            $script_arr[6]["loc"] = "footer";

            $script_arr[7]["name"] = "jquery.pulsate/jquery.pulsate.min.js";
            $script_arr[7]["type"] = "plugins/js";
            $script_arr[7]["loc"] = "footer";
        }
        if ($url_id == 168) {
            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "misc.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "footer";

            $script_arr[2]["name"] = "select2/select2.css";
            $script_arr[2]["type"] = "plugins/css";
            $script_arr[2]["loc"] = "header";

            $script_arr[3]["name"] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[3]["type"] = "plugins/css";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "select2/select2.min.js";
            $script_arr[4]["type"] = "plugins/js";
            $script_arr[4]["loc"] = "footer";

            $script_arr[5]["name"] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[5]["type"] = "plugins/js";
            $script_arr[5]["loc"] = "footer";

            $script_arr[6]["name"] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[6]["type"] = "plugins/js";
            $script_arr[6]["loc"] = "footer";

            $script_arr[7]["name"] = "table-data.js";
            $script_arr[7]["type"] = "js";
            $script_arr[7]["loc"] = "footer";

            $script_arr[8]["name"] = "MailBox.js";
            $script_arr[8]["type"] = "js";
            $script_arr[8]["loc"] = "footer";

            $script_arr[9]["name"] = "custom.js";
            $script_arr[9]["type"] = "js";
            $script_arr[9]["loc"] = "footer";

            $script_arr[10]["name"] = "style-popup.css";
            $script_arr[10]["type"] = "css";
            $script_arr[10]["loc"] = "header";

            $script_arr[11]["name"] = "jquery.tinyscrollbar.min.js";
            $script_arr[11]["type"] = "js";
            $script_arr[11]["loc"] = "footer";

            $script_arr[12]["name"] = "validate_mail_management.js";
            $script_arr[12]["type"] = "js";
            $script_arr[12]["loc"] = "footer";

            $script_arr[13]["name"] = "validate_ticket_create.js";
            $script_arr[13]["type"] = "js";
            $script_arr[13]["loc"] = "footer";

            $script_arr[15]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[15]["type"] = "plugins/css";
            $script_arr[15]["loc"] = "header";

            $script_arr[16]["name"] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[16]["type"] = "plugins/css";
            $script_arr[16]["loc"] = "header";

            $script_arr[17]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[17]["type"] = "plugins/js";
            $script_arr[17]["loc"] = "footer";
        }
        if ($url_id == 169) {

            $script_arr[0]["name"] = "ajax-dynamic-list.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "messages.css";
            $script_arr[1]["type"] = "css";
            $script_arr[1]["loc"] = "header";

            $script_arr[2]["name"] = "autoComplete.css";
            $script_arr[2]["type"] = "css";
            $script_arr[2]["loc"] = "header";

            $script_arr[3]["name"] = "ajax.js";
            $script_arr[3]["type"] = "js";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "misc.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";

            $script_arr[5]["name"] = "select2/select2.css";
            $script_arr[5]["type"] = "plugins/css";
            $script_arr[5]["loc"] = "header";

            $script_arr[6]["name"] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[6]["type"] = "plugins/css";
            $script_arr[6]["loc"] = "header";

            $script_arr[7]["name"] = "select2/select2.min.js";
            $script_arr[7]["type"] = "plugins/js";
            $script_arr[7]["loc"] = "footer";

            $script_arr[8]["name"] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[8]["type"] = "plugins/js";
            $script_arr[8]["loc"] = "footer";

            $script_arr[9]["name"] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[9]["type"] = "plugins/js";
            $script_arr[9]["loc"] = "footer";

            $script_arr[10]["name"] = "table-data.js";
            $script_arr[10]["type"] = "js";
            $script_arr[10]["loc"] = "footer";

            $script_arr[11]["name"] = "MailBox.js";
            $script_arr[11]["type"] = "js";
            $script_arr[11]["loc"] = "footer";

            $script_arr[13]["name"] = "custom.js";
            $script_arr[13]["type"] = "js";
            $script_arr[13]["loc"] = "footer";

            $script_arr[14]["name"] = "style-popup.css";
            $script_arr[14]["type"] = "css";
            $script_arr[14]["loc"] = "header";

            $script_arr[15]["name"] = "website.css";
            $script_arr[15]["type"] = "css";
            $script_arr[15]["loc"] = "header";

            $script_arr[16]["name"] = "jquery.tinyscrollbar.min.js";
            $script_arr[16]["type"] = "js";
            $script_arr[16]["loc"] = "footer";

            $script_arr[17]["name"] = "validate_mail_management.js";
            $script_arr[17]["type"] = "js";
            $script_arr[17]["loc"] = "footer";

            $script_arr[18]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[18]["type"] = "plugins/css";
            $script_arr[18]["loc"] = "header";

            $script_arr[19]["name"] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[19]["type"] = "plugins/css";
            $script_arr[19]["loc"] = "header";

            $script_arr[19]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[19]["type"] = "plugins/js";
            $script_arr[19]["loc"] = "footer";

            $script_arr[20]["name"] = "tagging-ticket.css";
            $script_arr[20]["type"] = "css";
            $script_arr[20]["loc"] = "header";
        }
        if ($url_id == 170) {

            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";
        }
        if ($url_id == 171) {

            $script_arr[0]["name"] = "ajax.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "misc.js";
            $script_arr[1]["type"] = "js";
            $script_arr[1]["loc"] = "header";
        }
        if ($url_id == 172) {

            $script_arr[0]["name"] = "ajax-dynamic-list.js";
            $script_arr[0]["type"] = "js";
            $script_arr[0]["loc"] = "header";

            $script_arr[1]["name"] = "messages.css";
            $script_arr[1]["type"] = "css";
            $script_arr[1]["loc"] = "header";

            $script_arr[2]["name"] = "autoComplete.css";
            $script_arr[2]["type"] = "css";
            $script_arr[2]["loc"] = "header";

            $script_arr[3]["name"] = "ajax.js";
            $script_arr[3]["type"] = "js";
            $script_arr[3]["loc"] = "header";

            $script_arr[4]["name"] = "misc.js";
            $script_arr[4]["type"] = "js";
            $script_arr[4]["loc"] = "footer";

            $script_arr[5]["name"] = "select2/select2.css";
            $script_arr[5]["type"] = "plugins/css";
            $script_arr[5]["loc"] = "header";

            $script_arr[6]["name"] = "DataTables/media/css/DT_bootstrap.css";
            $script_arr[6]["type"] = "plugins/css";
            $script_arr[6]["loc"] = "header";

            $script_arr[7]["name"] = "select2/select2.min.js";
            $script_arr[7]["type"] = "plugins/js";
            $script_arr[7]["loc"] = "footer";

            $script_arr[8]["name"] = "DataTables/media/js/jquery.dataTables.min.js";
            $script_arr[8]["type"] = "plugins/js";
            $script_arr[8]["loc"] = "footer";

            $script_arr[9]["name"] = "DataTables/media/js/DT_bootstrap.js";
            $script_arr[9]["type"] = "plugins/js";
            $script_arr[9]["loc"] = "footer";

            $script_arr[10]["name"] = "table-data.js";
            $script_arr[10]["type"] = "js";
            $script_arr[10]["loc"] = "footer";

            $script_arr[11]["name"] = "MailBox.js";
            $script_arr[11]["type"] = "js";
            $script_arr[11]["loc"] = "footer";

            $script_arr[12]["name"] = "custom.js";
            $script_arr[12]["type"] = "js";
            $script_arr[12]["loc"] = "footer";

            $script_arr[13]["name"] = "style-popup.css";
            $script_arr[13]["type"] = "css";
            $script_arr[13]["loc"] = "header";

            $script_arr[14]["name"] = "website.css";
            $script_arr[14]["type"] = "css";
            $script_arr[14]["loc"] = "header";

            $script_arr[15]["name"] = "jquery.tinyscrollbar.min.js";
            $script_arr[15]["type"] = "js";
            $script_arr[15]["loc"] = "footer";

            $script_arr[16]["name"] = "validate_mail_management.js";
            $script_arr[16]["type"] = "js";
            $script_arr[16]["loc"] = "footer";

            $script_arr[17]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[17]["type"] = "plugins/css";
            $script_arr[17]["loc"] = "header";

            $script_arr[18]["name"] = "bootstrap-social-buttons/social-buttons-3.css";
            $script_arr[18]["type"] = "plugins/css";
            $script_arr[18]["loc"] = "header";

            $script_arr[19]["name"] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[19]["type"] = "plugins/js";
            $script_arr[19]["loc"] = "footer";

            $script_arr[20]["name"] = "validate_ticket_status.js";
            $script_arr[20]["type"] = "js";
            $script_arr[20]["loc"] = "footer";

            $script_arr[21]["name"] = "tagging-ticket.css";
            $script_arr[21]["type"] = "css";
            $script_arr[21]["loc"] = "header";
        }
        if( $url_id == 173 ) {
            $script_arr[0]['name'] = "validate_configuration.js";
			$script_arr[0]["type"] = "js";
			$script_arr[0]["loc"] = "footer";

            $script_arr[1]['name'] = "assign_splits.js";
			$script_arr[1]["type"] = "js";
			$script_arr[1]["loc"] = "footer";


        }
        if ($url_id == 178) {
            $script_arr[0]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.css";
            $script_arr[0]['type'] = "plugins/css";
            $script_arr[0]['loc'] = "header";
            $script_arr[2]['name'] = "bootstrap-fileupload/bootstrap-fileupload.min.js";
            $script_arr[2]['type'] = "plugins/js";
            $script_arr[2]['loc'] = "footer";
        }
        if( $url_id == 182 ) {
            $script_arr[0]['name'] = "date_time_picker.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if( $url_id == 183 ) {
            $script_arr[0]['name'] = "Chart.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        return $script_arr;
    }

}
