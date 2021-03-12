<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title  text-center">บัตรคำของฉัน</h3>
    </div>

    <?php foreach($decks as $deck){ ?>
        <div class="card-body info">

            <div class="two_flex_column">
                <div>
                    ชุดบัตรคำ <strong><?php echo $deck->course->course_code."-".$deck->deck_name;?></strong>
                </div>
                <div>
                    <?php if( $profile_status === "user_visit_own_profile" ){ ?>
                        <a href="<?php echo base_url(["Deck", "show", $deck->deck_id]);?>" class="btn btn-sm btn-primary">ไป</a>
                    <?php } ?>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    บัตรคำรอทบทวนวันนี้/พรุ่งนี้
                </div>
                <div>
                    <strong><?php echo $deck->practice_to_review_today."/".$deck->practice_to_review_tomorrow ;?></strong>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    บัตรคำที่ได้/ทั้งหมด
                </div>
                <div>
                    <?php echo $deck->user_num_card."/".$deck->total_num_card;?>
                </div>
            </div>

            <div class="two_flex_column">
                <div style="padding:0 0 0 15px">
                    ช่วงเวลาเฉลี่ยของบัตรคำ
                </div>
                <div>
                    <?php echo $deck->average_practice_interval;?> วัน
                </div>
            </div>

        </div>
      
    <?php } ?>










</div>
    
    
    




























