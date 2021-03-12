<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_model.php';

class File_model extends My_model {

	protected $table_name;
	
    public function __construct(){
        parent::__construct();
		
    }

    // return TRUE/FALSE
	public function create_dir($dir_name){
        if(is_dir($dir_name)){ 
            return TRUE;
		}else{
            if(mkdir($dir_name)){ return TRUE;}else{return FALSE;}
        }
    }

    public function create_file($dir_name,$file_name){
        $full_path_name = $dir_name."/".$file_name;

        if( is_dir($dir_name) ){
            if( $my_file = fopen($full_path_name, 'w') ){
                fclose($my_file);
            }
            return TRUE;
        }else{
            return FALSE;
        }  
    }

    // return TRUE/FALSE
    public function delete_file($dir_name,$file_name){
        $full_path_name = $dir_name."/".$file_name;

        if( is_file($full_path_name) ){
            unlink($full_path_name);
            return TRUE;
        }else{
            return FALSE;
        }

    }

    //returen Array Of Text Or FALSE
    public function get_file_names_in_dir($dir_name){
        if( is_dir($dir_name) ){
            return array_diff(scandir($dir_name), array('.','..'));
        }else{
            return FALSE;
        }
    }

    //returen TRUE Or FALSE
    public function delete_all_files_in_dir($dir_name){
        
        if( $files = $this->get_file_names_in_dir($dir_name)){
            foreach($files as $file){
                $this->delete_file($dir_name,$file);
            }            
            return TRUE;

        }else{
            return FALSE;
        }


    }

    //returen TRUE Or FALSE
    public function delete_dir($dir_name){

        if(is_dir($dir_name)){
            rmdir($dir_name);
            return TRUE;

        }else{
            return FALSE;

        }
    }

    //return TRUE or FALSE
    public function write_to_file($dir_name,$file_name, $text){
        $full_path_name = $dir_name."/".$file_name;

        if( file_exists($full_path_name)){
            
            if( $my_file = fopen($full_path_name, "w") ){
                fwrite($my_file, trim($text));
                fclose($my_file);
                return TRUE;
                
            }
        }else{
            return FALSE;
        }
    }


    
}
