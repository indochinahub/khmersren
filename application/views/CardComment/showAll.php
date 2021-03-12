<div class="card card-info">

    <div class="card-body">
        <div class="two_flex_column">
            <div></div>
            <div style="padding-top:10px">
                <?php echo $pagination;?>
            </div>
        </div>
    </div>

    <?php foreach( $cardcomments as $comment ){ ?>
        <div class="card-body info">
            <div>
                <strong>ชุดบัตรคำ :: <?php echo $comment->course->course_code."-".$comment->deck->deck_name;?></strong><br>
                <strong>ลำดับ :: 02420</strong><br>
                วิชาเรียน :: [ <?php echo $comment->course->course_code." ".$comment->course->course_name;?> ]<br>
                
                โดย :: [ <strong><?php echo $comment->owner->user_display_name;?></strong> ] เมื่อ <?php echo get_thai_dateTime_from_sqlTimeStamp($comment->cardcomment_createtime);?><br>

            </div>
            <div><strong>ความเห็น</strong> :: <?php echo nl2br($comment->cardcomment_text);?>
            </div>
            <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <a href="<?php echo base_url(["Card","show","a",$comment->id_card,$comment->id_deck]);?>" class="btn btn-sm btn-primary  ">ไป</a>
                        </div>
            </div>
        </div>    
    <?php } ?>

    <div class="card-body">
        <div class="two_flex_column">
            <div></div>
            <div style="padding-top:10px">
                <?php echo $pagination;?>
            </div>
        </div>
    </div>

    



</div>