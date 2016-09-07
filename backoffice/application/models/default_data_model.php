<?php

class default_data_model extends inf_model {

    public function __construct() {
        parent::__construct();

        $this->load->model('validation_model');
        $this->load->model('product_model');
        $this->load->model('configuration_model');
        $this->load->model('registersubmit_model');
        $this->load->model('register_model');
        $this->load->model('employee_model');
        $this->load->model('mail_model');

        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
    }

    public function confirmRegister($regr, $module_status) {

        $max_nod_id = $this->registersubmit_model->getMaxOrderID();
        $next_order_id = $max_nod_id + 1;

        if ($regr['user_name_type'] == 'dynamic') {
            $regr['username'] = $this->registersubmit_model->getUsername();
        } else {
            $regr['username'] = $regr['user_name_entry'];
        }

        $regr['fatherid'] = $this->validation_model->userNameToID($regr['fatherid']);

        $regr['referral_id'] = $this->validation_model->userNameToID($regr['referral_name']);


        if ($regr['state'] != "") {
            $regr['state'] = $this->validation_model->getStateName($regr['state']);
        }

        $child_node = $this->validation_model->getChildNodeId($regr['fatherid'], $regr['position']);

        $updt_login_res = $res_login_update = $this->reg->updateLoginUser($regr['username'], md5($regr['pswd']), $child_node);

        if ($res_login_update) {

            $user_level = $this->registersubmit_model->getLevel($regr['fatherid']) + 1;

            $updt_ft_res = $res_ftindi_update = $this->registersubmit_model->updateFTIndividual($regr['fatherid'], $regr['position'], $regr['username'], $child_node, $next_order_id, $regr['by_using'], $user_level, $regr['product_id']);

            if ($res_ftindi_update) {

                $last_insert_id = $this->validation_model->userNameToID($regr['username']);

                $pin_status = $module_status['pin_status'];
                $pin_status;

                $regr['userid'] = $last_insert_id;

                $updt_ft_uni = $this->registersubmit_model->insertToUnilevelTree($regr);
                $insert_user_det_res = $res = $this->registersubmit_model->insertUserDetails($regr);
                $id = $insert_tmp1_res = $res1 = $this->registersubmit_model->tmpInsert($last_insert_id, 'L');
                $insert_tmp2_res = $res1 = $this->registersubmit_model->tmpInsert($last_insert_id, 'R');
            }
        }

        $rank_status = $module_status['rank_status'];
        $balance_amount = 0;
        if ($rank_status == "yes") {

            $referal_count = $this->validation_model->getReferalCount($regr['referral_id']);
            $old_rank = $this->validation_model->getUserRank($regr['referral_id']);
            $regr['rank'] = $this->validation_model->getCurrentRankFromRankConfig($referal_count);
            $new_rank = $regr['rank'];

            $this->register_model->updateUserRank($regr['referral_id'], $new_rank);

            if ($old_rank != $new_rank) {

                $balance_amount = $this->register_model->balanceAmount($regr['referral_id']);
                $rank_bonuss = array();
                $rank_bonuss = $this->configuration_model->getActiveRankDetails($new_rank);
                $balance_amount = $balance_amount + $rank_bonuss[0]['rank_bonus'];
                $this->register_model->updateUsedEwallet($regr['referral_id'], $balance_amount, "yes");
                $this->register_model->insertIntoRankHistory($old_rank, $regr['rank'], $regr['referral_id']);
            }
        }

        $product_status = $module_status['product_status'];
        $first_pair = $module_status['first_pair'];
        $referal_status = $module_status['referal_status'];


        if ($referal_status == "yes") {

            $referal_amount = $this->register_model->getReferalAmount();
            if ($product_status == "yes" && $first_pair == "1:1") {
                require_once 'calculation_11_product_model.php';
            } else if ($product_status == "no" && $first_pair == "1:1") {
                require_once 'calculation_11_without_product_model.php';
            } else if ($product_status == "yes" && $first_pair == "2:1") {
                require_once 'calculation_21_product_model.php';
            } else if ($product_status == "no" && $first_pair == "2:1") {
                require_once 'calculation_21_without_product_model.php';
            }
            $obj_calc = new calculation_model();

            $referal_id = $obj_calc->getReferalId($last_insert_id);

            if ($referal_amount > 0) {
                $raferal_amount = $balance_amount + $referal_amount;
                $ref_amt = $obj_calc->insertReferalAmount($referal_id, $referal_amount, $regr['userid']);
            }
        }

        if ($product_status == "yes") {

            if ($first_pair == "2:1") {

                require_once 'calculation_21_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($regr['userid'], $regr['fatherid'], $regr['product_id'], $regr['position'], $regr['userid']);
                if ($module_status['sponsor_commission_status'] == 'yes')
                    $obj_calc->calculateLevelCommission($regr['userid'], $regr['fatherid'], $regr['position'], $regr['product_id']);
            } else {

                require_once 'calculation_11_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($regr['userid'], $regr['fatherid'], $regr['product_id'], $regr['position'], $regr['userid']);
                if ($module_status['sponsor_commission_status'] == 'yes')
                    $obj_calc->calculateLevelCommission($regr['userid'], $regr['fatherid'], $regr['position'], $regr['product_id']);
            }
        } else {

            if ($first_pair == "2:1") {

                require_once 'calculation_21_without_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($regr['userid'], $regr['fatherid'], $regr['position'], $regr['userid']);
                if ($module_status['sponsor_commission_status'] == 'yes')
                    $obj_calc->calculateLevelCommission($regr['userid'], $regr['fatherid'], $regr['position'], $regr['product_id']);
            } else {

                require_once 'calculation_11_without_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($regr['userid'], $regr['fatherid'], $regr['position'], $regr['referral_id'], $regr['userid']);
                if ($module_status['sponsor_commission_status'] == 'yes')
                    $obj_calc->calculateLevelCommission($regr['userid'], $regr['fatherid'], $regr['position'], $regr['product_id']);
            }
        }


        if (($updt_ft_res) && ($updt_login_res) && ($insert_user_det_res) && ($insert_tmp1_res) && ($insert_tmp2_res)) {
            $mobile = $regr['mobile'];
            $username = $regr['username'];
            $password = $regr['pswd'];
            $full_name = $regr['full_name'];

            $site_info = $this->configuration_model->getSiteConfiguration();
            $site_name = $site_info['co_name'];
            $site_logo = $site_info['logo'];
            $base_url = base_url();

            $tran_code = $this->registersubmit_model->getRandTransPasscode(8);
            $this->registersubmit_model->savePassCodes($last_insert_id, $tran_code);

            if (($regr['email'] != "") && ($regr['email'] != null)) {
                $reg_mail = $this->register_model->checkMailStatus();
                if ($reg_mail['reg_mail_status'] == 'yes') {
                    $email = $regr['email'];

                    $mail_content = $this->validation_model->getMailBody();

                    $subject = "$site_name Registration Notification";
                    $mailBodyDetails = '<html xmlns="https://www.w3.org/1999/xhtml">
                                                <head>
                                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                                    
                                                    <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
                                                    <style>
 
                                                                margin:0px;
                                                                padding:0px;
                                                          
                                                    </style>

                                                </head>

                                                <body>
                                                    <div style="width:80%;padding:40px;border: solid 10px #D0D0D0;margin:50px auto;">
                                                      <div style="lwidth:100%;height:62px;border: solid 1px #D0D0D0;background:url(' . $base_url . 'public_html/images/head-bg.png) no-repeat center center;padding:3px 5px 3px 5px;">
                                                       <img src="' . $base_url . 'public_html/images/logos/' . $site_logo . '" alt="logo" />  
                                                      </div>
                                                      <div style="width:100%;margin:15px 0 0 0;">
                                                        <h1 style="font: normal 20px Tahoma, Geneva, sans-serif;">Dear <font color="#e10000">' . $full_name . ',</font></h1><br>
                                                       <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">' . $mail_content . '</p>
                                                        <div style="width:400px;height:225px;margin:16px auto;background:url' . $base_url . 'public_html/images/page.png);border: solid 1px #d0d0d0;border-radius: 10px;">
                                                          <img src="' . $base_url . 'public_html/images/login-icons.png" width="35px" height="35px" style="float:left;margin-top:10px;margin-left:10px;"/><h2 style="color:#C70716;font:normal 16px Tahoma, Geneva, sans-serif;line-height:34px;margin:10px 0 0 22px;float:left;padding-left: 0px;">LOGIN DETAILS</h2>
                                                          <div style="clear:both;"></div>
                                                          <ul style="display:block;margin:14px 0 0 -36px;float:left;">
                                                            <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;"> Login Link</span><font color="#025BB9"> : <a href=' . "$base_url" . '>Click Here</a></font></li>
                                                            
                                                            <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;">Your UserName</span><font color="#e10000"> : ' . $username . '</font></li>
                                                            <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;">Your Password</span><font color="#e10000"> : ' . $password . '</font></li>
                                                          </ul>
                                                        </div>
                                                        <p><br /><br /><br /><br /> </p>
                                                      </div>

                                                    </div>
                                                </body>
                                            </html>';

                    //$send_mail = $this->sendEmail($mailBodyDetails, $email, $reg_mail);

                    $mail_type = $this->register_model->getMailType();
                    if ($mail_type == 'normal')
                        $this->validation_model->sendEmail($mailBodyDetails, $email, $reg_mail, $subject);
                    else
                        $this->register_model->sendMailSmtp($subject, $mailBodyDetails);
                }
            }


            $this->registersubmit_model->insertBalanceAmount($regr['userid']);
            $encr_id = $this->session->userdata('inf_user_id');
            $encr_id = $this->register_model->getEncrypt($encr_id);

            $msg['user'] = $username;
            $msg['pwd'] = $password;
            $msg['id'] = $encr_id;
            $msg['status'] = true;
            $msg['tran'] = $tran_code;
            return $msg;
        } else {
            $this->registersubmit_model->rollBack();
            $encr_id = $this->session->userdata('inf_user_id');
            $encr_id = $this->register_model->getEncrypt($encr_id);

            $msg['user'] = "";
            $msg['pwd'] = "";
            $msg['id'] = "";
            $msg['status'] = false;
            $msg['tran'] = "";
            return $msg;
        }
    }

    function getUsername() {
        return $this->registersubmit_model->getUsername();
    }

    function confirmRegistration($reg_arr) {
        $result = $this->employee_model->confirmRegistration($reg_arr);
        return $result;
    }

    function addProduct($prod_arr) {
        $date = date('Y-m-d-h:i:s');
        $data = array('product_name' => $prod_arr['prod_name'],
            'prod_id' => $prod_arr['product_id'],
            'active' => $prod_arr['active'],
            'product_value' => $prod_arr['product_value'],
            'pair_value' => $prod_arr['pair_value'],
            'date_of_insertion' => $date,
            'prod_bv' => $prod_arr['bv_value']
        );
        $result = $this->db->insert('product', $data);
        return $result;
    }

    function isUserNameAvailable($user_name) {
        $flag = false;
        $count = 0;

        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("login_employee");
        $this->db->where('user_name', $user_name);
        $this->db->where('emp_status', 'yes');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = true;
        }
        return $flag;
    }

    function sendMesageToAdmin($user_id) {

        $date = date('Y-m-d H:i:s');
        $subject = 'Default data Generated';
        $message = 'Default data Generated on ' . $date;

        $mail_st = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $date);
        return $mail_st;
    }

    function sendMessageToUser($user_id, $subject, $message, $date, $father_id) {

        $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date, $father_id);
        return $res;
    }

}
