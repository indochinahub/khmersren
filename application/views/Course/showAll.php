
<!-- Main content -->


<?php foreach( $coursetypes as $type){ ?>
	<div class="bg-success text-center" style="padding:10px;margin-bottom:1px;text">
		<?php echo $type->coursetype_name;?>
	</div>
	
	<div class="icon_row">
	
		<?php  foreach( $type->courses as $course){ ?>
			<div class="course_icon">
				<div class="course_icon-thumbnail">
					<a href="<?php echo base_url(["Course","show",$course->course_id]);?>">
						<img src="<?php echo $course->thumbnail_url;?>" width="100%">
					</a>
				</div>
				<div class="course_icon-title" style="">
                    <a href="<?php echo base_url(["Course","show",$course->course_id]);?>">
					    <strong><?php echo $course->course_code;?></strong><br>
					    <?php echo $course->course_name;?>
                    </a>                        
				</div>		
			</div>		
					
		<?php } ?>	
	</div>
	
	

	



<?php } ?>














	



<hr>
    
    
    
<div class="bg-info" style="padding:10px">



<div class="content" style="background-color:#becae6;padding-top:10px;">

            <div style="display:flex;justify-content:space-evenly;margin-bottom:10px">
            <div class="card" style="width:30%;background-color:#becae6;">
                <a href="http://www.khmersren.com/course/index"> 
                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" src="http://www.khmersren.com/assets/images/web/004_allcourset.jpg" alt="Card image cap">
                </a>            
            </div>
            <div class="card" style="width:30%;background-color:#becae6;">
                <a href="http://www.khmersren.com/user/showAllUser">
                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" src="http://www.khmersren.com/assets/images/web/005_allannouce.jpg" alt="Card image cap">
                </a>            
            </div>
            
            <div class="card" style="width:30%;background-color:#becae6;">
                <a href="#">      
                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" src="http://www.khmersren.com/assets/images/web/006_allmembert.jpg" alt="Card image cap">
                </a>            
            </div>
        </div>    
        
            <div style="display:flex;justify-content:space-evenly;margin-bottom:10px">
            <div class="card" style="width:30%;background-color:#becae6;">
                <a href="http://www.khmersren.com/course/index"> 
                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" src="http://www.khmersren.com/assets/images/web/004_allcourset.jpg" alt="Card image cap">
                </a>            
            </div>
            <div class="card" style="width:30%;background-color:#becae6;">
                <a href="http://www.khmersren.com/user/showAllUser">
                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" src="http://www.khmersren.com/assets/images/web/005_allannouce.jpg" alt="Card image cap">
                </a>            
            </div>
            
            <div class="card" style="width:30%;background-color:#becae6;">
                <a href="#">      
                    <img style="border-radius:5%;border-style:solid;border-width:2px;border-color:black;" class="card-img-top" src="http://www.khmersren.com/assets/images/web/006_allmembert.jpg" alt="Card image cap">
                </a>            
            </div>
        </div>            
    
</div>




</div>

      