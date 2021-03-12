<div class="card card-info">

        <div class="card-body warning">
            <div class="two_flex_column">
                <div>
                    <a href="<?php echo base_url(["Post","addEdit","add"]);?>" class="btn btn-sm btn-primary">เพิ่ม</a>                 
                </div>
                <div>
                    <strong>เพิ่มบันทึก</strong>
                </div>
            </div>
        </div>

        <?php foreach($arr_post as $post ){ ?>
        
            <div class="card-body <?php if((int)$post->post_publishstatus === 1){echo "info";}else{echo "danger";}?>">

                <div>
                    <h4><?php if((int)$post->post_publishstatus === 0){echo "[ร่าง]";} ; echo $post->post_title;?></h4>
                    <h6  style="margin-left:15px"><?php echo get_thai_dateTime_from_sqlTimeStamp($post->post_publisheddata);?></h6>
                </div>

                <div style="margin-left:15px">
                    <?php echo $post->post_intro;?>
                </div>

                <div class="two_flex_column">
                    <div><strong>#<?php echo $post->postcategory->postcategory_title;?></strong>[<?php echo $post->postcategory->number;?>]
                    </div>
                    <div>
                        <a href="<?php echo base_url(["Profile","showPost",$member->user_id, $post->post_id]);?>" class="btn btn-sm btn-primary">ไป</a>
                    </div>
                </div>
            </div>

        <?php } ?>

</div>