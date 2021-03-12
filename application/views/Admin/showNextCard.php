<?php if( $show_list_of_decks === TRUE) { ?>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title  text-center">เลือกบัตรคำที่ต้องการ</h3>
        </div>

        <?php foreach($decks as $deck){ ?>
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;">
                    <div>ชุดบัตรคำ :: <strong><?php echo $deck->course->course_code."-".$deck->deck_name;?></strong><br>
                        บัตรคำรอทบทวนวันนี้/พรุ่งนี้ :: <strong><?php echo $deck->practice_to_review_today."/".$deck->practice_to_review_tomorrow ;?></strong><br>
                        บัตรคำที่ได้/ทั้งหมด :: <?php echo $deck->user_num_card."/".$deck->total_num_card;?><br>
                    </div>

                    <div>
                        <a href="<?php echo base_url(["Admin","showNextCard",$deck->deck_id]);?>" class="btn btn-sm btn-primary">ไป</a>
                    </div>
                </div>
            </div>    
        <?php } ?> 
    </div>

<?php }else{ ?>

    <div style="padding:10px">
        ชุดบัตรคำ <strong><?php echo $course->course_code."-".$deck->deck_name;?></strong>
        ของวิชา <strong><?php echo $course->course_code." ".$course->course_name;?></strong> ที่จะถูกเรียกใช้งาน
    </div>

    <div class="card card-info">

        <div class="card-header">
            <h3 class="card-title">บัตรคำที่ทบทวน/เพิ่มแล้ว 3 ใบล่าสุดจาก <?php echo $number_practices_which_have_reviewed_today;?> ใบ</h3>
        </div>

        <?php foreach($practices_which_have_reviewed_today as $practice){ ?>
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;">
                    <div>   รหัสบัตรคำ :: <strong><?php echo $practice->id_card;?></strong><br>
                            เวลาเยี่ยมชมล่าสุด :: <?php echo get_thai_dateTime_from_sqlTimeStamp($practice->practice_lastVisitDate);?><br>
                            วันที่เยี่ยมชมครั้งต่อไป :: <?php echo get_thai_dateTime_from_sqlTimeStamp($practice->practice_nextVisitDate);?><br>
                            ช่วงเวลาของบัตรคำ :: <?php echo $practice->practice_intervalDay;?> <br>
                    </div>
                    <div>
                    </div>
                </div>
            </div>            
        <?php } ?>




        <div class="card-header">
            <h3 class="card-title">รายการบัตรคำที่จะถูกทบทวน 2 ใบจาก <?php echo $number_of_practices_to_review_today;?> ใบ</h3> 
        </div>

        <?php foreach( $practices_to_review_today as $practice ){ ?>
        
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;">

                    <div>
                        รหัสบัตรคำ :: <strong><?php echo $practice->id_card;?></strong><br>
                        วันที่เยี่ยมชมครั้งต่อไป :: <?php echo get_thai_date_from_sqlTimeStamp($practice->practice_nextVisitDate);?><br>
                        ช่วงเวลาของบัตรคำ :: <?php echo $practice->practice_intervalDay;?>
                    </div>

                    <div>
                    </div>

                </div>
            </div>
        <?php } ?>

        <div class="card-header">
            <h3 class="card-title">บัตรคำใหม่ที่รอเพิ่ม</h3>
        </div>

        <div class="card-body">
            <div style="display:flex;justify-content:space-between;">

                <div>รหัสบัตรคำ :: <strong><?php echo $card->card_id;?></strong><br>
                </div>

                <div>
                    
                </div>

            </div>
        </div>    

    </div>

<?php } ?>


