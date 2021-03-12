<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title text-center">คำอธิบาย</h3>
    </div>
    <div class="card-body card-warning">
        <?php echo $course->course_description;?>
    </div>
</div>

<div class="card card-info">
    <?php if($decks){ ?>
        <div class="card-header">
            <h3 class="card-title text-center">ชุดบัตรคำ</h3>
        </div>
    <?php } ?>
    
        <?php foreach($decks as $deck){ ?>
            <div class="card-body">        
                <div style="display:flex;justify-content:space-between;">
                    <div>ชุดบัตรคำ ::<strong> <?php echo $course->course_code."-".$deck->deck_name;?></strong><br>
                    จำนวนบัตรคำ :: <?php if( $isUserLoggedIn ){ echo $deck->user_num_card."/";} ?><?php echo $deck->total_num_card;?><br>

                        <?php if( $isUserLoggedIn ){ ?>
                            บัตรคำรอทบทวนวันนี้/พรุ่งนี้ :: <?php echo $deck->practice_to_review_today."/".$deck->practice_to_review_tomorrow;?><br>
                            ระยะเวลาเฉลี่ย :: <?php echo $deck->average_practice_interval;?><br>
                        <?php } ?>

                    </div>
                    <div>
                        <a href="<?php echo base_url(["Deck","show",$deck->deck_id]);?>" class="btn btn-sm btn-primary">ไป</a>
                    </div>
                </div>
            </div>
        <?php } ?>
</div>  

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title  text-center">บทเรียน</h3>
    </div>

    <?php foreach($lessons as $lesson){ ?>
        <div class="card-body">
            <?php echo $lesson->lesson_name;?>
        </div>    
    <?php } ?>


</div>
