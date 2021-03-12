<div class="card card-info">

    <?php if( $if_data_was_updated === TRUE){ ?>
        <div class="card-body warning">
            ข้อมูลได้รับการปรับปรุงแล้ว
        </div>    
    <?php }?>

    <div class="card-body info">
        <form role="form" method="post">

            <?php foreach( $arr_setting as $setting) { ?>
                <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                    <label><strong><?php echo $setting->sitesetting_property;?></strong> :: </label>
                    <textarea class="form-control" name="<?php echo $setting->sitesetting_id;?>" rows="2"><?php echo $setting->sitesetting_value;?></textarea>
                </div>            
            <?php } ?>


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