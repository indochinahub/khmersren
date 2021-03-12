<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/My_controller.php';

class UnitTest extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('unit_test');
        $this->unit->use_strict(TRUE);
    }

    public function index(){
        echo "Using Unit Test Library <hr>";
        
        $this->preparation();
        $this->testUser_model();
        $this->showReport($this->unit->result(), $this->unit->report());
    }
    
    public function preparation(){
        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->db->query($sql);

        $sql = " DELETE FROM user WHERE user_id = 8 ";
        $this->db->query($sql);
        
        $sql = " DELETE FROM postcategory WHERE  postcategory_id = 1 ";
        $this->db->query($sql);        
    }

    public function testUser_model(){
        $this->load->model("user_model");
        $this->load->model("course_model");
        $this->load->model("deck_model");
        $this->load->model("file_model");
        $this->load->model("util_model");
        $this->load->model("cardgroup_model");
        $this->load->model("card_model");
        $this->load->model("practice_model");
        $this->load->model("lesson_model");
        $this->load->model("my_model");
        $this->load->model("cardComment_model");
        $this->load->model("siteSetting_model");
        $this->load->model("post_model");
        $this->load->model("postCategory_model");

    /*******************************************************************/
        $testName = "postCategory_model:get_by_user_id(user_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->postCategory_model->get_by_user_id($user_id = 1);
        $result02 =  $this->postCategory_model->get_by_user_id($user_id = 0);

        $result         =   [   
                                count($result01),
                                $result01[0]->if_it_is_default,
                                $result02,
                            ];

        $expectedResult =   [   
                                5,
                                TRUE,
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "postCategory_model:get_or_add_default_postcategory(user_id)_ValidArgument_returnObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $sql = " INSERT INTO postcategory (postcategory_id, postcategory_title, postcategory_defaultstatus, id_user) ";
        $sql .= " VALUES ('1', 'ทั่วไป', '1', '2') ";
        $this->db->query($sql);

        $result01 =  $this->postCategory_model->get_or_add_default_postcategory($user_id = 2);

        // Delete the row again
        $sql = " DELETE FROM postcategory WHERE  postcategory_id = 1 ";
        $this->db->query($sql);        

        $result02 =  $this->postCategory_model->get_or_add_default_postcategory($user_id = 3);

        // Delete the row again
        $sql = " DELETE FROM postcategory WHERE  postcategory_id = ".$result02->postcategory_id;
        $this->db->query($sql);                

        // There is no user-id 0
        $result03 =  $this->postCategory_model->get_or_add_default_postcategory($user_id = 0);


        $result         =   [   $result01->postcategory_id,
                                (int)$result02->postcategory_id > 0,
                                $result03
                            ];

        $expectedResult =   [   "1",
                                TRUE,
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "postCategory_model:get_default_postcategory_by_user_id(user_id)_ValidArgument_returnPostcategoryObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $sql = " INSERT INTO postcategory (postcategory_id, postcategory_title, postcategory_defaultstatus, id_user) ";
        $sql .= " VALUES ('1', 'ทั่วไป', '1', '2') ";
        $this->db->query($sql);

        $result01 =  $this->postCategory_model->get_default_postcategory_by_user_id($user_id = 2);

        // Delete the row again
        $sql = " DELETE FROM postcategory WHERE  postcategory_id = 1 ";
        $this->db->query($sql);        

        $result02 =  $this->postCategory_model->get_default_postcategory_by_user_id($user_id = 0);

        $result         =   [   $result01->postcategory_id,
                                $result02,
                            ];

        $expectedResult =   [   "1",
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "postCategory_model:_add_default_postcategory(user_id)_ValidArgument_returnInsertedIdOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $result01 =  $this->postCategory_model->_add_default_postcategory($user_id = 2);
        $result02 =  $this->postCategory_model->_add_default_postcategory($user_id = 0);

        $result         =   [   (int)$result01->postcategory_id > 0,
                                $result02,
                            ];

        $expectedResult =   [   TRUE,
                                FALSE
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Delete the row again
        $sql = " DELETE FROM postcategory WHERE  postcategory_id = ".$result01->postcategory_id;
        $this->db->query($sql);

    /*******************************************************************/
        $testName = "Post_model:move_all_post_in_the_postcategory_to_new_one(old_postcategory,new_postcategory)_ValidArgument_returnAffectedRowsOrFALSE";
        $note = "";
        unset($result);
        unset($expectedResult);

        // No postcategory = 0
        $result01 =  $this->post_model->move_all_post_in_the_postcategory_to_new_one($old_postcategory = 0,$new_postcategory = 12);
        $result02 =  $this->post_model->move_all_post_in_the_postcategory_to_new_one($old_postcategory = 12,$new_postcategory = 0);

        // Move
        $result03 =  $this->post_model->move_all_post_in_the_postcategory_to_new_one($old_postcategory = 12,$new_postcategory = 14);

        $result         =   [   
                                $result01,
                                $result02,
                                $result03,
                            ];

        $expectedResult =   [   
                                [],
                                [],
                                2,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Move the post back to original category
        $sql = " UPDATE post SET id_postcategory= 12 WHERE  id_postcategory = 14 ";
        $this->db->query($sql);

    /*******************************************************************/
        $testName = "Post_model:get_all_post_by_postcategory_id(postcategory_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->post_model->get_all_post_by_postcategory_id($postcategory_id = 0);
        $result02 =  $this->post_model->get_all_post_by_postcategory_id($postcategory_id = 10);

        $result         =   [   
                                $result01,
                                count($result02)
                            ];

        $expectedResult =   [   
                                [],
                                3,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:get_draft_post_by_postcategory_id(postcategory_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->post_model->get_published_post_by_postcategory_id($postcategory_id = 0);
        $result02 =  $this->post_model->get_published_post_by_postcategory_id($postcategory_id = 10);

        $result         =   [   
                                $result01,
                                count($result02),
                            ];

        $expectedResult =   [   
                                [],
                                1,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:get_draft_post_by_postcategory_id(postcategory_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->post_model->get_draft_post_by_postcategory_id($postcategory_id = 0);
        $result02 =  $this->post_model->get_draft_post_by_postcategory_id($postcategory_id = 10);

        $result         =   [   
                                $result01,
                                count($result02),
                            ];

        $expectedResult =   [   
                                [],
                                2,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:get_draft_post_by_user_id(user_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->post_model->get_draft_post_by_user_id($user_id = 0);
        $result02 =  $this->post_model->get_draft_post_by_user_id($user_id = 1);

        $result         =   [   
                                $result01,
                                count($result02),
                            ];

        $expectedResult =   [   
                                [],
                                7,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:get_published_post_by_user_id(user_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->post_model->get_published_post_by_user_id($user_id = 0);
        $result02 =  $this->post_model->get_published_post_by_user_id($user_id = 1);

        $result         =   [   
                                $result01,
                                count($result02),
                            ];

        $expectedResult =   [   
                                [],
                                2,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:update_publish_status(post_id,publish_status)_ValidArgument_returnAffectedRowsOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);

        $sql = " UPDATE post SET post_publishstatus = 0 WHERE post_id = 8 ";
        $this->db->query($sql);

        $result01 =  $this->post_model->update_publish_status($post_id = 8,$publish_status = 1);
        $result02 =  $this->post_model->update_publish_status($post_id = 8,$publish_status = 0);

        // There is no post_id 0 return 0
        $result03 =  $this->post_model->update_publish_status($post_id = 0,$publish_status = 0);

        // There is no publish_status = 3
        $result04 =  $this->post_model->update_publish_status($post_id = 0,$publish_status = 3);

        $result         =   [   
                                $result01,
                                $result02,
                                $result03,
                                $result04,
                            ];

        $expectedResult =   [   
                                1,
                                1,
                                0,
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:get_all_post_by_arr_postcategory_id(arr_postcategory_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $result01 =  $this->post_model->get_all_post_by_arr_postcategory_id($arr_postcategory_id = []);
        $result02 =  $this->post_model->get_all_post_by_arr_postcategory_id($arr_postcategory_id = [10]);
        $result03 =  $this->post_model->get_all_post_by_arr_postcategory_id($arr_postcategory_id = [10,11]);
        $result04 =  $this->post_model->get_all_post_by_arr_postcategory_id($arr_postcategory_id =  "" );

        $result         =   [   
                                $result01,
                                count($result02),
                                count($result03),
                                $result04,
                            ];

        $expectedResult =   [   
                                [],
                                3,
                                7,
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Post_model:get_all_post_by_user_id(user_id)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $result01 =  $this->post_model->get_all_post_by_user_id($user_id = 1);
        $result02 =  $this->post_model->get_all_post_by_user_id($user_id = 0);

        $result         =   [   
                                count($result01),
                                $result02
                            ];

        $expectedResult =   [   
                                9,
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    		

    /*******************************************************************/
        $testName = "SiteSetting_model:if_site_is_online()_NoArgument_returnTrueOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $result01 =  $this->siteSetting_model->if_site_is_online();
        
        $result         =   [   $result01,
                            ];

        $expectedResult =   [   TRUE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    		
    /*******************************************************************/
        $testName = "SiteSetting_model::get_sitesetting_value(property)_GetValidArgument_returnTextOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $result01 =  $this->siteSetting_model->get_sitesetting_value($property = "sitename");
        $result02 =  $this->siteSetting_model->get_sitesetting_value($property = "xxxx");
        
        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   "Khmersren.com",
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    		

    /*******************************************************************/
        $testName = "Helper::get_start_item_for_pagination(current_page, per_page)_ValidArgument_NumberOfStartItem";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $result01 =  get_start_item_for_pagination( $current_page = 1, $per_page = 5);
        $result02 =  get_start_item_for_pagination( $current_page = 2, $per_page = 5);
        $result03 =  get_start_item_for_pagination( $current_page = 3, $per_page = 5);

        $result         =   [   $result01,
                                $result02,
                                $result03,
                            ];

        $expectedResult =   [   0,
                                5,
                                10,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    		

    /*******************************************************************/
        $testName = "Helper::get_prepared_text_for_mySQL(text)_GetValidArgument_returnFormatedText";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_prepared_text_for_mySQL($text = " This should be trim. ");
        $result02 =  get_prepared_text_for_mySQL($text = " It should change [ <a href='test'>Test</a> ] to htmlspechialchar.");
        
        $result         =   [   $result01,
                            ];

        $expectedResult =   [   "This should be trim.",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    		

    /*******************************************************************/
        $testName = "Helper::get_thai_dateTime_from_sqlTimeStamp(sqlTimeStamp)_GetValidArgument_returnThaiDateTime";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_thai_dateTime_from_sqlTimeStamp($sqlTimeStamp = "2021-01-28 09:39:42");

        $result         =   [   $result01,
                            ];

        $expectedResult =   [   "28 ม.ค. 2564 09:39 น.",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Helper::get_thai_date_from_sqlTimeStamp(sqlTimeStamp)_GetValidArgument_returnThaiDate";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_thai_date_from_sqlTimeStamp($sqlTimeStamp = "2021-01-28 09:39:42");

        $result         =   [   $result01,
                            ];

        $expectedResult =   [   "28 ม.ค. 2564",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Helper::get_date_part_from_sqlTimeStamp(sqlTimeStamp)_GetValidArgument_returnDatePart";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_date_part_from_sqlTimeStamp($sqlTimeStamp = "2021-01-24 14:15:01");

        $result         =   [   $result01,
                            ];

        $expectedResult =   [   "2021-01-24",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Helper::get_new_iterval_num_day(current_intervalDay,interval_constant)_GetValidArgument_returnInt";    
        $note = "";
        unset($result);
        unset($expectedResult);

        // sqlTimeStamp = '2020-02-25 01:00:00'
        // unix_timestamp = 1582567200        
        $result01 =  get_sqltimeStamp_at_midnight_for_next_num_day( $unix_time_stamp    =  1582567200, 
                                                                    $num_day = 0 );
        $result02 =  get_sqltimeStamp_at_midnight_for_next_num_day( $unix_time_stamp    =  1582567200, 
                                                                    $num_day = -1 );
        $result03 =  get_sqltimeStamp_at_midnight_for_next_num_day( $unix_time_stamp    =  1582567200, 
                                                                    $num_day = 1 );

        $result         =   [   $result01,
                                $result02,
                                $result03,
                            ];

        $expectedResult =   [   "2020-02-25 00:00:00",
                                "2020-02-24 00:00:00",
                                "2020-02-26 00:00:00",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Helper::get_new_iterval_num_day(current_intervalDay,interval_constant)_GetValidArgument_returnInt";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_new_iterval_num_day( $current_intervalDay = 1, $interval_constant = 4);
        $result02 =  get_new_iterval_num_day( $current_intervalDay = 2, $interval_constant = 4);
        $result03 =  get_new_iterval_num_day( $current_intervalDay = 3, $interval_constant = 4);
        $result04 =  get_new_iterval_num_day( $current_intervalDay = 10, $interval_constant = 4);
        $result05 =  get_new_iterval_num_day( $current_intervalDay = 2000, $interval_constant = 4);
        $result06 =  get_new_iterval_num_day( $current_intervalDay = 5000, $interval_constant = 4);

        $result         =   [   $result01,
                                $result02,
                                $result03,
                                $result04,
                                $result05,
                                $result06,
                            ];

        $expectedResult =   [   2,
                                8,
                                12,
                                40,
                                4000,
                                4000,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Helper::sqltimestamp_to_unixtimestamp(sqltimestamp )_GetValidArgument_returnUnixTimeStamp";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  sqltimestamp_to_unixtimestamp( $sqltimestamp = '2020-02-25 01:00:00' );

        $result         =   [   $result01
                            ];

        $expectedResult =   [   1582567200,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Helper::get_sqltimeStamp_of_the_time_for_next_num_day(unix_time_stamp,num_day)_GetValidArgument_returnSqlTimeStamp";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_sqltimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132, $next_day = 0);
        $result02 =  get_sqltimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132, $next_day = 3);
        $result03 =  get_sqltimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132, $next_day = -3);

        $result         =   [   $result01,
                                $result02,
                                $result03,
                            ];

        $expectedResult =   [   "2021-01-04 15:15:32",
                                "2021-01-07 15:15:32",
                                "2021-01-01 15:15:32",

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Helper::get_unixTimeStamp_of_the_time_for_next_num_day(unix_time_stamp,num_day)_GetValidArgument_returnUnixTimeStamp";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  get_unixTimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132 , $next_day = 0);
        $result02 =  get_unixTimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132 , $next_day = 1);
        $result03 =  get_unixTimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132 , $next_day = 3);
        $result04 =  get_unixTimeStamp_of_the_time_for_next_num_day($unix_time_stamp = 1609748132 , $next_day = -3);

        $result         =   [   $result01,
                                $result02,
                                $result03,
                                $result04,
                            ];

        $expectedResult =   [   1609748132,
                                1609834532,
                                1610007332,
                                1609488932
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Helper::get_userlevel_text(user_level)_getValidParam_returnText";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = get_userlevel_text($user_level = 1);
        $result02 = get_userlevel_text($user_level = 2);
        $result03 = get_userlevel_text($user_level = 3);

        $result             =   [   $result01,
                                    $result02,
                                    $result03,
                                ];
        $expectedResult     =   [   "ผู้เรียน",
                                    "ครู",
                                    "ผู้ดูแลระบบ",
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);        

    /*******************************************************************/
        $testName = "Util_model::get_object_from_arr_object_with_pointer_by_key_id(arr_object,key_column)_GetValidArgument_returnObjectOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);

        $student1 = new stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        // Return false
        $result01 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = [], 
                            $key_column = "id", 
                            $key_id = "1"
                        );
        $result02 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "", 
                            $key_id = "1"
                        );
        $result03 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = ""
                        );                        
        $result04 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "1"
                        );
        $result05 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "2"
                        );                        
        $result06 = $this->util_model->get_object_from_arr_object_with_pointer_by_key_id(
                            $arr_object = $arr_student, 
                            $key_column = "id", 
                            $key_id = "3"
                        );                        

        $result         =   [   $result01,
                                $result02,
                                $result03,
                                $result04->previous_id, //id = 1
                                $result04->next_id,
                                $result05->previous_id, //id = 2
                                $result05->next_id,
                                $result06->previous_id, //id = 3
                                $result06->next_id,                                                                
                            ];

        $expectedResult =   [   FALSE,
                                FALSE,
                                FALSE,
                                FALSE,  //id = 1
                                2,
                                1,  //id = 2
                                3,
                                2,  //id = 3
                                FALSE,                                                                
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::get_object_from_arr_object_that_match_property_condition(origin_arr_object,property_name,text_to_compare)_GetValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $student1 = new stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        $result01 = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                            $origin_arr_object = [],
                            $property_name = "id",
                            $text_to_compare = 2,
                            $operator = "=="
                        );

        $result02 = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                        $origin_arr_object = $arr_student,
                        $property_name = "id",
                        $text_to_compare = 2,
                        $operator = "=="
                    );

        $result03 = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                        $origin_arr_object = $arr_student,
                        $property_name = "id",
                        $text_to_compare = "2", // It's OK to use 2 or "2"
                        $operator = "=="
                    );

        $result04 = $this->util_model->get_object_from_arr_object_that_match_property_condition(
                        $origin_arr_object = $arr_student,
                        $property_name = "name",
                        $text_to_compare = "Arun",
                        $operator = "=="
                    ); 

        $result         =   [   
                                $result01,
                                count($result02),
                                count($result03),
                                count($result04),
                            ];

        $expectedResult =   [
                                [],
                                1,
                                1,
                                1,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::get_assoc_from_array_of_object(arr_object,propery_as_key)_GetValidArgument_returnAssoc_Arrau";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $student1 = new stdClass;
        $student1->id = 1;
        $student1->name = "Wittaya";

        $student2 = new stdClass;
        $student2->id = 2;
        $student2->name = "Wicha";

        $student3 = new stdClass;
        $student3->id = 3;
        $student3->name = "Arun"; 

        $arr_student = [$student1, $student2, $student3];

        $result01 =  $this->util_model->get_assoc_from_array_of_object($arr_object = $arr_student, $key_property = "id");


        $result         =   [   count($result01),
                                is_object($result01["1"]),
                                $result01["1"]->name,
                            ];

        $expectedResult =   [   3,
                                TRUE,
                                "Wittaya",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::get_line_of_text_with_saparator_from_array(arrs,saparator)_GetValidArgument_returnText";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $arrs = ["text1","text2","text3"];
        $saparator = "---";
        $result01 =  $this->util_model->get_line_of_text_with_saparator_from_array($arrs, $saparator);

        $arrs = [];
        $saparator = "---";
        $result02 =  $this->util_model->get_line_of_text_with_saparator_from_array($arrs, $saparator);
        

        $result         =   [   $result01,
                                $result02,

                            ];

        $expectedResult =   [   "text1---text2---text3",
                                "",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::get_property_values_of_one_object_as_array(object_name)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $obj            = new stdClass();
        $obj->name      = "Wittaya";
        $obj->surname   = "Wijit";
        $result01 =  $this->util_model->get_property_values_of_one_object_as_array($object_name = $obj);

        $obj            = new stdClass();
        $result02 =  $this->util_model->get_property_values_of_one_object_as_array($object_name = $obj);

        $result         =   [   $result01,
                                $result02,

                            ];

        $expectedResult =   [   ["Wittaya","Wijit"],
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::sort_array_of_object_by_the_property(objects,sorted_property,order_by)_GetArrayOfDeckId_returnArrayOfObjects";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $user1          = new stdClass();
        $user1->id      = 11;
        $user1->name    = "Wittaya";
        $user1->age     = 45;

        $user2          = new stdClass();
        $user2->id      = 12;
        $user2->name    = "Sawitree";
        $user2->age     = 42;

        $user3          = new stdClass();
        $user3->id      = 13;
        $user3->name    = "Somrudee";
        $user3->age     = 30;

        $objects = [$user1, $user2, $user3];

        $result01 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = $objects,     
                                $sorted_property = "id", 
                                $order_by="asc"
                            );

        $result02 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = $objects,     
                                $sorted_property = "id", 
                                $order_by="desc"
                            );

        $result03 =  $this->util_model->sort_array_of_object_by_the_property( 
                                $objects = $objects,     
                                $sorted_property = "age", 
                                $order_by="asc"
                            );                            

        $result         =   [   [$result01[0]->id, $result01[1]->id,$result01[2]->id],
                                [$result02[0]->id, $result02[1]->id,$result02[2]->id],
                                [$result03[0]->id, $result03[1]->id,$result03[2]->id],
                            ];

        $expectedResult =   [  [11, 12, 13],
                            [13, 12, 11],
                            [13, 12, 11],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::get_property_value_Of_many_objects_as_array(array_of_objects,property)_GetValidArgument_returnArray";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $myObj1 = new stdClass();
        $myObj1->my_id = "01";
        $myObj1->my_name = "Wittaya";

        $myObj2 = new stdClass();
        $myObj2->my_id = "02";
        $myObj2->my_name = "Wichai";

        $myObj3 = new stdClass();
        $myObj3->my_id = "03";
        $myObj3->my_name = "Sathit";

        $result01 =  $this->util_model->get_property_value_Of_many_objects_as_array(
                                        $array_of_objects =[$myObj1,$myObj2,$myObj3],
                                        $property = "my_id" );

        $result02 =  $this->util_model->get_property_value_Of_many_objects_as_array(
                                        $array_of_objects =[$myObj1,$myObj2,$myObj3],
                                        $property = "my_name" );

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   ["01","02","03"] ,
                                ["Wittaya","Wichai","Sathit"]
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Util_model::get_property_names_of_one_object_as_array(object_name)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $obj            = new stdClass();
        $obj->name      = "Wittaya";
        $obj->surname   = "Wijit";
        $result01 =  $this->util_model->get_property_names_of_one_object_as_array($object_name = $obj);

        $obj            = new stdClass();
        $result02 =  $this->util_model->get_property_names_of_one_object_as_array($object_name = $obj);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   ["name","surname"],
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    


    /*******************************************************************/
        $testName = "User_model::get_by_post_id(post_id)_getValidParam_returnUserObjectOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->user_model->get_by_post_id($post_id = 0);
        $result02 = $this->user_model->get_by_post_id($post_id = 8);

        $result             =   [   
                                    $result01,
                                    is_object($result02),
                                ];
        $expectedResult     =   [   
                                    FALSE,
                                    TRUE
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "User_model::update_visit_time(id)_getValidParam_returnTRUE";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->user_model->update_visit_time($id = 1);

        $result             =   [   $result01,

                                ];
        $expectedResult     =   [   TRUE,

                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "User_model::get_all_users_order_by_visit_time(limits)_getValidParam_returnArrayOfObjects";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->user_model->get_all_users_order_by_visit_time();
        $result02 = $this->user_model->get_all_users_order_by_visit_time($limits = [0,5]);

        $result             =   [   count($result01) > 0,
                                    count($result02),
                                ];
        $expectedResult     =   [   TRUE,
                                    5,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "User_model::get_user_by_id(user_id)_getValidParam_returnObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->user_model->get_user_by_id($user_id = 1);
        $result02 = $this->user_model->get_user_by_id($user_id = 2);
        $result03 = $this->user_model->get_user_by_id($user_id = 0);


        $result             =   [   $result01->user_username,
                                    $result01->avartar_url,
                                    $result01->user_display_name,
                                    $result01->userlevel_text,
                                    $result02->user_display_name,
                                    $result03,
                                ];
        $expectedResult     =   [   "user01",
                                    "http://127.0.0.1/test/assets/images/user_pics/1.jpg",
                                    "Surasak",
                                    "ผู้เรียน",
                                    "user02",
                                    FALSE,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "User_model::get_avartar_url(user_id)_getValidParam_returnText";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->user_model->get_avartar_url($user_id = 1);
        $result02 = $this->user_model->get_avartar_url($user_id = 0);

        $result             =   [   $result01,
                                    $result02,
                                ];
        $expectedResult     =   [   "http://127.0.0.1/test/assets/images/user_pics/1.jpg" ,
                                    "http://127.0.0.1/test/assets/images/user_pics/anonymous.jpg"
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "User_model::get_by_username_password(username,password)_getValidParam_returnUserId";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->user_model->get_by_username_password($username = "admin" , $password = "1234");
        $result02 = $this->user_model->get_by_username_password($username = "yyy" , $password = "xxxx");

        $result             =   [   $result01->user_username,
                                    $result02
                                ];
        $expectedResult     =   [   "admin" ,
                                    FALSE,
                                    
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Practice_model::get_num_practice_to_review_for_user(user_id,unit_timestamp,next_day)_GetValidArgument_returnInt";
        $note = "";
        unset($result);
        unset($expectedResult);

        // '2020-05-22 08:30:00' = unix time : 1590111000
        $result01 =  $this->practice_model->get_num_practice_to_review_for_user($user_id = 1, 
                                        $unix_timestamp = time(), $next_day = 0 );



        $result         =   [   $result01,

                            ];

        $expectedResult =   [   19,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    
        
    /*******************************************************************/
        $testName = "Practice_model::get_practices_which_have_reviewed_today(deck_id,user_id,unix_timestamp)_GetValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        // '2020-05-22 08:30:00' = unix time : 1590111000
        $result01 =  $this->practice_model->get_which_have_reviewed_today($deck_id = 1, $user_id = 1,
                                            $unix_timestamp = 1590111000);
        $result02 =  $this->practice_model->get_which_have_reviewed_today($deck_id = 0, $user_id = 0,
                                            $unix_timestamp = 1590111000);

        $result         =   [   $result01[ 0]->practice_id,
                                $result02,
                            ];

        $expectedResult =   [   "1",
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Practice_model::get_visit_time(user_id,deck_id)_GetValidArgument_returnInt";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->practice_model->get_visit_time($user_id = 1,$deck_id = 1);
        $result02 =  $this->practice_model->get_visit_time($user_id = 0,$deck_id = 0);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   14,
                                0,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Practice_model::get_to_review(user_id,deck_id,current_unix_timestamp,next_day)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        //$this->card_model->set_current_card($card_id = 0, $deck_id = 1 ,$user_id = 1);

        $result01 =  $this->practice_model->get_to_review(
                                            $user_id = 1,
                                            $deck_id = 1,
                                            $unix_timestamp = 1582567200, // sqlTimeStamp = '2020-02-25 01:00:00'
                                            $next_day= 0    
                                        );

        $result02 =  $this->practice_model->get_to_review(
                                            $user_id = 1,
                                            $deck_id = 1,
                                            $unix_timestamp = time(), // now
                                            $next_day= 0    
                                        );
        
        $result03 =  $this->practice_model->get_to_review(
                                            $user_id = 0,
                                            $deck_id = 0,
                                            $unix_timestamp = time(),
                                            $next_day= 0    
        );

        $result         =   [   count($result01),
                                count($result02),
                                count($result03),

                            ];


        $expectedResult =   [   9,
                                12,
                                0,                                
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Practice_model::get_by_deck_id_and_user_id(deck_id,user_id)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);


        $result01 =  $this->practice_model->get_by_deck_id_and_user_id($deck_id = 1,$user_id = 1);
        $result02 =  $this->practice_model->get_by_deck_id_and_user_id($deck_id = 0,$user_id = 1);

        $result         =   [   count($result01),
                                count($result02),    
                            ];

        $expectedResult =   [   12,
                                0,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Practice_model::get_by_card_id_deck_id_user_id()_GetValidArgument_returnObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->practice_model->get_by_card_id_deck_id_user_id($card_id = 1, $deck_id = 1, $user_id = 1);
        $result02 =  $this->practice_model->get_by_card_id_deck_id_user_id($card_id = 0, $deck_id = 0, $user_id = 0);        

        $result         =   [   $result01->practice_id,
                                $result02,
                            ];

        $expectedResult =   [   "1",
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    


    /*******************************************************************/
        $testName = "Practice_model::get_average_practice_interval(deck_id,user_id)_GetValidArgument_returnInt";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->practice_model->get_average_interval($deck_id = 1 ,$user_id = 1);
        $result02 =  $this->practice_model->get_average_interval($deck_id = 1 ,$user_id = 0);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   1,
                                0,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Lesson_model::get_by_course_id(course_id)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->lesson_model->get_by_course_id($course_id = 1);
        $result02 =  $this->lesson_model->get_by_course_id($course_id = 0);

        $result         =   [   count($result01),
                                $result02
                            ];

        $expectedResult =   [   63,
                                []
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "File_model::write_to_file(dir_name,file_name,text)_getValidArgument_ReturnTRUEOrFALSE";    
        $note = "";
        unset($result);
        unset($expectedResult);

        
        $dir_name = FCPATH."assets/test/007write_to_file";
        $file_name = "write_text.txt";
        $text = "Hello, Everybody! ";

        // Create Blank File
        $my_file = fopen( $dir_name."/".$file_name, 'w') ;
        fclose($my_file);

        $result01 = $this->file_model->write_to_file($dir_name,$file_name, $text);

        $dir_name = FCPATH."assets/test/007write_to_file";
        $file_name = "kkkkkk"; //There is no file.
        $text = "Hello, Everybody! ";  
        $result02 = $this->file_model->write_to_file($dir_name,$file_name, $text);

        $result             =   [   $result01,
                                    $result02,
                                ];
                        
        $expectedResult     =   [   TRUE,
                                    FALSE,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "File_model::delete_dir(dir_name)_getValidArgument_ReturnTRUEOrFALSE";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $dir_name01 = FCPATH."assets/test/006delete_dir";
        $result01 = $this->file_model->delete_dir($dir_name01);

        $dir_name02 = FCPATH."assets/test/xxxx";
        $result02 = $this->file_model->delete_dir($dir_name02);

        $result             =   [   $result01,
                                    $result02,
                                ];
                        
        $expectedResult     =   [   TRUE,
                                    FALSE,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Create dir again
        mkdir($dir_name01);

    /*******************************************************************/
        $testName = "File_model::delete_all_files_in_dir(dir_name)_getValidArgument_ReturnTRUEOrFALSE";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $dir_name = FCPATH."assets/test/005delete_all_files_in_dir";

        $my_file = fopen( $dir_name."/"."test01.txt", 'w') ;
        fclose($my_file);
        $my_file = fopen( $dir_name."/"."test02.txt", 'w') ;
        fclose($my_file);
        $my_file = fopen( $dir_name."/"."test03.txt", 'w') ;
        fclose($my_file);

        $result01 = $this->file_model->delete_all_files_in_dir($dir_name);

        $dir_name = FCPATH."assets/test/xxxx";
        $result02 = $this->file_model->delete_all_files_in_dir($dir_name);

        $result             =   [   $result01,
                                    $result02,
                                ];
                        
        $expectedResult     =   [   TRUE,
                                    FALSE,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "File_model::get_file_names_in_dir(dir_name)_getValidArgument_ReturnArrayOfTextOrFALSE";    
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $dir_name = FCPATH."assets/test/004get_file_names_in_dir1";
        $result01 = $this->file_model->get_file_names_in_dir($dir_name);

        $dir_name = FCPATH."assets/test/xxx";
        $result02 = $this->file_model->get_file_names_in_dir($dir_name);

        $dir_name = FCPATH."assets/test/004get_file_names_in_dir2";
        $result03 = $this->file_model->get_file_names_in_dir($dir_name);        

        $result             =   [   count($result01),
                                    $result02,
                                    $result03,
                                ];
                        
        $expectedResult     =   [   3,
                                    FALSE,
                                    [],
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "File_model::delete_file(dir_name,file_name)_getValidArgument_ReturnTrueFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $dir_name = FCPATH."assets/test/003delete_file";
        $file_name = "test.txt";

        $result01 = $this->file_model->delete_file($dir_name,$file_name);
        $result02 = $this->file_model->delete_file($dir_name ,"xxx");

        $result             =   [   $result01,
                                    $result02,
                                ];
                        
        $expectedResult     =   [   TRUE,
                                    FALSE, // No such a file to be deleted
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Create File again
        $my_file = fopen($dir_name."/".$file_name, 'w');
        fclose($my_file);

    /*******************************************************************/
        $testName = "File_model::create_file(dir_name,file_name)_getValidArgument_ReturnTrueFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $dir_name = FCPATH."assets/test/002create_file";
        $file_name = "test.txt";
        $result01 = $this->file_model->create_file($dir_name,$file_name);
        $result02 = $this->file_model->create_file($dir_name,$file_name);

        $dir_name = FCPATH."assets/test/xxxx";
        $file_name = "test.txt";
        $result03 = $this->file_model->create_file($dir_name,$file_name);

        $result             =   [   $result01,
                                    $result02,
                                    $result03,
                                ];
                           
        $expectedResult     =   [   TRUE,
                                    TRUE, // Recreate the new file.
                                    FALSE, // There is no directory so the file won't be created.
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "File_model::create_dir(dir)_getValidArgument_ReturnTrueFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $dir_name = FCPATH."assets/test/001create_dir";

        // Delete Dir
        if(is_dir($dir_name)){rmdir($dir_name);}
        // Create Dir
        $result01 = $this->file_model->create_dir($dir_name);

        $result             =   [   $result01,
                                ];
        $expectedResult     =   [   TRUE,
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Deck_model::get_deck_content_in_html(content,column_name)_GetValidArgument_returnContentInHTMLOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->deck_model->get_content_in_html($deck_id = 19, $content="test", $column_name="card_text1");
        $result02 =  $this->deck_model->get_content_in_html($deck_id = 19, $content="test", $column_name="card_text10");
        $result03 =  $this->deck_model->get_content_in_html($deck_id = 19, $content="AmKZUZ9clKs", $column_name="card_youtube");
        $result04 =  $this->deck_model->get_content_in_html($deck_id = 19, $content="00480a.mp3", $column_name="card_sound1");
        $result05 =  $this->deck_model->get_content_in_html($deck_id = 19, $content="0240.jpg", $column_name="card_picture1");
        $result06 =  $this->deck_model->get_content_in_html($deck_id = 19, $content="xxx.jpg", $column_name="card_picture1");

        $result         =   [   $result01,
                                $result02,
                                strlen($result03) > 50, //'<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/AmKZUZ9clKs" allowfullscreen=""></iframe></div>',
                                strlen($result04) > 50,
                                strlen($result05) > 50,
                                strlen($result06) > 50, //"Picture is not found : D:\\xampp\htdocs\khmersren\assets\course/ENG01/image/xxx.jpg",
                            ];

        $expectedResult =   [   "test",
                                "test",
                                TRUE,
                                TRUE,
                                TRUE,
                                TRUE,                                
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Deck_model::get_decks_by_user_id(user_id)_GetObject_returnArrayOfObjects";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->deck_model->get_by_user_id($user_id = 1);
        $result02 =  $this->deck_model->get_by_user_id($user_id = 0);


        $result         =   [   count($result01),
                                $result02,
                            ];

        $expectedResult =   [   3,
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Deck_model::get_decks_by_course_id(course_id)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->deck_model->get_by_course_id($course_id = 0);
        $result02 =  $this->deck_model->get_by_course_id($course_id = 1);
        $result         =   [   $result01,
                                count($result02)
                            ];

        $expectedResult =   [   [],
                                5
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Deck_model::get_by_cardgroup_id(cardgroup_id)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->deck_model->get_by_cardgroup_id($cardgroup_id = 1);
        $result02 =  $this->deck_model->get_by_cardgroup_id($cardgroup_id = 0);

        $result         =   [   $result01[0]->deck_name,
                                $result02
                            ];

        $expectedResult =   [   "Practice 01",
                                []
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);



    /*******************************************************************/
        $testName = "Course_model::get_course_thumbnail_url(course_code)_getValidArgument_returnURL";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->course_model->get_thumbnail_url($course_code = "T001");
        $result02 = $this->course_model->get_thumbnail_url($course_code = "xxx");

        $result             =   [	$result01,
                                    $result02,
                                ];
                                
        $expectedResult     =   [	"http://127.0.0.1/khmersren/assets/course/T001/course_thumbnail.jpg",
                                    "http://127.0.0.1/khmersren/assets/course/course_thumbnail.jpg",
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);		

    /*******************************************************************/
        $testName = "Course_model::get_by_lesson_id(lesson_id)_GetValidArgument_returnObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->course_model->get_by_lesson_id($lesson_id = 1);
        $result02 =  $this->course_model->get_by_lesson_id($lesson_id = 0);

        $result         =   [   $result01->course_name,
                                $result02
                            ];

        $expectedResult =   [   "Test Course",
                                FALSE
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Course_model::get_by_deck_id(deck_id)_GetValidArgument_returnObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->course_model->get_by_deck_id($deck_id = 1);
        $result02 =  $this->course_model->get_by_deck_id($deck_id = 0);

        $result         =   [   $result01->course_code,
                                $result02
                            ];

        $expectedResult =   [   "T001",
                                FALSE

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Course_model::get_by_coursetype_id(coursetype_id)_getArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 = $this->course_model->get_by_coursetype_id($coursetype_id = 1);
        $result02 = $this->course_model->get_by_coursetype_id($coursetype_id = 0);

        $result             =   [   $result01[0]->course_shortname,
                                    $result02,
                                ];
        $expectedResult     =   [   "Test Course",
                                    [],
                                ];

        $this->unit->run($result, $expectedResult, $testName, $note);
        
    /*******************************************************************/
        $testName = "Course_model::get_by_cardgroup_id(cardgroup_id)_GetValidArgument_returnObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->course_model->get_by_cardgroup_id($cardgroup_id = 1);
        $result02 =  $this->course_model->get_by_cardgroup_id($cardgroup_id = 0);

        $result         =   [   $result01->course_code,
                                $result02      
                            ];

        $expectedResult =   [   "T001",
                                FALSE
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "Cardgroup_model::get_by_course_id(course_id)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->cardgroup_model->get_by_course_id($course_id = 1);
        $result02 =  $this->cardgroup_model->get_by_course_id($course_id = 0);
        $result         =   [   $result01[0]->cardgroup_name,
                                $result02
                            ];

        $expectedResult =   [   "CardGroup01 Of Test Course",
                                []
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "CardComment_model::get_by_deck_id(deck_id,limits)_GetValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->cardComment_model->get_by_deck_id($deck_id = 1);
        $result02 =  $this->cardComment_model->get_by_deck_id($deck_id = 1, $limits = [0,2]);
        $result03 =  $this->cardComment_model->get_by_deck_id($deck_id = 0);

        $result         =   [   count($result01),
                                count($result02),
                                count($result03),

                            ];

        $expectedResult =   [   6,
                                2,
                                0,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "CardComment_model::get_by_card_id_and_deck_id(card_id,deck_id)_GetValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->cardComment_model->get_by_card_id_and_deck_id($card_id = 1, $deck_id = 1);
        $result02 =  $this->cardComment_model->get_by_card_id_and_deck_id($card_id = 0, $deck_id = 0);

        $result         =   [   count($result01),
                                $result02,
                            ];
                    
        $expectedResult =   [   6,
                                []
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::insert_blank_card()_ValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->card_model->insert_blank_card();

        $result         =   [   $result01 > 0,

                            ];

        $expectedResult =   [   TRUE,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

        $sql = " DELETE FROM card WHERE card_id = ".$result01;
        $query = $this->db->query($sql);

    /*******************************************************************/
        $testName = "Card_model::get_by_cardgroup_id(cardgroup_id)_ValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->card_model->get_by_cardgroup_id($cardgroup_id = 1);
        $result02 =  $this->card_model->get_by_cardgroup_id($cardgroup_id = 0);

        $result         =   [   count($result01),
                                $result02,
                            ];

        $expectedResult =   [   15,
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_shuffled_choices(card_to_display_in_html,random_choices)_GetObject_returnShuffledChoices";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $card_to_display_in_html = new stdClass();

        $card_to_display_in_html->deck_choice1a_col = "deck_choice1a_col in HTML";
        $card_to_display_in_html->deck_choice1b_col = "deck_choice1b_col in HTML";
        $card_to_display_in_html->deck_choice1c_col = "deck_choice1c_col in HTML";
        $card_to_display_in_html->deck_choice1d_col = "deck_choice1d_col in HTML";

        $card_to_display_in_html->deck_choice2a_col = "deck_choice2a_col in HTML";
        $card_to_display_in_html->deck_choice2b_col = "deck_choice2b_col in HTML";
        $card_to_display_in_html->deck_choice2c_col = "deck_choice2c_col in HTML";
        $card_to_display_in_html->deck_choice2d_col = "deck_choice2d_col in HTML";

        $card_to_display_in_html->deck_choice3a_col = "deck_choice3a_col in HTML";
        $card_to_display_in_html->deck_choice3b_col = "deck_choice3b_col in HTML";
        $card_to_display_in_html->deck_choice3c_col = "deck_choice3c_col in HTML";
        $card_to_display_in_html->deck_choice3d_col = "deck_choice3d_col in HTML";

        $card_to_display_in_html->deck_choice4a_col = "deck_choice4a_col in HTML";
        $card_to_display_in_html->deck_choice4b_col = "deck_choice4b_col in HTML";
        $card_to_display_in_html->deck_choice4c_col = "deck_choice4c_col in HTML";
        $card_to_display_in_html->deck_choice4d_col = "deck_choice4d_col in HTML";

        $random_choices = [ 1, 2, 3, 4];
        shuffle($random_choices);

        $result01 =  $this->card_model->get_shuffled_choices($card_to_display_in_html,
                                $random_choices);

        $result         =   [   is_object($result01),
                            ];

        $expectedResult =   [   TRUE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_next_card_id_to_review_or_get_new(deck_id,user_id,unix_timestamp)_GetValidArgument_CardObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);


        $result01 =  $this->card_model->get_next_card_id_to_review_or_get_new($deck_id = 1 , $user_id = 1, time() );


        $result         =   [   $result01,

                            ];


        $expectedResult =   [   3,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_next_card_id_to_review(unix_timestamp)_GetValidArgument_CardObjectOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result01 =  $this->card_model->get_next_card_id_to_review($user_id = 1, $deck_id = 1, $unix_timestamp = 1582567200);
        $result02 =  $this->card_model->get_next_card_id_to_review($user_id = 0, $deck_id = 1, $unix_timestamp = 1582567200);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   3,
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_new_card_id_to_learn(unix_timestamp)_GetValidArgument_returnIntOrFalse";    
        $note = "";
        unset($result);
        unset($expectedResult);

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result01 =  $this->card_model->get_new_card_id_to_learn($user_id = 1, $deck_id = 1, $unix_timestamp = 1582567200);

        // sqlTimeStamp = '2020-02-25 01:00:00'
        $result02 =  $this->card_model->get_new_card_id_to_learn($user_id = 0, $deck_id = 0, $unix_timestamp = 1582567200);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   13,
                                FALSE
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_card_to_display_in_html()_NoArgument_returnObjectWithNewProperty";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->card_model->get_card_to_display_in_html($card_id = 1, $deck_id = 1);

        $result         =   [ is_object($result01),
                            ];

        $expectedResult =   [   TRUE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_card_ids_by_deck_id(deck_id)_GetValidArgument_ArrayOfId";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->card_model->get_card_ids_by_deck_id($deck_id = 1);
        $result02 =  $this->card_model->get_card_ids_by_deck_id($deck_id = 0);    

        $result         =   [   count($result01),
                                $result02,
                            ];

        $expectedResult =   [   15,
                                [],
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);    

    /*******************************************************************/
        $testName = "Card_model::get_by_deck_id(deck_id)_GetValidArgument_returnArrayOfObject";    
        $note = "";
        unset($result);
        unset($expectedResult);

        $result01 =  $this->card_model->get_by_deck_id($deck_id = 1);
        $result02 =  $this->card_model->get_by_deck_id($deck_id = 0);

        $result         =   [   count($result01) ,
                                count($result02)
                            ];
        $expectedResult =   [   15,
                                0
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:update_by_id(id,detail)_ValidArgument_returnNumberOfAffectedRows";
        $note = "";
        unset($result);
        unset($expectedResult);

        // Create the row to update
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->db->query($sql);
        
        $this->my_model->set_table_name_for_testing($table_name = "user");
        $detail = ["user_username"=>"xxxx"];
        $result01 =  $this->my_model->update_by_id($id = 7, $detail);

        $result         =   [   $result01,

                            ];

        $expectedResult =   [   1,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->db->query($sql);

    /*******************************************************************/
        $testName = "My_model:insert(detail)_ValidArgument_ReturnAffectedRow";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $this->my_model->set_table_name_for_testing($table_name = "user");

        $detail =   [   "user_id"=>7,
                        "user_username"=>"test_user",
                    ];
        $result01 =  $this->my_model->insert($detail);

        $result         =   [   $result01,
                            ];

        $expectedResult =   [   7,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Delete the row again
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->db->query($sql);

    /*******************************************************************/
        $testName = "My_model:_set_table_name(table_name)_and_get_table_name()_ValidArgument_returnNone";
        $note = "";
        unset($result);
        unset($expectedResult);

        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 =  $this->my_model->get_table_name();

        $result         =   [   $result01,
                            ];

        $expectedResult =   [   "user",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:get_num_rows(where_clause)_ValidArgument_returnNumber";
        $note = "";
        unset($result);
        unset($expectedResult);

        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 = $this->my_model->get_num_rows();

        $where_clause = " WHERE user_id < 4 ";
        $result02 = $this->my_model->get_num_rows($where_clause);
        
        $result         =   [   $result01 > 0 ,
                                $result02
                            ];

        $expectedResult =   [   TRUE,
                                3,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:get_fields_ValidArgument_returnArrayOfText";
        $note = "";
        unset($result);
        unset($expectedResult);

        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 = $this->my_model->get_fields();
        
        $result         =   [   $result01[0] ,
                                $result01[1] ,
                            ];

        $expectedResult =   [   "user_id",
                                "user_display_name",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:get_by_ids(ids)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result00 = $this->my_model->get_by_ids($ids = []);
        $result01 = $this->my_model->get_by_ids($ids = [1]);
        $result02 = $this->my_model->get_by_ids($ids = [0]);
        $result03 = $this->my_model->get_by_ids($ids = [0,1]);

        $result         =   [   
                                $result00,
                                $result01[0]->user_display_name,
                                $result02,
                                $result03[0]->user_display_name,
                            ];

        $expectedResult =   [   
                                [],
                                "Surasak",
                                [],
                                "Surasak",
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:get_by_id(id)_ValidArgument_returnObjectOrFalse";
        $note = "";
        unset($result);
        unset($expectedResult);

        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 = $this->my_model->get_by_id( $id = 1 );
        $result02 = $this->my_model->get_by_id( $id = 0 );

        $result         =   [   $result01->user_display_name,
                                $result02,
                            ];

        $expectedResult =   [   "Surasak",
                                FALSE,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:get_all(limits)_ValidArgument_returnArrayOfObject";
        $note = "";
        unset($result);
        unset($expectedResult);
        
        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 = $this->my_model->get_all();
        $result02 = $this->my_model->get_all($limits=[0,3]);

        $result         =   [   count($result01) > 0 ,
                                count($result02),
                            ];

        $expectedResult =   [   TRUE,
                                3,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:delete_by_ids(ids)_ValidArgument_returnAffectedRows";
        $note = "";
        unset($result);
        unset($expectedResult);

        // Create the row to update
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user1') ";
        $this->db->query($sql);
        $sql = " INSERT INTO user(user_id, user_username) VALUES (8, 'test_user2') ";
        $this->db->query($sql);
        
        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 = $this->my_model->delete_by_ids($ids = [7,8]);
        $result02 = $this->my_model->delete_by_ids($ids = []);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   2,
                                0,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Delete the row again
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->db->query($sql);
        $sql = " DELETE FROM user WHERE user_id = 8 ";
        $this->db->query($sql);

    /*******************************************************************/
        $testName = "My_model:delete_by_id(id)_ValidArgument_returnAffectedRows";
        $note = "";
        unset($result);
        unset($expectedResult);

        // Create the row to update
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user1') ";
        $this->db->query($sql);
        
        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 = $this->my_model->delete_by_id($id = 7);
        $result02 = $this->my_model->delete_by_id($id = 0);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   1,
                                0,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

        // Delete the row again
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->db->query($sql);

    /*******************************************************************/
        $testName = "My_model:_get(where_clause,limits)_ValidArgument_ArrayOfObjects";
        $note = "";
        unset($result);
        unset($expectedResult);

        $this->my_model->set_table_name_for_testing($table_name = "user");
        $result01 =  $this->my_model->_get($where_clause = "");
        $result02 =  $this->my_model->_get($where_clause = " WHERE user_id = 1 ");
        $result03 =  $this->my_model->_get($where_clause = "", $limits = [0,3]);

        $result         =   [   count($result01) > 0,
                                count($result02) ,
                                count($result03) ,
                            ];

        $expectedResult =   [   TRUE,
                                1,
                                3,

                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);

    /*******************************************************************/
        $testName = "My_model:_delete(where_clause)_ValidArgument_ReturnAffectedRow";
        $note = "";
        unset($result);
        unset($expectedResult);

        // Create the row to delete
        $sql = " INSERT INTO user(user_id, user_username) VALUES (7, 'test_user') ";
        $this->db->query($sql);

        $this->my_model->set_table_name_for_testing($table_name = "user");

        $where_clause = " WHERE user_id = 7 ";
        $result01 =  $this->my_model->_delete($where_clause);

        $where_clause = " WHERE user_id = 0 ";
        $result02 =  $this->my_model->_delete($where_clause);

        $result         =   [   $result01,
                                $result02,
                            ];

        $expectedResult =   [   1,
                                0,
                            ];

        $this->unit->run($result, $expectedResult, $testName, $note);


        // Delete the row to make sure that the table is cleared.
        $sql = " DELETE FROM user WHERE user_id = 7 ";
        $this->db->query($sql);


    }
    
    function showReport($results, $report){
        $results = $this->unit->result();
        $numOfTest = count($results);
        $numOfFail = 0;
        $failedResuts = [];
        
        foreach( $results as $result ){
                if( $result["Result"] == "Failed" ) {
                    $numOfFail = $numOfFail + 1 ;
                    array_push($failedResuts, $result);
                }
        }
        
        echo "number of Fails/Tests :: $numOfFail/$numOfTest <br>";
        echo "*****************************************<br>";
        foreach( $failedResuts as $result){
            echo "Test Name :: ".$result['Test Name']."<br>";
            echo "Note :: ".$result['Notes']."<br>";
            echo "Test Datatype/Expected Datatype :: ".$result['Test Datatype']."/".$result['Expected Datatype']."<br>";
            echo "File Name/Line Number :: ".$result['File Name']."/".$result['Line Number']."<br>";
            echo "*****************************************<br>";
        }
        echo "<hr>";
        echo $report;    
    
    }

}
