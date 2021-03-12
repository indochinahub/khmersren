<div class="card card-info">

    <div class="card-header">
        <h3 class="card-title text-center">คำสั่ง</h3>
    </div>

    <div class="card-body info">
        <strong><?php echo $card_HTML->deck_command1_col;?></strong>
        <?php if($card_HTML->deck_command2_col){ echo "<br>".$card_HTML->deck_command2_col;}?>
        <?php if($card_HTML->deck_command3_col){ echo "<br>".$card_HTML->deck_command3_col;}?>
        <?php if($card_HTML->deck_command4_col){ echo "<br>".$card_HTML->deck_command4_col;}?>
    </div>

    <?php if($card_HTML->deck_answer1_col){ ?>
        <div id="accordion">
            <div class="card-header" style="padding:0px;background-color:#ffc107;margin-bottom:1px;color:black" id="heading-4501">
                <h5 class="mb-0">
                    <button style="width:100%;text-align:center" class="btn btn-link" data-toggle="collapse" data-target="#collapse-4501" aria-expanded="true" aria-controls="collapse-4501">
                        <strong>ตรวจสอบคำตอบ</strong>
                    </button>
                </h5>
            </div>
            <div id="collapse-4501" style="padding: 0px;" class="collapse" aria-labelledby="heading-4501" data-parent="#accordion">
                    <div class="card-body info">
                        <?php echo $card_HTML->deck_answer1_col;?><br>
                        <?php echo $card_HTML->deck_answer2_col;?><br>
                        <?php echo $card_HTML->deck_answer3_col;?>
                    </div>
            </div>
        </div>    
    <?php } ?>

    <div class="card-header">
        <h3 class="card-title text-center">ตัวเลือก</h3>
    </div>

    <?php if($card_HTML->choice_1a_html){ ?>
        <div class="card-body info" style="<?php echo $card_HTML->choice_1a_background;?>">
            <div>
                <?php echo $card_HTML->choice_1a_html;?>
                <?php if( $card_HTML->choice_1b_html ){echo "<br>".$card_HTML->choice_1b_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_1c_html ){echo "<br>".$card_HTML->choice_1c_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_1d_html ){echo "<br>".$card_HTML->choice_1d_html;}?>
            </div>

            <?php if($card_HTML->page === "a"){ ?>
                <div class="two_flex_column">
                    <div>
                    </div>
                    <div>
                        <a href="<?php echo base_url(array_merge(["Card",
                                        "show","b",
                                        $card->card_id,$deck->deck_id],
                                        $card_HTML->choice_index,
                                        [$card_HTML->choice_1a_index]))
                                ;?>" 
                            class="btn btn-sm btn-primary">เลือก
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>    
    <?php } ?>

    <?php if($card_HTML->choice_2a_html){ ?>
        <div class="card-body" style="<?php echo $card_HTML->choice_2a_background;?>">
            <div>
                <?php echo $card_HTML->choice_2a_html;?>
                <?php if( $card_HTML->choice_2b_html ){ echo "<br>".$card_HTML->choice_2b_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_2c_html ){echo "<br>".$card_HTML->choice_2c_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_2d_html ){echo "<br>".$card_HTML->choice_2d_html;}?>
            </div>

            <?php if($card_HTML->page === "a"){ ?>
                <div class="two_flex_column">
                    <div>
                    </div>
                    <div>
                        <a href="<?php echo base_url(array_merge(["Card",
                                        "show","b",
                                        $card->card_id,$deck->deck_id],
                                        $card_HTML->choice_index,
                                        [$card_HTML->choice_2a_index]))
                                ;?>" 
                            class="btn btn-sm btn-primary">เลือก
                        </a>                    
                    </div>
                </div>
            <?php } ?>

        </div>
    <?php } ?>

    <?php if($card_HTML->choice_3a_html){ ?>
        <div class="card-body" style="<?php echo $card_HTML->choice_3a_background;?>">
            <div>
                <?php echo $card_HTML->choice_3a_html;?>
                <?php if( $card_HTML->choice_3b_html ){echo "<br>".$card_HTML->choice_3b_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_3c_html ){echo "<br>".$card_HTML->choice_3c_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_3d_html ){echo "<br>".$card_HTML->choice_3d_html;}?>
            </div>

            <?php if($card_HTML->page === "a"){ ?>
                <div class="two_flex_column">
                    <div>
                    </div>
                    <div>
                        <a href="<?php echo base_url(array_merge(["Card",
                                        "show","b",
                                        $card->card_id,$deck->deck_id],
                                        $card_HTML->choice_index,
                                        [$card_HTML->choice_3a_index]))
                                ;?>" 
                            class="btn btn-sm btn-primary">เลือก
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>
    <?php } ?>

    <?php if($card_HTML->choice_4a_html){ ?>    
        <div class="card-body" style="<?php echo $card_HTML->choice_4a_background;?>">
            <div>
                <?php echo $card_HTML->choice_4a_html;?>
                <?php if( $card_HTML->choice_4b_html ){echo "<br>".$card_HTML->choice_4b_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_4c_html  ){echo "<br>".$card_HTML->choice_4c_html;}?>
                <?php if( $card_HTML->page === "b" && $card_HTML->choice_4d_html  ){echo "<br>".$card_HTML->choice_4d_html;}?>
            </div>

            <?php if($card_HTML->page === "a"){ ?>            
                <div class="two_flex_column">
                    <div>
                    </div>
                    <div>
                        <a href="<?php echo base_url(array_merge(["Card",
                                        "show","b",
                                        $card->card_id,$deck->deck_id],
                                        $card_HTML->choice_index,
                                        [$card_HTML->choice_4a_index]))
                                ;?>" 
                            class="btn btn-sm btn-primary">เลือก
                        </a>
                    </div>
                </div>
            <?php } ?>
            
        </div>
    <?php } ?> 

    <?php if($card_HTML->page === "b"){ ?>

        <?php if( $selected_choice === 1){ ?>

            <div class="card-header">
                <h3 class="card-title text-center">ผล</h3>
            </div>
            <div class="card-body success">
                <div class="two_flex_column">
                    <div>   
                            ผล : <strong>คำตอบถูกต้อง</strong>
                    </div>
                    <div>
                            <?php if( $next_card_id === FALSE){ ?>
                                <a href="<?php echo base_url([ "Deck", "show", $deck->deck_id]);?>" class="btn btn-sm btn-primary">ไปชุดบัตรคำ</a>
                            <?php }else{ ?>
                                <a href="<?php echo base_url([ "Card", "show", "a", $next_card_id, $deck->deck_id]);?>" class="btn btn-sm btn-primary">ข้อถัดไป</a>
                            <?php } ?>
                    </div>
                </div>
            </div>

        <?php }else{ ?>
            <div class="card-header">
                <h3 class="card-title text-center">ผล</h3>
            </div>
            <div class="card-body danger">
                <div class="two_flex_column">
                    <div>   
                            ผล : <strong>คำตอบไม่ถูกต้อง</strong>
                    </div>
                    <div>
                            <?php if( $next_card_id === FALSE){ ?>
                                <a href="<?php echo base_url([ "Deck", "show", $deck->deck_id]);?>" class="btn btn-sm btn-primary">ไปชุดบัตรคำ</a>
                            <?php }else{ ?>
                                <a href="<?php echo base_url([ "Card", "show", "a", $next_card_id, $deck->deck_id]);?>" class="btn btn-sm btn-primary">ข้อถัดไป</a>
                            <?php } ?>
                    </div>
                </div>
            </div>

        <?php } ?>

    <?php } ?>

    <div class="card-header">
        <h3 class="card-title text-center">สถิติ</h3>
    </div>
    <div class="card-body info">

        <div class="two_flex_column">
            <div>จำนวนบัตรคำ</div>
            <div><?php echo $card_HTML->user_num_card."/".$card_HTML->total_num_card;?></div>
        </div>

        <div class="two_flex_column">
            <div>บัตรคำรอทบทวนวันนี้/วันพรุ่งนี้ :: </div>
            <div><strong><?php echo $card_HTML->practice_to_review_today."/".$card_HTML->practice_to_review_tomorrow;?></strong></div>
        </div>    

        <?php if($practice != FALSE ){ ?>
            <div class="two_flex_column">
                <div>ระยะเวลาเฉลี่ย</div>
                <div><?php echo $practice->practice_intervalDay;?> วัน</div>
            </div>

            <div class="two_flex_column">
                <div>เวลาทบทวนครั้งถัดไป</div>
                <div><?php echo get_thai_date_from_sqlTimeStamp($practice->practice_nextVisitDate);?></div>
            </div>

        <?php } ?>

    </div>

    <?php if( $card_HTML->page === "b" ){ ?>

        <div class="card-header">
            <h3 class="card-title text-center">ความเห็น</h3>
        </div>

        <?php foreach( $cardcomments as $comment){ ?>
            <div class="card-body info">
                <div> <?php echo nl2br($comment->cardcomment_text);?> </div>
                <div>   [ โดย : <strong><?php echo $comment->owner->user_display_name;?></strong> 
                        เมื่อ <?php echo get_thai_dateTime_from_sqlTimeStamp($comment->cardcomment_createtime);?> ]
                </div>
                <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <?php if( $comment->if_i_am_owner === TRUE ){  ?>
                                <a href="<?php echo base_url(["CardComment","delete",$comment->cardcomment_id,$card->card_id,$deck->deck_id]);?>" class="btn btn-sm btn-primary">ลบ</a>
                            <?php }elseif( $comment->if_i_am_admin === TRUE){ ?>
                                [Admin] <a href="<?php echo base_url(["CardComment","delete",$comment->cardcomment_id,$card->card_id,$deck->deck_id]);?>" class="btn btn-sm btn-primary">ลบ</a>
                            <?php } ?>
                            
                        </div>
                </div>
            </div>                
        <?php } ?>

        <div class="card-body info">

            <form role="form" method="post" action="<?php echo base_url(["CardComment","insert",$card->card_id,$deck->deck_id]);?>">
                <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                    <label>เพิ่มความเห็น</label>
                    <textarea class="form-control" name="cardcomment_text" rows="2"></textarea>
                </div>
                <div class="two_flex_column">
                        <div>
                        </div>
                        <div>
                            <button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">เพิ่ม</button>
                        </div>
                </div>
            </form>

        </div>

        <?php if( $if_i_am_admin === TRUE){ ?>

            <div class="card-header">
                <h3 class="card-title text-center">การจัดการบัตรคำ</h3>
            </div>

            <div class="card-body warning">        
                <div class="two_flex_column">
                    <div>
                        แก้ไขบัตรคำ
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Admin","editCard",$card->card_id,$deck->deck_id]);?>" class="btn btn-sm btn-primary  ">ไป</a>
                    </div>
                </div>
            </div>        

            <div class="card-body warning">        
                <div class="two_flex_column">
                    <div>
                        ลบบัตรคำ
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Admin","deleteCard",$card->card_id,$deck->deck_id]);?>" class="btn btn-sm btn-primary  ">ลบ</a>
                    </div>
                </div>
            </div>        


        <?php } ?>

    <?php } ?>



</div>
