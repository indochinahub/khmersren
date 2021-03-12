<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Lesson_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "lesson";

    }

    // return Array Of object
    public function get_by_course_id($course_id){

        $course_id = $this->db->escape((int)$course_id);

        $where_clause = " WHERE id_course = ".$course_id;
        $where_clause .= " ORDER BY lesson_sort ";
        $lessons = $this->_get($where_clause);

        return $lessons;
    }


}
