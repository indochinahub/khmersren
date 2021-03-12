<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Main extends My_controller {

	public function index()	{
        $this->load->model("post_model");

        $data["post"] = $this->post_model->get_by_id(14);




        $data["page_title"] = "";
        $data["breadcrumbs"] = [
                                    [ "", ""],
                                ];
                                
		$this->_mainView('index',$data);
        
	}

    public function siteOffline(){
        $data   = [     "page_title"=>"เว็บไซต์อยู่ระหว่างการปรับปรุง",
                        "what_happened"=>"ขออภัยด้วยครับ เว็บไซต์แห่งนี้อยู่ระหว่างการปรับปรุง และจะกลับมาใช้งานได้ในเร็วนี้",
                        "what_todo" => "หากมีปัญหาหรือข้อสงสัยประการใด กรุณาสามารถติดต่อผู้ดูแลระบบที่หมายเลข <strong>086-8681713</strong>",
                        "btnText_toGo" => "",
                        "btnLink_toGo" => ""
                ];        
        $this->_needSomething($data);;        
    }

    public function testDB(){
        
        $this->load->model("user_model");
        
        var_dump($this->user_model->get_all_user());
    }
    
    public function testError(){
        $data   = [     "page_title"=>"มีข้อผิดพลาด :: xxx",
                        "what_happened"=>"คุณไม่มีสิทธิ์ใช้งานส่วนนี้",
                        "what_todo" => "กรุณาล็อกอินด้วยบัญชีที่มีสิทธิ์",
                        "btnText_toGo" => "Back",
                        "btnLink_toGo" => base_url()
                ];        
        $this->_errorView($data);
    }

    public function testConfirm(){
        
        $data   = [     "page_title"=>"ยืนยัน :: xxx",
                        "what_happened"=>"คุณกำลังจะดำเนินาร xxxxx",
                        "what_todo" => "กด Confirm เพื่อทำต่อหรือกด Cancle เพื่อยกเลิก",
                        "btnText_toConfirm" => "Confirm",
                        "btnLink_toConfirm" => base_url(["Main"]),
                        "btnText_toCancle" => "Confirm",
                        "btnLink_toCancle" => base_url(["Main"]),                        
                ];        
        $this-> _confirmSomething($data);        
    }

    public function testPermission(){

    }
    
}
