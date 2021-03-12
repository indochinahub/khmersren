<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Card extends My_controller {
    
    public function __construct(){
        parent::__construct();
    }

    public function show($page, $card_id, $deck_id){
        $this->load->model("course_model");
        $this->load->model("cardComment_model");
        $this->load->model("deck_model");
        $this->load->model("card_model");
        $this->load->model("practice_model");

        if( !($data["user"] = $this->_getLoggedInUser())){return;}
        
        if( $this->_if_user_are_admin() ){
            $data["if_i_am_admin"] = TRUE;
        }else{
            $data["if_i_am_admin"] = FALSE;
        }
        
        $data["deck"] = $this->deck_model->get_by_id($deck_id);
        $data["course"] = $this->course_model->get_by_deck_id($deck_id);
        $data["card"] = $this->card_model->get_by_id($card_id);

        //$this->card_model->set_current_card($card_id, $deck_id , $user->user_id);

        $data["card_HTML"] = $this->card_model->get_card_to_display_in_html($card_id, $deck_id);

        $random_choices = [ 1, 2, 3, 4];
        if( $page === "a" ){
            $data["card_HTML"]->page = "a";

            shuffle($random_choices);
            $data["card_HTML"] = $this->card_model->get_shuffled_choices( $data["card_HTML"],$random_choices );

            $data["practice"] = $this->practice_model->get_by_card_id_deck_id_user_id($card_id, $deck_id, $data["user"]->user_id);

            

            $data["card_HTML"]->choice_1a_background = "background-color:#ceecf2;";
            $data["card_HTML"]->choice_2a_background = "background-color:#ceecf2;";
            $data["card_HTML"]->choice_3a_background = "background-color:#ceecf2;";
            $data["card_HTML"]->choice_4a_background = "background-color:#ceecf2;";

        }elseif( $page === "b" ){

            $data["card_HTML"]->page = "b";

            // use $segments to get $random_choices
            $segments = $this->uri->segment_array();
            $random_choices =   [   (int)$segments[6],
                                    (int)$segments[7],
                                    (int)$segments[8],
                                    (int)$segments[9],
                                ];
            $data["selected_choice"] =    (int)$segments[10];

            $data["card_HTML"] = $this->card_model->get_shuffled_choices( $data["card_HTML"],$random_choices );

            //set background
            $choice_properties = [      "choice_1a_index"=> "choice_1a_background",
                                        "choice_2a_index"=> "choice_2a_background",
                                        "choice_3a_index"=> "choice_3a_background",
                                        "choice_4a_index"=> "choice_4a_background",
                                ];

            foreach($choice_properties as $index => $background){
                if($data["card_HTML"]->$index === 1){
                    $data["card_HTML"]->$background = "background-color:#cef2d6;";
                    
                }elseif( $data["card_HTML"]->$index === $data["selected_choice"]){
                    $data["card_HTML"]->$background = "background-color:#f2ced2;";

                }else{
                    $data["card_HTML"]->$background = "background-color:#ceecf2;";
                    
                }
            }

            if( $practice = $this->practice_model->get_by_card_id_deck_id_user_id($card_id, $deck_id, $data["user"]->user_id)){
                $practice_id = $practice->practice_id;
            }else{
                $detail =   [   "id_deck"=>$deck_id,
                                "id_card"=>$card_id,
                                "id_user"=>$data["user"]->user_id,
                            ];
                $practice_id = $this->practice_model->insert($detail);
                $practice = $this->practice_model->get_by_id($practice_id);
            }

            // For New Card
            if($practice->practice_lastVisitDate === $practice->practice_nextVisitDate){
                $detail = [ 
                    "practice_intervalDay"=> 2,
                    "practice_nextVisitDate"=>get_sqlTimeStamp_at_midnight_for_next_num_day( time(), $next_day = 1),

                ];
            // For a existing Card which was redone in the same day
            }elseif( get_date_part_from_sqlTimeStamp($practice->practice_lastVisitDate) === get_date_part_from_sqlTimeStamp(get_sqlTimeStamp_of_the_time_for_next_num_day(time(),$next_day = 0))){
                $detail = [ 
                    "practice_lastVisitDate"=>get_sqlTimeStamp_of_the_time_for_next_num_day( time(), $next_day = 0) ,
                ];
            }elseif( $data["selected_choice"] === 1){

                $detail = [   
                    "practice_intervalDay"=>get_new_iterval_num_day( $practice->practice_intervalDay, $data["deck"]->deck_intervalconstant),
                    "practice_lastVisitDate"=>get_sqlTimeStamp_of_the_time_for_next_num_day( time(), $next_day = 0) ,
                    "practice_nextVisitDate"=>get_sqlTimeStamp_at_midnight_for_next_num_day( time(),
                                                get_new_iterval_num_day( $practice->practice_intervalDay, $data["deck"]->deck_intervalconstant)) ,
                    "practice_counter"=> $practice->practice_counter + 1,
                ];

            }else{

                $detail = [   
                    "practice_intervalDay"=> 1,
                    "practice_lastVisitDate"=>get_sqlTimeStamp_of_the_time_for_next_num_day( time(), $next_day = 0) ,
                    "practice_nextVisitDate"=>get_sqlTimeStamp_at_midnight_for_next_num_day( time(), $next_day = 1) ,
                    "practice_counter"=> $practice->practice_counter + 1,
                ];
            }

            $this->practice_model->update_by_id($practice_id, $detail);
            $data["practice"] = $this->practice_model->get_by_id($practice_id);
            
            $data["next_card_id"] =  $this->card_model->get_next_card_id_to_review_or_get_new($deck_id, $data["user"]->user_id, time());

            $cardcomments = $this->cardComment_model->get_by_card_id_and_deck_id($card_id, $deck_id);
            $data["cardcomments"] = [];
            foreach($cardcomments as $comment){

                $comment->if_i_am_owner = FALSE;
                $comment->if_i_am_admin = FALSE;
                if( $comment->id_user === $data["user"]->user_id ){  
                    $comment->if_i_am_owner = TRUE;
                }elseif( $this->_if_user_are_admin() ){
                    $comment->if_i_am_admin = TRUE;
                }
                
                $comment->owner = $this->user_model->get_user_by_id($comment->id_user);

                array_push($data["cardcomments"], $comment);
            }
        }

        $data["card_HTML"]->user_num_card = count($this->practice_model->get_by_deck_id_and_user_id($deck_id,$data["user"]->user_id));
        $data["card_HTML"]->total_num_card = count( $this->card_model->get_by_deck_id($deck_id));
        $data["card_HTML"]->practice_to_review_today = count($this->practice_model->get_to_review($data["user"]->user_id, $deck_id, time(), $next_day= 0) );
        $data["card_HTML"]->practice_to_review_tomorrow = count($this->practice_model->get_to_review($data["user"]->user_id, $deck_id, time(), $next_day= 1) );
        $data["card_HTML"]->average_practice_interval = $this->practice_model->get_average_interval($deck_id,$data["user"]->user_id);

        $data["page_title"] = "บัตรคำ ".$data["card"]->card_sort;
        $data["breadcrumbs"] = [    [ "วิชา ".$data["course"]->course_code, base_url(["Course","show",$data["course"]->course_id])],
                                    [ "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name, 
                                    base_url(["Deck","show",$data["deck"]->deck_id])
                                    ],
                                ];

        $this->_mainView("show",$data);
    }


    
}
