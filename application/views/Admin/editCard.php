<div class="card card-info">

    <?php if( $if_data_was_updated === TRUE){ ?>
        <div class="card-body warning">
            ข้อมูลได้รับการปรับปรุงแล้ว
        </div>
    <?php } ?>
    

    <div class="card-header">
        <h3 class="card-title">ข้อมูล</h3>
    </div>

    <?php foreach($card_properties as $property){ ?>
        <?php if($card->$property != NULL ){ ?>
            <div class="card-body info">
                <div><strong><?php echo $property;?></strong> :: </div>
                <?php echo $card->$property;?>
            </div>
        <?php } ?>
    <?php } ?>


    <div class="card-header">
        <h3 class="card-title">แก้ไขข้อมูล</h3>
    </div>

    <div class="card-body info">
        <form role="form" method="post">

            <?php foreach($card_properties as $property){ ?>
                <?php if($card->$property != NULL ){ ?>
                    <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                        <label><strong><?php echo $property;?></strong> :: </label>
                        <textarea class="form-control" name="<?php echo $property;?>" rows="2"><?php echo $card->$property;?></textarea>                    </div>

                <?php } ?>
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
