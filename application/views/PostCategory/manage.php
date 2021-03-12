<div class="card card-info">

        <div class="card-body warning">
            <div class="two_flex_column">
                <div>
                    <a href="<?php echo base_url(["PostCategory","addEdit","add"]);?>" class="btn btn-sm btn-primary">เพิ่ม</a>                 
                    
                </div>
                <div>
                    <strong>เพิ่มกลุ่มบันทึก</strong>
                </div>
            </div>
        </div>

        <?php foreach( $arr_category as $category){ ?>
            <div class="card-body info">
                <div class="two_flex_column">
                    <div><?php echo $category->postcategory_title;?>
                        [<?php echo $category->number;?>]
                    </div>
                    <div  style="margin-bottom:5px">
                        <?php if($category->if_it_is_default !== TRUE){ ?>
                            <a href="<?php echo base_url(["PostCategory","delete",$category->postcategory_id]);?>" class="btn btn-sm btn-primary">ลบ</a>
                            <a href="<?php echo base_url(["PostCategory","addEdit","edit",$category->postcategory_id]);?>" class="btn btn-sm btn-primary">แก้ไข</a>
                        <?php } ?>


                    </div>
                </div>
            </div>    
        <?php } ?>

        
</div>