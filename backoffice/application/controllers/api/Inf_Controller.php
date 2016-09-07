<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Inf_Controller extends REST_Controller {

    function __construct() {
        parent::__construct();

        $controler_class = $this->router->class;
        $controler_class_model = $controler_class . "_model";
        $this->load->model($controler_class_model, '', TRUE);
//        
    }

}

?>
