<?php

class profile_class_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function getUserDeatail($qr) {
        $this->user_detail_arr = $this->obj_tool_tip->getUserDetails($qr);

        return $this->user_detail_arr;
    }

    /**
     * Searh for members using supplied keyword
     * @param string $keyword This value will be escaped!
     * @param int $page Entry to start
     * @param int $limit Entry limit per page
     * @return array
     */
    public function searchMember($keyword, $page, $limit) {
        $this->load->model('country_state_model');
        $this->db->select("lu.user_id, lu.user_name");
        $this->db->select("fi.active, fi.father_id, fi.date_of_joining");
        $this->db->select("ud.user_detail_name");
        $this->db->select("COALESCE(IF(ud.user_detail_address = '', NULL, ud.user_detail_address), 'NA') as user_detail_address", false);
        $this->db->select("COALESCE(IF(ud.user_detail_mobile = '', NULL, ud.user_detail_mobile), 'NA') as user_detail_mobile", false);
        $this->db->select("COALESCE(IF(ud.user_detail_town = '', NULL, ud.user_detail_town), 'NA') as user_detail_town", false);
        $this->db->select("COALESCE(IF(ud.user_detail_nominee = '', NULL, ud.user_detail_nominee), 'NA') as user_detail_nominee", false);
        $this->db->select("COALESCE(IF(ud.user_detail_country = '', NULL, ud.user_detail_country), 'NA') as user_detail_country", false);
        $this->db->from("login_user as lu");
        $this->db->join("ft_individual as fi", "lu.user_id = fi.id", "INNER");
        $this->db->join("user_details as ud", "lu.user_id = ud.user_detail_refid", "INNER");
        $where = "lu.user_name LIKE {$this->db->escape($keyword . '%')} OR  ud.user_detail_name LIKE {$this->db->escape($keyword . '%')} OR
          ud.user_detail_address LIKE {$this->db->escape($keyword . '%')} OR ud.user_detail_town LIKE {$this->db->escape($keyword . '%')} OR
          ud.user_detail_mobile LIKE {$this->db->escape($keyword . '%')} OR  ud.user_detail_nominee LIKE {$this->db->escape($keyword . '%')}";
        $this->db->where($where);
        $this->db->order_by("lu.user_id");
        $this->db->limit($limit, $page);
        $query = $this->db->get();

        $arr = $query->result_array();
        
        $query->free_result();
        $this->search_user = null;
        
        foreach ($arr as $i => $row) {
            $this->search_user["detail$i"]["user_id"] = $row['user_id'];
            $id_encode = $this->encrypt->encode($row['user_name']);
            $encrypt_id = urlencode(str_replace("/", "_", $id_encode));
            $row['user_id_en'] = $encrypt_id;
            $row['sponser_name'] = $this->validation_model->IdToUserName($row['father_id']);
            $row['user_detail_country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $this->search_user["detail$i"] = $row;
        }

        return $this->search_user;
    }

    /**
     * Count members that contain supplied keyword
     * @param string $keyword This value will be escaped!
     * @return int
     */
    public function getCountMembers($keyword)
    {
        $this->db->select("COUNT(*) as num");
        $this->db->from("login_user as lu");
        $this->db->join("ft_individual as fi", "lu.user_id = fi.id", "INNER");
        $this->db->join("user_details as ud", "lu.user_id = ud.user_detail_refid", "INNER");
        $where = "lu.user_name LIKE {$this->db->escape($keyword . '%')}  OR  ud.user_detail_name LIKE {$this->db->escape($keyword . '%')} OR
          ud.user_detail_address LIKE {$this->db->escape($keyword . '%')} OR ud.user_detail_town LIKE {$this->db->escape($keyword . '%')} OR
          ud.user_detail_mobile LIKE {$this->db->escape($keyword . '%')} OR  ud.user_detail_nominee LIKE {$this->db->escape($keyword . '%')}";
        $this->db->where($where);
        $query = $this->db->get();
        try {
            $result = $query->row()->num;
        } catch (Exception $ex) {
            $result = 0;
            log_message('error', $ex->getMessage());
        }
        $query->free_result();
        
        return $result;
    }

    public function blockMember($user_id, $status) {

        $this->db->where('id', $user_id);
        $query = $this->db->update('ft_individual', array('active' => $status));
        return $query;
    }

    public function searchMemberPage($keyword) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $login_user = $this->table_prefix . "login_user";
        $ft_individual = $this->table_prefix . "ft_individual";
        $user_details = $this->table_prefix . "user_details";
        $searchpage = "select lu.*,fi.*,ud.* from $login_user as lu inner join $ft_individual as fi on lu.user_id = fi.id inner join $user_details as ud on lu.user_id = ud.user_detail_refid where lu.user_name LIKE '$keyword%'  OR  ud.user_detail_name LIKE '$keyword%' OR ud.user_detail_address LIKE '$keyword%' OR ud.user_detail_town LIKE '$keyword%' OR ud.user_detail_mobile LIKE '$keyword%' OR  ud.user_detail_nominee LIKE '$keyword%'  Order by lu.user_id";

        $search_my_page = $this->selectData($searchpage);
        $cnt = mysql_num_rows($search_my_page);

        return $cnt;
    }

    public function getUserStatus($id) {
        $user_statue = $this->obj_tool_tip->getStatus($id);
        return $user_statue;
    }

    public function dispalyProfileSearchDiv($form_action = '', $div_heading = '', $target = "") {
        ?>
        <div class="box">
            <p class="highlight"><h4><?php $div_heading ?></h4><br />
            <form   name="searchform" action="<?php echo $form_action ?>" method="post" method="post" target="<? echo $target ?>" >
                <table  border="0"  align=''>
                    <tr ><td>Select User Name</td>
                        <td ><input type="text" id="user_name" name="user_name"  onKeyUp="ajax_showOptions(this, 'getCountriesByLetters', 'no', event)" autocomplete="Off" ></td>
                        <td><input type="submit" name="profile_update" value="Submit" class="submit" /></td></tr>
                </table><br />
            </form>
        </div>
        <?php
    }

}
