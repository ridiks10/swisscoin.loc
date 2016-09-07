<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inf_pagination extends CI_Pagination {

	const PER_PAGE          = 50;
	var $total_rows			=  0; // Total number of items (database results)
	var $per_page			= 50; // Max number of items you want shown per page
	var $num_links			=  2; // Number of "digit" links to show before/after the currently viewed page
	var $cur_page			=  0; // The current page being viewed
	var $use_page_numbers	= true; // Use page number for segment instead of offset
	var $first_link			= '&laquo;';
	var $next_link			= false;
	var $prev_link			= false;
	var $last_link			= '&raquo;';
	var $uri_segment		= 4;
	var $full_tag_open		= '';
	var $full_tag_close		= '';
	var $first_tag_open		= '<li>';
	var $first_tag_close	= '</li>';
	var $last_tag_open		= '<li>';
	var $last_tag_close		= '</li>';
	var $cur_tag_open		= '<li class="active"><a href="#">';
	var $cur_tag_close		= '</a></li>';
	var $next_tag_open		= '&nbsp;';
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	var $num_tag_open		= '<li>';
	var $num_tag_close		= '</li>';
	var $page_query_string	= FALSE;
	var $query_string_segment = 'per_page';
	var $display_pages		= TRUE;
	var $anchor_class		= '';

	public function __construct() {
		parent::__construct();
	}
	public function create_links( array $params ) {
		foreach( $params as $_key => $_param ) {
			$this->$_key = $_param;
		}
		$this->initialize();
		return parent::create_links();
	}
}