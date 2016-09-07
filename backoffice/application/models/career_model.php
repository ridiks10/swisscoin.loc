<?php
/**
 * @property  direct_bonuses_model $direct_bonuses_model
 * @property  ft_individual_model $ft_individual_model
 */
class career_model extends inf_model {

    const USER                 = 0;
    const JADE                 = 8;
    const PEARL                = 9;
    const SAPHIRE              = 1;
    const RUBY                 = 2;
    const EMERALD              = 3;
    const DIAMOND              = 4;
    const BLUE_DIAMOND         = 5;
    const GREEN_DIAMOND        = 10;
    const PURPLE_DIAMOND       = 11;
    const RED_DIAMOND          = 12;
    const BLACK_DIAMOND        = 6;
    const DOUBLE_BLACK_DIAMOND = 7;

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        
    }
    public function addCarrer($leadership_rank, $leadership_award,$qualifying_personal_pv,$qualifying_weaker_leg_bv,$qualifying_terms,$image_name,$updateid=''){
        $date = date('Y-m-d H:i:s');
        $this->db->set('leadership_rank', $leadership_rank);
        $this->db->set('leadership_award', $leadership_award);
        $this->db->set('date', $date);
        $this->db->set('qualifying_personal_pv', $qualifying_personal_pv);
        $this->db->set('qualifying_weaker_leg_bv', $qualifying_weaker_leg_bv);
        $this->db->set('qualifying_terms', $qualifying_terms);
        $this->db->set('image_name', $image_name);
        if($updateid!=""){
             $this->db->where('id', $updateid);
             $result = $this->db->update('careers');
        }else{
             $result = $this->db->insert('careers');
        }
       
        return $result;  
    }
    public function getAllCareers($id = NULL){

        $this->db
            ->select('*')
            ->from('careers')
            ->order_by('order');
        if($id){
            return $this->db
                ->where('id', $id)
                ->get()
                ->first_row('array');
        }else{
            $result = $this->db
                ->get()
                ->result_array();
            for($i = count($result) - 1; $i >= 0; $i--){
                $result[$i+1] = $result[$i];
            }
            unset($result[0]);
            return $result;
        }
    }
    
    public function getCarrerStat($user_id) {
        $team_bv = 0;
        $this->db->select('ub.aq_team_bv, ft.career');
        $this->db->from('user_balance_amount as ub');
        $this->db->join('ft_individual as ft', 'ub.user_id = ft.id');
        $this->db->where('ub.user_id', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function updateUserRank( $user_id, $output = false ) {
		$this->load->model( 'ft_individual_model' );

		$conditions = $this->getCareersCondition();
		$tree_users = $this->getNestedUsers( $user_id );
		$parent = $this->career_to_user_id( $user_id );

		if ( empty( $tree_users ) )
			return false;
		foreach ( $tree_users as $level ) {
			if( $output ) echo '<br>======================== NEXT LEVEL ================== <br>';
			foreach ( $level as $user ) {
				$this->_career_distrb( $user, $conditions, $output );
			}
		}
		if( $output ) echo '<br>======================== FIRST LEVEL ================== <br>';
		$this->_career_distrb( current( $parent ), $conditions, $output );


    }

	public function getNestedUsers( $user_ids, $_collection = [ ] )
	{
		if ( ! is_array( $user_ids ) ) {
			$user_ids = [ $user_ids ];
		}

		$this->db->select( 'ub.user_id, ft.career, ub.aq_team_bv, ft.date_of_joining' );
		$this->db->from( 'user_balance_amount as ub' );
		$this->db->join( 'ft_individual as ft', 'ft.id = ub.user_id' );
		$this->db->where( 'ub.aq_team_bv >', 0 );
		$this->db->where( 'ft.active !=', 'server' );
		$this->db->where_in( 'ft.father_id', $user_ids );
		$this->db->order_by( "ft.date_of_joining", "desc" );
		$result  = $this->db->get()->result_array();
		if ( ! empty( $result ) ) {
			array_push( $_collection, $result );
			$_childrens = array_column( $result, 'user_id' );

			return $this->getNestedUsers( $_childrens, $_collection );
		}

		return array_reverse( $_collection );
	}



    /**
     * Helper function because careers stored in stupid order. If you change id of careers than you need to change this
     * @return array;
     */
    public function getCareersCondition()
    {
        $careers = array_values( self::getConstants() );
        $details = array();
        $this->db->select('id, leadership_rank, qualifying_personal_pv, order');
        $this->db->from('careers');
        $this->db->order_by('order');
        $query = $this->db->get();


        array_push( $details, [
            'id'                     => self::USER,
            'leadership_rank'        => 'USER',
            'qualifying_personal_pv' => 0,
            'child'                  => 0,
            'num'                    => 0
        ] );

        foreach ( $query->result_array() as $row ) {

            $i                                       = $row['order'];
            $details[ $i ]['id']                     = $row['id'];
            $details[ $i ]['leadership_rank']        = $row['leadership_rank'];
            $details[ $i ]['qualifying_personal_pv'] = $row['qualifying_personal_pv'];

            switch ( $row['id'] ) {
                case self::JADE :
                    $details[$i]['child'] = $careers;
                    $details[$i]['num'] = 2;
                    break;
                case  self::PEARL:
                    $details[$i]['child'] = array_slice(  $careers, array_search( self::JADE, $careers ) );
                    $details[$i]['num'] = 1;
                    break;
                case self::SAPHIRE :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::JADE, $careers ) );
                    $details[$i]['num'] = 2;
                    break;
                case self::RUBY :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::PEARL, $careers ) );
                    $details[$i]['num'] = 1;
                    break;
                case self::EMERALD :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::SAPHIRE, $careers ) );
                    $details[$i]['num'] = 1;
                    break;
                case self::DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::RUBY, $careers ) );
                    $details[$i]['num'] = 1;
                    break;
                case self::BLUE_DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::EMERALD, $careers ) );
                    $details[$i]['num'] = 1;
                    break;
                case self::GREEN_DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::DIAMOND, $careers ) );
                    $details[$i]['num'] = 1;
                    break;
                case self::PURPLE_DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::DIAMOND, $careers ) );
                    $details[$i]['num'] = 2;
                    break;
                case self::RED_DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::DIAMOND, $careers ) );
                    $details[$i]['num'] = 5;
                    break;
                case self::BLACK_DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::DIAMOND, $careers ) );
                    $details[$i]['num'] = 10;
                    break;
                case self::DOUBLE_BLACK_DIAMOND :
                    $details[$i]['child'] = array_slice( $careers, array_search( self::DIAMOND, $careers ) );
                    $details[$i]['num'] = 20;
                    break;
            }
        }
        return $details;
    }

    private static function getConstants() {
        $cClass = new ReflectionClass(__CLASS__);
        return $cClass->getConstants();
    }

    /**
     * Another helper function to deal with career db order
     * @param array $careers career return helper
     * @param int $id career id
     * @return int career order
     */
    public function getCareerOrderFromId(&$careers, $id) {
        foreach ($careers as $i => $career) {
            if ($career['id'] == $id) {
                return $i;
            }
        }
        return 0;
    }

    public function career_list ()
    {
        $this->db->select('ub.user_id, ft.career, ub.aq_team_bv');
        $this->db->from('user_balance_amount as ub');
        $this->db->join('ft_individual as ft', 'ft.id = ub.user_id');
        $this->db->where('ub.aq_team_bv >', 0);
        $this->db->where('ft.active !=', 'server');
        $this->db->order_by("ft.date_of_joining", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function career_to_user_id ( $user_id )
    {
        $this->db->select('ub.user_id, ft.career, ub.aq_team_bv');
        $this->db->from('user_balance_amount as ub');
        $this->db->join('ft_individual as ft', 'ft.id = ub.user_id');
        $this->db->where('ub.aq_team_bv >', 0);
        $this->db->where('ub.user_id', $user_id );
        $this->db->where('ft.active !=', 'server');
        $this->db->order_by("ft.date_of_joining", "desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function _career_distrb($user, &$conditions, $output = false)
    {
        $this->load->model('ft_individual_model');

        if ($output) echo '<br>user(' . $user['user_id'] . ')->';
        $ind = $old = 0;
        foreach ($conditions as $i => $cnd) {
            if ($cnd['id'] == $user['career']) {
                $ind = $old = $i;
                break;
            }
        }
        if ($output) echo 'old(' . $conditions[$old]['leadership_rank'] . ')';

        $cond = true;
        while ($cond) {
            $ind++;
            if ($output) echo '<br>user(' . $user['user_id'] . ')->qualify for(' . $conditions[$ind]['leadership_rank'] . ')';
            $cond = $user['aq_team_bv'] >= $conditions[$ind]['qualifying_personal_pv'] && $this->ft_individual_model->haveChildrenOfRank($user['user_id'], $conditions[$ind]['child'], $conditions[$ind]['num'], $output);
            if ($output) echo ($user['aq_team_bv'] >= $conditions[$ind]['qualifying_personal_pv'] ? '(' . $conditions[$this->getCareerOrderFromId($conditions, $conditions[$ind]['child'][0])]['leadership_rank'] . ')' : '') .'::team BV(' . $user['aq_team_bv'] . ' of ' . $conditions[$ind]['qualifying_personal_pv'] . ') -- ' . ($cond ? 'true' : 'false');
        }
        $new = $ind - 1;

        if ($new > $old) {
            $this->ft_individual_model->updateCareer($user['user_id'], $conditions[$new]['id']);
        }
    }

    public function updateCareers()
    {
        $this->load->model('ft_individual_model');
        $this->load->model('direct_bonuses_model');

        $user_ids = $this->direct_bonuses_model->getNewUserIds();

        if(empty($user_ids)){
            return 0;
        }

        $users = $this->db
            ->select('ub.user_id,ub.aq_team_bv,ft.career')
            ->from('user_balance_amount as ub')
            ->join('ft_individual as ft', 'ft.id = ub.user_id')
            ->where_in('ub.user_id', $user_ids)
            ->order_by("ub.user_id", "desc")
            ->get()
            ->result_array();

        $conditions = $this->getCareersCondition();

        $count = 0;

        foreach ($users as $user) {

            $ind = $old = 0;
            foreach ($conditions as $i => $cnd) {
                if ($cnd['id'] == $user['career']) {
                    $ind = $old = $i;
                    break;
                }
            }

            $cond = true;
            while ($cond) {
                $ind++;

                $cond = $user['aq_team_bv'] >= $conditions[$ind]['qualifying_personal_pv'] && $this->ft_individual_model->haveChildrenOfRank($user['user_id'], $conditions[$ind]['child'], $conditions[$ind]['num']);
            }
            $new = $ind - 1;

            if ($new > $old) {
                $this->ft_individual_model->updateCareer($user['user_id'], $conditions[$new]['id']);
                $count++;
            }

        }
        return $count;
    }

    
    public function getDiamondCareers()
    {
        $careers = array_values(self::getConstants());
        return array_slice($careers, array_search(self::DIAMOND, $careers));
    }

}