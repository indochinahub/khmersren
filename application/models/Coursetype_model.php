<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class Coursetype_model extends My_model {

    protected $table_name;

    public function __construct(){
        parent::__construct();
        $this->table_name = "coursetype";

    }

}
