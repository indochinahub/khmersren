<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Course_model extends My_model {

    protected $table_name;
        
    public function __construct(){
        parent::__construct();
        $this->table_name = "course";
    }

    // return Object Or FALSE
    public function get_by_cardgroup_id($cardgroup_id){
        $this->load->model("cardgroup_model");
        $this->load->model("course_model");

        if( !($cardgroup = $this->cardgroup_model->get_by_id($cardgroup_id))){return FALSE;}
        if( !( $course = $this->get_by_id($cardgroup->id_course))){return FALSE;}

        return $course;
    }

    // return Array of Object
    public function get_by_coursetype_id($coursetype_id){

        $coursetype_id = $this->db->escape((int)$coursetype_id);
        $sql = " SELECT * FROM course WHERE id_coursetype = ".$coursetype_id." ORDER BY course_sort ";
        $query = $this->db->query($sql);
        return $query->result();        
		
    }

    // return Object Or FALSE
    public function get_by_deck_id($deck_id){
        $this->load->model("deck_model");
        //$this->load->model("deck_model");

        if( !($deck = $this->deck_model->get_by_id($deck_id))){return FALSE;}
        if( !($course = $this->get_by_cardgroup_id($deck->id_cardgroup))){return FALSE;}

        return $course;
    }

    // return Object Or FALSE
    public function get_by_lesson_id($lesson_id){
        $this->load->model("lesson_model");
        
        if( !( $lesson = $this->lesson_model->get_by_id($lesson_id) )){return FALSE;}
        return $this->get_by_id($lesson->id_course);
    }

    // return URL
	public function get_thumbnail_url($course_code){
		
		$thumbnail_path = COURSE_DIR."/$course_code/course_thumbnail.jpg";
		
		if( file_exists($thumbnail_path) ){
			return COURSE_URL."$course_code/course_thumbnail.jpg";
			
		}else{
			return COURSE_URL."course_thumbnail.jpg";
			
		}
    }
}
