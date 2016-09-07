<?php

class ft_individual_model extends inf_model {

    private $_table = 'ft_individual';
    
    private $teamBonus;
    
    public function __construct() {
        $this->db->select('tb_required_firstliners, tb_first_line_minimum_pack');
        $this->db->limit(1);
        $this->teamBonus = $this->db->get('configuration')->row_array();
    }

    public function updateProduct($user, $product)
    {
        $this->db->set('product_id', $product);
        $this->db->where('id', $user);
        $this->db->where('product_id <', $product);
        if (!$this->db->update($this->_table)) {
            throw new Exception($this->db->_error_message());
        }
    }
    
    public function getFirstliners($user) {
        $this->db->select('id, user_name');
        $this->db->where('father_id', $user);
        $this->db->where('active !=', 'server');
        return $this->db->get($this->_table)->result_array();
    }
    
    /**
     * Find father of user
     * @param int $user id of user
     * @return int|false
     */
    public function getFather($user) {
        $this->db->select('father_id');
        $this->db->where('id', $user);
        try {
            return $this->db->get($this->_table)->row()->father_id;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Determine is user qualify for team bonus distribution
     * @param int $user to check team status
     * @param string $date when check this user status
     * @return boolean
     * @throws Exception on SQL error
     */
    public function qualifyTeamBonus($user, $date = null)
    {
        // this block should crit on any error
        try {
            $this->db->select('COUNT(*) as num');
            $this->db->where('father_id', $user);
            $this->db->where('active !=', 'server');
            $this->db->where('product_id >=', $this->teamBonus['tb_first_line_minimum_pack']);
            if (!empty($date)) {
                $this->db->where('date_of_joining <=', $date);
            }
        } catch (Exception $e) {
            throw $e;
        }
        //this block error mostly mean user do not qualify for team bonus
        try {
            $r = $this->db->get($this->_table)->row()->num;
            return $r >= $this->teamBonus['tb_required_firstliners'];
        } catch (Exception $e) {
            log_message('error', 'Could not get num[' . $this->db->last_query() . ']==>' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Set all users career to 0
     */
    public function discardCareer() {
        $this->db->set('career', 0);
        $this->db->update($this->_table);
    }
    
    /**
     * 
     * @param int $user user whose firstline we will check
     * @param int $rank firstline rank to compare
     * @param int $num required count of firstliners
     * @return type
     */
    public function haveChildrenOfRank($user, $rank, $num, $output = false)
    {
        if (!is_array($rank)) {
            $rank = [$rank];
        }
        $this->db->select('id');
        $this->db->where_in('career', $rank);
        $this->db->where('father_id', $user);
        $this->db->where('active !=', 'server');
        $query = $this->db->get($this->_table);
        if ($output) echo '::(' . $query->num_rows() . ' of ' . $num . ') users of rank';
        return $query->num_rows() >= $num;
    }
    
    /**
     * 
     * @param int $user user id
     * @param int $rank new rank id
     * @return boolean whether ok with save
     */
    public function updateCareer($user, $rank)
    {
        if (!$rank) {
            return false;
        }
        $this->db->set('career', $rank);
        $this->db->where('id', $user);
        $this->db->limit(1);
        $this->db->update($this->_table);
        return true;
    }
    
    public function getDiamondUsers() {
        $this->load->model('career_model');
        $careers = $this->career_model->getDiamondCareers();
        $this->db->_protect_identifiers = false;
        $this->db->select('`ft`.`id`, `ft`.`user_name`, careers.`share`');
        $this->db->from("{$this->_table} as `ft`");
        $this->db->join('careers', "careers.`id` = `ft`.`career` AND `ft`.`active` != 'server'");
        $this->db->where_in('`ft`.`career`', $careers);
        $query = $this->db->get();
        $this->db->_protect_identifiers = true;
        
        return $query->result_array();
    }
    
}
