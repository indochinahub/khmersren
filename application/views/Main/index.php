<div class="card card-info">
            
    <div class="card-body info">
        <div>
            <h4><?php if((int)$post->post_publishstatus === 0){echo "[ร่าง]";} ; echo $post->post_title;?></h4>
            <h6 style="margin-left:15px"><?php echo get_thai_dateTime_from_sqlTimeStamp($post->post_publisheddata);?></h6>
        </div>

        <div style="margin-left:15px">
            <?php echo $post->post_intro;?>
        </div>

        <div style="margin-left:15px">
            <?php echo $post->post_content;?>
        </div>

    </div>

</div>