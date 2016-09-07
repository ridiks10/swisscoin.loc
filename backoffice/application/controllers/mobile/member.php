<?php

require_once 'Inf_Controller.php';

class Member extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("android/new/android_model");
    }

    function change_password() {
// add three extra fields current_password,new_password and confirm_password
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $this->load->model('password_model');
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $new_pwd_md5 = md5($post_array['new_password']);
        if (!$user_id) {
            $user_details['status'] = false;
            $user_details['message'] = 'Invalid Login details';
        } else {
            $dbpassword = $this->password_model->selectPassword($user_id);
            $val = $this->password_model->validatePswd($post_array['new_password']);
            if (!$val) {
                $user_details['status'] = false;
                $user_details['message'] = 'Special character not allowed';
            } else if (!$post_array['new_password']) {
                $user_details['status'] = false;
                $user_details['message'] = 'You must enter new password';
            } else if (!$post_array['current_password']) {
                $user_details['status'] = false;
                $user_details['message'] = 'You must enter current password';
            } else if (!$post_array['confirm_password']) {
                $user_details['status'] = false;
                $user_details['message'] = 'You must enter confirm password';
            } else if (strcmp($dbpassword, md5($post_array['current_password'])) != 0 || strlen($post_array['new_password']) < 6) {
                $user_details['status'] = false;
                $user_details['message'] = 'Your current password is mismatch or new password is too short';
            } else if (strcmp($post_array['new_password'], $post_array['confirm_password']) != 0) {
                $user_details['status'] = false;
                $user_details['message'] = 'password mismatch';
            } else {
                $update = $this->password_model->updatePassword($new_pwd_md5, $user_id, $user_type);
                if ($update) {
                    $send_details = array();
                    $type = 'change_password_mob';
                    $email = $this->validation_model->getUserEmailId($user_id);
                    $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
                    $send_details['new_password'] = $post_array['new_password'];
                    $send_details['email'] = $email;
                    $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                    $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
                    $result = $this->mail_model->sendAllEmails($type, $send_details);
                    $this->validation_model->insertUserActivity($user_id, 'password changed mob', $user_id);
                    $user_details['status'] = true;
                    $user_details['message'] = 'password changed sucessfully';
                } else {
                    $user_details['status'] = false;
                    $user_details['message'] = 'Error on password  change';
                }
            }
        }
        echo json_encode($user_details);
        exit();
    }

    function profile_edit() {
// add three extra fields current_password,new_password and confirm_password
        $this->load->model('registersubmit_model');
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $user_id = $this->LOG_USER_ID;
        $post_array['address'] = $post_array['address_line1'];
        $post_array['pin'] = $post_array['zip_code'];
        $post_array['mobile'] = $post_array['mobile_number'];
        $post_array['land_line'] = $post_array['land_line_number'];
        $year = $post_array['year'];
        $month = $post_array['month'];
        $day = $post_array['day'];
        $post_array['date_of_birth'] = $year . '-' . $month . '-' . $day;
        if (($year == '0000') || ($month == '00') || ($day == '00')) {
            $user_details['status'] = false;
            $user_details['message'] = 'must select date of birth';
        }
        $mobile_length = strlen($post_array['mobile_number']);
        $land_line_length = strlen($post_array['land_line']);
        $year_length = strlen($post_array['year']);
        $month_length = strlen($post_array['month']);
        $day_length = strlen($post_array['day']);

        $email_count = $this->android_inf_model->getCountEmail($post_array['email'], $user_id);
        if (!$post_array['gender']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter gender';
        } else if (!$post_array['address_line1']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter current Address Line 1';
        } else if (!$post_array['second_name']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter last name';
        } else if (!$post_array['first_name']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter first name';
        } else if (!$post_array['address_line2']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter current Address Line 2';
        } else if (!$post_array['city']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter current City';
        } else if (!$post_array['mobile_number']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Mobile Number';
        } else if (!is_numeric($post_array['mobile_number'])) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter numeric for Mobile Number';
        } else if (strlen($mobile_length < 10)) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter at least 10 digit for Mobile Number';
        } else if (!$post_array['email']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Email';
        } else if (!filter_var($post_array['email'], FILTER_VALIDATE_EMAIL)) {
            $user_details['status'] = false;
            $user_details['message'] = 'Invalid Email';
        } else if ($email_count) {
            $user_details['status'] = false;
            $user_details['message'] = 'Email already registered by another user';
        } else if (!$post_array['year']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Year';
        } else if (strlen($year_length != 4)) {
            $user_details['status'] = false;
            $user_details['message'] = 'Plese check enter year';
        } else if (!$post_array['month']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Month';
        } else if ($post_array['month'] > 12 || $post_array['month'] < 1) {
            $user_details['status'] = false;
            $user_details['message'] = 'You plese check enter month';
        } else if (!$post_array['day']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Day';
        } else if (!$post_array['pan_no']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Pan Number';
        } else if (!$post_array['year']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter year';
        } else if (!is_numeric($post_array['year'])) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter numeric for Year';
        } else if (!$post_array['month']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Month';
        } else if (!is_numeric($post_array['month'])) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter numeric for Month';
        } else if (!$post_array['day']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Day';
        } else if (!is_numeric($post_array['day'])) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter numeric for Day';
        } else if (!$post_array['bank_name']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Bank name';
        } else if (!$post_array['bank_branch']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Branch Name';
        } else if (!$post_array['bank_acc_no']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Bank Account Number';
        } else if (!$post_array['ifsc']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter IFSC';
        } else if (!$post_array['zip_code']) {
            $user_details['status'] = false;
            $user_details['message'] = 'You must enter Zip code';
        } else {
            $post_array['country'] = $this->android_inf_model->getCountryIDFromName($post_array['country']);
            $post_array['state'] = $this->android_inf_model->getStateIdFromName($post_array['state']);
            $res = $this->android_inf_model->updateUserDetails($post_array, $user_id);

            if ($res) {
                $loggin_id = $this->LOG_USER_ID;
                $data_array = array();
                $data_array['edit_profile'] = $post_array;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($user_id, 'profile_updated_mobile', $user_id, $data);
                $user_details['status'] = true;
                $user_details['message'] = 'Profile updated sucessfully';
            } else {
                $user_details['status'] = false;
                $user_details['message'] = 'Error on profile updation';
            }
        }
        echo json_encode($user_details);
        exit();
    }

    function get_profile_data() {
        $user_id = $this->LOG_USER_ID;
        $this->load->model('profile_model');
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
            $user_name = $this->LOG_USER_NAME;
            $product_status = $this->MODULE_STATUS['product_status'];
            $lang_id = $this->LANG_ID;
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $json_response['data'] = $this->profile_model->getProfileDetails($user_id, $user_name, $product_status, $lang_id);
        }

        echo json_encode($json_response);
        exit();
    }

    function get_refferal_details() {
        $user_id = $this->LOG_USER_ID;
        $this->load->model('configuration_model');
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $json_response['data'] = $this->android_inf_model->getReferalDetails($user_id);
            echo json_encode($json_response);
            exit();
        }
    }

    function get_product() {
        $user_id = $this->LOG_USER_ID;
        $this->load->model('configuration_model');
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            //$json_response['data'] = $this->android_inf_model->getAllProducts();
            $json_response['data'] = $this->android_inf_model->getProductDetails();
            echo json_encode($json_response);
            exit();
        }
    }

    public function uploadImage() {
        //imagename adn image are extra fields
        $target_path = './public_html/images/profile_picture/';
        $user_id = $this->LOG_USER_ID;
        $post_array = $this->input->post();
        $image = $post_array['image'];
        $imagename = $post_array['imagename'];

        $binary = base64_decode($image);
        header('Content-Type: bitmap; charset=utf-8');
        $file = fopen($target_path . $imagename, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
           $this->android_inf_model->updateUserProfileImage($user_id,$imagename);
            $json_response['status'] = true;
            $json_response['message'] = 'UploadImage';
        }
        echo json_encode($json_response);
    }

}

?>
