<div class="card card-info">

    <div class="card-body info">

        <form role="form" method="post">

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>หัวข้อ</strong> :: </label>
                <textarea class="form-control" name="title" rows="1"><?php echo $title;?></textarea>
                <?php if(form_error('title')){ echo form_error('title');}?>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>คำนำ</strong> :: </label>
                <textarea class="form-control" name="intro" rows="4"><?php echo $intro;?></textarea>
                <?php if(form_error('intro')){ echo form_error('intro');}?>
            </div>            

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>เนื้อหา</strong> :: </label>
                <textarea class="form-control" name="content" rows="5"><?php echo $content;?></textarea>
            </div>            
                        
            <div class="form-group"  style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>กลุ่มบทความ</strong> :: </label>

                <?php foreach( $arr_postcategory as $postcategory) { ?>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="<?php echo $postcategory->postcategory_id;?>" name="postCategory_id" 
                            value="<?php echo $postcategory->postcategory_id;?>" 
                            <?php   if( ($action === "add" || $action === "input_not_valid"  )&& $postcategory->if_it_is_default == TRUE){ 
                                        echo "checked";
                                    }elseif($action === "edit" && $postcategory->if_it_is_current_postcategory == TRUE){
                                        echo "checked";
                                    }
                            ?> 
                        >
                        <label for="<?php echo $postcategory->postcategory_id;?>" class="custom-control-label"><?php echo $postcategory->postcategory_title;?></label>
                    </div>                
                <?php } ?>
            </div>

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>การแสดงผล</strong> ::</label>

                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="1" name="post_publishstatus" value="1"
                        <?php   if($action === "add" || $action === "input_not_valid"){  
                                    echo "checked";
                                }elseif( $action === "edit" && $post->post_publishstatus === "1"    ){
                                    echo "checked";
                                }
                        ?>
                    >
                    <label for="1" class="custom-control-label">แสดงทันที</label>
                </div>

                <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" id="0" name="post_publishstatus" value="0"
                        <?php   if( $action === "edit" && $post->post_publishstatus === "0"    ){
                                    echo "checked";
                                }
                        ?>                    
                    >
                    <label for="0" class="custom-control-label">ร่าง</label>
                </div>


            </div>









            

            <div class="two_flex_column">
                <div>
                </div>
                <div>
                    <button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">ปรับปรุง</button>
                </div>
            </div>

        </form>

    </div>
</div>