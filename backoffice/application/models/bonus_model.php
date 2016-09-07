<?php

class bonus_model extends inf_model {

    private $mailObj;


    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('joining_model');
        $this->load->model('payout_model');
    }

   
     public function getJoiningDetailsperMonth($user_id = '') {
        return $this->joining_model->getJoiningDetailsperMonth($user_id);
    }
     public function getPayoutReleasePercentages($user_id = '') {
        return $this->payout_model->getPayoutReleasePercentages($user_id);
    }
     public function getPayoutReleasePercentages2($user_id = '') {
        
        $payout_details = array();

        $released_payouts = $this->getReleasedPayoutCount($user_id);
        $pending_payouts = $this->getPendingPayoutCount($user_id);
        
        $total_payouts = $pending_payouts + $released_payouts;
        if ($total_payouts > 0) {
            $released_payouts_percentage = ($released_payouts / $total_payouts) * 100;
            $pending_payouts_percentage = ($pending_payouts / $total_payouts) * 100;
        } else {
            $released_payouts_percentage = 100;
            $pending_payouts_percentage = 0;
        }

        $payout_details['released'] = $released_payouts_percentage;
        $payout_details['pending'] = $pending_payouts_percentage;

        return $payout_details;
         
    }
    
    
     public function getReleasedPayoutCount($user_id = '') {

        $count = 0;
        if ($user_id == '') {
            $this->db->select_sum('requested_amount');
            $this->db->from('payout_release_requests');
            $this->db->where('status', 'released');
            $count = $this->db->get()->row()->requested_amount;
        } else {
            $this->db->select_sum('requested_amount');
            $this->db->from('payout_release_requests');
            $this->db->where('status', 'released');
            $this->db->where('requested_user_id', $user_id);
            $count = $this->db->get()->row()->requested_amount;
        }
        return $count;
    }

    public function getPendingPayoutCount($user_id = '') {
        $count = 0;
        if ($user_id == '') {
            $this->db->select_sum('requested_amount');
            $this->db->from('payout_release_requests');
            $this->db->where('status', 'pending');
            $count = $this->db->get()->row()->requested_amount;
        } else {
            $this->db->select_sum('requested_amount');
            $this->db->from('payout_release_requests');
            $this->db->where('status', 'pending');
            $this->db->where('requested_user_id', $user_id);
            $count = $this->db->get()->row()->requested_amount;
        }
        return $count;
    }

    public function getTotalCountBonus( $id, $bonus_type = null ) {

		$this->db->select( 'amount_payable' );
		$this->db->from( 'leg_amount l' );
		$this->db->where( 'l.user_id', $id );

		if ( ! is_null( $bonus_type ) ) {
			$this->db->where( 'l.amount_type', $bonus_type );
		}

		$result = $this->db->get()->result_array();

		return  [
			'max_num_pages' => count( $result ),
			'total_amount'  => empty( $result ) ? 0 : array_sum( array_column( $result, 'amount_payable' ) )
		];
	}

    public function getBonusDetails($id, $bonus_type = null, $stage = null, array $limit = [] ){
		$data       = [ ];
		$i          = 0;
		$tot_amount = 0;
		$this->db->select( 'amount_payable,date_of_submission,user_name,from_id,l.amount_type' );
		$this->db->from( 'leg_amount l' );
		$this->db->join( 'ft_individual u', 'u.id=l.from_id', 'left' );
		$this->db->where( 'l.user_id', $id );

		if ( ! is_null( $bonus_type ) ) {
            $this->db->where( 'l.amount_type', $bonus_type );
        }
        if ( ! is_null( $stage ) ) {
            $this->db->where( 'l.stage', $stage );
        }
        if( ! empty( $limit ) ) {
            $this->db->limit( $limit['limit'], $limit['offset'] );
        }
        $this->db->order_by("date_of_submission", "desc");


        $query = $this->db->get();
         
         foreach ($query->result_array() as $row) {

			 $data[ $i ]["amount_payable"]     = $row['amount_payable'];
			 $data[ $i ]["date_of_submission"] = $row['date_of_submission'];
			 $data[ $i ]["user_name"]          = $row['user_name'];
			 $data[ $i ]["amount_type"]        = $row['amount_type'];
			 $data[ $i ]['from_user']  = ( $row['from_id'] ) ? $this->validation_model->IdToUserName( $row['from_id'] ) : 'NA';
			 $tot_amount += $data[ $i ]["amount_payable"];
			 $data[ $i ]['tot_amount'] = $tot_amount;
			 $i++;
        }
         return $data;
    }
     
    
     public function getLegAmountStage() {
        $status=1;
        $this->db->select_max('stage');
        $query = $this->db->get('leg_amount');
        $rowcount = $query->num_rows();
        if ($rowcount) {
            $status = $query->row()->stage;
        }
        return $status;
    }

}
