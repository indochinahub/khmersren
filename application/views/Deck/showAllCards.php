    <div class="card-body">
        <div class="two_flex_column">
            <div></div>
            <div style="padding-top:10px">
                <?php echo $pagination;?>
            </div>
        </div>
    </div>

    <?php foreach($cards_HTML as $card_HTML){ ?>
        <div class="card card-info">

            <div class="card-body <?php if( $card_HTML->if_i_have_done){echo "danger";}else{echo "warning";}?>">
                รหัสบัตรคำ :: <strong><?php echo $card_HTML->card_id;?></strong><br>
                ลำดับที่ :<strong><?php echo $card_HTML->card_sort;?></strong>
                
            </div>

            <div class="card-header">
                <h3 class="card-title text-center">คำสั่ง</h3>
            </div>

            <div class="card-body info">
                <strong><?php echo $card_HTML->deck_command1_col;?></strong>
                <?php if($card_HTML->deck_command2_col){ echo "<br>".$card_HTML->deck_command2_col;}?>
                <?php if($card_HTML->deck_command3_col){ echo "<br>".$card_HTML->deck_command3_col;}?>
                <?php if($card_HTML->deck_command4_col){ echo "<br>".$card_HTML->deck_command4_col;}?>
            </div>

            <div class="card-header">
                <h3 class="card-title text-center">ตัวเลือก</h3>
            </div>

            <?php if($card_HTML->deck_answer1_col){ ?>
                <div id="accordion">
                    <div class="card-header" style="padding:0px;background-color:#ffc107;margin-bottom:1px;color:black" id="heading-4501">
                        <h5 class="mb-0">
                            <button style="width:100%;text-align:center" class="btn btn-link" data-toggle="collapse" data-target="#collapse-4501" aria-expanded="true" aria-controls="collapse-4501">
                                <strong>ตรวจสอบคำตอบ</strong>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse-4501" style="padding: 0px;" class="collapse" aria-labelledby="heading-4501" data-parent="#accordion">
                            <div class="card-body info">
                                <?php echo $card_HTML->deck_answer1_col;?><br>
                                <?php echo $card_HTML->deck_answer2_col;?><br>
                                <?php echo $card_HTML->deck_answer3_col;?>
                            </div>
                    </div>
                </div>    
            <?php } ?>


            <?php if($card_HTML->choice_1a_html){ ?>
                <div class="card-body info">
                    <div>
                        <?php echo $card_HTML->choice_1a_html;?>
                        <?php if( $card_HTML->choice_1b_html ){echo "<br>".$card_HTML->choice_1b_html;}?>
                        <?php if( $card_HTML->choice_1c_html ){echo "<br>".$card_HTML->choice_1c_html;}?>
                        <?php if( $card_HTML->choice_1d_html ){echo "<br>".$card_HTML->choice_1d_html;}?>
                    </div>
                </div>    
            <?php } ?>

            <?php if($card_HTML->choice_2a_html){ ?>
                <div class="card-body info">
                    <div>
                        <?php echo $card_HTML->choice_2a_html;?>
                        <?php if( $card_HTML->choice_2b_html ){ echo "<br>".$card_HTML->choice_2b_html;}?>
                        <?php if( $card_HTML->choice_2c_html ){echo "<br>".$card_HTML->choice_2c_html;}?>
                        <?php if( $card_HTML->choice_2d_html ){echo "<br>".$card_HTML->choice_2d_html;}?>
                    </div>

                </div>
            <?php } ?>

            <?php if($card_HTML->choice_3a_html){ ?>
                <div class="card-body info">
                    <div>
                        <?php echo $card_HTML->choice_3a_html;?>
                        <?php if( $card_HTML->choice_3b_html ){echo "<br>".$card_HTML->choice_3b_html;}?>
                        <?php if( $card_HTML->choice_3c_html ){echo "<br>".$card_HTML->choice_3c_html;}?>
                        <?php if( $card_HTML->choice_3d_html ){echo "<br>".$card_HTML->choice_3d_html;}?>
                    </div>
                </div>
            <?php } ?>

            <?php if($card_HTML->choice_4a_html){ ?>    
                <div class="card-body">
                    <div>
                        <?php echo $card_HTML->choice_4a_html;?>
                        <?php if( $card_HTML->choice_4b_html ){echo "<br>".$card_HTML->choice_4b_html;}?>
                        <?php if( $card_HTML->choice_4c_html  ){echo "<br>".$card_HTML->choice_4c_html;}?>
                        <?php if( $card_HTML->choice_4d_html  ){echo "<br>".$card_HTML->choice_4d_html;}?>
                    </div>
                </div>
            <?php } ?> 
  
    </div>
<?php } ?>        



