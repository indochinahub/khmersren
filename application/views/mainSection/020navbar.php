
<!-- Navbar -->
<?php if( $controller_name === "Profile"){ ?>

    <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-warning">
        <div style="padding:15px;">
            <div class="widget-user-image">
                <a href="<?php echo base_url();?>">
                    <img class="img-circle elevation-2" src="<?php echo $member->avartar_url;?>" 
                                                                        
                    
                     width="100" height="100" alt="User Avatar">
                </a>
            </div>
        </div>
        <div>
            <div style="padding:15px;">
                <h3 class="widget-user-username"><?php echo $member->user_display_name;?></h3>
                <h5 class="widget-user-desc"><?php echo $member->userlevel_text;?></h5>
            </div>
        </div>
    </nav>
    
<?php }elseif( $USER !== FALSE){ ?>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-warning">
        <div style="padding:15px;">
            <div class="widget-user-image">
                <a href="<?php echo base_url();?>">
                    <img class="img-circle elevation-2" src="<?php echo $USER->avartar_url;?>" 
                     width="100" height="100" alt="User Avatar">
                </a>
            </div>
        </div>
        <div>
            <div style="padding:15px;">
                <h3 class="widget-user-username"><?php echo $USER->user_display_name;?></h3>
                <h5 class="widget-user-desc"><?php echo $USER->userlevel_text;?></h5>
            </div>
        </div>
    </nav>

 <?php }else{ ?>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-success">
        <div style="padding:15px;">
            <div class="widget-user-image">
                <a href="<?php echo base_url();?>">
                    <img class="img-circle elevation-2" src="<?php echo base_url();?>assets/images/user_pics/banner.jpg" 
                     width="100" height="100" alt="User Avatar">
                </a>
            </div>
        </div>
        <div>
            <div style="padding:15px;">
                <h3 class="widget-user-username">Khmersren.com</h3>
                <h5 class="widget-user-desc">เทคโนโลยีเพื่อการเรียนรู้ด้วยตนเอง</h5>
            </div>
        </div>
    </nav>

<?php } ?>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url();?>" class="nav-link">หน้าแรก</a>
      </li>
	  
	  
	  <?php  if($USER != FALSE){  ?>
		  <li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url(["Profile", "myProfile", $USER->user_id]);?>" class="nav-link">โปรไฟล์ของฉัน</a>
		  </li>
	  <?php } ?>	  

    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?= base_url() ?>assets/adminlte3/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?= base_url() ?>assets/adminlte3/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?= base_url() ?>assets/adminlte3/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->