<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Course extends My_controller {
    
    public function __construct(){
		parent::__construct();
    }

    public function showAll(){
        $this->load->model("course_model");
        $this->load->model("coursetype_model");

        $data["page_title"] = "วิชาทั้งหมด";
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                ];
                                
        $origin_coursetypes = $this->coursetype_model->get_all();
        
        $coursetypes = [];
        foreach( $origin_coursetypes as $coursetype){
            $origin_courses = $this->course_model->get_by_coursetype_id($coursetype->coursetype_id);
                                                   
			
			$courses = [];
			foreach($origin_courses as $course){
				$course->thumbnail_url = $this->course_model->get_thumbnail_url($course->course_code); ;
				
				array_push($courses, $course);
			}
			
			// Collect only no-blank coursetype
			if( $courses !== [] ){
				$coursetype->courses = $courses;
				array_push($coursetypes, $coursetype);
			}
        }
        
        $data["coursetypes"] = $coursetypes;
        $this->_mainView("showAll",$data);

    }


    public function show($course_id){
        $this->load->model("course_model");
        $this->load->model("deck_model");
        $this->load->model("lesson_model");
        $this->load->model("practice_model");
        $this->load->model("card_model");

        if( !($user = $this->_getLoggedInUser())){return;}

        $data["course"] =   $this->course_model->get_by_id($course_id);
        $decks  =   $this->deck_model->get_by_course_id($course_id);

        $data["decks"] = [] ;
        foreach( $decks as $deck){
            $deck->user_num_card = count($this->practice_model->get_by_deck_id_and_user_id($deck->deck_id,$user->user_id));

            
            $deck->practice_to_review_today = count($this->practice_model->get_to_review($user->user_id, $deck->deck_id, time(), $next_day= 0));
            $deck->total_num_card = count( $this->card_model->get_by_deck_id($deck->deck_id));

            $deck->practice_to_review_tomorrow = count($this->practice_model->get_to_review($user->user_id, $deck->deck_id, time(), $next_day= 1)) ;
            $deck->average_practice_interval = $this->practice_model->get_average_interval($deck->deck_id,$user->user_id);

            array_push( $data["decks"], $deck );
        }

        $data["lessons"] = $this->lesson_model->get_by_course_id($course_id);
        $data["isUserLoggedIn"] =  $this->_isUserLoggedIn();
        $data["page_title"] = "วิชา :: ".$data["course"]->course_code." ".$data["course"]->course_name ;
        $data["breadcrumbs"] = [    [ "หน้าแรก", base_url()],
                                    [ "วิชาทั้งหมด", base_url(["Course","showAll"])],
                                ];
        $this->_mainView("show",$data);
    
    }









    
}
