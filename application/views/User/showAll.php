<div class="card card-info">

    <div class="card-body">
        <div class="two_flex_column">
            <div></div>
            <div style="padding-top:10px">
                <?php echo $pagination;?>
            </div>
        </div>
    </div>
        <?php foreach($users as $user){ ?>
            <div class="card-body info">    
                <div style="display:flex;justify-content:flex-start">
                    <div>
                        <a href="<?php echo base_url(["Profile","myProfile",$user->user_id]);?>"> 
                            <img style="border-radius:5%;border-style:solid;border-width:1px;border-color:black;width:100px;height:auto" class="card-img-top" src="<?php echo $user->avartar_url;?>" alt="Card image cap">
                        </a>                        
                    </div>
                    <div style="padding-left:15px">
                        <strong><?php echo $user->user_display_name;?></strong><br>
                        บัตรคำรอทบทวน ::<?php echo $user->user_card_to_review_today."/".$user->user_card_to_review_tomorrow;?><br>
                        เมื่อ :: <?php echo get_thai_dateTime_from_sqlTimeStamp($user->user_visit_time);?>
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