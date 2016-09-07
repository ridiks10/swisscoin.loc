<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of android_model
 *
 * @author ioss
 */
class Android_inf_model extends Core_Inf_Model {

    function __construct() {
        parent::__construct();
    }

    public function getUserByUsernameAndPassword($adminName, $username, $password) {

        $login_detail = $this->loginPrimaryUser($adminName);
        if ($login_detail) {
            $user_terminate_status = $this->checkIfUserTerminated($username, $login_detail);
            if ($user_terminate_status) {
                $table_prefix = $login_detail['id'] . '_login_user';

                $this->db->from($table_prefix);
                $this->db->where('user_name', $username);
                $this->db->where('addedby', 'code');
                $this->db->where('password', $password);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $login_detail['user_id'] = $row->user_id;
                    return $login_detail;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function loginPrimaryUser($adminName) {

        $login_detail = array();
        $where = "(account_status = 'active' OR account_status = 'upgraded')";
        $this->db->select('id,mlm_plan');
        $this->db->from('infinite_mlm_user_detail');
        $this->db->where('user_name', $adminName);
        $this->db->where($where);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $login_detail['id'] = $row->id;
            $login_detail['mlm_plan'] = $row->mlm_plan;
        }
        return $login_detail;
    }

    public function checkIfUserTerminated($username, $login_detail) {

        $table_prefix = $login_detail['id'] . '_ft_individual';

        $this->db->select('active');
        $this->db->from($table_prefix);
        $this->db->where('user_name', $username);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            if (strcmp($row->active, 'terminated') != 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function updateJoining($userid, $prefix) {

        $data = array('today' => 0, 'total' => 0);
        $date = date('Y-m-d');

        $this->db->from($prefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);
        $this->db->like('join_date', $date, 'after');
        $query = $this->db->get();
        $data['today'] = $query->num_rows();
        $query->free_result();
        $this->db->from($prefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);
        $query = $this->db->get();
        $data['total'] = $query->num_rows();

        return $data;
    }

    public function sendMessage($userid, $prefix, $sub, $msg) {

        $this->db->set('mailaduser', $userid);
        $this->db->set('mailadsubject', $sub);
        $this->db->set('mailadiddate', date('Y-m-d H:i:s'));
        $this->db->set('status', 'yes');
        $this->db->set('mailadidmsg', $msg);
        $this->db->insert($prefix . '_mailtoadmin');

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function getEwallet($userid, $tprefix) {

        $amount = array('total' => 0, 'release' => 0, 'req' => 0);
        $table = $tprefix . '_user_balance_amount';
        $this->db->select('balance_amount');
        $this->db->from($table);
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $row = $query->row();
        $amount['total'] = $row->balance_amount;

        $query->free_result();

        $this->db->select_sum('paid_amount');
        $this->db->where('paid_type', 'released');
        $this->db->where('paid_user_id', $userid);
        $query = $this->db->get($tprefix . '_amount_paid');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $amount['release'] = $row->paid_amount;
        }
        $query->free_result();

        $this->db->select_sum('requested_amount');
        $this->db->where('status', 'pending');
        $this->db->where('requested_user_id', $userid);
        $query = $this->db->get($tprefix . '_payout_release_requests');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $amount['req'] = $row->requested_amount;
        }

        if ($amount['total'] == null) {
            $amount['total'] = 0;
        }

        if ($amount['release'] == null) {
            $amount['release'] = 0;
        }

        if ($amount['req'] == null) {
            $amount['req'] = 0;
        }

        return $amount;
    }

    /**
     * @since 1.21 There is no total_leg
     */
    public function getBonus($userid, $prefix) {

        if ($userid == '') {
            die();
        }
        $detail = array('leftpoint' => 0, 'rightpoint' => 0, 'leftcarry' => 0, 'rightcarry' => 0, 'total' => 0, 'amount' => 0);
        $this->db->select('total_left_count,total_right_count,total_left_carry,total_right_carry');
        $this->db->from($prefix . '_leg_details');
        $this->db->where('id', $userid);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $detail['leftpoint'] = $row->total_left_count;
            $detail['rightpoint'] = $row->total_right_count;
            $detail['leftcarry'] = $row->total_left_carry;
            $detail['rightcarry'] = $row->total_right_carry;
        }
        $query->free_result();
        $this->db->select_sum('total_amount');
        $this->db->from($prefix . '_leg_amount');
        $this->db->where('user_id', $userid);
        $this->db->where('amount_type', 'leg');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $detail['total'] = 0;
            if ($row->total_amount == '') {
                
            } else {
                $detail['amount'] = $row->total_amount;
            }
        }
        return $detail;
    }

    public function getUserDetails($userid, $tprefix) {

        $details = array();
        $this->db->select('user_details_ref_user_id');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_detail_refid', $userid);
        $query = $this->db->get();

        $refid = 0;
        $pid = 0;

        $row = $query->row();
        $refid = $row->user_details_ref_user_id;

        $this->db->select('user_detail_name');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_detail_refid', $refid);
        $query = $this->db->get();
        $row = $query->row();

        $details['sponser'] = $row->user_detail_name;

        $query->free_result();

        $this->db->select('user_name,position,product_id');
        $this->db->from($tprefix . '_ft_individual');
        $this->db->where('id', $userid);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['username'] = $row->user_name;
            $details['position'] = $row->position;
            $pid = $row->product_id;
        }

        $query->free_result();

        $module_details = $this->getModuleStatus($tprefix);
        if ($module_details->product_status == 'yes') {
            $this->db->select('product_name');
            $this->db->from($tprefix . '_product');
            $this->db->where('product_id', $pid);
            $query = $this->db->get();
            $row = $query->row();

            $details['package'] = $row->product_name;
        } else {
            $details['package'] = 'No Package';
        }

        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_detail_refid', $userid);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['name'] = $row->user_detail_name;
            $details['dob'] = $row->user_detail_dob;
            $details['gender'] = $row->user_detail_gender;
            $details['address'] = $row->user_detail_address;
            $details['country'] = $row->user_detail_country;
            $details['photo'] = $row->user_photo;

            if ($row->user_detail_state == FALSE) {
                $details['state'] = 'NA';
            } else {
                $details['state'] = $row->user_detail_state;
            }

            if ($row->user_detail_pin == FALSE) {
                $details['pin'] = 'NA';
            } else {
                $details['pin'] = $row->user_detail_pin;
            }

            $details['mobile'] = $row->user_detail_mobile;

            if ($row->user_detail_land == FALSE) {
                $details['land'] = 'NA';
            } else {
                $details['land'] = $row->user_detail_land;
            }

            $details['email'] = $row->user_detail_email;

            if ($row->user_detail_pan == FALSE) {
                $details['pan'] = 'NA';
            } else {
                $details['pan'] = $row->user_detail_pan;
            }

            if ($row->user_detail_acnumber == FALSE) {
                $details['bankac'] = 'NA';
            } else {
                $details['bankac'] = $row->user_detail_acnumber;
            }

            if ($row->user_detail_ifsc == FALSE) {
                $details['ifsc'] = 'NA';
            } else {
                $details['ifsc'] = $row->user_detail_ifsc;
            }

            if ($row->user_detail_nbank == FALSE) {
                $details['namebank'] = 'NA';
            } else {
                $details['namebank'] = $row->user_detail_nbank;
            }

            if ($row->user_detail_nbranch == FALSE) {
                $details['branch'] = 'NA';
            } else {
                $details['branch'] = $row->user_detail_nbranch;
            }

            if ($row->user_detail_facebook == FALSE) {
                $details['face'] = 'NA';
            } else {
                $details['face'] = $row->user_detail_facebook;
            }

            if ($row->user_detail_twitter == FALSE) {
                $details['twit'] = 'NA';
            } else {
                $details['twit'] = $row->user_detail_twitter;
            }
        }
        return $details;
    }

    public function getMailCount($userid, $tprefix) {

        $details = array();
        $date = date('Y-m-d');
        $table = $tprefix . '_mailtouser';
        $this->db->from($table);
        $this->db->where('mailtoususer', $userid);
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'yes');
        $query = $this->db->get();

        $details['read'] = $query->num_rows();

        $query->free_result();
        $this->db->from($table);
        $this->db->where('mailtoususer', $userid);
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $query = $this->db->get();

        $details['unread'] = $query->num_rows();

        $query->free_result();
        $this->db->from($table);
        $this->db->where('mailtoususer', $userid);
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $this->db->like('mailtousdate', $date, 'after');
        $query = $this->db->get();

        $details['today'] = $query->num_rows();
        return $details;
    }

    public function checkPassword($userid, $tprefix, $oldpass) {

        $detail = array('status' => false);
        $pass = md5($oldpass);

        $this->db->from($tprefix . '_login_user');
        $this->db->where('PASSWORD', $pass);
        $this->db->where('user_id', $userid);
        $query = $this->db->get();

        $row = $query->num_rows();
        if ($row > 0) {
            $detail['status'] = true;
        }
        return $detail;
    }

    public function updateProfile($userid, $tprefix, $detail) {

        $this->db->where('user_detail_refid', $userid);
        $this->db->update($tprefix . '_user_details', $detail);
        $result = $this->db->affected_rows();
        if ($result > 0) {
            $response['status'] = 'true';
        } else {
            $response['status'] = 'false';
        }
        return $response;
    }

    public function changePassword($userid, $tprefix, $newpass) {

        $detail = array('status' => false);
        $new = md5($newpass);

        $data = array('password' => $new);
        $this->db->where('user_id', $userid);
        $this->db->update($tprefix . '_login_user', $data);

        $result = $this->db->affected_rows();
        if ($result > 0) {
            $detail['status'] = true;
        }
        return $detail;
    }

    public function updateMailStatus($tprefix, $mailid) {

        $detail = array('status' => false);
        $data = array('read_msg' => 'yes');

        $this->db->where('mailtousid', $mailid);
        $this->db->update($tprefix . '_mailtouser', $data);

        $result = $this->db->affected_rows();
        if ($result > 0) {

            $detail['status'] = true;
        }
        return $detail;
    }

    public function getCountry() {

        $this->db->select('country_id,country_name,country_code,phone_code,iso_code_3');
        $query = $this->db->get('mat_country_all');
        $detail = array();
        $i = 0;
        foreach ($query->result() as $row) {
            $detail["$i"]['id'] = $row->country_id;
            $detail["$i"]['name'] = $row->country_name;
            $detail["$i"]['code'] = $row->country_code;
            $detail["$i"]['phonecode'] = $row->phone_code;
            $detail["$i"]['isocode'] = $row->iso_code_3;
            $i++;
        }
        $detail['count'] = $i;
        return $detail;
    }

    public function getState() {

        $query = $this->db->get('mat_life_state');
        $detail = array();
        $i = 0;
        foreach ($query->result() as $row) {

            $detail["$i"]['code'] = $row->code;
            $detail["$i"]['countryid'] = $row->country_id;
            $detail["$i"]['name'] = $row->State_Name;
            $detail["$i"]['stateid'] = $row->State_Id;
            $detail["$i"]['status'] = $row->status;
            $i++;
        }
        $detail['count'] = $i;
        return $detail;
    }

    public function getStartId($prefix, $userid) {

        $this->db->select_max('user_detail_refid', 'max');
        $this->db->from($prefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);

        $query = $this->db->get();
        $row = $query->row();
        return $row->max;
    }

    public function getLastid($prefix, $userid) {

        $this->db->select_min('user_detail_refid', 'min');
        $this->db->from($prefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);

        $query = $this->db->get();
        $row = $query->row();
        return $row->min;
    }

    public function getRefferalDetailNext($userid, $tprefix, $startid, $limit) {

        $maxlimit = intval($limit) + 1;

        $this->db->select('user_detail_refid,user_detail_name,join_date,user_detail_email,user_detail_country');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);
        $this->db->where('user_detail_refid <', $startid);
        $this->db->order_by('user_detail_refid', 'desc');
        $this->db->limit($maxlimit);
        $query = $this->db->get();

        $detail = array();
        $num = $query->num_rows();
        $detail['fetchedNum'] = $num;
        if ($num == $maxlimit) {
            $detail['count'] = $maxlimit - 1;
        } else {
            $detail['count'] = $num;
        }

        $i = 0;
        $j = 0;

        foreach ($query->result() as $row) {
            if ($j < $detail['count']) {
                $response = array();
                if ($j == 0) {
                    $detail['startidprevious'] = $row->user_detail_refid;
                    $detail['startidnext'] = $row->user_detail_refid;
                } else {
                    $detail['startidnext'] = $row->user_detail_refid;
                }
                $this->db->select('user_name');
                $this->db->from($tprefix . '_ft_individual');
                $this->db->where('id', $row->user_detail_refid);
                $query2 = $this->db->get();
                $row2 = $query2->row();

                $response['username'] = $row2->user_name;
                $response['userdetailname'] = $row->user_detail_name;
                $response['joindate'] = $row->join_date;
                $response['joindate'] = date('d-m-Y', strtotime($response['joindate']));
                $response['email'] = $row->user_detail_email;
                $response['country'] = $row->user_detail_country;

                $detail[$i] = $response;
                unset($response);

                $i++;
                ++$j;
            }
        }
        return $detail;
    }

    public function getRefferalDetailPrevious($userid, $tprefix, $startid, $limit) {

        $maxlimit = intval($limit) + 1;

        $this->db->select('user_detail_refid, user_detail_name,join_date,user_detail_email,user_detail_country');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);
        $this->db->where('user_detail_refid >', $startid);
        $this->db->order_by('user_detail_refid', 'asc');
        $this->db->limit($maxlimit);
        $query = $this->db->get();

        $detail = array();
        $num = $query->num_rows();
        $detail['fetchedNum'] = $num;
        if ($num == $maxlimit) {
            $detail['count'] = $maxlimit - 1;
        } else {
            $detail['count'] = $num;
        }
        $i = 0;
        $j = 0;
        foreach ($query->result() as $row) {
            if ($j < $detail['count']) {
                $response = array();
                if ($j == 0) {
                    $detail['startidnext'] = $row->user_detail_refid;
                    $detail['startidprevious'] = $row->user_detail_refid;
                } else {
                    $detail['startidprevious'] = $row->user_detail_refid;
                }
                $this->db->select('user_name');
                $this->db->from($tprefix . '_ft_individual');
                $this->db->where('id', $row->user_detail_refid);
                $query2 = $this->db->get();

                $row2 = $query2->row();

                $response['username'] = $row2->user_name;
                $response['userdetailname'] = $row->user_detail_name;
                $response['joindate'] = $row->join_date;
                $response['joindate'] = date('d-m-Y', strtotime($response['joindate']));
                $response['email'] = $row->user_detail_email;
                $response['country'] = $row->user_detail_country;
                $detail[$i] = $response;
                unset($response);
                $i++;
                ++$j;
            }
        }
        return $detail;
    }

    public function getMailStartId($prefix, $userid) {

        $this->db->select_max('mailtousid', 'max');
        $this->db->from($prefix . '_mailtouser');
        $this->db->where('mailtoususer', $userid);
        $query = $this->db->get();

        $row = $query->row();
        return $row->max;
    }

    public function getMailLastId($prefix, $userid) {

        $this->db->select_min('mailtousid', 'min');
        $this->db->from($prefix . '_mailtouser');
        $this->db->where('mailtoususer', $userid);
        $query = $this->db->get();

        $row = $query->row();
        return $row->min;
    }

    public function getMailDetailNext($userid, $tprefix, $startid, $limit) {

        $maxlimit = intval($limit) + 1;

        $this->db->select('mailtousid, mailtoussub,mailtousmsg,mailtousdate,read_msg');
        $this->db->from($tprefix . '_mailtouser');
        $this->db->where('mailtoususer', $userid);
        $this->db->where('mailtousid <', $startid);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailtousid', 'desc');
        $this->db->limit($maxlimit);
        $query = $this->db->get();

        $detail = array();
        $num = $query->num_rows();
        $detail['fetchedNum'] = $num;
        if ($num == $maxlimit) {
            $detail['count'] = $maxlimit - 1;
        } else {
            $detail['count'] = $num;
        }
        $i = 0;
        $j = 0;
        foreach ($query->result() as $row) {
            if ($j < $detail['count']) {
                $response = array();
                if ($j == 0) {
                    $detail['startidprevious'] = $row->mailtousid;
                    $detail['startidnext'] = $row->mailtousid;
                } else {
                    $detail['startidnext'] = $row->mailtousid;
                }
                $response['id'] = $row->mailtousid;
                $response['sub'] = $row->mailtoussub;
                $response['msg'] = $row->mailtousmsg;
                $response['date'] = $row->mailtousdate;
                $response['date'] = date('d-m-Y', strtotime($response['date']));
                $response['read'] = $row->read_msg;
                $detail[$i] = $response;
                unset($response);

                $i++;
                ++$j;
            }
        }
        return $detail;
    }

    public function getMailDetailPrevious($userid, $tprefix, $startid, $limit) {

        $maxlimit = intval($limit) + 1;

        $this->db->select('mailtousid, mailtoussub,mailtousmsg,mailtousdate,read_msg');
        $this->db->from($tprefix . '_mailtouser');
        $this->db->where('mailtoususer', $userid);
        $this->db->where('mailtousid >', $startid);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailtousid', 'asc');
        $this->db->limit($maxlimit);
        $query = $this->db->get();

        $detail = array();
        $num = $query->num_rows();
        $detail['fetchedNum'] = $num;

        if ($num == $maxlimit) {
            $detail['count'] = $maxlimit - 1;
        } else {
            $detail['count'] = $num;
        }
        $i = 0;
        $j = 0;

        foreach ($query->result() as $row) {
            if ($j < $detail['count']) {
                $response = array();
                if ($j == 0) {
                    $detail['startidprevious'] = $row->mailtousid;
                    $detail['startidnext'] = $row->mailtousid;
                } else {
                    $detail['startidprevious'] = $row->mailtousid;
                }
                $response['id'] = $row->mailtousid;
                $response['sub'] = $row->mailtoussub;
                $response['msg'] = $row->mailtousmsg;
                $response['date'] = $row->mailtousdate;
                $response['date'] = date('d-m-Y', strtotime($response['date']));
                $response['read'] = $row->read_msg;
                $detail[$i] = $response;
                unset($response);

                $i++;
                ++$j;
            }
        }
        return $detail;
    }

    public function getRefferalNameNext($userid, $tprefix, $startid, $limit) {

        $maxlimit = intval($limit) + 1;

        $this->db->select('user_detail_refid, user_detail_name');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);
        $this->db->where('user_detail_refid <', $startid);
        $this->db->order_by('user_detail_refid', 'desc');
        $this->db->limit($maxlimit);
        $query = $this->db->get();

        $detail = array();
        $num = $query->num_rows();
        $detail['fetchedNum'] = $num;
        if ($num == $maxlimit) {
            $detail['count'] = $maxlimit - 1;
        } else {
            $detail['count'] = $num;
        }
        $i = 0;
        $j = 0;
        foreach ($query->result() as $row) {
            if ($j < $detail['count']) {
                $response = array();
                if ($j == 0) {
                    $detail['startidprevious'] = $row->user_detail_refid;
                    $detail['startidnext'] = $row->user_detail_refid;
                } else {
                    $detail['startidnext'] = $row->user_detail_refid;
                }

                $response['username'] = $row->user_detail_name;
                $detail[$i] = $response;
                unset($response);
                $i++;
                ++$j;
            }
        }
        return $detail;
    }

    public function getRefferalNamePrevious($userid, $tprefix, $startid, $limit) {

        $maxlimit = intval($limit) + 1;

        $this->db->select('user_detail_refid, user_detail_name');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_details_ref_user_id', $userid);
        $this->db->where('user_detail_refid >', $startid);
        $this->db->order_by('user_detail_refid', 'asc');
        $this->db->limit($maxlimit);
        $query = $this->db->get();

        $detail = array();
        $num = $query->num_rows();
        $detail['fetchedNum'] = $num;
        if ($num == $maxlimit) {
            $detail['count'] = $maxlimit - 1;
        } else {
            $detail['count'] = $num;
        }

        $i = 0;
        $j = 0;

        foreach ($query->result() as $row) {
            if ($j < $detail['count']) {
                $response = array();
                if ($j == 0) {
                    $detail['startidnext'] = $row->user_detail_refid;
                    $detail['startidprevious'] = $row->user_detail_refid;
                } else {
                    $detail['startidprevious'] = $row->user_detail_refid;
                }
                $response['username'] = $row->user_detail_name;
                $detail[$i] = $response;
                unset($response);
                $i++;
                ++$j;
            }
        }
        return $detail;
    }

    public function checkValidSponser($username, $tprefix) {

        $table = $tprefix . '_ft_individual';
        $this->db->from($table);
        $this->db->where('user_name', $username);
        $this->db->where('active !=', 'server');
        $qr = $this->db->get();
        $cnt = $qr->num_rows();
        if ($cnt > 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getRefferalName($username, $tprefix) {

        $table = $tprefix . '_login_user';
        $user_id = NULL;
        $this->db->select('user_id');
        $this->db->from($table);
        $this->db->where('user_name', $username);
        $query = $this->db->get();
        $row = $query->row();
        $user_id = $row->user_id;

        $user_detail_name = NULL;
        $table = $tprefix . '_user_details';
        $this->db->select('user_detail_name');
        $this->db->from($table);
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();

        $row = $query->row();
        $user_detail_name = $row->user_detail_name;

        return $user_detail_name;
    }

    public function getPlacement($sponsor_id, $position, $tprefix) {

        $table = $tprefix . '_ft_individual';
        $this->db->select('id');
        $this->db->select('active');
        $this->db->from($table);
        $this->db->where('father_id', $sponsor_id);
        $this->db->where('position', $position);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            if ($row->active == 'server') {
                return $sponsor_id;
            } else {
                $placement = $this->getPlacement($row->id, $position, $tprefix);
                return $placement;
            }
        }
    }

    public function userNameToID($username, $tprefix) {

        $table = $tprefix . '_ft_individual';
        $user_id = 0;
        $this->db->select('id');
        $this->db->from($table);
        $this->db->where('user_name', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    public function IdToUserName($user_id, $tprefix) {

        $table = $tprefix . '_ft_individual';
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from($table);
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getProductStatus($tprefix) {

        $this->db->select('product_status');
        $this->db->from($tprefix . '_module_status');
        $query = $this->db->get();
        $row = $query->row();
        return $row->product_status;
    }

    public function isProductAdded($tprefix) {

        $flag = 'no';
        $this->db->select('COUNT(*) AS cnt');
        $this->db->from($tprefix . '_product');
        $qr = $this->db->get();

        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }

        if ($count > 0)
            $flag = 'yes';

        return $flag;
    }

    public function idToFullName($placementid, $tprefix) {

        $this->db->select('user_detail_name');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_detail_refid', $placementid);
        $query = $this->db->get();
        $row = $query->row();
        return $row->user_detail_name;
    }

    public function getProducts($tprefix) {

        $this->db->select('product_id ,product_name,active,date_of_insertion,prod_id,product_value,pair_value,product_qty,prod_bv');
        $this->db->from($tprefix . '_product');
        $this->db->where('active', 'yes');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $product_details[] = $row;
        }
        return $product_details;
    }

    public function getModuleStatus($tprefix) {

        $this->db->select('pin_status,referal_status,product_status,first_pair');
        $this->db->from($tprefix . '_module_status');
        $query = $this->db->get();
        return $query->row();
    }

    public function getUserNameConfig($tprefix) {

        $this->db->select('user_name_type');
        $this->db->from($tprefix . '_username_config');
        $query = $this->db->get();
        $config = $query->row();
        if ($config->user_name_type == 'static') {
            return 'static';
        } else {
            $username = $this->getUsername($tprefix);
            return $username;
        }
    }

    public function getUserNameConfigDetails($tprefix) {

        $query = $this->db->get($tprefix . '_username_config');
        foreach ($query->result_array() as $row) {
            $config['length'] = $row['length'];
            $config['prefix_status'] = $row['prefix_status'];
            $config['prefix'] = $row['prefix'];
        }
        return $config;
    }

    public function getUsername($tprefix) {

        $config = $this->getUserNameConfigDetails($tprefix);
        $length = $config['length'];
        $u_name = $this->getRandId($length, $tprefix);
        if ($config['prefix_status'] == 'yes') {
            $prefix = $config['prefix'];
            $u_name = $prefix . $u_name;
        }
        return $u_name;
    }

    public function getRandId($length, $tprefix) {

        $key = '';
        $charset = "0123456789";
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        $randum_id = $key;
        $config = $this->getUserNameConfigDetails($tprefix);
        $this->db->select('*');
        $this->db->from($tprefix . '_login_user');
        $this->db->where('user_name', $randum_id);
        $query = $this->db->get();

        $count = $query->num_rows();
        if ($count == 0)
            return $key;
        else
            $this->getRandId($length, $tprefix);
    }

    public function getLicesnse($tprefix) {
        $this->db->select('terms_conditions');
        $this->db->from($tprefix . '_terms_conditions');
        $this->db->where('id', '6');
        $query = $this->db->get();
        $row = $query->row();
        $license = $row->terms_conditions;
        return $license;
    }

    public function confirmRegister($tprefix, $details, $pay_type) {

        $this->db->trans_begin();
        $this->load->model('android/androidregistersubmit');
        $reg = new AndroidRegisterSubmit();
        $regr = array();
        $max_nod_id = $reg->getMaxOrderID($tprefix);
        $next_order_id = $max_nod_id + 1;

        $regr['fatherid'] = $this->userNameToID($details['placementusername'], $tprefix);
        $regr['referral_id'] = $this->userNameToID($details['sponserusername'], $tprefix);
        $regr['product_id'] = $details['productid'];
        $regr['username'] = $details['username'];
        $regr['joining_date'] = date('Y-m-d H:i:s');

        $child_node = $reg->getChildNodeId($tprefix, $regr['fatherid'], $details['position']);

        $updt_login_res = $res_login_update = $reg->updateLoginUser($tprefix, $details['username'], md5($details['password']), $child_node);

        if ($res_login_update) {
            $user_level = $reg->getLevel($tprefix, $regr['fatherid']) + 1;
            $updt_ft_res = $res_ftindi_update = $reg->updateFTIndividual($tprefix, $regr['fatherid'], $details['position'], $details['username'], $child_node, $user_level, $details['productid'], $next_order_id, $pay_type);

            if ($res_ftindi_update) {
                $last_insert_id = $this->userNameToID($details['username'], $tprefix);
                $regr['userid'] = $last_insert_id;

                $details['loginuser'] = $this->userNameToID($details['loginuser'], $tprefix);

                //$updt_ft_uni = $reg->insertToUnilevelTree($tprefix,$regr);
                $insert_user_det_res = $res = $reg->insertUserDetails($tprefix, $regr, $details);

                $id = $insert_tmp1_res = $res1 = $reg->tmpInsert($tprefix, $last_insert_id, 'L');
                $insert_tmp2_res = $res1 = $reg->tmpInsert($tprefix, $last_insert_id, 'R');
                $insert_tmp2_res = $res1 = 1;
            }
        }

        $rank_status = $this->getRankStatus($tprefix);
        $balance_amount = 0;
        if ($rank_status == 'yes') {
            $referal_count = $this->getReferalCount($tprefix, $regr['referral_id']);
            $old_rank = $this->getUserRank($tprefix, $regr['referral_id']);
            $regr['rank'] = $this->getCurrentRankFromRankConfig($tprefix, $referal_count);
            $new_rank = $regr['rank'];

            $this->updateUserRank($tprefix, $regr['referral_id'], $new_rank);

            if ($old_rank != $new_rank) {
                $balance_amount = $this->balanceAmount($tprefix, $regr['referral_id']);
                $rank_bonuss = array();
                $rank_bonuss = $this->getAllRankDetails($tprefix, $new_rank);
                $balance_amount = $balance_amount + $rank_bonuss[0]['rank_bonus'];
                $this->updateUsedEwallet($tprefix, $regr['referral_id'], $balance_amount, 'yes');
                $this->insertIntoRankHistory($tprefix, $old_rank, $regr['rank'], $regr['referral_id']);
            }
        }

        $module_status = $this->getModuleStatus($tprefix);

        $product_status = $module_status->product_status;

        $first_pair = $module_status->first_pair;

        $referal_status = $module_status->referal_status;


        if ($referal_status == 'yes') {

            $referal_amount = $this->getReferalAmount($tprefix);
            if ($product_status == 'yes' && $first_pair == '1:1') {
                require_once 'calculation_11_product_model.php';
            } else if ($product_status == 'no' && $first_pair == '1:1') {
                require_once 'calculation_11_without_product_model.php';
            } else if ($product_status == 'yes' && $first_pair == '2:1') {
                require_once 'calculation_21_product_model.php';
            } else if ($product_status == 'no' && $first_pair == '2:1') {
                require_once 'calculation_21_without_product_model.php';
            }
            $obj_calc = new calculation_model();
            $referal_id = $obj_calc->getReferalId($tprefix, $last_insert_id);

            if ($referal_amount > 0) {
                $raferal_amount = $balance_amount + $referal_amount;
                $ref_amt = $obj_calc->insertReferalAmount($tprefix, $referal_id, $referal_amount, $regr['userid']);
            }
        }

        if ($product_status == 'yes') {
            if ($first_pair == '2:1') {
                require_once 'calculation_21_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($tprefix, $regr['userid'], $regr['fatherid'], $regr['product_id'], $details['position'], $regr['userid']);
            } else {
                require_once 'calculation_11_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($tprefix, $regr['userid'], $regr['fatherid'], $regr['product_id'], $details['position'], $regr['userid']);
            }
        } else {
            if ($first_pair == '2:1') {
                require_once 'calculation_21_without_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($tprefix, $regr['userid'], $regr['fatherid'], $details['position'], $regr['userid']);
            } else {
                require_once 'calculation_11_without_product_model.php';
                $obj_calc = new calculation_model();
                $obj_calc->calculateLegCount($tprefix, $regr['userid'], $regr['fatherid'], $details['position'], $regr['referral_id'], $regr['userid']);
            }
        }

        if (($updt_ft_res) && ($updt_login_res) && ($insert_user_det_res) && ($insert_tmp1_res) && ($insert_tmp2_res)) {
            $username = $regr['username'];

            $site_info = $this->getSiteConfiguration($tprefix);
            $site_name = $site_info['co_name'];
            $site_logo = $site_info['logo'];
            $base_url = base_url();

            $tran_code = $reg->getRandTransPasscode($tprefix, 8);

            $reg->savePassCodes($tprefix, $last_insert_id, $tran_code);

            if (( $details['email'] != '') && ( $details['email'] != null)) {
                $reg_mail = $this->checkMailStatus($tprefix);
                if ($reg_mail['reg_mail_status'] == 'yes') {
                    $email = $details['email'];
                    $mail_content = $reg->getMailBody($tprefix);
                    $subject = $site_name . 'Registration Notification';

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
                                                        <h1 style="font: normal 20px Tahoma, Geneva, sans-serif;">Dear <font color="#e10000">' . $details["name"] . ',</font></h1><br>
                                                       <p style="font: normal 12px Tahoma, Geneva, sans-serif;text-align:justify;color:#212121;line-height:23px;">' . $mail_content . '</p>
                                                        <div style="width:400px;height:225px;margin:16px auto;background:url' . $base_url . 'public_html/images/page.png);border: solid 1px #d0d0d0;border-radius: 10px;">
                                                          <img src="' . $base_url . 'public_html/images/login-icons.png" width="35px" height="35px" style="float:left;margin-top:10px;margin-left:10px;"/><h2 style="color:#C70716;font:normal 16px Tahoma, Geneva, sans-serif;line-height:34px;margin:10px 0 0 22px;float:left;padding-left: 0px;">LOGIN DETAILS</h2>
                                                          <div style="clear:both;"></div>
                                                          <ul style="display:block;margin:14px 0 0 -36px;float:left;">
                                                            <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;"> Login Link</span><font color="#025BB9"> : <a href=' . "$base_url" . '>Click Here</a></font></li>
                                                            
                                                            <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;">Your UserName</span><font color="#e10000"> : ' . $details["username"] . '</font></li>
                                                            <li style="list-style:none;font:normal 15px Tahoma, Geneva, sans-serif;color:#212121;margin:5px 0 0 20px;border:1px solid #ccc;background:#fff;width:300px;padding:5px;"><span style="width:150px;float:left;">Your Password</span><font color="#e10000"> : ' . $details["password"] . '</font></li>
                                                          </ul>
                                                        </div>
                                                        <p><br /><br /><br /><br /> </p>
                                                      </div>

                                                    </div>
                                                </body>
                                            </html>';

                    $reg->sendEmail($tprefix, $mailBodyDetails, $regr['userid'], $subject);
                }
            }
            $reg->insertBalanceAmount($tprefix, $regr['userid']);
            $encr_id = $details['loginuser'];
            $encr_id = $this->getEncrypt($encr_id);

            $this->db->trans_complete();
            $msg['user'] = $username;
            $msg['pwd'] = $details['password'];
            $msg['id'] = $encr_id;
            $msg['status'] = 'true';
            $msg['tran'] = $tran_code;
            return $msg;
        } else {
            $this->db->trans_rollback();
            $encr_id = $details['loginuser'];
            $encr_id = $this->getEncrypt($encr_id);

            $msg['user'] = '';
            $msg['pwd'] = '';
            $msg['id'] = '';
            $msg['status'] = 'false';
            $msg['tran'] = '';
            return $msg;
        }
    }

    public function getRankStatus($tprefix) {
        $this->db->select('rank_status');
        $this->db->from($tprefix . '_module_status');
        $query = $this->db->get();
        $row = $query->row();
        return $row->rank_status;
    }

    public function getReferalAmount($tprefix) {
        $referal_amount = '';
        $this->db->select('referal_amount');
        $this->db->from($tprefix . '_configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $referal_amount = $row->referal_amount;
        }
        return $referal_amount;
    }

    public function getSiteConfiguration($tprefix) {
        $this->db->select('*');
        $this->db->from($tprefix . '_site_information');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $site_info_arr['co_name'] = $row['company_name'];
            $site_info_arr['company_address'] = $row['company_address'];
            $site_info_arr['logo'] = $row['logo'];
            $site_info_arr['email'] = $row['email'];
            $site_info_arr['phone'] = $row['phone'];
            $site_info_arr['favicon'] = $row['favicon'];
            $site_info_arr['default_lang'] = $row['default_lang'];
        }

        return $site_info_arr;
    }

    public function checkMailStatus($tprefix) {
        $stat = NULL;
        $this->db->select('from_name');
        $this->db->select('reg_mail_status');
        $this->db->from($tprefix . '_mail_settings');
        $this->db->where('id', 1);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $stat = $row;
        }
        return $stat;
    }

    function getEncrypt($string) {
        $key = "EASY1055MLM!@#$";
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }

    public function getReferalCount($tprefix, $id) {
        $count = NULL;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from($tprefix . '_ft_individual');
        $this->db->where('sponsor_id', $id);

        $this->db->where('active !=', 'server');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getUserRank($tprefix, $id) {
        $rank = NULL;
        $this->db->select('user_rank_id');
        $this->db->from($tprefix . '_ft_individual');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $rank = $row->user_rank_id;
        }
        return $rank;
    }

    public function getCurrentRankFromRankConfig($tprefix, $num) {
        $rank_id = 0;
        $count = $this->getRefferalCount($tprefix, $num);
        $this->db->select('rank_id');
        $this->db->where('referal_count', $count);
        $this->db->limit(1);
        $res = $this->db->get($tprefix . '_rank_details');
        foreach ($res->result() as $row) {
            $rank_id = $row->rank_id;
        }
        return $rank_id;
    }

    public function getRefferalCount($tprefix, $num) {
        $count = 0;
        $this->db->select_max('referal_count');
        $this->db->where('referal_count <', $num);
        $this->db->limit(1);
        $res = $this->db->get($tprefix . '_rank_details');

        foreach ($res->result() as $row) {
            $count = $row->referal_count;
        }
        return $num;
    }

    public function updateUserRank($tprefix, $id, $rank) {
        $this->db->set('user_rank_id', $rank);
        $this->db->where('id', $id);
        $result = $this->db->update($tprefix . '_ft_individual');
        return $result;
    }

    public function balanceAmount($tprefix, $user_id, $balance = '') {
        $user_balance = NULL;
        $this->db->select('balance_amount');
        $this->db->select('user_id');
        $this->db->where('user_id', $user_id);
        if ($balance != '')
            $this->db->where('balance_amount >', $balance);
        $this->db->from($tprefix . '_user_balance_amount');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {

            $user_balance = $row['balance_amount'];
        }
        return $user_balance;
    }

    public function getAllRankDetails($tprefix, $rank_id = '') {
        $arr = array();
        if ($rank_id != '')
            $this->db->where('rank_id', $rank_id);
        $query = $this->db->get($tprefix . '_rank_details');
        //echo $this->db->last_query();
        $i = 0;
        foreach ($query->result() as $row) {
            $arr[$i]['rank_id'] = $row->rank_id;
            $arr[$i]['rank_name'] = $row->rank_name;
            $arr[$i]['referal_count'] = $row->referal_count;
            $arr[$i]['rank_bonus'] = $row->rank_bonus;

            $i++;
        }

        return $arr;
    }

    public function updateUsedEwallet($tprefix, $ewallet_user, $ewallet_bal, $up_bal = '') {
        if ($up_bal == '') {
            $user_id = $this->userNameToID($ewallet_user, $tprefix);
        } else {
            $user_id = $ewallet_user;
        }
        $this->db->set('balance_amount', round($ewallet_bal, 2));
        $this->db->where('user_id', $user_id);
        $result = $this->db->update($tprefix . '_user_balance_amount');
        return $result;
    }

    public function insertIntoRankHistory($tprefix, $old_rank, $new_rank, $ref_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $ref_id);
        $this->db->set('current_rank', $old_rank);
        $this->db->set('new_rank', $new_rank);
        $this->db->set('date', $date);
        $res = $this->db->insert($tprefix . '_rank_history');
        return $res;
    }

    public function getPayways($tprefix) {
        $ways = array();
        $this->db->from($tprefix . '_payment_methods');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->payment_type == 'Payment Gateway') {
                $ways['gateway'] = $row->status;
            }
            if ($row->payment_type == 'E-pin') {
                $ways['epin'] = $row->status;
            }
            if ($row->payment_type == 'E-wallet') {
                $ways['ewallet'] = $row->status;
            }
            if ($row->payment_type == 'Free Joining') {
                $ways['freejoin'] = $row->status;
            }
        }
        if ($ways['gateway'] == 'yes') {
            $this->db->from($tprefix . '_payment_gateway_config');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                if ($row->gateway_name == 'Paypal') {
                    $ways['paypal'] = $row->status;
                }
                if ($row->gateway_name == 'Creditcard') {
                    $ways['credit'] = $row->status;
                }
                if ($row->gateway_name == 'EPDQ') {
                    $ways['epdq'] = $row->status;
                }
            }
        }
        return $ways;
    }

    public function validate($tprefix, $username) {
        $this->db->from($tprefix . '_ft_individual');
        $this->db->where('user_name', $username);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getRegisterAmount($tprefix) {
        $amount = NULL;
        $this->db->select('reg_amount');
        $this->db->from($tprefix . '_configuration');
        $res = $this->db->get();
        foreach ($res->result() as $row) {

            $amount = $row->reg_amount;
        }

        return $amount;
    }

    public function getEpin($tprefix, $epin) {
        $epin_arr = array();
        $date = date('Y-m-d');
        $this->db->select('pin_numbers,pin_balance_amount');
        $this->db->from($tprefix . '_pin_numbers');
        $this->db->where('pin_numbers', $epin);
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $row) {
                $epin_arr['pin_numbers'] = $row['pin_numbers'];
                $epin_arr['pin_amount'] = $row['pin_balance_amount'];
            }
        } else {
            $epin_arr['pin_numbers'] = 'nopin';
        }

        return $epin_arr;
    }

    public function insertUsedPin($tprefix, $pindetail, $length, $loginuser) {
        $date = date('Y-m-d');
        $loginuser = $this->userNameToID($loginuser, $tprefix);

        for ($i = 0; $i < $length; $i++) {
            $pin_no = $pindetail['pin' . $i];
            $pin_balance = intval($pindetail['amount' . $i]);
            $pin_amount = intval($this->getEpinAmount($pin_no, $tprefix));
            if ($pin_balance == 0)
                $this->db->set('status', 'no');
            else
                $this->db->set('status', 'yes');
            $this->db->set('pin_number', $pin_no);
            $this->db->set('used_user', $loginuser);
            $this->db->set('pin_alloc_date', $date);
            $this->db->set('pin_amount', round($pin_amount, 2));
            $this->db->set('pin_balance_amount', $pindetail['amount' . $i]);
            $res = $this->db->insert($tprefix . '_pin_used');
        }
        return $res;
    }

    public function getEpinAmount($pin_no, $tprefix) {
        $date = date('Y-m-d');
        $this->db->select('pin_balance_amount');
        $this->db->from($tprefix . '_pin_numbers');
        $this->db->where('pin_numbers', $pin_no);
        $this->db->where('status', 'yes');
        $this->db->where("pin_expiry_date >=", $date);
        $res = $this->db->get();
        $row = $res->row();
        return $row->pin_balance_amount;
    }

    public function updateUsedEpin($tprefix, $pin_detail, $length, $loginuser) {
        $loginuser = $this->userNameToID($loginuser, $tprefix);
        $date = date('Y-m-d');
        for ($i = 0; $i < $length; $i++) {
            $pin_no = $pin_detail['pin' . $i];
            $pin_balnce = floatval($pin_detail['amount' . $i]);
            if ($pin_balnce == 0) {
                $this->db->set('status', 'no');
            } else {
                $this->db->set('status', 'yes');
            }
            $this->db->set('pin_alloc_date', $date);
            $this->db->set('used_user', $loginuser);
            $this->db->set('pin_balance_amount', round($pin_balnce, 2));
            $this->db->where('pin_numbers', $pin_no);
            $result = $this->db->update($tprefix . '_pin_numbers');
        }
        return $result;
    }

    public function insertpaymentDetails($tprefix, $paypal_details) {
        $paypal_details['user_id'] = $this->userNameToID($paypal_details['user_id'], $tprefix);
        $this->db->insert($tprefix . '_payment_registration_details', $paypal_details);
    }

    public function insertIntoSalesOrder($tprefix, $loginuser, $pid, $payment_method) {
        $date = date('Y-m-d H:i:s');
        $last_inserted_id = $this->getMaxIdUserBalance($tprefix);
        $invoice_no = 1000 + $last_inserted_id;
        $product_details = $this->getProduct($tprefix, $pid);
        $amount = $product_details['product_value'];
        $user_id = $this->userNameToID($loginuser, $tprefix);
        $this->db->set('invoice_no', $invoice_no);
        $this->db->set('prod_id', $pid);
        $this->db->set('user_id', $user_id);
        $this->db->set('amount', round($amount, 2));
        $this->db->set('date_submission', $date);
        $this->db->set('payment_method', $payment_method);
        $res = $this->db->insert($tprefix . '_sales_order');
    }

    public function getMaxIdUserBalance($tprefix) {
        $max_order_id = '';
        $this->db->select_max('id', 'id');
        $this->db->from($tprefix . '_user_balance_amount');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_order_id = $row->id;
        }
        return $max_order_id;
    }

    public function getProduct($tprefix, $prdtid) {
        $product = array();
        $this->db->select('*');
        $this->db->from($tprefix . '_product');
        $this->db->where('product_id', $prdtid);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $product['product_id'] = $row->product_id;
            $product['product_name'] = $row->product_name;
            $product['active'] = $row->active;
            $product['product_value'] = $row->product_value;
            $product['prod_bv'] = $row->prod_bv;
            $product['pair_value'] = $row->pair_value;
        }
        return $product;
    }

    public function checkUpdate($version) {
        $this->db->select('maintenance');
        $this->db->from('androidappcontrol');
        $query = $this->db->get();
        $row = $query->row();
        if ($row->maintenance == 'yes') {
            return 'maintenance';
        } else {
            $this->db->select('update');
            $this->db->from('androidappcontrol');
            $result = $this->db->get();
            $row = $result->row();
            $version_now = $row->update;
            $version_now = (floatval($version_now));
            if ($version_now > (floatval($version))) {
                return 'update';
            } else {
                return 'true';
            }
        }
    }

    public function updatepaymentDetails($tprefix, $paypal_details) {
        $this->db->set('payer_id', $paypal_details['payer_id']);
        $this->db->where('order_id', $paypal_details['order_id']);
        $this->db->update($tprefix . '_payment_registration_details');
    }

    public function updateActivity($tprefix, $login_id, $activity = '') {
        $login_id = $this->userNameToID($login_id, $tprefix);

        $date = date('Y-m-d H:i:s');
        $ip_adress = $_SERVER['REMOTE_ADDR'];
        $this->db->set('user_id', $login_id);
        $this->db->set('done_by', $login_id);
        $this->db->set('activity', $activity);
        $this->db->set('ip', $ip_adress);
        $this->db->set('date', $date);
        $this->db->insert($tprefix . '_activity_history');
        if ($this->db->affected_rows() > 0) {
            return 'true';
        }
    }

    public function checkUser($userid, $tprefix) {
        $this->db->where('id', $userid);
        $query = $this->db->get($tprefix . '_ft_individual');
        if ($query->num_rows() > 0) {
            return 'yes';
        } else {
            return 'no';
        }
    }

    public function setMobileSession() {
        $session_data = array(
            "user_id" => 53,
            "user_name" => 'binaryadmin',
            "user_type" => 'admin',
            "admin_user_id" => 53,
            "admin_user_name" => 'binaryadmin',
            "table_prefix" => "53_",
            "mlm_plan" => "Binary",
            "is_logged_in" => true,
        );


        $this->inf_model->trackModule();
        $sess_array['mlm_plan'] = $this->inf_model->MODULE_STATUS['mlm_plan'];
        $this->session->set_userdata('mobile_logged_in', $session_data);
    }

    public function updateUserDetails($regr, $uid) {
        echo "kkkk";die();
        $this->db->where('user_detail_refid', $uid);
        $reg_update = array(
            'user_detail_second_name' => $regr['second_name'],
            'user_detail_address' => $regr['address'],
            'user_detail_address2' => $regr['address_line2'],
            'user_detail_country' => $regr['country'],
            'user_detail_state' => $regr['state'],
            'user_detail_city' => $regr['city'],
            'user_detail_mobile' => $regr['mobile'],
            'user_detail_land' => $regr['land_line'],
            'user_detail_email' => $regr['email'],
            'user_detail_pin' => $regr['pin'],
            'user_detail_acnumber' => $regr['bank_acc_no'],
            'user_detail_ifsc' => $regr['ifsc'],
            'user_detail_nbank' => $regr['bank_name'],
            'user_detail_nbranch' => $regr['bank_branch'],
            'user_detail_pan' => $regr['pan_no'],
            'user_detail_dob' => $regr['date_of_birth'],
            'user_detail_gender' => $regr['gender']
        );

        $reg_res = $this->db->update('user_details', $reg_update);
        return $reg_res;
    }

}
