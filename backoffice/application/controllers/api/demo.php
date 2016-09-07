<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Reference ASMP project
 *  Description of demo
 *
 * @author ioss
 */
require_once 'Inf_Controller.php';
class demo  extends Inf_Controller{
    public function __construct() {
        parent::__construct();
    }//FUNCTION ENDS [ public function __construct() ]
    
        /* 
         * THIS IS A TEST POST FUNCTION. 
         * This function is triggered by a rest client
         * Author Mujeeb Rehman O
         */
    function test_post()
    {
        
         $name= $this->post("name");
         if ($name == "") {
            $name = 'Nothing';
        }

        $array["status"] = "success";
        $array["post_vaue"] = "you post value = $name";
        $this->response($array, 200);
    }
    
    
    /*
     * This is a test GET Function
     * this function is triggerd by a rest client
     * No login is needed  for this function
     * Author Mujeeb Rehman O
     */
    function test_get()
    {
         $name= $this->get("name");
         if ($name == "") {
            $name = 'Nothing';
        }

        $array["status"] = "success";
        $array["post_vaue"] = "you post value = $name";
        $this->response($array, 200);
        
    }
    
}