<?php 


if(SHOWDEBUG === 1){ ?>

    <div class="bg-info" style="margin:10px;padding:10px">
        <?php
            echo "Controller :: $controller_name<br>";
            echo "Method :: $method_name<br>";   
            if($USER != FALSE){
                echo "User Id :: ".$USER->user_id."<br>";
                echo "Username :: ".$USER->user_username."<br>";
            }else{
                echo "User Id ::  No logged-in! <br>";
            }
            
            if($user_id_cookies){
                echo "Cookies Id :: $user_id_cookies<br>";
            }else{
                echo "Cookies Id :: No Cookies! <br>";
            }
            
            

        ?>
    </div>

<?php } ?>