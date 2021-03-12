<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title text-center">คำอธิบาย</h3>
    </div>
    <div class="card-body info">
        Essential Grammar in Use    
    </div>

    <div class="card-header">
        <h3 class="card-title text-center">ใช้งานบ้ตรคำ</h3>
    </div>
    
    <div class="card-body  info">        
        <div class="two_flex_column">
            <div>
                <strong>เพิ่ม/ทบทวนบัตรคำ</strong>
            </div>
            <div>
                    <a href="<?php echo base_url([ "Card", "show", "a", $next_card_id, $deck->deck_id]);?>" class="btn btn-sm btn-primary <?php if($next_card_id === FALSE){echo "disabled";}?> " >ไป</a>
            </div>
        </div>
    </div>

    <div class="card-body info">
        <div class="two_flex_column">
            <div>
                ดูบัตรคำทั้งหมด
            </div>
            <div>
                <a href="<?php echo base_url(["Deck", "showAllCards",$deck->deck_id]);?>" class="btn btn-sm btn-primary">ไป</a>
            </div>
        </div>
    </div>

    <?php if( $cardcomment_num > 0 ){ ?>
        <div class="card-body info">
            <div class="two_flex_column">
                <div>
                    ดูความคิดเห็นทั้งหมด
                </div>
                <div>
                    <a href="<?php echo base_url(["Deck", "showAllComments",$deck->deck_id]);?>" class="btn btn-sm btn-primary">ไป</a>
                </div>
            </div>
        </div>    
    
    <?php } ?>



    <div class="card-header">
        <h3 class="card-title text-center">สถิติ</h3>
    </div>

    <div class="card-body info">
        <div class="two_flex_column">
            <div>
                จำนวนบัตรคำ    
            </div>
            <div>
            <?php echo $user_num_card."/";?><?php echo $total_num_card;?>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                <strong>บัตรคำรอทบทวนวันนี้/พรุ่งนี้</strong>
            </div>
            <div>
                <strong><?php echo $practice_to_review_today."/".$practice_to_review_tomorrow;?></strong>
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                ระยะเวลาเฉลี่ย 
            </div>
            <div>
            <?php echo $average_practice_interval;?> วัน
            </div>
        </div>

        <div class="two_flex_column">
            <div>
                จำนวนครั้งที่เข้าเยี่ยมชม
            </div>
            <div>
                <?php echo $practice_visit_time;?> ครั้ง
            </div>
        </div>

    </div>

    <div class="card-header">
        <h3 class="card-title text-center">การจัดการบัตรคำ</h3>
    </div>
    
    <div class="card-body warning">
        <div class="two_flex_column">
            <div>
                ล้างบัตรคำ :: <?php echo $user_num_card."/";?><?php echo $total_num_card;?>
            </div>
            <div>
                <a href="<?php echo base_url(["Deck","clearAllCards",$deck->deck_id]);?>" class="btn btn-sm btn-primary">ไป</a>
                
            </div>
        </div>
    </div>    

</div>