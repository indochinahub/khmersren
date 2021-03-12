<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Post_model extends My_model {

    protected $table_name;
    
    public function __construct(){
        parent::__construct();
        $this->table_name = "post";
    }

    // return Array Of Object
    public function get_all_post_by_user_id($user_id){
        $this->load->model("postCategory_model");
        $this->load->model("util_model");

        if(!($arr_postCategory = $this->postCategory_model->get_by_user_id($user_id))){return [];}

        $arr_postCategory_id = $this->util_model->get_property_value_Of_many_objects_as_array($arr_postCategory,"postcategory_id");

        $arr_post = $this->get_all_post_by_arr_postcategory_id($arr_postCategory_id);
        $arr_post = $this->util_model->sort_array_of_object_by_the_property( $arr_post, "post_publisheddata", $order_by ="desc");

        return $arr_post;
    }

    // return Array of Object
    public function get_all_post_by_arr_postcategory_id($arr_postcategory_id){

        if( !is_array($arr_postcategory_id)){ return [];}

        if( $arr_postcategory_id !== [] ){
            $this->db->from($this->get_table_name());
            $this->db->where_in( "id_postcategory", $arr_postcategory_id);
            $query = $this->db->get();
            return $query->result();

        }else{
            return [];

        }
    }

    // return Array of Object
    public function get_draft_post_by_postcategory_id($postcategory_id){
        $this->load->model("util_model");

        $arr_all_post = $this->get_all_post_by_postcategory_id($postcategory_id);

        $arr_all_post = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                    $origin_arr_object = $arr_all_post, 
                    $property_name = "post_publishstatus", 
                    $text_to_compare = "0", 
                    $operator = "=="
                    );

        return $arr_all_post;

    }

    // return Array of Object
    public function get_published_post_by_postcategory_id($postcategory_id){
        $this->load->model("util_model");

        $arr_all_post = $this->get_all_post_by_postcategory_id($postcategory_id);

        $arr_all_post = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                    $origin_arr_object = $arr_all_post, 
                    $property_name = "post_publishstatus", 
                    $text_to_compare = "1", 
                    $operator = "=="
                    );        
        return $arr_all_post;

    }    

    // return Array of Object
    public function get_all_post_by_postcategory_id($postcategory_id){
        $this->load->model("util_model");

        $arr_all_post = $this->get_all_post_by_arr_postcategory_id([$postcategory_id]);

        return $arr_all_post;
        
    }        

    // return Array of Object
    public function get_draft_post_by_user_id($user_id){
        $this->load->model("util_model");

        if( !($arr_post = $this->get_all_post_by_user_id($user_id)) ){ return [];}

        $arr_post = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = $arr_post,
                            $property_name = "post_publishstatus",
                            $text_to_compare = "0",
                            $operator = "=="
                            );
        return $arr_post; 

    }
    
    // return Array of Object
    public function get_published_post_by_user_id($user_id){

        if( !($arr_post = $this->get_all_post_by_user_id($user_id)) ){ return [];}

        $arr_post = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                        $origin_arr_object = $arr_post,
                        $property_name = "post_publishstatus",
                        $text_to_compare = "1",
                        $operator = "=="
                        );
        return $arr_post; 
    }

    // return Affected Rows or False
    public function move_all_post_in_the_postcategory_to_new_one($old_postcategory_id,$new_postcategory_id){
        $this->load->model("postCategory_model");

        if( !($old_postcategory = $this->postCategory_model->get_by_id($old_postcategory_id)) ){ return [];}
        if( !($new_postcategory = $this->postCategory_model->get_by_id($new_postcategory_id)) ){ return [];}

        $sql = " UPDATE post SET id_postcategory= $new_postcategory_id WHERE  id_postcategory= $old_postcategory_id ";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    // return AffectedRows or False
    public function update_publish_status($post_id,$publish_status){
        
        if( !in_array( (int)$publish_status, [0,1] ) ){return FALSE;}

        $detail =   [ "post_publishstatus"=>$publish_status];
        return $this->post_model->update_by_id($post_id, $detail);
    }    

}
