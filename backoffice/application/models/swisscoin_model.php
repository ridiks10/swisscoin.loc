<?php

Class swisscoin_model extends inf_model {

    function __construct() {
        parent::__construct();
    }


    function getFoundationContent(){
        return $this->db->select('content')->from('55_custom_pages')->where('name', 'swisscoin_foundation')->get()->row(0,'array');
    }

    function updateFoundationContent($content){
        return $this->db->set('content', $content)->where('name', 'swisscoin_foundation')->update('55_custom_pages');
    }
    function getImpressumContent() {
		$result = $this->db->select('content')->from($this->table_prefix . 'custom_pages')->where('name', 'footer_impressum')->get()->row(0, 'array');
        return empty($result) ? 'Field is empty..' : $result['content'];
    }
	function updateImpressumContent( $content ) {
        return $this->db->set('content', $content )
			->where('name', 'footer_impressum')
			->update($this->table_prefix . 'custom_pages');
    }
   
}
