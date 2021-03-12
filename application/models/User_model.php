<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class User_model extends My_model {

    protected $table_name;
    
    public function __construct(){
        parent::__construct();
        $this->table_name = "user";
    }

    // return Array Of Objects
    public function get_all_users_order_by_visit_time($limits = []){
        $where_clause = " WHERE 1 ORDER BY user_visit_time DESC ";
        return $this->_get($where_clause, $limits );

    }

    // return UserObject or FAlse
    public function get_by_post_id($post_id){
        $this->load->model("post_model");
        $this->load->model("postCategory_model");

        if( !($post = $this->post_model->get_by_id($post_id)) ){ return FALSE;}
        if( !($postcategory = $this->postCategory_model->get_by_id($post->id_postcategory))){ return FALSE;}

        return $this->get_user_by_id($postcategory->id_user);
    }

    // return Object Or False
    public function get_user_by_id($user_id){

        if( $user = $this->get_by_id($user_id) ){
            $user->avartar_url = $this->get_avartar_url($user_id);
            $user->userlevel_text = get_userlevel_text($user->user_level);

            if( $user->user_display_name === NULL ){ 
                $user->user_display_name = $user->user_username; 
            }
        }

        return $user;
    }

    // return Text
    public function get_avartar_url($user_id){
        
        $image_full_path = FCPATH."assets/images/user_pics/".$user_id.".jpg";
        
        if( is_file($image_full_path)){
            return base_url([ "assets", "images", "user_pics", $user_id.".jpg" ]) ;
        }else{
            return base_url([ "assets", "images", "user_pics", "anonymous".".jpg" ]) ;
        }            
        
    }

    // return Object Or False
    public function get_by_username_password($username, $password ){

        $username = $this->db->escape($username);
        $password = $this->db->escape($password);
        $where_clause = " WHERE user_username = ".$username." AND user_password = ".$password;
        $result = $this->_get( $where_clause );
        
        if($result){
            return $result[0];
        }else{
            return FALSE;
        }        


    }

    // Return TRUE
    public function update_visit_time($user_id){

        $detail = [ "user_visit_time" => get_sqlTimeStamp_of_the_time_for_next_num_day(time(), $next_day = 0)];
        $this->update_by_id($user_id, $detail);
        return TRUE;

    }

    
}
