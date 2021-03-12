<div class="card card-info">
    <div class="card-body <?php if((int)$post->post_publishstatus === 1){echo "info";}else{echo "danger";}?>">
        <div>
            <h4><?php if((int)$post->post_publishstatus === 0){echo "[ร่าง]";} ; echo $post->post_title;?></h4>
            <h6 style="margin-left:15px"><?php echo get_thai_dateTime_from_sqlTimeStamp($post->post_publisheddata);?></h6>
        </div>

        <div style="margin-left:15px">
            <?php echo $post->post_intro;?>
        </div>

        <div style="margin-left:15px">
            <?php echo $post->post_content;?>
        </div>


        <div class="two_flex_column">
            <div>
                <strong>#<?php echo $postcategory->postcategory_title;?></strong>[<?php echo $postcategory->number;?>]
            </div>
            <div>

            <?php if( $post->previous_id != FALSE ){ ?>
                <a href="<?php echo base_url(["Profile","showPost",$member->user_id,$post->previous_id]);?>" class="btn btn-sm btn-primary">ก่อนหน้า</a>
            <?php }?>
            
            <?php if( $post->next_id != FALSE ){ ?>
                <a href="<?php echo base_url(["Profile","showPost",$member->user_id,$post->next_id]);?>" class="btn btn-sm btn-primary">ถัดไป</a>
            <?php }?>


            </div>
        </div>
    </div>

    <?php if( $if_user_view_own_profile === TRUE){ ?>
        <div class="card-body warning">
            <div class="two_flex_column" style="margin-bottom:5px;">
                <div>
                    <a href="<?php echo base_url(["Post","addEdit","edit",$post->post_id]);?>" class="btn btn-sm btn-primary">ทำ</a>
                </div>
                <div>
                    <strong>แก้ไข</strong>บันทึกนี้
                </div>
            </div>

            <div class="two_flex_column" style="margin-bottom:5px;">
                <div>
                    <a href="<?php echo base_url(["Post","delete",$post->post_id ]);?>" class="btn btn-sm btn-primary">ทำ</a>
                </div>
                <div>
                    <strong>ลบบันทึกนี้</strong>
                </div>
            </div>        

            <?php if($post->post_publishstatus === "1"){ ?>  

                <div class="two_flex_column" style="margin-bottom:5px;">
                    <div>
                        <a href="<?php echo base_url(["Post","changePublishStatus",$post->post_id,0]);?>" class="btn btn-sm btn-primary">ทำ</a>
                    </div>          
                    <div>
                        เปลี่ยนเป็น <strong>ร่างบทความ</strong>
                    </div>
                </div>

            <?php }elseif( $post->post_publishstatus === "0"){ ?>

                <div class="two_flex_column">
                    <div>
                        <a href="<?php echo base_url(["Post","changePublishStatus",$post->post_id,1]);?>" class="btn btn-sm btn-primary">ทำ</a>
                    </div>
                    <div>
                        <strong>เผยแพร่</strong>บทความ
                    </div>
                </div>                

            <?php } ?>
        </div>    
    <?php } ?>


</div>
