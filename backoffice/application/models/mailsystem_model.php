<?php

/**
 * Global model intended to group all mail/messages separated functions
 * 
 * Extending from default Core_inf_model to ignore all unnecessary
 * inf_model stuff
 */
class mailSystem_model extends Core_inf_model {
    
    // user type constants
    const USER_ADMIN = 'admin';
    const USER_USER = 'user';
    
    // tables constants
    const TBL_MESSAGES_ADMIN = 'mailtoadmin';
    const TBL_MESSAGES_USER = 'mailtouser';
    
    // messages status constant
    const MESSAGE_ALL = 0;
    const MESSAGE_READ = 1;
    const MESSAGE_UNREAD = 2;

    public function __construct() {
        parent::__construct();
    }
    
    public function countUnreadMessages($user, $type)
    {
        if ($type == self::USER_ADMIN) {
            return $this->countAdminUnreadMessages();
        } else {
            return $this->countUserUnreadMessages($user);
        }
    }
    
    protected function countAdminUnreadMessages()
    {
        $this->db->select("COUNT(*) as num");
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        try {
            return $this->db->get(self::TBL_MESSAGES_ADMIN)->row()->num;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return 0;
        }
    }
    
    protected function countUserUnreadMessages($user)
    {
        $this->db->select("COUNT(*) as num");
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $this->db->where('mailtoususer', $user);
        try {
            return $this->db->get(self::TBL_MESSAGES_USER)->row()->num;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return 0;
        }
    }
    
    public function messageHeaderContent($user, $type, $status = self::MESSAGE_ALL) {
        if ($type == self::USER_ADMIN) {
            return $this->messageHeaderContentAdmin($status);
        } else {
            return $this->messageHeaderContentUser($user, $status);
        }
    }
    
    protected function messageHeaderContentAdmin($status)
    {
        $this->db->select('mailadsubject as subject');
        $this->db->select('mailadiddate as date');
        $this->db->select('user_name as username');
        $this->db->select('user_photo as userphoto');
        $this->db->from(self::TBL_MESSAGES_ADMIN);
        $this->db->join('ft_individual', self::TBL_MESSAGES_ADMIN . '.mailaduser = ft_individual.id', 'INNER');
        $this->db->join('user_details', self::TBL_MESSAGES_ADMIN . '.mailaduser = user_details.user_detail_refid', 'LEFT');
        $this->db->where('status', 'yes');
        if ($status != self::MESSAGE_ALL) {
            if ($status == self::MESSAGE_READ) {
                $this->db->where('read_msg', 'yes');
            } else {
                $this->db->where('read_msg', 'no');
            }
        }
        $this->db->order_by("mailadiddate", "desc");
        $this->db->limit(5);
        $result = [];
        foreach ($this->db->get()->result() as $row) {
            if (!$row->userphoto || !file_exists(PROFILE_IMAGES . $row->userphoto)) {
                $row->userphoto = 'nophoto.jpg';
            }
            $result[] = $row;
        }
        return $result;
    }
    
    protected function messageHeaderContentUser($user, $status)
    {
        $this->db->select('mailtoussub as subject');
        $this->db->select('mailtousdate as date');
        $this->db->select('user_name as username');
        $this->db->select('user_photo as userphoto');
        $this->db->from(self::TBL_MESSAGES_USER);
        $this->db->_protect_identifiers = false;
        $this->db->join('login_user', "login_user.user_type = 'admin'", 'LEFT');
        $this->db->_protect_identifiers = true;
        $this->db->join('user_details', 'login_user.user_id = user_details.user_detail_refid', 'LEFT');
        $this->db->where('status', 'yes');
        if ($status != self::MESSAGE_ALL) {
            if ($status == self::MESSAGE_READ) {
                $this->db->where('read_msg', 'yes');
            } else {
                $this->db->where('read_msg', 'no');
            }
        }
        $this->db->where('mailtoususer', $user);
        $this->db->order_by("mailtousdate", "desc");
        $this->db->limit(5);
        $result = [];
        foreach ($this->db->get()->result() as $row) {
            if (!$row->userphoto || !file_exists(PROFILE_IMAGES . $row->userphoto)) {
                $row->userphoto = 'nophoto.jpg';
            }
            $result[] = $row;
        }
        return $result;
    }
    
}