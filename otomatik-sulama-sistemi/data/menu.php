
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
  <!--  <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!--
                         <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Yönetici</a>
            </div>
             -->
            <img id="logo" src="dist/img/otomatiksulamalogo.png">
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item  ">
                    <a href="<?=SITE?>" class="nav-link <?php if(!$_GET){ echo($_SERVER['PHP_SELF']=="/index.php" ? "active" : " ");}?>  ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Kontrol Paneli
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=SITE?>sulama-kayitlari" class="nav-link <?php echo ($_GET && !empty($_GET["sayfa"]) && $_GET["sayfa"] == "sulama-kayitlari") ? "active" : " "; ?>">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Sulama Kayıtları
                            <?php
                                if ($kayitBildirimSayisiSulama != 0) {
                                    echo '<span class="right badge badge-danger">'.$kayitBildirimSayisiSulama.'</span>';
                                }
                            ?>

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=SITE?>ortam-kayitlari" class="nav-link <?php echo ($_GET && !empty($_GET["sayfa"]) && $_GET["sayfa"] == "ortam-kayitlar") ? "active" : " "; ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Ortam Kayıtları
                            <?php
                            if ($kayitBildirimSayisiOrtam != 0) {
                                echo '<span class="right badge badge-danger">'.$kayitBildirimSayisiOrtam.'</span>';
                            }
                            ?>

                        </p>
                    </a>
                </li>
                <li class="nav-item" style="position: fixed;bottom: 0;">
                    <a href="<?=SITE?>index.php?sayfa=cikis" class="nav-link ">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>Çıkış</p>
                    </a>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>