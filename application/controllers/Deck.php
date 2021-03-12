<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Deck extends My_controller {
    
    public function __construct(){

        parent::__construct();
    }

    public function clearAllCards($deck_id,$confirm = 0){
        $this->load->model("practice_model");
        $this->load->model("util_model");

        if( !($data["user"] = $this->_getLoggedInUser())){return;}

        if( $confirm === "1" ){
            $practices = $this->practice_model->get_by_deck_id_and_user_id($deck_id, $data["user"]->user_id);

            $card_ids = $this->util_model->get_property_value_Of_many_objects_as_array($practices, "practice_id");
            $this->practice_model->delete_by_ids($card_ids);

            redirect(["Deck","show",$deck_id]);

        }else{
            
            $data    =  [   "page_title"=>"ยืนยันการชุดบัตรคำ",
                            "what_happened"=>"คุณกำลังจะบัตรคำจำนวน xxx ใบของชุดบัตรคำ <strong>xxxEN006-02</strong> ",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Deck","clearAllCards",$deck_id,1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Deck","show",$deck_id]),                            
                        ];  

            $this->_confirmSomething($data);
        }

    }

    public function show($deck_id){

        $this->load->model("course_model");
        $this->load->model("deck_model");
        $this->load->model("card_model");
        $this->load->model("practice_model");
        $this->load->model("cardComment_model");

        if( !($data["user"] = $this->_getLoggedInUser())){return;}
        $data["deck"] = $this->deck_model->get_by_id($deck_id);
        $data["course"] = $this->course_model->get_by_deck_id($deck_id);
        
        $data["total_num_card"] = count( $this->card_model->get_by_deck_id($data["deck"]->deck_id));;
        $data["user_num_card"] = count($this->practice_model->get_by_deck_id_and_user_id($deck_id,$data["user"]->user_id) );
        $data["practice_to_review_today"] = count($this->practice_model->get_to_review($data["user"]->user_id, $deck_id, time(), $next_day= 0)) ;
        $data["practice_to_review_tomorrow"] = count($this->practice_model->get_to_review($data["user"]->user_id, $deck_id, time(), $next_day= 1));
        $data["next_card_id"] =  $this->card_model->get_next_card_id_to_review_or_get_new($deck_id, $data["user"]->user_id, time());
        $data["average_practice_interval"] = $this->practice_model->get_average_interval($data["deck"]->deck_id,$data["user"]->user_id);
        $data["cardcomment_num"] = count($this->cardComment_model->get_by_deck_id($deck_id) );

        
        $data["practice_visit_time"] = $this->practice_model->get_visit_time($data["user"]->user_id,$data["deck"]->deck_id);

        $data["page_title"] = "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name;
        $data["breadcrumbs"] = [    [ "วิชาทั้งหมด", base_url(["Course","showAll"])],
                                    [ "วิชา ".$data["course"]->course_code, base_url(["Course","show",$data["course"]->course_id])]
                                ];
        $this->_mainView("show",$data);
    
    }

    public function showAllCards($deck_id){
        $this->load->model("card_model");
        $this->load->model("deck_model");
        $this->load->model("practice_model");
        $this->load->model("course_model");

        if( !($data["user"] = $this->_getLoggedInUser())){return;}

        $course = $this->course_model->get_by_deck_id($deck_id);
        $deck = $this->deck_model->get_by_id($deck_id);
        $cards = $this->card_model->get_by_deck_id($deck_id);

        $current_page = (int)$this->uri->segment(4,1);

        $this->load->library('pagination');
        $pagination_config =  get_default_config_for_pagination();
        $pagination_config["base_url"]      =  base_url(["Deck","showAllCards", $deck_id]);
        $pagination_config["total_rows"]    =  count($cards);
        $pagination_config["per_page"]      =  30;
        $pagination_config["num_links"]     =  1;
        $pagination_config["uri_segment"]   =  4;
        $this->pagination->initialize($pagination_config);
        $data["pagination"] =  $this->pagination->create_links();

        $start_item = get_start_item_for_pagination( $current_page, $pagination_config["per_page"]);

        $cards = array_slice($cards, $start_item, $pagination_config["per_page"]);

        $data["cards_HTML"] = [];
        foreach($cards as $card){

            $card_HTML = $this->card_model->get_card_to_display_in_html($card->card_id, $deck_id);
            $card_HTML = $this->card_model->get_shuffled_choices( $card_HTML,[1,2,3,4] );
            $card_HTML->card_id = $card->card_id;
            $card_HTML->card_sort = $card->card_sort;
            
            if( $this->practice_model->get_by_card_id_deck_id_user_id($card->card_id, $deck_id, $data["user"]->user_id)){
                $card_HTML->if_i_have_done = TRUE;
            }else{
                $card_HTML->if_i_have_done = FALSE;
            }
   
            array_push($data["cards_HTML"],$card_HTML);

        }

        $data["page_title"] = "บัตรคำในชุดบัตรคำ ".$course->course_code."-".$deck->deck_name;
        $data["breadcrumbs"] = [    [   "ชุดบัตรคำ ".$course->course_code."-".$deck->deck_name , 
                                        base_url(["Deck","show",$deck_id])
                                    ],
                                ];
        $this->_mainView("showAllCards",$data);

    }

    public function showAllComments($deck_id){
        $this->load->model("cardComment_model");
        $this->load->model("course_model");
        $this->load->model("util_model");
        $this->load->model("deck_model");

        $data["course"] = $this->course_model->get_by_deck_id($deck_id);
        $data["deck"] = $this->deck_model->get_by_id($deck_id);


        $cardcomments = $this->cardComment_model->get_by_deck_id($deck_id);
        $cardcomments =$this->util_model->sort_array_of_object_by_the_property( $cardcomments, "cardcomment_id", $order_by ="desc");

        $current_page = (int)$this->uri->segment(4,1);

        $this->load->library('pagination');
        $pagination_config =  get_default_config_for_pagination();
        $pagination_config["base_url"]      =  base_url( ["Deck","showAllComments",$deck_id] );
        $pagination_config["total_rows"]    =  count($cardcomments);
        $pagination_config["per_page"]      =  40;
        $pagination_config["num_links"]     =  1;
        $pagination_config["uri_segment"]   =  4;
        $this->pagination->initialize($pagination_config);
        $data["pagination"] =  $this->pagination->create_links();

        $start_item = get_start_item_for_pagination( $current_page, $pagination_config["per_page"]);

        $cardcomments = array_slice($cardcomments, $start_item, $pagination_config["per_page"]);

        $data["cardcomments"] = [];
        foreach($cardcomments as $comment){
            $comment->owner = $this->user_model->get_user_by_id($comment->id_user);
            array_push($data["cardcomments"],$comment);

        }

        $data["page_title"] = "ความคิดเห็นของชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name;
        $data["breadcrumbs"] = [    [ "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name, 
                                       base_url(["Deck","show", $deck_id])
                                    ],
                                ];

        $this->_mainView("showAllComments",$data);
    }




    
}
