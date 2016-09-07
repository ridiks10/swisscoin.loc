<?php

Class package_model extends inf_model {

	private static $colors = [
		2 => '#286090',
		3 => '#204a6f',
		4 => '#5cb85c',
		5 => '#448644',
		6 => '#5bc0de',
		7 => '#1c7690',
		8 => '#d58512',
		9 => '#c38429',
		10 => '#ec7d7a',
		11 => '#e03631',
		12 => '#ac2925',
	];

    function __construct() {
        parent::__construct();
    }

    public function getAllPackage($user_id) {
        $obj_arr = array();
        $this->db->select_sum('quantity');
        $this->db->select('sum(`quantity`*`bv`) as tbv', FAlSE);
        $this->db->select('sum(`quantity`*`price`) as tprice', FAlSE);
        $this->db->select('sum(`quantity`*`token`) as ttoken', FAlSE);
        $this->db->select('package');
        $this->db->where('user_id',$user_id);
        $this->db->group_by('package'); 
        $this->db->from('order_history');
        
        $query = $this->db->get();
 
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i]["quantity"] = $row['quantity'];
            $obj_arr[$i]["token"] = $row['ttoken'];
            $obj_arr[$i]["bv"] = $row['tbv'];
            $obj_arr[$i]["price"] = $row['tprice'];
            $obj_arr[$i]["package"] = $row['package'];
            $obj_arr[$i]["package_name"] = $this->validation_model->getPrdocutName($row['package']);
           
            $i++;
        }
    
        return $obj_arr;
    }


    function getTotalTokens($user_id) {
        return $this->db->select( 'SUM(`token` * `quantity` * POW(2, `assigned_split`) ) as sum', false )
            ->where('user_id',$user_id)
            ->where('tax_id IS NULL')
            ->get('order_history')
            ->first_row('array')['sum'];
    }

    public function getPackageStats($user_id = null, $_start = null, $_finish = null, array $pagination = null ) {

		$this->db->select('fi.user_name as user_name');
		$this->db->select('p.product_name as product_name');
		$this->db->select('oh.quantity');
		$this->db->select('oh.date as date' );
		$this->db->select('( `oh`.`price` * `oh`.`quantity` ) as total_amount' );
		$this->db->from('order_history as oh');
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->join( 'ft_individual as fi', 'fi.id = oh.user_id', 'left' );
		if( ! is_null( $user_id ) ) {
			$this->db->where('user_id',$user_id);
		}
		if( ! is_null( $_start ) && ! is_null( $_finish ) ) {
			$this->db->where("oh.date BETWEEN '$_start' AND '$_finish'");
		}
		$this->db->order_by('oh.date', 'DESC');
		if ( ! is_null( $pagination ) ) {
			$this->db->limit( $pagination['limit'], $pagination['offset'] );
		}

		$query = $this->db->get();

		return $query->result_array();

    }

    public function getPackageCountStats( $_start, $_finish ) {
		$this->db->select( 'package' );
		$this->db->select( 'p.product_name as product_name' );
		$this->db->select( 'SUM(oh.quantity) as ctr' );
		$this->db->from( 'order_history as oh' );
		$this->db->join( 'package as p', 'oh.package = p.product_id' );
		$this->db->where( "oh.date BETWEEN '$_start' AND '$_finish'" );
		$this->db->group_by( 'package' );
		$this->db->order_by( 'oh.package', 'ASC' );
		$result = $this->db->get()->result_array();

		$packages = array_column( $result, 'package' );
		foreach ( range( 2, 12 ) as $number ) {
			if ( ! in_array( $number, $packages ) ) {
				array_push( $result, [
					'package'      => $number,
					'product_name' => self::getPackageName( $number ),
					'ctr'          => 0
				] );
			}
		}

		return $result;
    }

	public function getTotalRows( $user_id = null, $_start = null, $_finish = null ) {
		$this->db->select('id', false );
		if( ! is_null( $user_id ) ) {
			$this->db->where('user_id', intval( $user_id ) );
		}
		if( ! is_null( $_start ) && ! is_null( $_finish ) ) {
			$this->db->where("date BETWEEN '$_start' AND '$_finish'");
		}
		$this->db->from('order_history');
		return $this->db->get()->num_rows();

	}
	public function getPackageName( $id ) {
		return $this->db->select('product_name')->where('product_id', intval( $id ) )->get('package')->first_row('array')['product_name'];
	}

	public function generateLines($timeline) {
		$output = [ ];
		foreach ( self::getPackagesData() as $package ) {
			$line = [
				'label' => $package->product_name,
				'borderColor' => self::$colors[$package->package],
				'fill' => false,
				'data'  => [ ]
			];
			$i    = 0;
			foreach ( $timeline as $date_period ) {
				$i++;
				foreach ( $date_period as $pack ) {
					if ( $pack['package'] == $package->package ) {
						$line['data'][] = [
							'x' => $i,
							'y' => $pack['ctr']
						];
						continue 2;
					}
				}
			}
			array_push( $output, $line );
		}

		return $output;
	}
	public function getPackagesData() {
		$this->db->select('product_name');
		$this->db->select('product_id as package');
		$this->db->from('package');
		$this->db->where('product_id > 1');
		return $this->db->get()->result_object();
	}
}






















