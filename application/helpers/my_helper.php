<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

function get_date_part_from_sqlTimeStamp($sqlTimeStamp){
    if( strlen($sqlTimeStamp) == 19 ){
        return substr($sqlTimeStamp, 0, 10 );
    }else{
        die( "text of sql_time_stamp should be 19 charactors");
    }
}

function get_default_config_for_pagination(){
    $config     =   [   "first_link"    => FALSE,
                        "last_link"     => FALSE,
                        "use_page_numbers" => TRUE,
                        
                        "full_tag_open" => "<nav aria-label='...'><ul class='pagination'>",
                        "full_tag_close"=> "</ul></nav>",
                        
                        "num_tag_open"  => "<li class='page-item'><span class='page-link'>",
                        "num_tag_close" => "</span></li>",
  
                        "cur_tag_open"  => "<li class='page-item active'><span class='page-link'>",
                        "cur_tag_close" => "</span></li>",
                        
                        "prev_link"     => "Previous",
                        "prev_tag_open" => "<li class='page-item'><span class='page-link'>",
                        "prev_tag_close"=> "</span></li>",
                        
                        "next_link"     => "Next",                                
                        "next_tag_open" => "<li class='page-item'><span class='page-link'>",
                        "next_tag_close"=> "</span></li>",   

                        "first_link"     => "First",
                        "first_tag_open" => "<li class='page-item'><span class='page-link'>",
                        "first_tag_close"=>"</span></li>",

                        "last_link"      => "Last",
                        "last_tag_open"  => "<li class='page-item'><span class='page-link'>",
                        "last_tag_close" => "</span></li>",
                        
                        "first_link"     => FALSE,
                        "last_link"      => FALSE,
                    ];

    return $config;
}

function get_new_iterval_num_day( $current_intervalDay, $interval_constant){
    if($current_intervalDay < 2){
        return 2;
    }else{
        $new_interval_day = floor( $current_intervalDay * $interval_constant );
        if($new_interval_day >= 4000){$new_interval_day = 4000; }
        return intval($new_interval_day);
    }
}

function get_sqlTimeStamp_of_the_time_for_next_num_day($unix_time_stamp, $next_day = 0){
    return date('Y-m-d H:i:s', get_unixTimeStamp_of_the_time_for_next_num_day($unix_time_stamp, $next_day)) ;
}

function get_sqlTimeStamp_at_midnight_for_next_num_day($unix_time_stamp, $next_day) {
    return date('Y-m-d 00:00:00', $unix_time_stamp + (60*60*24*$next_day) ) ;
}

function get_unixTimeStamp_of_the_time_for_next_num_day($unix_time_stamp, $next_day = 0){
    return $unix_time_stamp + (60*60*24*$next_day);
}

function get_thai_date_from_sqlTimeStamp($sqlTimeStamp){
    // echo "All :: $sql_time_stamp <br>";
    // echo "Thai Year :: ".substr($sql_time_stamp,0,4)."<br>";
    // echo "Thai Month :: ".substr($sql_time_stamp,5,2)."<br>";
    // echo "Thai Date :: ".substr($sql_time_stamp,8,2)."<br>";
    // echo "Time :: ".substr($sql_time_stamp,11,5)."<br>";
    // echo "<hr>";

    $thai_year = substr($sqlTimeStamp, 0, 4) + 543 ;  
    
    if( substr($sqlTimeStamp,5,2)     == "01"){ $thai_month = "ม.ค.";}
    elseif(substr($sqlTimeStamp,5,2)  == "02"){ $thai_month = "ก.พ.";}
    elseif(substr($sqlTimeStamp,5,2) == "03"){  $thai_month = "มี.ค.";}
    elseif(substr($sqlTimeStamp,5,2) == "04"){  $thai_month = "เม.ย.";}
    elseif(substr($sqlTimeStamp,5,2) == "05"){  $thai_month = "พ.ค.";}
    elseif(substr($sqlTimeStamp,5,2) == "06"){  $thai_month = "มิ.ย.";}
    elseif(substr($sqlTimeStamp,5,2) == "07"){  $thai_month = "ก.ค.";}
    elseif(substr($sqlTimeStamp,5,2) == "08"){  $thai_month = "ส.ค.";}
    elseif(substr($sqlTimeStamp,5,2) == "09"){  $thai_month = "ก.ย.";}
    elseif(substr($sqlTimeStamp,5,2) == "10"){  $thai_month = "ต.ค.";}
    elseif(substr($sqlTimeStamp,5,2) == "11"){  $thai_month = "พ.ย.";}
    elseif(substr($sqlTimeStamp,5,2) == "12"){  $thai_month = "ธ.ค.";}

    $thai_date = substr($sqlTimeStamp,8,2);

    $thai_time = substr($sqlTimeStamp,11,5);
    
    return "$thai_date $thai_month $thai_year";
}

function get_thai_dateTime_from_sqlTimeStamp($sqlTimeStamp){
    $thai_date_month_year = get_thai_date_from_SQLtimeStamp($sqlTimeStamp);

    $thai_date = substr($sqlTimeStamp,8,2);
    $thai_time = substr($sqlTimeStamp,11,5);
    
    return "$thai_date_month_year $thai_time น.";
}

function get_prepared_text_for_mySQL($text){

    $text = trim($text);
    return $text;
}

function get_start_item_for_pagination( $current_page, $per_page){
    $start_item = ( $current_page - 1 ) * $per_page;
    return $start_item;
}

function get_userlevel_text($user_level){
        
    if($user_level == STUDENT_LEVEL){
        return "ผู้เรียน";
    }elseif($user_level == TEACHER_LEVEL){
        return "ครู";
    }elseif($user_level == ADMIN_LEVEL){
        return "ผู้ดูแลระบบ";
    }
    
}

function sqlTimeStamp_to_unixTimeStamp( $sqltimestamp ){

    $dateTime = new DateTime($sqltimestamp);
    return $dateTime->getTimestamp(); 
}