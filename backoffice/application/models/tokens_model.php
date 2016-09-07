<?php

Class Tokens_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

	public function addSplitsToAllowedPacks( $user_id = null )
	{

		$this->load->model( 'validation_model' );

		$this->db->select( 'oh.id as id' );
		$this->db->from( 'order_history as oh' );
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->where( 'assigned_split < p.splits' );
		if ( ! is_null( $user_id ) ) {
			$this->db->where( 'user_id', $user_id );
		}
		$query = $this->db->get();


		$query = $query->result_array();
		if ( empty( $query ) )
			return false;
		$ids = array_column( $query, 'id' );
		$this->db->set( 'assigned_split', 'assigned_split + 1', false );
		$this->db->where_in( 'id', $ids );

		$this->db->update( 'order_history' );
	}
	public function getCountOfCompletedPacks() {
		$this->db->select('COUNT(`oh`.`id`) as ctr', false );
		$this->db->from('order_history as oh');
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->where( '( `assigned_split` = `p`.`splits` OR `p`.`mining_status` = "YES" ) ' );
		$this->db->where('tax_id IS NULL');
		$this->db->group_by('user_id');
		$this->db->group_by('package');
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function getCompletedPacks( $done ) {
		$this->db->select('oh.user_id');
		$this->db->select('oh.package as package');
		$this->db->select('GROUP_CONCAT(`oh`.`id`) as list', false );
		$this->db->from('order_history oh');
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->where( '( `assigned_split` = `p`.`splits` OR `p`.`mining_status` = "YES" ) ' );
		$this->db->where('oh.tax_id IS NULL');
		$this->db->group_by('oh.user_id');
		$this->db->group_by('oh.package');
		$query = $this->db->get('', 1000);

		return $query->result_array();
	}


	public function insertIntoMining2( array $package )
	{
		$this->begin();
		$result = true;
		$order  = [
			'req_user_id' => intval( $package['user_id'] ),
			'date'        => date( 'Y-m-d H:i:s' )
		];

		$result &= $this->db->insert( 'mining_request', $order );
		$inserted_id = $this->db->insert_id();

		$this->db->set( 'tax_id', intval( $inserted_id ) );
		$this->db->where_in( 'id', array_map( 'intval', explode( ',', $package['list'] ) ) );

		$result &= $this->db->update( 'order_history' );
		if ( $result ) {
			$this->commit();
		} else {
			$this->rollBack();
		}
		return $result;
	}
	public function getLatestSplitLevel() {
		return $this->db->select('MAX(`level`) as level')
				   ->get('mining_request')
				   ->first_row('array')['level'];
	}

	public function resetSplits( ) {
		$result = true;
		$this->db->set('assigned_split', 'assigned_split - 1', false );
		$this->db->where('assigned_split > 0');
		$result &= $this->db->update('order_history');

		$this->db->set('tax_id', NULL );
		$result &= $this->db->update('order_history');

		$result &= $this->db->empty_table('mining_request');

		return $result;
	}
	public function resetSplits2( $level ) {
		$result = true;
		$this->db->set('assigned_split', 'assigned_split - 1', false );
		$this->db->where('assigned_split > 0');
		$result &= $this->db->update('order_history');

		$this->load->model('validation_model');

		$this->db->set('tax_id', NULL );
		$this->db->where('level', $level );
		$result &= $this->db->update('order_history');

		$this->db->select('id');
		$this->db->from('mining_request');

		$result &= $this->db->delete('mining_request', [ 'level' => $level ] );
		return $result;
	}

	public function getAllTokens( $user_id )
	{
		$this->db->select( 'oh.price as package_price' );
		$this->db->select( 'p.num_of_tokens as token_per_one' );
		$this->db->select( 'p.product_name as package_name' );
		$this->db->select( 'p.splits as package_splits' );
		$this->db->select( 'oh.assigned_split as package_assigned_split' );
		$this->db->select( 'p.product_id as product_id' );
		$this->db->select( 'SUM(oh.quantity) as quantity' );
		$this->db->select( 'SUM(`token` * `quantity` * POW(2, `assigned_split`) ) as package_token', false );
		$this->db->select( "IF(  oh.assigned_split =  p.splits, \"YES\",  p.mining_status ) AS package_mining", false );
		$this->db->from( 'order_history as oh' );
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->where( 'oh.user_id', $user_id );
		$this->db->group_by( 'oh.package' );
		$this->db->group_by( 'oh.assigned_split' );
		$query = $this->db->get();

		return $query->result_array();
	}

    public function getJoiningDate($user_id, $table_perfix = "") {

        $table_name = $table_perfix . 'ft_individual';
        $this->db->select('date_of_joining');
        $this->db->from($table_name);
        $this->db->where('id', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row)
            return $row->date_of_joining;
    }
    
    public function getAllPackage($user_id) {
        $obj_arr = array();
        $this->db->where('user_id',$user_id);
        $this->db->group_by('package'); 
        $this->db->from('order_history');
        
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
			$obj_arr[ $i ]["quantity"]     = $row['quantity'];
			$obj_arr[ $i ]["token"]        = $row['token'];
			$obj_arr[ $i ]["date"]         = $row['date'];
			$obj_arr[ $i ]["package"]      = $row['package'];
			$obj_arr[ $i ]["package_name"] = $this->validation_model->getPrdocutName( $row['package'] );

			$i++;
        }
    
        return $obj_arr;
    }

	public function getHistoryCount() {
		$this->db->select('COUNT( DISTINCT `user_id`) as ctr', false );
		$this->db->from('order_history');
		$query  = $this->db->get();
		return $query->first_row('array')['ctr'];
	}

    public function getTokenStats( $user_ID = null, array $pagination = null ) {

		$this->db->select( 'SUM(`oh`.`token` * `oh`.`quantity` * POW(2, `assigned_split`) ) as requested_tokens', false );
		$this->db->select( 'user_id as id' );
		$this->db->from( 'order_history as oh' );
		$this->db->where('tax_id IS NOT NULL');
		$this->db->group_by('oh.user_id');
		$_req_tokens = $this->db->_compile_select();
		$this->db->_reset_select();


		$this->db->select( 'SUM(`token` * `quantity` * POW(2, `assigned_split`) ) as total_tokens', false );
		$this->db->select('user_id as user_id');
		$this->db->select( '`user_name` as user_name', false );
		$this->db->select('requested_tokens');
		$this->db->from( 'order_history as oh' );
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->join( 'ft_individual as fi', 'fi.id = oh.user_id', 'left' );
		$this->db->join( '(' . $_req_tokens . ') as req', 'req.id = oh.user_id', 'left' );

		if ( ! is_null( $user_ID ) ) {
			$this->db->where( 'oh.user_id', $user_ID );
		}
		$this->db->group_by( 'oh.user_id' );
		if ( ! is_null( $pagination ) ) {
			$this->db->limit( $pagination['limit'], $pagination['offset'] );
		}
		$this->db->order_by( 'total_tokens', "DESC" );

		$query = $this->db->get();

		return $query->result_array();

    }



}

























