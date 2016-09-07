<?php

require_once 'Inf_Controller.php';

class Revamp extends Inf_Controller {

    function revamp_update_plan() {
	$account_status = $this->revamp_model->getUpgardeStatus();
	if ($account_status != 'active') {
	    $msg = lang('you_are_already_upgraded_your_plan');
	    $this->redirect($msg, 'home', false);
	}

	$title = lang('upgrade_plan');
	$this->set('title', $this->COMPANY_NAME . " | $title");

	$help_link = 'revam';
	$this->set('help_link', $help_link);

	$this->HEADER_LANG['page_top_header'] = lang('upgrade_plan');
	$this->HEADER_LANG['page_top_small_header'] = '';
	$this->HEADER_LANG['page_header'] = lang('upgrade_plan');
	$this->HEADER_LANG['page_small_header'] = '';

	$this->load_langauge_scripts();

	if ($this->input->post('update') && $this->validate_revamp_update_plan()) {
            $update_post_array = $this->input->post();
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array = $this->validation_model->escapeStringPostArray($update_post_array);
            $update_post_array['mlm_details'] = $this->validation_model->stripTagTextArea($this->input->post('mlm_details'));
            
	    $mlm_details = $update_post_array['mlm_details'];
	    $shopping_status = $update_post_array['shopping_status'];
	    $repurchase_status = $update_post_array['repurchase_status'];
	    $replication_status = $update_post_array['replication_status'];
	    $reference = $update_post_array['reference'];
	    $document = $_FILES['document']['name'];
	    $session_data = $this->session->userdata('inf_logged_in');
	    $table_prefix = $session_data['table_prefix'];
	    $user_ref_id = str_replace('_', '', $table_prefix);
	    $user_detail = $this->revamp_model->getOneUserDetail($user_ref_id);
	    $plan = $user_detail["mlm_plan"];
	    $documentupload = 'document';
	    $new_file_name = '';
	    $url = $this->revamp_model->isValidURL($reference);
	    if ($url) {
		$config['upload_path'] = './public_html/images/document/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|ppt|doc|xls|xlsx';
		$config['max_size'] = '2000000';
		$config['max_width'] = '800';
		$config['max_height'] = '800';
		$this->load->library('upload', $config);

		if ($this->upload->do_upload($documentupload)) {
		    if ($document) {
			$data = array('upload_data' => $this->upload->data());
			$new_file_name = $data['upload_data']['file_name'];
		    } else {
			$new_file_name = '';
		    }
		}
		$result1 = $this->revamp_model->updateRequirementForBinary($mlm_details, $shopping_status, $repurchase_status, $replication_status, $reference, $user_ref_id, $new_file_name, $plan);
		$result2 = $this->revamp_model->upgradeAccount($user_ref_id);
		if ($result1 && $result2) {
		    $msg = lang('your_request_has_saved_successfully');
		    $this->redirect($msg, 'home', true);
		} else {
		    $msg = lang('updation_failed');
		    $this->redirect($msg, 'revamp/revamp_update_plan', false);
		}
	    } else {
		$msg = lang('invalid_reference_url_ex');
		$this->redirect($msg . ' : https://www.referenceurl.com', 'revamp/revamp_update_plan', false);
	    }
	}
	$this->setView();
    }

    function validate_revamp_update_plan() {
	$this->form_validation->set_rules('mlm_details', lang('mlm_plan_details'), 'trim|required');
	$this->form_validation->set_rules('shopping_status', 'Shopping Status', 'trim|required|strip_tags');
	$this->form_validation->set_rules('repurchase_status', 'Shopping Status', 'trim|required|strip_tags');
	$this->form_validation->set_rules('replication_status', 'Replication Status', 'trim|required|strip_tags');
	$this->form_validation->set_rules('reference', lang('reference'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('document', 'Document', 'trim|strip_tags');
	$validate_form = $this->form_validation->run();
	return $validate_form;
    }

    function findState() {
	$this->AJAX_STATUS = true;
	$arr = $this->revamp_model->getState();
	echo '<td><b>State Name <span><font color="#FF0000">*</font></span> </b></td><td><br/><select name="india_state"  id="india_state" style="width: 158px;"  " >
            <option value="">Select State</option>';
	for ($i = 0; $i < count($arr); $i++) {
	    $id = $arr["detail$i"]["State_Id"];
	    $name = $arr["detail$i"]["State_Name"];
	    echo "<option value='$name'>$name</option>";
	}
	echo '</select></td>';
    }

    function send_feedback() {
	$title = lang('feedbacks');
	$this->set('title', $this->COMPANY_NAME . " | $title");

	$help_link = 'send_feedback';
	$this->set('help_link', $help_link);

	$this->HEADER_LANG['page_top_header'] = lang('send_feedback');
	$this->HEADER_LANG['page_top_small_header'] = '';
	$this->HEADER_LANG['page_header'] = lang('send_feedback');
	$this->HEADER_LANG['page_small_header'] = '';

	$this->load_langauge_scripts();

	$session_data = $this->session->userdata('inf_logged_in');
	$table_prefix = $session_data['table_prefix'];
	$infinite_id = str_replace('_', '', $table_prefix);
	if ($this->input->post('send') && $this->validate_send_feedback()) {
            $send_post_array = $this->input->post();
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array = $this->validation_model->escapeStringPostArray($send_post_array);
            $send_post_array['feedback_detail'] = $this->validation_model->stripTagTextArea($this->input->post('feedback_detail'));
	    $feed_subject = $send_post_array['feedback_subject'];
	    $feed_detail = $send_post_array['feedback_detail'];
	    $result = $this->revamp_model->insertFeedback($feed_subject, $feed_detail, $infinite_id);
	    $user_detail = $this->revamp_model->getOneUserDetail($infinite_id);
	    $full_name = $user_detail['full_name'];
	    $user_name = $user_detail['user_name'];
	    $country = $user_detail['country'];
	    $state = $user_detail['state'];
	    $location = $user_detail['location'];
	    $phone = $user_detail['phone'];
	    $email = $user_detail['email'];
	    $mlm_plan = $user_detail['mlm_plan'];
	    $mailBodyDetails = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body >
<table id="Table_01" width="600"   border="0" cellpadding="0" cellspacing="0">
	<tr><td COLSPAN="3"></td></tr>

		<td width="50px"></td>
<td   width="520px"  >
		Dear Admin<br>  
                <p>
<table>
    <tr>    <td width ="100px" > <h3> User Details </h3> </td>  </tr>
    <tr>    <td widh="300px">  Full Name </td> <td>  ' . $full_name . '  </td></tr>
    <tr>    <td>    Mobile No   </td>  <td>   ' . $phone . '  </td>  </tr>
    <tr>    <td>    Email    </td>    <td>    ' . $email . '    </td>    </tr>
    <tr>    <td>    User Name    </td>    <td>        ' . $user_name . '    </td>    </tr>
    <tr>    <td>    Country    </td>    <td>        ' . $country . '    </td>    </tr>
    <tr>    <td>    State    </td>    <td>            ' . $state . '    </td>    </tr>
    <tr>    <td>    Location    </td>    <td>            ' . $location . '    </td>    </tr>
    <tr>    <td>    MLM Plan    </td>    <td>            ' . $mlm_plan . '    </td>    </tr>
    <tr>    <td>    Feedback Subject     </td> <td>    ' . $feed_subject . '</td></tr>
    <tr>    <td>    Feedback Details    </td>    <td>        ' . $feed_detail . '    </td>    </tr>
</table>
        </p>
        For more information Infinite MLM Software <a href="www.infinitemlmsoftware.com">www.infinitemlmsoftware.com</a><br>
        InfiniteMLM Software blog:<a href="www.blog.infinitemlmsoftware.com">www.blog.infinitemlmsoftware.com</a><br>
        For Support:<a href="www.ioss.in"><b>www.ioss.in</b></a><br> <br/>
	<b>Note:</b><br>
	The demo that will be <font color="#FF0000"><b>automatically deleted after 48 hours</b> </font>unless upgraded.<br>
        Have a nice Day..<br><br>
        <b>Contact Us</b>
<table><tr><td><h2>Infinite Open Source Solutions,</h2></td></tr><tr><td><b>Technology Business Incubator, <br>National Institute of Technology Calicut,<b>NIT Campus (P.O.),<br>Calicut - 673601, Kerala<br>Phone: +91 495 2287430</b></td> </tr><tr><td><a ><img src="https://www.ioss.in/images/phone.gif" width="40" align="middle" height="40"><b> +91 9747380289</b></a></td></tr><tr><td><img src="https://www.ioss.in/images/site.gif" align="middle"> <a href="https://www.ioss.in"><b>https://www.ioss.in</b></a></td></tr><tr><td><img src="https://www.ioss.in/images/mail.gif" width="40" align="middle" height="28"> <a><b>info@ioss.in<b></a></td></tr></table>
</td>
<td width="30px"></td>
</tr>
<tr>
        <td COLSPAN="3">
        </td>
</tr>
</table>
</body>
</html>';
	    $arr = $this->revamp_model->sendMail($mailBodyDetails);
	    $msg = '';
	    if ($result) {
		$msg = lang('your_feedback_send_successfully_thank_you_for_posting_feedback');
		$this->redirect($msg, 'home', TRUE);
	    } else {
		$msg = lang('feedback_sending_failed');
		$this->redirect($msg, 'revamp/send_feedback', FALSE);
	    }
	}
	$this->setView();
    }

    function validate_send_feedback() {
	$this->form_validation->set_rules('feedback_subject', lang('feedback_subject'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('feedback_detail', lang('feedback_details'), 'trim|required');
	$validate_form = $this->form_validation->run();
	return $validate_form;
    }
}
