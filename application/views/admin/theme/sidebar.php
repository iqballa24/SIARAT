<aside class="main-sidebar sidebar-light-danger elevation-4">
    <!-- Brand Logo -->
    <a href="lsphcmi.com" class="brand-link" target="_blank">
        <img src="<?= base_url('assets/img/vector/logo.svg'); ?>" alt="LSP HCMI Logo" class="brand-image ">
        <span class="brand-text font-weight-light">LSP HCMI</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('images/user4-128x128.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <?php $i = $this->uri->segment(2) ?>
               <?php $x = $this->uri->segment(3) ?>
               <li class="nav-item">
                    <a href="<?= site_url('admin/dashboard/read'); ?>" class="nav-link <?= $i =='dashboard' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?= $i =='divisi' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            Divisi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/divisi/read'); ?>" class=" nav-link <?= $x =='read' && $i == 'divisi' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Lihat data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/divisi/insert'); ?>" class="nav-link <?= $x =='insert' && $i == 'divisi' ? 'active' : ''; ?>">
                                <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                                <p>Tambah data</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?= $i == 'category' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-filter"></i>
                        <p>
                            Kategori Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/category/read'); ?>" class="nav-link <?= $i == 'category' && $x == 'read'? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Lihat data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/category/insert'); ?>" class="nav-link <?= $i == 'category' && $x == 'insert'? 'active' : ''; ?>">
                                <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                                <p>Tambah data</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?= $i == 'suratmasuk'? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Surat Masuk
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/suratmasuk/read'); ?>" class="nav-link <?= $i == 'suratmasuk' && $x == 'read'? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Lihat data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/suratmasuk/insert'); ?>" class="nav-link <?= $i == 'suratmasuk' && $x == 'insert'? 'active' : ''; ?>">
                                <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                                <p>Tambah data</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?= $i == 'suratkeluar' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Surat Keluar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/category/read'); ?>" class="nav-link <?= $i == 'suratkeluar' && $x == 'read' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Lihat data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/category/insert'); ?>" class="nav-link <?= $i == 'suratkeluar' && $x == 'insert' ? 'active' : ''; ?>">
                                <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                                <p>Tambah data</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

</aside>