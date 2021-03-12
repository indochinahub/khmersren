<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class CardComment_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "cardcomment";

    }

    // return Array Of Object
    public function get_by_card_id_and_deck_id($card_id, $deck_id){
 
        $card_id = $this->db->escape($card_id);
        $deck_id = $this->db->escape($deck_id);

        $where_clause = " WHERE id_card = ".$card_id." AND id_deck = ".$deck_id;
        $cardcomments = $this->_get($where_clause);

        return $cardcomments;
    }

    public function get_by_deck_id($deck_id, $limits = []){

        $deck_id = $this->db->escape($deck_id);
        $where_clause = " WHERE  id_deck = ".$deck_id;
        if( $limits ){
            $where_clause .= " LIMIT ".$limits[0].",".$limits[1];
        }

        $cardcomments = $this->_get($where_clause);

        return $cardcomments;        

    }

}
