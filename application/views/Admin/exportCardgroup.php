<div class="card card-info">
        <div class="card-header">
            <h3 class="card-title  text-center">เลือกบัตรคำที่ต้องการ</h3>
        </div>

            <?php foreach($cardgroups as $cardgroup){ ?>
                <div class="card-body">
                    <div style="display:flex;justify-content:space-between;">
                        <div>กลุ่มบัตรคำ :: <?php echo $cardgroup->cardgroup_id;?> <br>
                            วิชา:: <?php echo $cardgroup->course->course_code."-".$cardgroup->course->course_name;?><br>
                            ชุดบัตรคำ :: <strong><?php echo $cardgroup->decks_text;?></strong><br>

                        </div>

                        <div>
                            <a href="<?php echo base_url(["Admin","exportCardgroup",$cardgroup->cardgroup_id]);?>" class="btn btn-sm btn-primary">ไป</a>

                            
                        </div>
                    </div>
                </div>                
            <?php } ?>

    </div>