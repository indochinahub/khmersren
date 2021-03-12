<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class SiteSetting_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "sitesetting";

    }

    // return Text or False
    public function get_sitesetting_value( $property ){
        $where_clause = " WHERE sitesetting_property = '".$property."'";
        $settings = $this->_get($where_clause);
        if($settings){
            return $settings[0]->sitesetting_value;
        }else{
            return FALSE;
        }
    }

    // return TRUE Or FALSE
    public function if_site_is_online(){

        if( $this->get_sitesetting_value("siteonline") == "1"){
            return TRUE;
            
        }else{
            return FALSE;

        }
        


    }
    

}
