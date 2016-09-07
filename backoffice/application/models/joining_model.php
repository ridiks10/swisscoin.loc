<?php

/**
 * @property-read joining_class_model $joining_class_model 
 */
class joining_model extends inf_model {

    public function __construct() {
	$this->load->model('joining_class_model');
	$this->load->model('page_model');
    }

    public function paging($page, $limit, $url, $from, $to) {
	$numrows = $this->joining_class_model->allJoiningpage($from, $to);
	$page_arr['first'] = $this->page_model->paging($page, $limit, $numrows);
	$page_arr['page_footer'] = $this->page_model->setFooter($page, $limit, $url);
	return $page_arr;
    }

    /**
     * @deprecated since version 1.21
     * @see joining_class_model::getJoinings() Actual method that return data
     */
    public function todaysJoining($today, $page, $limit) {
        log_message('error', 'joining_model->todaysJoining() :: Deprecated call');
        return $this->joining_class_model->getJoinings($today, null, $page, $limit);
    }

    public function todaysJoiningCount($date) {

	return $this->joining_class_model->todaysJoiningCount($date);
    }

    /**
     * @deprecated since version 1.21
     * @see joining_class_model::getJoinings() Actual method that return data
     */
    public function weeklyJoining($from, $to, $page, $limit) {
        log_message('error', 'joining_model->weeklyJoining() :: Deprecated call');
        return $this->joining_class_model->getJoinings($from, $to, $page, $limit);
    }

    public function allJoiningpage($from, $to) {

	return $this->joining_class_model->allJoiningpage($from, $to);
    }

    public function totalJoiningUsers($user_id = '') {
	$numrows = 0;
	if ($user_id == "") {
	    $this->db->select('user_id');
	    $this->db->from("login_user");
	    $this->db->not_like('addedby', 'server');
	    $this->db->not_like('user_type', 'admin');
	    $query = $this->db->get();
	    $numrows = $query->num_rows(); // Number of rows returned from above query.
	} else {
	    $this->db->select('id');
	    $this->db->from("ft_individual");
	    $this->db->where('sponsor_id', $user_id);
	    $query = $this->db->get();
	    $numrows = $query->num_rows(); // Number of rows returned from above query. 
	}
	return $numrows;
    }

    public function getJoiningDetailsperMonth($user_id = '') {
	$details = array();
	$month_start_end_dates = array();
	$month = "";
	$start_date = "";
	$end_date = "";
	$count = 0;
	$yr = "";
	$date = "";
	for ($i = 1; $i <= 12; $i++) {
	    $yr = date("Y");
	    $date = date("Y-m-d", strtotime("$yr-$i-01"));
	    $month_start_end_dates = $this->getCurrentMonthStartEndDates($date);
	    $start_date = $month_start_end_dates["month_first_date"] . " 00:00:00";
	    $end_date = $month_start_end_dates["month_end_date"] . " 23:59:59";
	    $count = $this->getJoiningCountPerMonth($start_date, $end_date, $user_id);

	    switch ($i) {
		case 1:
		    $month = "Jan";
		    break;
		case 2:
		    $month = "Feb";
		    break;
		case 3:
		    $month = "Mar";
		    break;
		case 4:
		    $month = "Apr";
		    break;
		case 5:
		    $month = "May";
		    break;
		case 6:
		    $month = "Jun";
		    break;
		case 7:
		    $month = "Jul";
		    break;
		case 8:
		    $month = "Aug";
		    break;
		case 9:
		    $month = "Sep";
		    break;
		case 10:
		    $month = "Oct";
		    break;
		case 11:
		    $month = "Nov";
		    break;
		case 12:
		    $month = "Dec";
		    break;
	    }
	    $details[$i]["country"] = "United States";
	    $details[$i]["month"] = $month;
	    $details[$i]["joining"] = $count;
	}
	return $details;
    }

    public function getJoiningCountPerMonth($start_date, $end_date, $user_id = '') {

	$count = 0;
	if ($user_id == "") {

	    $this->db->select('*');
	    $this->db->from('login_user AS lu');
	    $this->db->join('ft_individual AS ft', 'ft.id = lu.user_id', 'INNER');
	    $this->db->where("date_of_joining BETWEEN '$start_date' AND '$end_date'");
	    $this->db->not_like('user_type', 'admin');
	    $count = $this->db->count_all_results();
	} else {
	    $this->db->select('*');
	    $this->db->from("ft_individual");
	    $this->db->where('sponsor_id', $user_id);
	    $this->db->where("date_of_joining BETWEEN '$start_date' AND '$end_date'");
	    $count = $this->db->count_all_results();
	}
	return $count;
    }

    public function getCurrentMonthStartEndDates($current_date) {

	$start_date = '';
	$end_date = '';
	$date = $current_date;

	list($yr, $mo, $da) = explode('-', $date);

	$start_date = date('Y-m-d', mktime(0, 0, 0, $mo, 1, $yr));
	$i = 2;

	list($yr, $mo, $da) = explode('-', $start_date);

	while (date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) {
	    $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr));
	    $i++;
	}

	$ret_arr["month_first_date"] = $start_date;
	$ret_arr["month_end_date"] = $end_date;
	return $ret_arr;
    }

}
