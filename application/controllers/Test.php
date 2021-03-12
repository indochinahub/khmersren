<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Test extends My_controller {
    
    public function __construct(){
		  parent::__construct();
    }
    
    public function index(){

        if( !($data["user"] = $this->_getLoggedInUser())){return;}
        
    }

    public function test_helper(){

        
    }

    
	
    
    
}
