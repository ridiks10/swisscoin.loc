<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Inf_Controller.php';

class ajax extends Inf_Controller {
    
    function __construct() {
        parent::__construct();
		$this->load->model('tokens_model');
    }

    public function autocomplete() {
        $term = $this->input->get('term');
        $this->load->model('user_details_model');
        
        echo json_encode($this->user_details_model->autocompleteUsername($term));
        die;
    }
    public function packages_stats() {
        $this->load->model('package_model');
		$this->package_model->getPackageCountStats( date('Y-m-d H:i:s', strtotime( '-40 days' ) ), date('Y-m-d H:i:s') );

		$dates = [];
		$dates['week'][]  = strtotime('now');
		$dates['week'][]  = strtotime('-7 days');

		$dates['week1'][] = strtotime('-7 days');
		$dates['week1'][] = strtotime('-14 days');

		$dates['week2'][] = strtotime('-14 days');
		$dates['week2'][] = strtotime('-21 days');

		$dates['week3'][] = strtotime('-21 days');
		$dates['week3'][] = strtotime('-28 days');

		$dates['week4'][] = strtotime('-28 days');
		$dates['week4'][] = strtotime('-35 days');

		$dates['week5'][] = strtotime('-35 days');
		$dates['week5'][] = strtotime('-42 days');


		$dates['week6'][] = strtotime('-42 days');
		$dates['week6'][] = strtotime('-49 days');

		$_stack = [];
		$i = 0;

		foreach( $dates as $name => $timeline ) {
			$_stack[$i++] = $this->package_model->getPackageCountStats( date('Y-m-d H:i:s', array_pop($timeline) ), date('Y-m-d H:i:s',  array_pop($timeline) ) );
		}

		$datasets = $this->package_model->generateLines( array_reverse($_stack) );
		$labels = array_map( function ( $v ) {
			return date('d F', array_pop( $v ) ) . ' - ' . date('d F', array_pop($v) );
		}, $dates );
		echo( json_encode([
			'datasets' => $datasets,
			'labels'  => array_reverse( array_values( $labels ) )
		]) );
		exit();

    }

	public function restart_splits()
	{
		$this->load->model( 'validation_model' );
		$this->tokens_model->resetSplits();
		die( json_encode( [
			'status'      => 'OK',
			'total_count' => $this->tokens_model->getCountOfCompletedPacks()
		] ) );
	}

	public function assign_splits() {

		$this->load->model('validation_model');

		$done = intval( $this->input->get('done') );
		$output = [];
		if( empty( $done ) ) {
			$this->tokens_model->addSplitsToAllowedPacks();
			$output['total'] = $this->tokens_model->getCountOfCompletedPacks();
		} else {
			$output['total'] = intval( $this->input->get('total') );
		}

		$completedPacks = $this->tokens_model->getCompletedPacks( $done );

		$results = [];
		foreach( $completedPacks as $_order ) {
			$results[] = $this->tokens_model->insertIntoMining2( $_order );
			$done++;
		}

		$output['done'] = $done;
		die(json_encode($output));

	}



}
