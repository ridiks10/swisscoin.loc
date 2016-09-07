<?php

Class mining_tokens_model extends inf_model
{

	function __construct()
	{
		parent::__construct();
	}
	public function getTotalRows( $user_id = null ) {
		$this->db->select('COUNT(id) as num_rows');
		$this->db->from('mining_request');
		if( ! is_null( $user_id ) ) {
			$this->db->where('req_user_id', intval($user_id) );
		}
		$query = $this->db->get();
		return $query->first_row('array')['num_rows'];

	}
	public function getRequestedTokens( $user_id = null,  array $pagination = null ) {
		$this->load->model('validation_model');

		$this->db->select('oh.assigned_split as assigned_splits');
		$this->db->select('p.num_of_tokens as token_per_pack');
		$this->db->select('SUM(quantity) as quantity');
		$this->db->select('p.product_name as package_name');
		$this->db->select('fi.user_name as user_name');
		$this->db->select('mr.req_user_id as uid');
		$this->db->select('mr.date as request_date');
		$this->db->select('SUM(`oh`.`token` * `oh`.`quantity` * POW( 2, `assigned_split`) ) as requested_tokens', false );
		$this->db->from('mining_request as mr');
		$this->db->join('order_history as oh', 'oh.tax_id = mr.id', 'right' );
		$this->db->join('package as p', 'oh.package = p.product_id');
		$this->db->join( 'ft_individual as fi', 'fi.id = mr.req_user_id', 'left' );
		$this->db->where('mr.status', 'pending');
		if( ! is_null( $user_id ) ) {
			$this->db->where('mr.req_user_id', intval($user_id) );
		}
		$this->db->group_by('oh.tax_id');
		if ( ! is_null( $pagination ) ) {
			$this->db->limit( $pagination['limit'], $pagination['offset'] );
		}
		$this->db->order_by( 'requested_tokens', "DESC" );
		$query = $this->db->get();

		$skg = $this->validation_model->getColumnFromConfig('ac_skg_v');
		$details = $query->result_array();
		foreach( $details as &$request ) {
			$request['tokens_to_mining'] = $request['requested_tokens'] / $skg;
		}
		return $details;

	}

	public function getCoins($user_id)
	{
		$mining_details = $this->getRequestedTokens($user_id);
		$coins = 0;
		foreach ($mining_details as $mining_detail) {
			$coins += $mining_detail['tokens_to_mining'];
		}
		return $coins;
	}
}