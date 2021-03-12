<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Post extends My_controller {
    
    public function __construct(){
        parent::__construct();
    }

    public function addEdit($action, $post_id = 0){
        $this->load->model("post_model");
        $this->load->model("postCategory_model");
        $this->load->library('form_validation');

        $data["action"] = $action;

        if( !($data["user"] = $this->_getLoggedInUser())){return;}

        $arr_postcategory = $this->postCategory_model->get_by_user_id($data["user"]->user_id);

        //Validate Input
        if( $this->input->post("submit") === "submit") {
            $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
            $this->form_validation->set_rules('title', 'หัวข้อ', 'trim|required');
            $this->form_validation->set_rules('intro', 'คำนำ', 'trim|required');
    
            if( $this->form_validation->run() == FALSE ) {
                $data["action"] = "input_not_valid";

            }
        }

        // Add Post to databse
        if( $data["action"] === "add" && $this->input->post("submit") === "submit"){

            $title   = $this->input->post("title");
            $intro  = $this->input->post("intro");
            $content = $this->input->post("content");
            $postCategory_id = $this->input->post("postCategory_id");
            $post_publishstatus = $this->input->post("post_publishstatus");

            $detail =   [   "post_title"=>$title,
                            "post_intro"=>$intro,
                            "post_content"=>$content,
                            "id_postCategory"=>$postCategory_id,
                            "post_publishstatus"=>$post_publishstatus,
                        ];

            $post_id = $this->post_model->insert($detail);
            redirect(base_url(["Profile","showPost",$data["user"]->user_id,$post_id]) );

        // Show Add Form
        }elseif( $data["action"] === "add" ){

            $data["title"] = "";
            $data["intro"] = "";
            $data["content"] = "";
            $data["arr_postcategory"] = $arr_postcategory; 

            $data["page_title"] = "เพิ่มบทความ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
            $this->_mainView('addEdit',$data);

        }elseif( $data["action"] === "edit" && $this->input->post("submit") === "submit" ){

            $title   = $this->input->post("title");
            $intro  = $this->input->post("intro");
            $content = $this->input->post("content");
            $id_postcategory = $this->input->post("postCategory_id");
            $post_publishstatus = $this->input->post("post_publishstatus");

            $detail =   [   "post_title"=>$title,
                            "post_intro"=>$intro,
                            "post_content"=>$content,
                            "id_postcategory"=>$id_postcategory,
                            "post_publishstatus"=>$post_publishstatus,
                        ];

            $this->post_model->update_by_id($post_id, $detail);

            redirect(base_url(["Profile","showPost",$data["user"]->user_id,$post_id]) );
            

        }elseif( $data["action"] === "edit" ){
            $data["post"] = $this->post_model->get_by_id($post_id);
            
            $data["title"] = $data["post"]->post_title;
            $data["intro"] = $data["post"]->post_intro;
            $data["content"] = $data["post"]->post_content;
            

            $arr_postcategory_with_default = [];
            foreach($arr_postcategory as $postcategory ){
                if($postcategory->postcategory_id === $data["post"]->id_postcategory){
                    $postcategory->if_it_is_current_postcategory = TRUE;
                }else{
                    $postcategory->if_it_is_current_postcategory = FALSE;
                }

                array_push($arr_postcategory_with_default,$postcategory);

            }
            $data["arr_postcategory"] = $arr_postcategory;

            $data["page_title"] = "ปรับปรุงบทความ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
            $this->_mainView('addEdit',$data);

        }elseif( $data["action"] === "input_not_valid" ){
            $data["title"] = $this->input->post("title");
            $data["intro"] = $this->input->post("intro");
            $data["content"] = $this->input->post("content");

            $data["arr_postcategory"] = $arr_postcategory;

            $data["page_title"] = "ปรับปรุงบทความ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
            $this->_mainView('addEdit',$data);
        }

    }

    public function delete($post_id, $confirm = 0){
        $this->load->model("post_model");
        $this->load->model("user_model");

        $post = $this->post_model->get_by_id($post_id);
        $owner = $this->user_model->get_by_post_id($post_id);

        if( (int)$confirm === 0 ){

            $what_happened = "คุณกำลังจะลบบันทึกหมายเลข <strong>".$post->post_id."</strong> ";
            $what_happened .= "ชื่อเรื่อง <strong>".$post->post_title."</strong>";
            
            $data   = [     "page_title"=>"ยืนยันการลบบันทึก",
                            "what_happened"=>$what_happened,
                            "what_todo" => "กด <strong>ยืนยัน</strong> เพื่อทำต่อหรือกด <strong>ยกเลิก</strong> เพื่อยกเลิก",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Post","delete",$post_id,1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Profile","showPost",$owner->user_id,$post_id]),
                    ];        
            $this->_confirmSomething($data);

        }else{
            $this->post_model->delete_by_id($post_id);
            redirect(["Profile","myPost",$owner->user_id]);

       }
    }
    
    public function changePublishStatus($post_id,$publish_status){
        $this->load->model("post_model");
        $this->load->model("user_model");

        $post = $this->post_model->get_by_id($post_id);
        $owner = $this->user_model->get_by_post_id($post_id);
        
        $this->post_model->update_publish_status($post_id,$publish_status);

        redirect(base_url(["Profile","showPost",$owner->user_id,$post_id]));
    }
}
