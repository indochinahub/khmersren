<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class User extends My_controller {
    
    public function __construct(){

      parent::__construct();

    }


    public function login(){
        $this->load->library('form_validation');
        
        if ($this->input->method() == 'post'){
            
            $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            
            $username   =   trim($this->input->post('username'));
            $password   =   trim($this->input->post('password'));
            
            
            if($this->form_validation->run() == TRUE){
                
                if( $user = $this->user_model->get_by_username_password($username, $password ) ){
                    
                    $this->session->set_userdata('user_id', $user->user_id);
                    setcookie('user_id', $user->user_id, time() + (86400 * 7), "/");
                    redirect(base_url());
                    
                }else{
                    $data   = [     "page_title"=>"ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง",
                                    "what_happened"=>"",
                                    "what_todo" => "กรุณาล็อกอินอีกครั้ง",
                                    "btnText_toGo" => "ไป",
                                    "btnLink_toGo" => base_url(["User","login"])
                            ];        
                    $this->_needSomething($data);                    
                    
                }                
            }else{
                
                $data["username"]   =   $username;
                $data["password"]   =   $password;
                $this->load->view("User/login",$data);
                return;
            }
            
            
        }else{
            
            unset($_SESSION['user_id']);
            if( isset($_COOKIE["user_id"])){
                setcookie('user_id', $_COOKIE["user_id"], time() - (86400 * 7), "/");
            }            
            
            $data["username"]       =   "";
            $data["password"]       =   "";
            $this->load->view("User/login",$data);
            
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        if( isset($_COOKIE["user_id"])){
            setcookie('user_id', $_COOKIE["user_id"], time() - (86400 * 7), "/");
        }
        redirect(base_url());
    }

    public function showAll(){
        $this->load->model("user_model");
        $this->load->model("practice_model");

        $current_page = $this->uri->segment(3,1);
        
        $this->load->library('pagination');
        $pagination_config =  get_default_config_for_pagination();
        $pagination_config["base_url"]      =  $base_url = base_url(["User","showAll"]);
        $pagination_config["total_rows"]    =  $this->user_model->get_num_rows();
        $pagination_config["per_page"]      =  20;
        $pagination_config["num_links"]     =  1;
        $pagination_config["uri_segment"]   =  3;
        $this->pagination->initialize($pagination_config);
        $data["pagination"] =  $this->pagination->create_links();

        $start_item = get_start_item_for_pagination( $current_page, $pagination_config["per_page"]);

        $users = $this->user_model->get_all_users_order_by_visit_time($limits = [ $start_item,$pagination_config["per_page"]]);

        $data["users"] = [];
        foreach($users as $user){
            $user = $this->user_model->get_user_by_id($user->user_id);
            $user->avartar_url = $this->user_model->get_avartar_url($user->user_id);
            $user->user_card_to_review_today = $this->practice_model->get_num_practice_to_review_for_user($user->user_id,time(),$next_day = 0 );
            $user->user_card_to_review_tomorrow = $this->practice_model->get_num_practice_to_review_for_user($user->user_id,time(),$next_day = 1 );

            array_push($data["users"],$user);
        }

        $data["page_title"] = "ความคิดเห็นทั้งหมด";
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                ];

        $this->_mainView("showAll",$data);       
    }    
    



     





    
    
}