<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class PostCategory_model extends My_model {

    protected $table_name;
    
    public function __construct(){
        parent::__construct();
        $this->table_name = "postcategory";
    }

    // return Insert Id Or FALSE
    public function _add_default_postcategory($user_id){
        $this->load->model("user_model");

        if( $this->user_model->get_by_id($user_id) === FALSE ){
            return FALSE;
        }

        $detail = [     "postcategory_title"=>"ทั่วไป",
                        "postcategory_defaultstatus" => 1,
                        "id_user"=>$user_id, 
        ];
        $this->insert($detail);

        return $this->get_by_id( $this->db->insert_id() );
    }

    // return Array Of Object or FALSE
    public function get_by_user_id($user_id){

        if( !($default_postcategory = $this->get_or_add_default_postcategory($user_id)) ) { return FALSE;}

        $default_postcategory->if_it_is_default = TRUE;

        $postcategory = [];
        array_push($postcategory, $default_postcategory);
        
        $where_clause = " WHERE id_user = ".$user_id. " AND postcategory_defaultstatus = 0 ";
        $arr_non_default_postcategory = $this->_get($where_clause);

        foreach($arr_non_default_postcategory as $category){
            $category->if_it_is_default = FALSE;
            array_push($postcategory, $category);
        }

        return $postcategory;
    }

    // return Int Or FALSE
    public function get_default_postcategory_by_user_id($user_id){

        $where_clause = " WHERE id_user = ".$user_id." AND postcategory_defaultstatus = 1 ";
        if( $arr_postcategory = $this->_get($where_clause) ){
            return $arr_postcategory[0];

        }else{
            return FALSE;
        }
    }

    // return only default_postcategory object Or FALSE
    public function get_or_add_default_postcategory($user_id){

        if($default_postcategory = $this->get_default_postcategory_by_user_id($user_id)){
            return $default_postcategory;

        }elseif($default_postcategory = $this->_add_default_postcategory($user_id)){
            return $default_postcategory;
            
        }else{
            return FALSE;
        }
    }


}
