  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url();?>" class="brand-link">
      <img src="<?php echo base_url();?>assets/images/user_pics/banner.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Khmersren</span>
    </a>
    

    <!-- Sidebar -->
    <div class="sidebar">
    
    <?php if($USER != FALSE){ ?>
          <!-- Sidebar user panel (optional) -->

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $USER->avartar_url;?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo base_url(["Profile","myProfile", $USER->user_id]);?>" class="d-block"><?php echo $USER->user_display_name;?></a>
            </div>
        </div>
        
    <?php } ?>      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          
<?php if($USER != FALSE) { ?>

    <li class="nav-header">เมนูของฉัน</li>

        <li class="nav-item">
            <a href="<?php echo base_url(["Profile","myProfile", $USER->user_id]);?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    โปรไฟล์ของฉัน
                </p>
            </a>
        </li>          

        <li class="nav-item">
            <a href="<?php echo base_url(["Profile","myDeck", $USER->user_id]);?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                บัตรคำของฉัน
                </p>
            </a>
        </li>          

        <li class="nav-item">
            <a href="<?php echo base_url(["Profile","myPost", $USER->user_id]);?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    บทความของฉัน
                </p>
            </a>
        </li>          


        <li class="nav-item">
            <a href="<?php echo base_url(["Profile","myCourse", $USER->user_id]);?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    บทเรียนของฉัน
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php echo base_url(["PostCategory", "manage"]);?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    จัดการกลุ่มบทความ
                </p>
            </a>
        </li>


        

        <li class="nav-item">
            <a href="<?php echo base_url(["User","logout"]);?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    ออกจากระบบ
                </p>
            </a>
        </li>

<?php }else{ ?>

    <li class="nav-item">
        <a href="<?php echo base_url(["User","login"]);?>" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
                <p>
                    เข้าสู่ระบบ
                </p>
        </a>
    </li>               

<?php } ?>

          <li class="nav-header">เมนูหลัก</li>

          <li class="nav-item">
            <a href="<?php echo base_url(["Course", "showAll"]);?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                วิชาทั้งหมด
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?php echo base_url(["CardComment", "showAll"]);?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                ความเห็นทั้งหมด
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="<?php echo base_url(["User", "showAll"]);?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                ผู้ใช้งานทั้งหมด
              </p>
            </a>
          </li>
          

          <li class="nav-item">
            <a href="<?php echo base_url(["main","testError"]);?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Test Error
              </p>
            </a>
          </li>
          

          <?php if( $USER !== FALSE && $USER->user_level == ADMIN_LEVEL){ ?>

                <li class="nav-header">เมนูผู้ดูแลระบบ</li>
                <li class="nav-item">
                    <a href="<?php echo base_url(["Admin", "importCard"]);?>" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        นำเข้าบัตรคำ
                    </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(["Admin", "exportCardgroup"]);?>" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        ส่งออกกลุ่มบัตรคำ
                    </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(["Admin", "addBlankCard"]);?>" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        เพิ่มบัตรคำเปล่า
                    </p>
                    </a>
                </li>                

                <li class="nav-item">
                    <a href="<?php echo base_url(["Admin", "showNextCard", 0]);?>" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        แสดงบัตรคำถัดไป
                    </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(["Admin", "siteSetting"]);?>" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        ตั้งค่าเว็บไซต์
                    </p>
                    </a>
                </li>                    
          <?php } ?>


          <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          
          <li class="nav-item">
            <a href="<?php echo base_url(["main","testConfirm"]);?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Test Confirm
              </p>
            </a>
          </li>      

          <li class="nav-item">
            <a href="<?php echo base_url(["main","testDB"]);?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Test Database
              </p>
            </a>
          </li>      


          



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
