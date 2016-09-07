<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'admin/Inf_Controller.php';

class Captcha extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function load_captcha($type = "admin") {
        $this->captcha_model->CreateImage($type);
    }

}
