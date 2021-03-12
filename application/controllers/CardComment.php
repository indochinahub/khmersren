<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class CardComment extends My_controller {
    
  public function __construct(){

        parent::__construct();

    }

    public function delete($cardcomment_id,$card_id,$deck_id){
        $this->load->model("cardComment_model");

        if( !($data["user"] = $this->_getLoggedInUser())){return;}
        $cardcomment = $this->cardComment_model->get_by_id($cardcomment_id);

        $this->cardComment_model->delete_by_id($cardcomment_id);

        redirect(base_url(["Card","show","a",$card_id,$deck_id]));
    }

    public function insert($card_id,$deck_id){

        $this->load->model("cardComment_model");

        if( !($user = $this->_getLoggedInUser())){return;}

        if( $this->input->post("submit") === "submit" ){

            $cardcomment_text = get_prepared_text_for_mySQL($this->input->post("cardcomment_text"));

            $detail =   [   "id_user"=>$user->user_id,
                            "id_card"=>$card_id,
                            "id_deck"=>$deck_id,
                            "cardcomment_text"=>$cardcomment_text,
                        ];
            $inserted_id = $this->cardComment_model->insert($detail);

        }

        redirect(base_url(["Card","show","a",$card_id,$deck_id]));
    }

    public function showAll(){

        $this->load->model("cardComment_model");
        $this->load->model("course_model");
        $this->load->model("user_model");
        $this->load->model("util_model");

        $cardcomments = $this->cardComment_model->get_all();
        $cardcomments =$this->util_model->sort_array_of_object_by_the_property( $cardcomments, "cardcomment_id", $order_by ="desc");
        //
        $current_page = (int)$this->uri->segment(3,1);

        $this->load->library('pagination');
        $pagination_config =  get_default_config_for_pagination();
        $pagination_config["base_url"]      =  base_url(["CardComment","showAll"]);
        $pagination_config["total_rows"]    =  count($cardcomments);
        $pagination_config["per_page"]      =  30;
        $pagination_config["num_links"]     =  1;
        $pagination_config["uri_segment"]   =  3;
        $this->pagination->initialize($pagination_config);
        $data["pagination"] =  $this->pagination->create_links();

        $start_item = get_start_item_for_pagination( $current_page, $pagination_config["per_page"]);

        $cardcomments = array_slice($cardcomments, $start_item, $pagination_config["per_page"]);


        $data["cardcomments"] = [];
        foreach($cardcomments as $comment){
            $comment->course = $this->course_model->get_by_deck_id($comment->id_deck);
            $comment->deck = $this->deck_model->get_by_id($comment->id_deck);
            $comment->owner = $this->user_model->get_user_by_id($comment->id_user);
            array_push($data["cardcomments"],$comment);

        }

        $data["page_title"] = "ความคิดเห็นทั้งหมด";
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                ];

        $this->_mainView("showAll",$data);                                

    }


    
}
