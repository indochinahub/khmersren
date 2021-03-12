<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Profile extends My_controller {
    
    public $MEMBER = FALSE;
    
    public function __construct(){
		parent::__construct();

    }

    public function myCourse($member_id){
        echo "My Course";
    }

    public function myDeck($member_id){
        $this->load->model("course_model");
        $this->load->model("util_model");
        $this->load->model("user_model");
        $this->load->model("deck_model");
        $this->load->model("practice_model");
        $this->load->model("card_model");
        
        $data["member"] = $this->user_model->get_user_by_id($member_id);

        $origin_decks =  $this->deck_model->get_by_user_id($member_id);

        $decks = [];
        foreach( $origin_decks as $deck){
            $deck->course = $this->course_model->get_by_deck_id($deck->deck_id);

            $deck->practice_to_review_today = count($this->practice_model->get_to_review($data["member"]->user_id, $deck->deck_id, time(), $next_day= 0) );
            $deck->practice_to_review_tomorrow = count($this->practice_model->get_to_review($data["member"]->user_id, $deck->deck_id, time(), $next_day= 1) );

            $deck->user_num_card = count($this->practice_model->get_by_deck_id_and_user_id($deck->deck_id,$data["member"]->user_id));
            
            $deck->total_num_card = count( $this->card_model->get_by_deck_id($deck->deck_id));
            $deck->average_practice_interval = $this->practice_model->get_average_interval($deck->deck_id,$member_id);

            array_push($decks, $deck);
        }

        $decks = $this->util_model->sort_array_of_object_by_the_property( $objects = $decks, 
                                $sorted_property = "practice_to_review_today",
                                $order_by ="desc");

        $data["decks"] = $decks;

        $data["page_title"] = "บัตรคำของ".$data["member"]->user_display_name;
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                    [ "โปรไฟล์ของ".$data["member"]->user_display_name , base_url(["Profile","myProfile",$member_id])],
                                    
                                ];
                                
        $this->_mainView('myDeck',$data);        
        
    }
  
	public function myProfile($member_id){
        $this->load->model("course_model");
        $this->load->model("util_model");
        $this->load->model("user_model");
        $this->load->model("deck_model");
        $this->load->model("practice_model");
        $this->load->model("card_model");
        $this->load->model("post_model");

        $data["member"] = $this->user_model->get_user_by_id($member_id);

        $origin_decks =  $this->deck_model->get_by_user_id($member_id);
        
        // Decks Section
        $decks = [];
        foreach( $origin_decks as $deck){
            $deck->course = $this->course_model->get_by_deck_id($deck->deck_id);

            $deck->practice_to_review_today = count($this->practice_model->get_to_review($data["member"]->user_id, $deck->deck_id, time(), $next_day= 0) );
            $deck->practice_to_review_tomorrow = count($this->practice_model->get_to_review($data["member"]->user_id, $deck->deck_id, time(), $next_day= 1) );

            $deck->user_num_card = count($this->practice_model->get_by_deck_id_and_user_id($deck->deck_id,$data["member"]->user_id));
            
            $deck->total_num_card = count( $this->card_model->get_by_deck_id($deck->deck_id));
            $deck->average_practice_interval = $this->practice_model->get_average_interval($deck->deck_id,$member_id);

            array_push($decks, $deck);
        }
        $decks = $this->util_model->sort_array_of_object_by_the_property( $objects = $decks, 
                                $sorted_property = "practice_to_review_today",
                                $order_by ="desc");
                                
        $data["decks"] = array_slice($decks,0,3);

        // Post section
        if( ($user = $this->_getLoggedInUser()) &&  $data["member"]->user_id === $user->user_id ){
            $arr_post = $this->post_model->get_all_post_by_user_id($data["member"]->user_id);
        }else{
            $arr_post = $this->post_model->get_published_post_by_user_id($data["member"]->user_id);
        }
        
        $arr_postcategory = $this->postCategory_model->get_by_user_id($data["member"]->user_id);
        $assoc_postcategory = $this->util_model->get_assoc_from_array_of_object($arr_postcategory, "postcategory_id");
        
        $data["arr_post"] = [];
        foreach($arr_post as $post) {
            $post->postcategory = $assoc_postcategory[$post->id_postcategory];
            array_push($data["arr_post"],$post);
        }

        $data["arr_post"] = array_slice($data["arr_post"],0,3);

        $data["page_title"] = "โปรไฟล์ของ ".$data["member"]->user_display_name;
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                ];
                                
		$this->_mainView('myProfile',$data);

	}

    public function myPost($member_id){
        $this->load->model("post_model");
        $this->load->model("postCategory_model");
        $this->load->model("util_model");

        $data["member"] = $this->user_model->get_user_by_id($member_id);

        if( ($user = $this->_getLoggedInUser()) &&  $data["member"]->user_id === $user->user_id ){
            $arr_post = $this->post_model->get_all_post_by_user_id($data["member"]->user_id);
        }else{
            $arr_post = $this->post_model->get_published_post_by_user_id($data["member"]->user_id);
        }
        
        $arr_postcategory = $this->postCategory_model->get_by_user_id($data["member"]->user_id);
        $assoc_postcategory = $this->util_model->get_assoc_from_array_of_object($arr_postcategory, "postcategory_id");
        
        $data["arr_post"] = [];
        foreach($arr_post as $post) {
            $post->postcategory = $assoc_postcategory[$post->id_postcategory];
            
            if( ($user = $this->_getLoggedInUser()) &&  $data["member"]->user_id === $user->user_id ){
                $post->postcategory->number = count($this->post_model->get_all_post_by_postcategory_id($post->postcategory->postcategory_id));
            }else{
                $post->postcategory->number = count($this->post_model->get_published_post_by_postcategory_id($post->postcategory->postcategory_id));
            }

            array_push($data["arr_post"],$post);
        }

        $data["page_title"] = "บทความของ".$data["member"]->user_display_name;
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                    [ "โปรไฟล์ของ".$data["member"]->user_display_name , base_url(["Profile","myProfile",$member_id])],
                                ];
                                
		$this->_mainView('myPost',$data);
    }

    public function showPost($member_id,$post_id){
        $this->load->model("post_model");
        $this->load->model("postCategory_model");
        $this->load->model("util_model");

        $data["member"] = $this->user_model->get_user_by_id($member_id);

        $arr_post = $this->post_model->get_all_post_by_user_id($member_id);
        $data["post"] = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id($arr_post, "post_id", (string)$post_id);

        if( ($user = $this->_getLoggedInUser()) &&  $data["member"]->user_id === $user->user_id ){
            $arr_post = $this->post_model->get_all_post_by_user_id($member_id);
            $data["post"] = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id($arr_post, "post_id", (string)$post_id);
            $data["postcategory"] = $this->postCategory_model->get_by_id($data["post"]->id_postcategory);
            $data["postcategory"]->number = count($this->post_model->get_all_post_by_postcategory_id($data["postcategory"]->postcategory_id));
            $data["if_user_view_own_profile"]  = TRUE;

        }else{
            $arr_post = $this->post_model->get_published_post_by_user_id($member_id);
            $data["post"] = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id($arr_post, "post_id", (string)$post_id);
            $data["postcategory"] = $this->postCategory_model->get_by_id($data["post"]->id_postcategory);
            $data["postcategory"]->number = count($this->post_model->get_published_post_by_postcategory_id($data["postcategory"]->postcategory_id));
            $data["if_user_view_own_profile"]  = FALSE;

        }        

        $data["page_title"] = " ";
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                    [ "บทความของ ".$data["member"]->user_display_name, base_url(["Profile","myPost",$member_id])],
                                ];
                                
		$this->_mainView('showPost',$data);        
    }
}
