<?php
    
class My_Controller extends CI_Controller{

    public $USER; 
    public $MEMBER;
    
    public function __construct(){

		parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model("user_model");
        $this->load->model("siteSetting_model");

        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->load->helper('my_helper');

        $this->USER = FALSE;
        $this->MEMBER = FALSE;


        if( ! $this->siteSetting_model->if_site_is_online() ){

            if( $this->_getControllerName() === "Main" &&  $this->_getMethodName() === "siteOffline"){
            }elseif($this->_getControllerName() === "User" &&  $this->_getMethodName() === "logout"){
            }elseif($this->_getControllerName() === "User" &&  $this->_getMethodName() === "login"){
            }elseif($this->_getControllerName() === "Admin"){
            }else{
                redirect(["Main","siteOffline"]);
            }
        }
        
        if( $this->session->has_userdata('user_id') ){
            $user_id = $this->session->userdata('user_id');
            $this->USER = $this->user_model->get_user_by_id($user_id);
            setcookie('user_id', $user_id, time() + (86400 * 7), "/");
            $this->user_model->update_visit_time($user_id);
            
        }elseif( isset($_COOKIE["user_id"]) ) {
            $user_id = $_COOKIE["user_id"];
            $this->session->set_userdata('user_id', $user_id);
            $this->USER = $this->user_model->get_user_by_id( $user_id );
            setcookie('user_id', $user_id, time() + (86400 * 7), "/");
            $this->user_model->update_visit_time($user_id);

        }

    }

    public function _getControllerName(){
        return $this->router->fetch_class();
    }
    
    public function _getMethodName(){
        return $this->router->fetch_method();
    }
    
    public function _getLoggedInUser(){
        return $this->USER;
    }

    public function _if_user_are_admin(){

        if( (int)$this->USER->user_level === ADMIN_LEVEL ){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function _isUserLoggedIn(){
        if( $this->USER === FALSE){
            return FALSE;
        }else{
            return TRUE;
        }


    }   

    public function _mainView($file_name,$data){        
        //$data["page_title"] = "Hello";
        // $data["breadcrumbs"] = [
                                    // [ "Home", "http://www.google.com"],
                                    // [ "Test", "http://www.yahoo.com"],
                                    // [ "Test2", "http://www.yahoo.com"],
                                    // [ "Test3", ""],
                                // ]; 

                                      

        if( !isset($data["page_title"])) {$data["page_title"] = FALSE;}
        if( !isset($data["breadcrumbs"])) {$data["breadcrumbs"] = FALSE;}        
        
        $data["controller_name"] = $this->_getControllerName();
        $data["method_name"]     = $this->_getMethodName();
        
        if( isset($_COOKIE["user_id"])) {
                $data["user_id_cookies"] = $_COOKIE["user_id"];
        }else{
                $data["user_id_cookies"] = FALSE;
        }
        
        $data["USER"] = $this->USER;
        
        if( $data["controller_name"] === "Profile" ){

            if( ! isset($data["member"]) || ( $data["member"] === FALSE   )  ){ die("data[member] need to be set."); }

            $data["profile_status"] = "";
            if( $data["USER"] === FALSE) {
                $data["profile_status"] = "guest_visit_member_profile";

            }elseif( (int)$data["USER"]->user_id === (int)$data["member"]->user_id ) {
                $data["profile_status"] = "user_visit_own_profile";

            }else{
                $data["profile_status"] = "user_visit_member_profile";
            }

        }
        
        $this->load->view("mainSection/010head", $data);
        $this->load->view("mainSection/020navbar", $data);
        $this->load->view("mainSection/030sidebar", $data);
        $this->load->view("mainSection/032contentHeader", $data);
        

        if( $file_name === "needSomething" ){
            $this->load->view("mainSection/needSomething", $data);
            
        }elseif( $file_name === "confirmSomething" ){
            $this->load->view("mainSection/confirmSomething", $data);
        }else{
            $this->load->view($this->_getControllerName().'/'.$file_name, $data);
        }        
        
        $this->load->view("mainSection/050infoBox", $data);
        $this->load->view("mainSection/060sectionCloseTag", $data);
        $this->load->view("mainSection/070footer", $data);
    }

    public function _if_needLogIn(){
        if($this->_isUserLoggedIn()){  
            return FALSE;
        }else{
            $data    = [    "page_title"=>"กรุณาเข้าสู่ระบบ",
                            "what_happened"=>"คุณต้องเข้าสู่ระบบเพื่อใช้งานส่วนนี้",
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>เข้าสู่ระบบ</strong>\" ",
                            "btnText_toGo" => "เข้าสู่ระบบ",
                            "btnLink_toGo" => base_url(["User", "login"])
            ];        

            $this->_needSomething($data);
            return TRUE;
        }
    }

    public function _if_needMoreLevel($needed_level){
 
        if($this->_if_needLogIn()){return TRUE;}

        $user = $this->_getLoggedInUser();

        if( (int)$user->user_level < (int)$needed_level ){
            //redirect(base_url(["Inform","needMoreLevel",$needed_level]));
            $data    = [    "page_title"=>"หน้านี้ต้องการสิทธิ์ที่สูงกว่า",
                            "what_happened"=>"ท่านไม่มีสิทธิ์เข้าใช้งานหน้านี้ เนื่องจากท่านมีสิทธิ์ xxx ขณะที่หน้านี้ต้องการสิทธิ์ yyyy ",
                            "what_todo" => "คลิ๊กที่ปุ่ม​​ <b>หน้าแรก</b> เพื่อกลับไปหน้าแรก",
                            "btnText_toGo" => "หน้าแรก",
                            "btnLink_toGo" => base_url()
                        ];        
            $this->_needSomething($data);
            return TRUE;

        }else{
            return FALSE;

        }
    }

    public function _if_needToBeAdmin(){
        if( $this->_if_needMoreLevel($needed_level = 3) ){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }

    public function _if_needToBeContentOwner($owner_id){
        $this->load->model("user_model");

        if($this->_if_needLogIn()){return TRUE;}
        $user = $this->_getLoggedInUser();

        if(  (int)$owner_id !== (int)$user->user_id ){
            $owner = $this->user_model->get_user_by_id($owner_id);
    
            $what_happend = "เจ้าของเนื้อหาส่วนนี้คือ <strong>".$owner->user_display_name."</strong><br>";
            $what_happend .= "ชื่อผู้ใช้งานของคุณคือ <strong>".$user->user_display_name."</strong>";
    
            $data    = [    "page_title"=>"คุณไม่มีสิทธิ์เข้าใช้งานเนื้อหาส่วนนี้",
                            "what_happened"=>$what_happend ,
                            "what_todo" => "หากมีข้อขัดข้องใดๆ กรุณาแจ้ง <strong>ผู้ดูแลระบบ</strong>",
                            "btnText_toGo" => "หน้าแรก",
                            "btnLink_toGo" => base_url()
                        ];        
    
            $this->_needSomething($data);            

            return TRUE;

        }else{

            return FALSE;
        }
    }

    public function _if_needToBeContentOwnerOrAdmin($owner_id){

        if($this->_if_needLogIn()){return TRUE;}
        $user = $this->_getLoggedInUser();

        if(!$this->_if_user_are_admin() and ( (int)$user->user_id !== (int)$owner_id )){ 
            $owner = $this->user_model->get_user_by_id($owner_id);

            $what_happend = "คุณไม่ใช่เจ้าของเนื้อหาส่วนนี้ หรือ ไม่ใช่ผู้ดูและระบบ <br>";
            $what_happend .= "เจ้าของเนื้อหาส่วนนี้คือ <strong>".$owner->user_display_name."</strong><br>";
            $what_happend .= "ชื่อผู้ใช้งานของคุณคือ <strong>".$user->user_display_name."</strong>";
    
            $data    = [    "page_title"=>"คุณไม่มีสิทธิ์เข้าใช้งานเนื้อหาส่วนนี้",
                            "what_happened"=>$what_happend ,
                            "what_todo" => "หากมีข้อขัดข้องใดๆ กรุณาแจ้ง <strong>ผู้ดูแลระบบ</strong>",
                            "btnText_toGo" => "หน้าแรก",
                            "btnLink_toGo" => base_url()
                        ];        
    
            $this->_needSomething($data); ;
            return TRUE;

        }else{
            return FALSE;

        }

        
            
    }

    public function _needSomething($data){
        
        if  (   isset($data["page_title"]) && isset($data["what_happened"]) && isset($data["what_todo"])
                &&isset($data["btnText_toGo"]) && isset($data["btnLink_toGo"])
            ){
            
            // $data               = [     "page_title"=>"มีข้อผิดพลาด :: xxx",
                                        // "what_happened"=>"คุณไม่มีสิทธิ์ใช้งานส่วนนี้",
                                        // "what_todo" => "กรุณาล็อกอินด้วยบัญชีที่มีสิทธิ์",
                                        // "btnText_toGo" => "Back",
                                        // "btnLink_toGo" => base_url()
                                // ];
            
            return $this->_mainView("needSomething", $data);      
            
        }else{
            
            die("There is not enought data to show Error;");
        }        
    }    

    public function _confirmSomething($data){
        if  (   isset($data["page_title"]) && isset($data["what_happened"]) && isset($data["what_todo"])
                &&isset($data["btnText_toConfirm"]) && isset($data["btnLink_toConfirm"])
                &&isset($data["btnText_toCancle"]) && isset($data["btnLink_toCancle"])
            ){
                
            return $this->_mainView("confirmSomething", $data);            
            
        }else{
            die("There is not enought data to show Confirm;");
            
        }
    } 







}