<?php

        // $data   = [     "page_title"=>"ยืนยัน :: xxx",
                        // "what_happened"=>"คุณกำลังจะดำเนินาร xxxxx",
                        // "what_todo" => "กด Confirm เพื่อทำต่อหรือกด Cancle เพื่อยกเลิก",
                        // "btnText_toConfirm" => "Confirm",
                        // "btnLink_toConfirm" => base_url(),
                        // "btnText_toCancle" => "Confirm",
                        // "btnLink_toCancle" => base_url(),                        
                // ];     
        
?>        
        <div class="bg-warning" style="margin:10px;padding:10px">
            <p><?php echo $what_happened;?></p>
            <p><?php echo $what_todo;?></p>
           
            <div class="two_button_box">
                <div><a href="<?php echo $btnLink_toConfirm;?>" class="btn btn-danger"><?php echo $btnText_toConfirm;?></a></div>
                <div><a href="<?php echo $btnLink_toCancle;?>" class="btn btn-primary"><?php echo $btnText_toCancle;?></a></div>
            </div>            
            
            
            
            
            
            
            
            
        </div>
            
                    
