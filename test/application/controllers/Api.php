<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
    }
    
    function login() {
        
        //$cr = $this->input->post('email');
        $cr = json_decode($this->input->raw_input_stream, true);
        
        echo "hello ". $cr['email'];
       
    }
    
    function getsomething() {
        echo "You got something";
    }
    
}