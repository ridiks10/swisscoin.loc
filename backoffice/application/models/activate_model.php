<?php

class activate_model extends inf_model {

    private $mailObj;

    public function __construct() {
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();

        $this->load->model('profile_class_model');
        $this->load->model('validation_model');
        $this->load->model('page_model');
        $this->load->model('registersubmit_model');
    }

    public function inactivateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'no');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'deactivated');
        }
        return $result;
    }

    public function usertActivationDeactivationHistory($user_id, $type, $status = '') {
        $this->db->set('user_id', $user_id);
        $this->db->set('type', $type);
        $this->db->set('status', $status);
        $result = $this->db->insert('user_activation_deactivation_history');
        return $result;
    }

    public function activateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'activated');
        }
        return $result;
    }

    public function updateSponsorId($user_id, $sponsor_id) {
        $result = FALSE;
        $result = $this->updateSponsorFT($user_id, $sponsor_id);
        if ($result) {
            $result = $this->updateSponsorUssrDetails($user_id, $sponsor_id);
        }
        return $result;
    }

    public function updateSponsorFT($user_id, $sponsor_id) {
        $this->db->set('sponsor_id', $sponsor_id);
        $this->db->where('id', $user_id);
        $this->db->where('active', 'yes');
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function updateSponsorUssrDetails($user_id, $sponsor_id) {
        $this->db->set('user_details_ref_user_id', $sponsor_id);
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $result = $this->db->update('user_details');
        return $result;
    }

    public function insertSponsorNameChangeHistory($user_id, $old_sponsor_id, $new_sponsor_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $user_id);
        $this->db->set('old_sponsor_id', $old_sponsor_id);
        $this->db->set('new_sponsor_id', $new_sponsor_id);
        $this->db->set('date', $date);
        $result = $this->db->insert('sponsor_name_change_history');
        return $result;
    }

    public function checkUsernameExist($user_name) {
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        //$this->db->where('active', 'yes');
        $this->db->where('active !=', 'server');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUserPosition($user_id) {
        $position = "NA";
        $this->db->select('position');
        $this->db->from("ft_individual");
        $this->db->where('id', $user_id);
        $this->db->where('active !=', 'server');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $position = $row->position;
        }
        return $position;
    }

    public function tempInsertUserPosition($father_id, $position) {
        $result = $this->registersubmit_model->tmpInsert($father_id, $position);
        return $result;
    }

    public function ChangeUserPosition($new_user_id, $user_id, $position, $father_id) {

        $result = $this->replacePosition($new_user_id, $user_id, $position, $father_id);
        return $result;
    }

    public function getPosition($user_id) {
        $position = '';
        $this->db->select('position');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $position = $row->position;
        }
        return $position;
    }

    public function replacePosition($new_user_id, $user_id, $position, $father_id) {
        $is_empty_leg = $this->checkIsEmptyLeg($new_user_id, $position);
        if (!$is_empty_leg) {//is empty leg
            $result = $this->replaceEmptyLegWithNewUser($new_user_id, $user_id, $position, $father_id);
        } else {
            $result = FALSE;
        }
        return $result;
    }

    public function checkIsEmptyLeg($new_user_id,$position) {
        $this->db->from('ft_individual');
        $this->db->where('active !=', 'server');
        $this->db->where('father_id', $new_user_id);
        $this->db->where('position', $position);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function replaceEmptyLegWithNewUser($new_user_id, $user_id, $position, $father_id) {
        $is_sponsor = $this->checkSponsor($user_id, $new_user_id);
        if ($is_sponsor) {
            return FALSE;
        } else {
            $result = $this->tempInsertUserPosition($father_id, $position);
            if ($result) {
                $result1 = $this->replaceUser($new_user_id, $user_id, $position);
            }
            if ($result1) {
                $result = $this->deleteExtraEmptyLeg($new_user_id, $user_id, $position);
            }
        }
        return $result;
    }

    public function deleteEmptyLeg($new_user_id, $position = '') {
        $this->db->set('father_id', 0);
        $this->db->where('id', $new_user_id);
        $this->db->where('position', $position);
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function deleteEmptyLegServerEntry($new_user_id, $position = '') {
        $this->db->set('father_id', 0);
        $this->db->where('id', $new_user_id);
        $this->db->where('position', $position);
        $this->db->where('active', 'server');
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function replaceUser($new_user_id, $user_id, $position) {
        $this->db->set('father_id', $new_user_id);
        $this->db->set('position', $position);
        $this->db->where('id', $user_id);
        $this->db->where('active !=', 'server');
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function replaceUserEmpty($new_user_id, $user_id, $position) {
        $this->db->set('father_id', $new_user_id);
        $this->db->set('position', $position);
        $this->db->where('id', $user_id);
        $this->db->where('active !=', 'server');
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function deleteExtraEmptyLeg($new_user_id, $user_id, $position) {
        $this->db->set('father_id', 0);
        $this->db->where('position', $position);
        $this->db->where('father_id', $new_user_id);
        $this->db->where('active', 'server');
        $this->db->limit(1);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function getReplaceChildId($new_user_id, $position) {
        $replace_child_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('father_id', $new_user_id);
        $this->db->where('position', $position);
        $this->db->where('active !=', 'server');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $replace_child_id = $row->id;
        }
        return $replace_child_id;
    }

    public function getLastuserId($user_id, $position) {
        $this->db->select('id');
        $this->db->select('active');
        $this->db->from('ft_individual');
        $this->db->where('father_id', $user_id);
        $this->db->where('position', $position);
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            if ($row->active == "server") {
                return $user_id;
            } else {
                $user_id = $this->getLastuserId($row->id, $position);
                return $user_id;
            }
        }
        return $user_id;
    }

    public function checkSponsor($user_id, $new_user_id) {
        $this->db->select('father_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $new_user_id);
        $this->db->where('active !=', 'server');
        $result = $this->db->get();
        foreach ($result->result() as $row) {
            if ($row->father_id == $user_id) {
                return $user_id;
            } else if ($row->father_id == 0) {
                return 0;
            } else {
                $father_id = $this->checkSponsor($user_id, $row->father_id);
                return $father_id;
            }
        }
        return $father_id;
    }

    public function updateFatherId($father_id, $new_user_id) {
        $this->db->set('father_id', $father_id);
        $this->db->where('id', $new_user_id);
        $this->db->where('active !=', 'server');
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function insertPlacementHistory($from_user_id, $to_user_id, $position) {
        $date = date('Y-m-d H:i:s');
        $data = array("from_user_id" => $from_user_id, "to_user_id" => $to_user_id, "position" => $position, "changed_date" => $date);
        $result = $this->db->insert('placement_history', $data);
        return $result;
    }

    public function addLegIfnotExist($user_id) {
        $this->db->from('ft_individual');
        $this->db->where('father_id', $user_id);
        $this->db->where('position', 'R');
        $this->db->where('active !=', 'server');
        $right_count = $this->db->count_all_results();
        if (!$right_count) {
            $position = "R";
            $this->registersubmit_model->tmpInsert($user_id, $position);
        }
        $this->db->from('ft_individual');
        $this->db->where('father_id', $user_id);
        $this->db->where('position', 'L');
        $this->db->where('active !=', 'server');
        $left_count = $this->db->count_all_results();
        if (!$left_count) {
            $position = "L";
            $this->registersubmit_model->tmpInsert($user_id, $position);
        }
        return TRUE;
    }

    public function getCountOfEmptyLegs($new_user_father_id, $position) {
        $this->db->from('ft_individual');
        $this->db->where('father_id', $new_user_father_id);
        $this->db->where('position', $position);
        $count = $this->db->count_all_results();
        return $count;
    }

}
