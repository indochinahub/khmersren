<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Card_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "card";

    }

    // return Array Of Object
    public function get_by_cardgroup_id($cardgroup_id){

        $where_clause = " WHERE id_cardgroup = ".$cardgroup_id;
        $cards = $this->_get($where_clause);
        return $cards;

    }
    // return Array Of Object
    public function get_by_deck_id($deck_id){
        $this->load->model("deck_model");

        $deck_id = $this->db->escape((int)$deck_id);
        
        if(!( $deck = $this->deck_model->get_by_id($deck_id) )){ return [];}

        $where_clause =  " WHERE id_cardgroup = ".$deck->id_cardgroup;
        $cards = $this->_get($where_clause );

        return $cards;
    }

    // return Array Of Object
    public function get_card_ids_by_deck_id($deck_id){
        $this->load->model("card_model");
        $this->load->model("util_model");

        $deck_id = $this->db->escape((int)$deck_id);
        
        if( $cards = $this->card_model->get_by_deck_id($deck_id)){
            $card_ids = $this->util_model->get_property_value_Of_many_objects_as_array($array_of_objects = $cards,$property = "card_id");
            return $card_ids;
    
        }else{
            return [];
        }
    }

    //  return Object
    public function get_card_to_display_in_html($card_id, $deck_id){
        $this->load->model("util_model");
        $this->load->model("deck_model");
        $this->load->model("card_model");

        $card_in_html = new stdClass();

        $deck = $this->deck_model->get_by_id( $deck_id );
        $card = $this->card_model->get_by_id( $card_id);

        $deck_property_names = $this->util_model->get_property_names_of_one_object_as_array($deck);
        $deck_property_names = array_values(array_diff($deck_property_names,[
                                        "deck_id",  "id_cardgroup", "deck_sort", "deck_name", "deck_description",
                                        "deck_hint1_col", "deck_hint2_col", "deck_rowperpage", "deck_intervalconstant",
                                        ]));

        foreach($deck_property_names as $deck_property_name){
                $card_property_name = $deck->$deck_property_name;

                if($card_property_name){
                    $card_in_html->$deck_property_name = $this->deck_model->get_content_in_html($deck_id,
                                                                        $card->$card_property_name, 
                                                                        $card_property_name);
                }else{
                    $card_in_html->$deck_property_name = FALSE;
                }
        }

        return $card_in_html;
    }

    // return Int Or False
    public function get_new_card_id_to_learn($user_id, $deck_id, $unix_timestamp){
        $this->load->model("practice_model");

        $all_card_ids = $this->get_card_ids_by_deck_id($deck_id);

        $practices = $this->practice_model->get_by_deck_id_and_user_id($deck_id, $user_id);

        $practiced_card_ids = $this->util_model->get_property_value_Of_many_objects_as_array($array_of_objects = $practices, $property = "id_card");

        if( $new_card_ids = array_values(array_diff($all_card_ids,$practiced_card_ids))){
            return (int)$new_card_ids[0];
        }else{
            return FALSE;
        }
    }    

    // return Object Or False
    public function get_next_card_id_to_review($user_id, $deck_id, $unix_timestamp){

        $this->load->model("practice_model");

        $user_id = $this->db->escape((int)$user_id);
        $deck_id = $this->db->escape((int)$deck_id); 

        if($practices = $this->practice_model->get_to_review($user_id, $deck_id, $unix_timestamp, $next_day= 0)){
            return (int)$practices[0]->id_card;
        }else{
            return FALSE;
        }
    }

    // return Int of False
    public function get_next_card_id_to_review_or_get_new($deck_id, $user_id, $unix_timestamp){

        if( $next_card_id = $this->get_next_card_id_to_review($user_id, $deck_id, $unix_timestamp) ){
        }elseif( $next_card_id = $this->get_new_card_id_to_learn($user_id, $deck_id, $unix_timestamp) ) {
        }else{
            $next_card_id = FALSE;
        }
        
        return $next_card_id;

    }

    // return new properties to be choices and choices_index
    public function get_shuffled_choices($card_to_display_in_html, $random_choices){

        $choices = [ 1, 2, 3, 4];

        $i = 1;
        // add +1 to every key of $random_choices
        // we start the index from 1 not 0
        $modified_key_choices = [];
        foreach($random_choices as $key=>$value){
            $modified_key_choices[$key+1] = $value; 
        }
        $random_choices = $modified_key_choices;
        //$random_choices = [ 1, 4, 3, 2];

        // Choice01
        $old_property = "deck_choice".$random_choices[1]."a_col";
        $card_to_display_in_html->choice_1a_html = $card_to_display_in_html->$old_property;
        $card_to_display_in_html->choice_1a_index = $random_choices[1];

        $old_property = "deck_choice".$random_choices[1]."b_col";
        $card_to_display_in_html->choice_1b_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_1b_index = $random_choices[1];

        $old_property = "deck_choice".$random_choices[1]."c_col";
        $card_to_display_in_html->choice_1c_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_1c_index = $random_choices[1];

        $old_property = "deck_choice".$random_choices[1]."d_col";
        $card_to_display_in_html->choice_1d_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_1d_index = $random_choices[1];

        // Choice02
        $old_property = "deck_choice".$random_choices[2]."a_col";
        $card_to_display_in_html->choice_2a_html = $card_to_display_in_html->$old_property;
        $card_to_display_in_html->choice_2a_index = $random_choices[2];

        $old_property = "deck_choice".$random_choices[2]."b_col";
        $card_to_display_in_html->choice_2b_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_2b_index = $random_choices[2];

        $old_property = "deck_choice".$random_choices[2]."c_col";
        $card_to_display_in_html->choice_2c_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_2c_index = $random_choices[2];

        $old_property = "deck_choice".$random_choices[2]."d_col";
        $card_to_display_in_html->choice_2d_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_2d_index = $random_choices[2];

        // Choice03
        $old_property = "deck_choice".$random_choices[3]."a_col";
        $card_to_display_in_html->choice_3a_html = $card_to_display_in_html->$old_property;
        $card_to_display_in_html->choice_3a_index = $random_choices[3];

        $old_property = "deck_choice".$random_choices[3]."b_col";
        $card_to_display_in_html->choice_3b_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_3b_index = $random_choices[3];        

        $old_property = "deck_choice".$random_choices[3]."c_col";
        $card_to_display_in_html->choice_3c_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_3c_index = $random_choices[3];

        $old_property = "deck_choice".$random_choices[3]."d_col";
        $card_to_display_in_html->choice_3d_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_3d_index = $random_choices[3];

        // Choice04
        $old_property = "deck_choice".$random_choices[4]."a_col";
        $card_to_display_in_html->choice_4a_html = $card_to_display_in_html->$old_property;
        $card_to_display_in_html->choice_4a_index = $random_choices[4];

        $old_property = "deck_choice".$random_choices[4]."b_col";
        $card_to_display_in_html->choice_4b_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_4b_index = $random_choices[4];
         
        $old_property = "deck_choice".$random_choices[4]."c_col";
        $card_to_display_in_html->choice_4c_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_4c_index = $random_choices[4];
        
        $old_property = "deck_choice".$random_choices[4]."d_col";
        $card_to_display_in_html->choice_4d_html = $card_to_display_in_html->$old_property;
        //$card_to_display_in_html->choice_4d_index = $random_choices[4];


        $card_to_display_in_html->choice_index = $random_choices;

        return $card_to_display_in_html;

    }


    // return InsertedId
    public function insert_blank_card(){
        $sql = " INSERT INTO card (id_cardgroup) VALUES (8) ";
        $query = $this->db->query($sql);
        
        return $this->db->insert_id();

    }

}
