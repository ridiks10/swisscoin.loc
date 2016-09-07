<?php

require_once 'Inf_Controller.php';

class Leg_Count_Commission extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('profile_model');
    }

    function view_leg_count() {
        $title = lang('leg_count');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'commission-details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('commission_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('commission_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $product_status = $this->MODULE_STATUS['product_status'];
        $this->leg_count_commission_model->initialize($product_status);
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $mlm_plan = $this->MLM_PLAN;
        $is_valid_username = "";
        $user_name = $this->LOG_USER_NAME;
        $user_leg_detail = $numrows = $result_per_page = 0;
        $leg_level = array();
        $arr_len = "";

        /////////////////////////////////////////////////////////////

        if ($this->input->post('user_name') && $this->validate_view_leg_count()) {
            $base_url = base_url() . 'leg_count_commission/view_leg_count';
            $config['base_url'] = $base_url;
            $config['per_page'] = 200;
            if ($this->uri->segment(4) != "")
                $page = $this->uri->segment(4);
            else
                $page = 0;

            $legcount = TRUE;
            $user_name = $this->input->post('user_name');
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if ($is_valid_username) {
                $users = $this->leg_count_commission_model->getUserIdFromUserName($user_name);
                $user_id = $users['user_id'];
                $user_type = $users['user_type'];
                $user_name = $users['user_name'];
            } else {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'leg_count_commission/view_leg_count', false);
            }

            $depth_ceiling = $this->leg_count_commission_model->getDepthCieling();

            if ($user_id > 0) {
                $leg_level = $this->leg_count_commission_model->getEachLeveLegCountAndTotalLeveAmount($user_id, $depth_ceiling + 1);
                $arr_len = count($leg_level);
            } else {
                $msg = $this->lang->line('Username_not_Exists');
                $this->redirect($msg, "profile/user_account", false);
            }
            $this->set("leg_level", $leg_level);
            $this->set('arr_len', $arr_len);
            $user_leg_detail = $this->leg_count_commission_model->getUserLegDetails($user_id, $page, $config['per_page']);
            $numrows = $this->leg_count_commission_model->getCountUserLegDetails($user_id, $user_type);

            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();
        }
        $this->set("page", $page);
        $this->set('user_leg_detail', $user_leg_detail);
        $this->set('count', $numrows);
        $this->set('result_per_page', $result_per_page);
        $this->set('mlm_plan', $mlm_plan);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('user_name', $user_name);
        $this->set('legcount', $legcount);
        $this->setView();
    }

    function validate_view_leg_count() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function contact($user_id) {
        $this->AJAX_STATUS = true;

        $total_leg_tot = "";
        $total_amount_tot = "";
        ///    $action = isset($_POST["action"]) ? $_POST["action"] : "";
        ///    $id = $this->URL['id'];

        $depth_ceiling = $this->leg_count_commission_model->getDepthCieling();
        //Admin
        $user_id_tmp = $this->leg_count_commission_model->userNameToID($this->input->post('user_name'));
        ///     if ($this->URL['id'] > 0)
        ///         $user_id_tmp = $this->URL['id'];
        if ($user_id_tmp > 0)
            $leg_level = $this->leg_count_commission_model->getEachLeveLegCountAndTotalLeveAmount($user_id_tmp, $depth_ceiling + 1);
        ///     if ($_SESSION['user_type'] != "admin") {
        if ($user_id > 0)
            $leg_level = $this->leg_count_commission_model->getEachLeveLegCountAndTotalLeveAmount($user_id, $depth_ceiling + 1);
        ///     }

        $arr_len = count($leg_level);

        if ($arr_len > 0) {
            echo "<div style='display:none'>
		<div class='contact-top'></div>
		<div class='contact-content' style='background-color:#ffffff;'>
			<h1 class='contact-title'>User Level Commission</h1>
			<div class='contact-loading' style='display:none'></div>
			<div class='contact-message' style='display:none'></div>

		  <table  class ='table table-striped table-bordered table-hover table-full-width'  width='100%' id='grid'>
			  <tr class ='th' >
			  <th>Level</th><th>Members</th><th>Amount</th>
			</tr>";

            for ($k = 1; $k <= $arr_len; $k++) {
                if ($k % 2 == 0)
                    $class = 'tr1';
                else
                    $class = 'tr2';

                $level = $leg_level["detail$k"]["level"] - 1;
                $tot_leg = $leg_level["detail$k"]["persons"];
                $tot_amt = round($leg_level["detail$k"]["amount"], 2);


                $total_leg_tot += $tot_leg;
                $total_amount_tot += $tot_amt;

                ///          $z = $i + 1;

                echo "<tr class='$class'>
			<td>$level</td>
			<td> $tot_leg</td>
			<td> $tot_amt</td>
			</tr>";


                ///         $i++;
                ///         $count = $i;
            } // For loop ends here



            $class = 'total';
            echo "<tr  class='$class' align='left' >
                <td><b>Total</b></td>
                <td><b> $total_leg_tot</b></td>
                <td><b> $total_amount_tot</b></td>
				</tr> </table></div>";
        }

        // $html_1.$html_2.$html_3
        echo "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>User Level Commission</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>";
        //$html_1.$html_2.$html_3
        echo "<div class='contact-bottom'></div>
</div>";
        exit;
    }

    function users() {
        $this->AJAX_STATUS = true;

        echo "<table border=0 width='700px'><tr bgcolor='#C6FFFF'><th>User Name</th><th>Full Name</th><th>Mobile No</th><th>E-mail</th></tr> ";

        echo "</table>";
    }

//    function get_user_summary($username) {
//        $is_valid_username = $this->validation_model->isUserNameAvailable($username);
//        $this->set('is_valid_username', $is_valid_username);
//        if ($is_valid_username) {
//            $user_id = $this->validation_model->userNameToID($username);
//            $product_status = $this->MODULE_STATUS['product_status'];
//            $lang_id = $this->LANG_ID;
//            $profile_arr = $this->profile_model->getProfileDetails($user_id, '', $product_status, $lang_id);
//
//            $details = $profile_arr['details'];
//            $file_name = $this->profile_model->getUserPhoto($user_id);
//            if ($file_name == "")
//                $file_name = "nophoto.jpg";
//
//            $pin_status = $this->MODULE_STATUS['pin_status'];
//            $ewallet_status = $this->MODULE_STATUS['ewallet_status'];
//            $referal_status = $this->MODULE_STATUS['referal_status'];
//
//            $this->set("pin_status", $pin_status);
//            $this->set("ewallet_status", $ewallet_status);
//            $this->set("referal_status", $referal_status);
//
//            $this->set("file_name", $file_name);
//            $this->set("user_name", $username);
//            $this->set("user_id", $user_id);
//            $this->set("details", $details);
//
//            $this->set("tran_User_Name", $this->lang->line('User_Name'));
//            $this->set("tran_full_name", $this->lang->line('full_name'));
//            $this->set("tran_email", $this->lang->line('email'));
//            $this->set("tran_mobile_no", $this->lang->line('mobile_no'));
//            $this->set("tran_address", $this->lang->line('address'));
//            $this->set("tran_country", $this->lang->line('country'));
//            $this->set("tran_view_profile", $this->lang->line('view_profile'));
//            $this->set("tran_view_commission_details", $this->lang->line('view_commission_details'));
//            $this->set("tran_view_income_details", $this->lang->line('view_income_details'));
//            $this->set("tran_view_refferal_details", $this->lang->line('view_refferal_details'));
//            $this->set("tran_view_income_statement", $this->lang->line('view_income_statement'));
//            $this->set("tran_user_account", $this->lang->line('user_account'));
//            $this->set("tran_view_ewallet_details", $this->lang->line('view_ewallet_details'));
//            $this->set("tran_view_user_epin", $this->lang->line('view_user_epin'));
//        }
//    }
}

?>