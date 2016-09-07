<?php
class joining_class_model extends CI_Model {

    /**
     * @deprecated since version 1.21
     */
    public function getUserName($fatherId) {
        log_message('error', 'joining_class_model->getUserName() :: Deprecated call');
        $this->load->model('validation_model');
        $username = $this->validation_model->IdToUserName($fatherId);
        return $username;
    }

    public function allJoining() {

        $ft_individual = $this->table_prefix . "ft_individual";
        $search_my_joinin = "select * from $ft_individual where active!='server' and active NOT LIKE 'terminated%' order by id asc limit $page, $limit";

        //echo $serchpin;
        $search_joining = $this->selectData($search_my_joinin, "Error on selecting all joining....");
        $cnt = mysql_num_rows($search_joining);
        if ($cnt > 0) {
            $i = 0;
            while ($search_active = mysql_fetch_array($search_joining)) {
                $this->all_join["detail$i"]["id"] = $search_active['id'];
                $this->all_join["detail$i"]["user_name"] = $search_active['user_name'];
                $this->all_join["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->all_join["detail$i"]["active"] = $search_active['active'];
                $this->all_join["detail$i"]["father_id"] = $search_active['father_id'];
                $this->all_join["detail$i"]["date_of_joining"] = $search_active['date_of_joining'];
                $this->all_join["detail$i"]["first_pair"] = $search_active['first_pair'];
                $i++;
            }
        }
    }

    /**
     * 
     * @param string $today ESCAPED. Single day or start day if $to is not null
     * @param string|null $to ESCAPED. If not null than end day
     * @param int $page Page num
     * @param int $limit Entries per page
     * @param string $table_prefix Deprecated 1.21
     * @return type
     */
    public function getJoinings($today, $to = null, $page = '', $limit = '',$table_prefix='')
    {
        $this->db->select('fu.id, fu.user_name, fu.active, ff.user_name as father_user, fu.date_of_joining, fu.first_pair, u.user_detail_name as user_full_name, fs.user_name as sponsor_name');
        $this->db->from("ft_individual as fu");
        $this->db->join("user_details as u", "fu.id = u.user_detail_refid", "INNER");
        $this->db->join("ft_individual as ff", "fu.father_id = ff.id", "LEFT");
        $this->db->join("ft_individual as fs", "fu.sponsor_id = fs.id", "LEFT");
        $this->db->where("fu.active NOT LIKE 'server%' AND fu.active NOT LIKE 'terminated%'");
        if (!is_null($to)) {
            $this->db->where("fu.date_of_joining BETWEEN {$this->db->escape($today)} and {$this->db->escape($to)}");
        } else {
            $this->db->where("fu.date_of_joining LIKE {$this->db->escape($today . '%')}");
        }
        $this->db->order_by("date_of_joining", "asc");
        if ($page != "" and $limit != "") {
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get();

        return $query->result_array();
        
    }

    /**
     * @todo Optimization required
     * @param string $date
     * @param int $user_id
     * @return type
     */
    public function todaysJoiningCount($date, $user_id = '') {
        $count = 0;
        if ($user_id == "") {
	    $this->db->select('user_id');
            $this->db->from('login_user AS lu');
            $this->db->join('ft_individual AS ft', 'ft.id = lu.user_id', 'INNER');
            $this->db->where("active NOT LIKE 'server%' AND active NOT LIKE 'terminated%' AND date_of_joining LIKE {$this->db->escape($date . '%')}");
            $this->db->not_like('user_type', 'admin');
            $query = $this->db->get();
	    $numrows = $query->num_rows(); // Number of rows returned from above query.
        } else {
	    $this->db->select('id');
            $this->db->from("ft_individual");
            $this->db->where('sponsor_id', $user_id);
            $this->db->where("date_of_joining LIKE {$this->db->escape($date . '%')}");
            $query = $this->db->get();
	    $numrows = $query->num_rows(); // Number of rows returned from above query.
        }
        return $numrows;
    }

    /**
     * @deprecated since version 1.21
     * @see joining_class_model::getJoinings()
     */
    public function weeklyJoining($from, $to, $page = '', $limit = '')
    {
        log_message('error', 'joining_class_model->weeklyJoining() :: Deprecated call');
        $this->db->select('*');
        $this->db->from("ft_individual");
        $this->db->where("active NOT LIKE 'server%' and active NOT LIKE 'terminated%' and date_of_joining BETWEEN '$from' and '$to'");
        $this->db->order_by("date_of_joining", "asc");
        if ($page != "" and $limit != "") {
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get();

        $this->weekly_join = null;

        foreach ($query->result_array() as $i => $search_active) {
            $this->weekly_join["detail$i"]["id"] = $search_active['id'];
            $this->weekly_join["detail$i"]["user_name"] = $search_active['user_name'];
            $this->weekly_join["detail$i"]["active"] = $search_active['active'];
            $this->weekly_join["detail$i"]["father_id"] = $search_active['father_id'];
            $this->weekly_join["detail$i"]["date_of_joining"] = $search_active['date_of_joining'];
            $this->weekly_join["detail$i"]["first_pair"] = $search_active['first_pair'];
            $this->weekly_join["detail$i"]["user_full_name"]=$this->userFullName($search_active['id']);
            $this->weekly_join["detail$i"]["sponsor_name"]=$this->getSponsorId($search_active['user_name']);
        }
        return $this->weekly_join;
    }
    
    /**
     * @deprecated since version 1.21
     */
    function getSponsorId($user_name)
    {
        log_message('error', 'joining_class_model->getSponsorId() :: Deprecated call');
        $fathers='';
        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('user_name',"$user_name");
        $query = $this->db->get();
        foreach ($query->result() as $father_id) {
                $fathers = $father_id->sponsor_id;
        }
        return $this->getSponsorName($fathers);
        
    }
    /**
     * @deprecated since version 1.21
     */
    public function getSponsorName($user_id)
    {
        log_message('error', 'joining_class_model->getSponsorName() :: Deprecated call');
        $sponsor='';
        $this->db->select('user_name');
        $this->db->from('login_user');
        $this->db->where('user_id',"$user_id");
        $query = $this->db->get();
        foreach ($query->result() as $sponsor_name) {
                $sponsor = $sponsor_name->user_name;
        }
        return $sponsor;
    }
    
    /**
     * @deprecated since version 1.21
     */
    public function userFullName($user_id)
    {
        log_message('error', 'joining_class_model->userFullName() :: Deprecated call');
        $user_full_name='';
        $this->db->select('user_detail_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid',"$user_id");
        $query = $this->db->get();
        foreach ($query->result() as $user_name) {
                $user_full_name = $user_name->user_detail_name;
        }
        return $user_full_name;
        
    }
    /**
     * @todo Optimization required
     * @param string $from From date
     * @param string $to From date
     * @return int
     */
    public function allJoiningpage($from, $to) {
        if ($to == "") {
            $to = $from;
        }
        $from = $from . " 00:00:00";
        $to = $to . " 23:59:59";

        $this->db->select('*');
        $this->db->from("ft_individual");
        $this->db->where("active NOT LIKE 'server%' and active NOT LIKE 'terminated%' and  date_of_joining BETWEEN {$this->db->escape($from)} and {$this->db->escape($to)}");
        $numrows = $this->db->count_all_results(); // Number of rows returned from above query.
        return $numrows;
    }

}