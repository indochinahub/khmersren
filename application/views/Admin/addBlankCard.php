<div class="card">
    <form role="form" method="post">
        <div class="card-body">
            จำนวนบัตรคำปัจจุบัน :: <strong><?php echo $num_current_cards;?></strong>
        </div>
    
        <div class="card-body">
            <div class="form-group">
                <label>จำนวนบัตรคำที่ต้่องการ ::</label>
                <input class="form-control" type="number" name="required_num" min="<?php echo $num_current_cards + 1;?>" placeholder="><?php echo $num_current_cards;?>">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" name="submit" value="submit" class="btn btn-sm btn-primary">Submit</button>
        </div>
        
    </form>
</div>