<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Deck_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "deck";

    }

    // return Array Of Object
    public function get_by_cardgroup_id($cardgroup_id){

        $cardgroup_id = $this->db->escape((int)$cardgroup_id );
        $where_clause = " WHERE id_cardgroup = ".$cardgroup_id ;

        return $this->_get($where_clause);
    }    

    // return Array Of Object
    public function get_by_course_id($course_id){

        $this->load->model("cardgroup_model");
        $cardgroups = $this->cardgroup_model->get_by_course_id((int)$course_id);

        $decks = [];
        foreach($cardgroups as $cardgroup){
            
            $decks_in_cardgroup = $this->get_by_cardgroup_id($cardgroup->cardgroup_id);
            foreach($decks_in_cardgroup as $deck){
                array_push($decks,$deck);
            }
        }

        return $decks;
    }

    // return Array Of Object
    public function get_by_user_id($user_id){
        $this->load->model("course_model");

        $user_id = $this->db->escape((int)$user_id);

        $sql = " SELECT DISTINCT id_deck FROM practice WHERE id_user = $user_id " ;
        $query = $this->db->query($sql); 

        
        $arr_id = [];
        if( $arr_result = $query->result() ) {

            foreach( $arr_result as $result){
                array_push( $arr_id,  (int)$result->id_deck);
            }

            $arr_deck = $this->get_by_ids($arr_id);
            return $arr_deck;

        }else{
            return [];
        }                
    }

    // return Content In Html Or False
    public function get_content_in_html($deck_id, $content, $column_name){
        $this->load->model("course_model");

        $course = $this->course_model->get_by_deck_id($deck_id);        

        $html = FALSE;
        if( "card_text" == substr( $column_name, 0, 9) ){
            $html = "$content";

        }elseif( "card_youtube" == substr( $column_name, 0, 12) ){
            $html = "<div class='embed-responsive embed-responsive-16by9'>";
            $html .= "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$content."' allowfullscreen></iframe>";
            $html .= "</div>";

        }elseif( "card_sound" == substr( $column_name, 0, 10) ){
            $url     =  COURSE_URL.$course->course_code."/sound/".$content;
            $html    =  "<audio controls>";
            $html   .=  "<source src='$url' type='audio/mpeg'>";
            $html   .=  "</audio>";
            $html   .=  "<br><a href='$url'>[ Listen Directly ]</a>";

        }elseif( "card_picture" == substr( $column_name, 0, 12)){
            if( $content){
                $full_path = COURSE_DIR."/".$course->course_code."/image/$content";
                
                if( file_exists ($full_path)){
                    $url  =  COURSE_URL.$course->course_code."/image/".$content;
                    $html = "<div>";
                    $html .= "<img src='$url' class='img-fluid'>";
                    $html .= "</div>";

                }else{
                    $html = "<div>Picture is not found : $full_path </div>";

                }                
            }            
        }
        return $html;

    }


}
