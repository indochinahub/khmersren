<?php  if( $page_title !== ""){ ?>

    <div class="content-header" style="padding-bottom:0px">
      <div class="container-fluid">
        <div class="row mb-2">


            <div class="col-sm-6">
                <h3 class="m-0 text-dark"><?php echo $page_title;?></h3>
            </div><!-- /.col -->


            <?php if( $breadcrumbs !== false ){ ?>
            
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php foreach( $breadcrumbs as $breadcrumb){ ?>
                        <?php if($breadcrumb[1] ===""){ ?>
                            <li class="breadcrumb-item "><?php echo $breadcrumb[0];?></li>
                        <?php }else{ ?>
                            <li class="breadcrumb-item "><a href="<?php echo $breadcrumb[1];?>"><?php echo $breadcrumb[0];?></a></li>
                        <?php } ?>
                    
                        
                    <?php } ?>
                </ol>
                </div><!-- /.col -->
                
                
            <?php } ?>
          
          
        </div><!-- /.row -->


      </div><!-- /.container-fluid -->
    </div>
<?php } ?>