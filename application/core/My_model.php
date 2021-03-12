<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_model extends CI_Model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "";

    }

    // Return affected row
    public function _delete($where_clause = ""){

        $sql = " DELETE FROM ".$this->get_table_name() ;
        if($where_clause === ""){
            die("Need where_clause!");
        }else{
            $sql .= " $where_clause ";
        }

        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    //Return Array Of Object
    public function _get($where_clause, $limits = []){

        $sql = " SELECT * FROM ".$this->get_table_name() ;
        if($where_clause === ""){
             $sql .= " WHERE 1 ";
        }else{
            $sql .= " $where_clause ";
        }

        if( $limits !== [] ){
             $sql .= " LIMIT $limits[0],$limits[1] ";
        }

        $query = $this->db->query($sql);
        return $query->result();
    }

    //Return Affected Rows
    public function delete_by_id($id){
        return $this->delete_by_ids($ids=[(int)$id]);

    }

    //Return Affected Rows
    public function delete_by_ids($ids){

        if( $ids === [] ){
            return 0;

        }else{
            $this->db->from($this->get_table_name());
            $this->db->where_in($this->get_table_name()."_id", $ids);
            $query = $this->db->delete();
            return $this->db->affected_rows();        

        }
    }    

    // Return Array Of Object
    public function get_all($limits = []){

        $where_clause = " WHERE 1 ";
        return $this->_get($where_clause, $limits);

    }

    // Return Object Or False
    public function get_by_id($id){

        $where_clause = " WHERE ".$this->get_table_name()."_id = ".$id;
        if( $rows = $this->_get($where_clause)){
            return $rows[0];
        }else{
            return FALSE;
        }
        
    }

    // return Array of Ojbect
    public function get_by_ids($ids){

        if( $ids !== [] ){
            $this->db->from($this->get_table_name());
            $this->db->where_in($this->get_table_name()."_id", $ids);
            $query = $this->db->get();
            return $query->result();

        }else{
            return [];

        }

    }    

    // Return Array Of Properties
    public function get_fields(){

        $fields = $this->db->list_fields( $this->get_table_name());
        return $fields;
    }

    // Return Int
    public function get_num_rows($where_clause = ""){

        $sql =      " SELECT COUNT( * ) as 'num_rows' ";
        $sql .=     " FROM ".$this->get_table_name();

        if( $where_clause ){
            $sql .=  " $where_clause ";
        }else{
            $sql .=  " WHERE 1 ";
        }

        $query = $this->db->query($sql);

        return (int)$query->result()[0]->num_rows;        
    }

    // Return Text
    public function get_table_name(){
        if( $this->table_name === ""){
            die("Table Name has to be set.");

        }else{
            return $this->table_name;

        }
    }

    // Return Inserted_id As Int
    public function insert($detail){
        $this->db->insert( $this->get_table_name() , $detail);
        return (int)$this->db->insert_id();
    }    

    // Use for testing only
    // Return None
    public function set_table_name_for_testing($table_name){
        $this->table_name = $table_name;
    }
    
    // Return affected row
    public function update_by_id($id, $detail){

        $this->db->where( $this->get_table_name()."_id", $id);
        $this->db->update( $this->get_table_name(), $detail);
        return $this->db->affected_rows();
    }

}
