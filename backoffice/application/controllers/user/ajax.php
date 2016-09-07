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
    }

    public function setViewedNews() {
        $news_id = $this->input->post('news_id');
        $this->load->model('news_model');
        $result = $this->news_model->setViewedNews($news_id);
        echo json_encode(['status' => $result]);
        die;
    }
    public function update_career_stats() {
		$output = false;
		if( $this->uri->segment(4) === false ) {
			$user_id = $this->LOG_USER_ID;
		} else {
			$user_id = intval( $this->uri->segment(4) );
			$output = true;
		}

        $this->load->model('career_model');
        $this->career_model->updateUserRank( $user_id, $output );
        $stat = $this->career_model->getCarrerStat( $user_id );
        $_career = $this->career_model->getAllCareers( $stat['career'] );
        $stat['career'] = $_career['leadership_rank'];
        echo json_encode( $stat );
        exit();
    }

}
