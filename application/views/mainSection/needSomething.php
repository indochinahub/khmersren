<?php

                                    // "what_happened"=>"คุณไม่มีสิทธิ์ใช้งานส่วนนี้",
                                    // "what_todo" => "กรุณาล็อกอินด้วยบัญชีที่มีสิทธิ์",
                                    // "btnText_toGo" => "Back",
                                    // "btnLink_toGo" => base_url(["main","login"])        
        
?>        
        <div class="bg-warning" style="margin:10px;padding:10px">
            <p><?php echo $what_happened;?></p>
            <p><?php echo $what_todo;?></p>
            
            <?php if( $btnText_toGo !== ""){ ?>
                <div class="button_box">
                    <div class="button_box-single_right">
                    <a href="<?php echo $btnLink_toGo;?>" class="btn btn-primary"><?php echo $btnText_toGo;?></a>
                    </div>
                </div>                            
            <?php } ?>
    
        </div>