<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/My_controller.php';

class Admin extends My_controller {

    public function __construct(){
        parent::__construct();

    }

    public function addBlankCard(){
        $this->load->model("card_model");

        if($this->_if_needToBeAdmin()){return;}

        $data["num_current_cards"] = count($this->card_model->get_by_cardgroup_id($cardgroup_id = 8));

        if( $this->input->post("submit") == "submit"){
            $required_num = $this->input->post("required_num");
            
            for( $i = $data["num_current_cards"] + 1; $i <= $required_num; $i++) {
                $this->card_model->insert_blank_card();
            }

            $data["num_current_cards"] = count($this->card_model->get_by_cardgroup_id($cardgroup_id = 8));

        }

        $data["page_title"] = "เพิ่มบัตรคำเปล่า";
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                ];                        

        $this->_mainView('addBlankCard',$data);        



    }
    
    public function editCard($card_id, $deck_id){
        $this->load->model("course_model");
        $this->load->model("util_model");
        $this->load->model("card_model");
        $this->load->model("deck_model");

        if($this->_if_needToBeAdmin()){return;}

        $data["card"] = $this->card_model->get_by_id($card_id);
        $data["deck"] = $this->deck_model->get_by_id($deck_id);

        $data["card_properties"] = $this->util_model->get_property_names_of_one_object_as_array($data["card"]);
        $data["card_properties"] = array_diff($data["card_properties"], ["card_id","id_cardgroup"]);

        $data["if_data_was_updated"] = FALSE;

        if( $this->input->post("submit") === "submit" ){

            $detail = [];
            foreach( $data["card_properties"] as $property ){
                if( $this->input->post($property) ){
                    $detail[$property] = $this->input->post($property);
                }else{
                    $detail[$property] = NULL;
                }
            }

            if( $this->card_model->update_by_id($card_id, $detail) ){
                $data["if_data_was_updated"] = TRUE;
            }

            $data["card"] = $this->card_model->get_by_id($card_id);
        }

        $data["page_title"] = "แก้ไขบัตรคำหมายเลข ".$data["card"]->card_sort;
        $data["breadcrumbs"] = [
                                    [ "บัตรคำหมายเลข ".$data["card"]->card_sort, base_url(["Card","show","a",$card_id,$deck_id])],
                                ];                        

        $this->_mainView('editCard',$data);
    }

    public function deleteCard($card_id, $deck_id, $confirm = 0){
        $this->load->model("card_model");

        if($this->_if_needToBeAdmin()){return;}

        if($confirm === 0){

            $data    =  [   "page_title"=>"ยืนยันการลบบัตรคำ",
                            "what_happened"=>"คุณกำลังจะลบบัตรคำหมายเลข ".$card_id,
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Admin","deleteCard",$card_id,$deck_id,1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(["Card","show","a",$card_id,$deck_id]),                            
                        ];  

            $this->_confirmSomething($data);

        }else{
            $this->card_model->delete_by_id($card_id);
            redirect(base_url(["Deck","show",$deck_id]));
            
            
        }
    }

    public function exportCardgroup($cardgroup_id = 0){
        $this->load->model("cardgroup_model");
        $this->load->model("course_model");
        $this->load->model("deck_model");
        $this->load->model("file_model");
        $this->load->model("card_model");
        $this->load->model("util_model");

        if($this->_if_needToBeAdmin()){return;}

        if($cardgroup_id === 0){

            $cardgroups = $this->cardgroup_model->get_all();
    
            $data["cardgroups"] = [];
            foreach($cardgroups as $cardgroup){
                
                $cardgroup->course = $this->course_model->get_by_cardgroup_id($cardgroup->cardgroup_id);
    
                $decks = $this->deck_model->get_by_cardgroup_id($cardgroup->cardgroup_id);
                $decks_text = "";
                foreach( $decks as $deck){
                    $decks_text .= $cardgroup->course->course_code."-".$deck->deck_name.",";
    
                }
                $cardgroup->decks_text = $decks_text;
                
                array_push($data["cardgroups"],$cardgroup);
            }
    
            $data["page_title"] = "ส่งออกบัตรคำ ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
    
            $this->_mainView('exportCardgroup',$data);

        }else{
            $cardgroup_id = (int)$cardgroup_id ;

            $cardgroup = $this->cardgroup_model->get_by_id($cardgroup_id);
            $cards = $this->card_model->get_by_cardgroup_id($cardgroup_id);

            $card_columns = $this->card_model->get_fields();
            $card_columns_text = $this->util_model->get_line_of_text_with_saparator_from_array($card_columns, $saparator = "\t");

            $dir_name       = FCPATH."assets/01get_text_file_from_cardgroup";
            $file_name      = "cardgroup.txt";

            $this->file_model->create_file($dir_name,$file_name);

            $text = "card\n";
            $text .= $card_columns_text."\n";

            foreach($cards as $card){
                $card_array = [];
                foreach( $card_columns as $card_column){
                    array_push($card_array,$card->$card_column);

                }

                $text .= $this->util_model->get_line_of_text_with_saparator_from_array($card_array, $saparator = "\t")."\n";

            }

            $this->file_model->write_to_file($dir_name,$file_name, $text);

            $data    = [    "page_title"=>"ท่านได้ส่งออกกลุ่มบัตรคำเรียบร้อยแล้ว",
                            "what_happened"=>"ท่านได้ส่งออกกลุ่มบัตรคำ <strong>12</strong> ของวิชา <strong>xxx EN001 ภาษาอังกฤษxxx</strong> เรียบร้อยแล้ว <br>",
                            "what_todo" => "คลิ๊กที่ปุ่ม​​ <b>ไป</b> เพื่อกลับไปหน้า 'ส่งออกกลุ่มบัตรคำ' ",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url(["Admin","exportCardgroup"])
                        ];        

            $this->_needSomething($data);            
        }
    }

    public function importCard($confirm = 0){
        $this->load->model("card_model");
        $this->load->model("course_model");

        if($this->_if_needToBeAdmin()){return;}

        $dir_name       = FCPATH."assets/02dump_text_file_to_card";
        $file_name      = "card.txt";
        $full_path_name = $dir_name."/".$file_name;

        if( ! is_file($full_path_name )){ die( "There is no file at :".$full_path_name);} 

        $my_file        =   fopen($full_path_name, "r");
        $table_name     =   trim(fgets($my_file));
        $arr_column_name   =   explode("\t", trim(fgets($my_file))); 


        if( $confirm === 0){
            $line = trim(fgets($my_file));
            $arr_element = explode("\t", $line);
            if(count($arr_column_name) !== count($arr_element)){ die("number columns doesn't equal number of elements");}

            $course = $this->course_model->get_by_cardgroup_id($arr_element[1]);

            $what_happened = "นำเข้าบัตรคำในวิชาเรียน <strong>".$course->course_code."::".$course->course_name."</strong><br>";
            $what_happened  .= "ตัวอย่างบัตรคำแรกมีดังต่อไปนี้<br>";
            for ( $i = 0 ; $i < count($arr_column_name); $i++) {
                $what_happened .= "<strong>".$arr_column_name[$i]." </strong> ::".$arr_element[$i]."<br>";
            }

            $num_rows = 1;
            while (!feof($my_file)) {
                $line = trim(fgets($my_file));
                $arr_element = explode("\t", $line);
                $num_rows = $num_rows + 1 ;
            }

            $data    =  [   "page_title"=>"ยืนยันการนำเข้าบทเรียน ".$num_rows." ใบ",
                            "what_happened"=>$what_happened,
                            "what_todo" => "คลิ๊กที่ปุ่ม \"<strong>ยืนยัน</strong>\" หรือปุ่ม \"<strong>ยกเลิก</strong>\" ",
                            "btnText_toConfirm" => "ยืนยัน",
                            "btnLink_toConfirm" => base_url(["Admin","importCard",1]),
                            "btnText_toCancle" => "ยกเลิก",
                            "btnLink_toCancle" => base_url(),
                        ];  

            $this->_confirmSomething($data);

        }else{
            $num_rows = 0;
            while (!feof($my_file)) {
                $line = trim(fgets($my_file));
                $arr_element = explode("\t", $line);
                if(count($arr_column_name) !== count($arr_element)){ die("number columns doesn't equal number of elements");}
                $assoc_detail = [];
                for ( $i = 0 ; $i < count($arr_column_name); $i++) {
                    if( $arr_element[$i] ===  "NULL"){
                        $assoc_detail[ $arr_column_name[$i]] = NULL;    
                    }else{

                        $arr_element[$i] = htmlspecialchars($arr_element[$i], ENT_HTML5 );
                        $assoc_detail[ $arr_column_name[$i]] = $arr_element[$i];
                    }                
                }
                $this->card_model->update_by_id($id = $arr_element[0], $assoc_detail);
                $num_rows = $num_rows + 1;
            }

            $data    = [    "page_title"=>"ท่านได้นำเข้าบัตรคำเรียบร้อยแล้ว",
                            "what_happened"=>"ท่านได้นำเข้าบัตรคำจำนวน <strong>".$num_rows." </strong>ใบ เรียบร้อยแล้ว <br>",
                            "what_todo" => "คลิ๊กที่ปุ่ม​​ <b>ไป</b> เพื่อกลับไป <strong>หน้าแรก</strong>",
                            "btnText_toGo" => "ไป",
                            "btnLink_toGo" => base_url()
                        ];        
            $this->_needSomething($data);     

        }
    }

	public function showNextCard($deck_id = 0) {

        if( $this->_if_needToBeAdmin()){return;}
        
        $this->load->model("course_model");
        $this->load->model("util_model");
        $this->load->model("deck_model");
        $this->load->model("practice_model");
        $this->load->model("card_model");

        if( !($data["user"] = $this->_getLoggedInUser())){return;}
    
        if($deck_id === "0") {

            $origin_decks =  $this->deck_model->get_by_user_id($user->user_id);

            $decks = [];
            foreach( $origin_decks as $deck){

                $deck->course = $this->course_model->get_by_deck_id($deck->deck_id);
                $deck->practice_to_review_today = count($this->practice_model->get_to_review($user->user_id, $deck->deck_id, time(), $next_day= 0) );
                $deck->practice_to_review_tomorrow = count($this->practice_model->get_to_review($user->user_id, $deck->deck_id, time(), $next_day= 1) );
                $deck->user_num_card = count($this->practice_model->get_by_deck_id_and_user_id($deck->deck_id,$user->user_id));
                $deck->total_num_card = count( $this->card_model->get_by_deck_id($deck->deck_id));
                array_push($decks, $deck);
            }
            $decks = $this->util_model->sort_array_of_object_by_the_property( $objects = $decks, 
                                        $sorted_property = "practice_to_review_today", $order_by ="desc");

            $data["decks"] = $decks;
            $data["show_list_of_decks"] = TRUE;
            $data["page_title"] = "ชุดบัตรคำของผู้ดูแลระบบ";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];                        
 
        }else{

            $data["deck"] = $this->deck_model->get_by_id($deck_id);
            $data["course"] = $this->course_model->get_by_deck_id($deck_id);

            $data["practices_to_review_today"] = $this->practice_model->get_to_review($user->user_id, $deck_id, time(), $next_day= 0);
            $data["number_of_practices_to_review_today"] = count($data["practices_to_review_today"]);
            $data["practices_to_review_today"] = array_slice($data["practices_to_review_today"],0,2);

            //Get reviewed cards or added card
            $data["practices_which_have_reviewed_today"] = $this->practice_model->get_which_have_reviewed_today($deck_id, $user->user_id,time());

            $data["number_practices_which_have_reviewed_today"] = count($data["practices_which_have_reviewed_today"]);
            $data["practices_which_have_reviewed_today"] = array_slice($data["practices_which_have_reviewed_today"],0,3);

            $card_id = $this->card_model->get_new_card_id_to_learn($user->user_id, $deck_id, time());
            $data["card"] = $this->card_model->get_by_id($card_id);
            
            $data["show_list_of_decks"] = FALSE;
            $data["page_title"] = "ชุดบัตรคำ ".$data["course"]->course_code."-".$data["deck"]->deck_name." ที่จะถูกเรียกใช้งาน";
            $data["breadcrumbs"] = [
                                        [ "หน้าแรก", base_url()],
                                    ];
        }

        $this->_mainView('showNextCard',$data);
	}

    public function siteSetting(){

        if( $this->_if_needToBeAdmin()){return;}        

        $this->load->model("siteSetting_model");
        

        if($this->input->post('submit') === "submit"){
            $arr_detail =   [];
            $assoc_detail[1] =    $this->input->post("1");
            $assoc_detail[2] =    $this->input->post("2");

            // Siteonline must be "0","1"
            if( ! in_array( $assoc_detail[2], ["0", "1"] )){
                die("  Siteonline must be 0 or 1. ");
            }

            foreach ($assoc_detail as $i => $value) {
                $id = $i;
                $detail = ["sitesetting_value"=>$value];

                if( $this->siteSetting_model->update_by_id($id, $detail) ){
                    $data["if_data_was_updated"] = TRUE;
                }else{
                    $data["if_data_was_updated"] = FALSE;
                }
            }
        }else{
            $data["if_data_was_updated"] = FALSE;
    
        }

        $data["arr_setting"] = $this->siteSetting_model->get_all();

        $data["page_title"] = "ตั้งค่าเว็บไซต์";
        $data["breadcrumbs"] = [
                                    [ "หน้าแรก", base_url()],
                                ];        
        $this->_mainView('siteSetting',$data);
    }

    public function test(){
        if( $this->_if_needLogIn() ){return;}
    }

    
}