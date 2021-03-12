<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Practice_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "practice";

    }

    // return Int Or Zero
    public function get_average_interval($deck_id,$user_id){

        $deck_id = $this->db->escape((int)$deck_id);
        $user_id = $this->db->escape((int)$user_id);
        $sql = "SELECT AVG(practice_intervalDay) from practice WHERE id_deck = ".$deck_id." AND id_user = ".$user_id ;
        $query = $this->db->query($sql); 
        $average = $query->result_array()[0]["AVG(practice_intervalDay)"];        

        if( $average ){
            return intval(floor($average));
        }else{
            return 0;
        }        
    }

    // return object or FALSE
    public function get_by_card_id_deck_id_user_id($card_id, $deck_id, $user_id){

        $card_id = $this->db->escape((int)$card_id);
        $deck_id = $this->db->escape((int)$deck_id);
        $user_id = $this->db->escape((int)$user_id);

        $where_clause = " WHERE id_deck = $deck_id AND id_user = $user_id AND id_card = $card_id "; 

        if( $practices = $this->_get($where_clause) ){
            return $practices[0];

        }else{
            return FALSE;

        }
    }

    // return Array Of Object
    public function get_by_deck_id_and_user_id($deck_id,$user_id){

        $deck_id = $this->db->escape((int)$deck_id);
        $user_id = $this->db->escape((int)$user_id); 

        $where_clause = " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;
        return $this->_get($where_clause);

    }

    // return Array Of Object
    public function get_to_review($user_id, $deck_id, $unix_timestamp, $next_day= 0){
        $this->load->model("course_model");

        $user_id = $this->db->escape((int)$user_id);
        $deck_id = $this->db->escape((int)$deck_id); 

        $sql_time_stamp     =   get_sqltimeStamp_of_the_time_for_next_num_day($unix_timestamp, $next_day);

        $where_clause       =   " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;
        $where_clause       .=  " AND practice_nextVisitDate < '$sql_time_stamp' " ;
        $where_clause       .=  " ORDER BY practice_intervalDay DESC ";

        return $this->_get($where_clause);
    }

    // return Int
    public function get_num_practice_to_review_for_user($user_id, $unix_timestamp, $next_day = 0 ){

        $sql_time_stamp     =   get_sqltimeStamp_of_the_time_for_next_num_day($unix_timestamp, $next_day);

        $sql    =       " SELECT COUNT( * ) as 'num_rows' FROM practice ";
        $sql    .=      " WHERE id_user = ".$user_id." AND practice_nextVisitDate < '$sql_time_stamp' " ;
        $query = $this->db->query($sql);

        return (int)$query->result()[0]->num_rows;  
        
    }

    // return Int
    public function get_visit_time($user_id,$deck_id){
        $user_id = $this->db->escape($user_id);
        $deck_id = $this->db->escape($deck_id);
        
        $sql    =       " SELECT SUM(practice_counter)  as 'number'  ";
        $sql    .=      " FROM practice ";
        $sql    .=      " WHERE id_deck = ".$deck_id." AND id_user = ".$user_id;        
        $query = $this->db->query($sql);

        if($query->result()){
            return intval($query->result_array()[0]["number"]);
        }else{
            return 0;
        }
    }

    // return Array Of Object
    public function get_which_have_reviewed_today($deck_id, $user_id, $unix_timestamp){

        $this->load->model("practice_model");

        $deck_id = $this->db->escape((int)$deck_id);
        $user_id = $this->db->escape((int)$user_id);

        $sqlTimeStamp = get_sqlTimeStamp_at_midnight_for_next_num_day($unix_timestamp, $next_day = 0);
        
        $where_clause  =      " WHERE id_user = ".$user_id." AND id_deck = ".$deck_id;
        $where_clause  .=     " AND practice_lastVisitDate > "."'$sqlTimeStamp'";
        $where_clause  .=     " ORDER BY practice_lastVisitDate desc ";
        $practices = $this->practice_model->_get($where_clause );

        return $practices;

    }





}
