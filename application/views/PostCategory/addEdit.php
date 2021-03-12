<div class="card card-info">

    <div class="card-body info">

        <form role="form" method="post">

            <div class="form-group" style="margin-bottom:1px;padding:10px 0 5px 0">
                <label><strong>หัวข้อ</strong> :: </label>
                <textarea class="form-control" name="title" rows="1"><?php echo $title;?></textarea>
                <?php if(form_error('title')){ echo form_error('title');}?>
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