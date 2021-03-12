<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class PostCategory extends My_controller {
    
    public function __construct(){
        parent::__construct();
    
    }

    public function addEdit($action, $postcategory_id = 0){
        $this->load->model("postCategory_model");
        $this->load->library('form_validation');

        if($this->_if_needLogIn()){return;}
        $data["user"] = $this->_getLoggedInUser();

        //Validate Input
        if( $this->input->post("submit") === "submit") {
            $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
            $this->form_validation->set_rules('title', 'หัวข้อ', 'trim|required');
    
            if( $this->form_validation->run() == FALSE ) {
                $action = "input_not_valid";
            }
        }

        // Add Post to databse
        if( $action === "add" && $this->input->post("submit") === "submit"){

            $title   = $this->input->post("title");

            $detail =   [   "postcategory_title"=>$title,
                            "id_user"=>$data["user"]->user_id,
                        ];

            $postcategory_id = $this->postCategory_model->insert($detail);
            redirect(base_url(["PostCategory","manage"]));
        
        // Show Add Form
        }elseif( $action === "add" ){

            $data["title"] = "";
            $data["intro"] = "";
            $data["content"] = "";

            $data["page_title"] = "เพิ่มกลุ่มบันทึก";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                        [ "กลุ่มบันทึก", base_url(["PostCategory","manage"])],
                                        
                                    ];
            $this->_mainView('addEdit',$data);

        }elseif( $action === "edit" && $this->input->post("submit") === "submit" ){

            $title   = $this->input->post("title");
            
            $detail =   [   "postcategory_title"=>$title,
                        ];

            $this->postCategory_model->update_by_id($postcategory_id, $detail);

            redirect(base_url(["PostCategory","manage"]));

        }elseif( $action === "edit" ){

            $postCategory = $this->postCategory_model->get_by_id($postcategory_id);

            $data["title"] = $postCategory->postcategory_title;

            $data["page_title"] = "ปรับปรุงบทความ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
            $this->_mainView('addEdit',$data);

        }elseif( $action === "input_not_valid" ){
            $data["title"] = $this->input->post("title");
            $data["intro"] = $this->input->post("intro");
            $data["content"] = $this->input->post("content");

            $data["page_title"] = "ปรับปรุงบทความ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
            $this->_mainView('addEdit',$data);
        }
    }

    public function delete($postcategory_id, $confirm = 0){

        $this->load->model("postCategory_model");
        $this->load->model("post_model");

        if($this->_if_needLogIn()){ return;}
        $user = $this->_getLoggedInUser();

        if( (int)$confirm === 0 ){
            $postcategory = $this->postCategory_model->get_by_id($postcategory_id);

            $what_happened = "คุณกำลังจะลบกลุ่มบันทึกชื่อ <strong>".$postcategory->postcategory_title."</strong>";
            
            $data   = [     "page_title"=>"ยืนยันการลบบันทึก",
                            "what_happened"=>$what_happened,
                            "what_todo" => "กด <strong>ยืนยัน</strong> เพื่อทำต่อหรือกด <strong>ยกเลิก</strong> เพื่อยกเลิก",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["PostCategory","delete", $postcategory_id,1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["PostCategory","manage"]),
                    ];        
            $this->_confirmSomething($data);

        }else{
            $default_postcategory = $this->postCategory_model->get_or_add_default_postcategory($user->user_id);
            $this->post_model->move_all_post_in_the_postcategory_to_new_one($postcategory_id, $default_postcategory->postcategory_id);
            $this->postCategory_model->delete_by_id($postcategory_id);

            redirect(base_url(["PostCategory","manage"]));
        }
    }

    public function manage(){
        $this->load->model("postCategory_model");
        $this->load->model("post_model");

        if($this->_if_needLogIn()){return;}
        $data["user"] = $this->_getLoggedInUser();
        
        $arr_category = $this->postCategory_model->get_by_user_id($data["user"]->user_id);

        $data["arr_category"] = [];
        foreach($arr_category as $category){
            $arr_post = $this->post_model->get_all_post_by_postcategory_id($category->postcategory_id);
            $category->number = count($arr_post);
            array_push($data["arr_category"],$category);

        }

        $data["page_title"] = "กลุ่มบทความของ​​ ".$data["user"]->user_display_name;
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                    [ "โปรไฟล์ของ".$data["user"]->user_display_name , base_url(["Profile","myProfile",$data["user"]->user_id])],
                                ];
                                
		$this->_mainView('manage',$data);
    }


    

}
