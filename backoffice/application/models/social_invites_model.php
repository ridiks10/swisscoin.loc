<?php

class Social_invites_model extends inf_model {

    public function __construct() {
        
    }

    public function getSocialInviteData($invite_id) {
        $social_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('id', $invite_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $social_details = $row;
        }

        if ($query->num_rows == 0) {
            $social_details['subject'] = '';
            $social_details['content'] = '';
        } else {
            $social_details['subject'] = str_replace("\n", '', trim(stripslashes($social_details['subject'])));
            $social_details['content'] = str_replace("\n", '', trim(stripslashes($social_details['content'])));
        }
        return $social_details;
    }

}
