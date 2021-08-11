<?php foreach ($data_setting as $data) : ?>
<aside class="main-sidebar sidebar-<?= $data['mode'] ?>-<?= $data['theme']; ?> elevation-4">
    <!-- Brand Logo -->
    <a href="lsphcmi.com" class="brand-link" target="_blank">
        <img src="<?= base_url('upload_folder/img/'.$data['logo']); ?>" alt="<?= $data['owner']; ?>" class="brand-image ">
        <span class="brand-text font-weight-light"><?= $data['owner']; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

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
        <nav class="mt-2 <?= $data['sidebar'] ?>">
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
                <li class="nav-header text-md">Master</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/skema/read'); ?>" class="nav-link <?= $i =='skema' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Skema
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/asesor/read'); ?>" class="nav-link <?= $i =='asesor' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Asesor
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/divisi/read'); ?>" class="nav-link <?= $i =='divisi' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Divisi
                        </p>
                    </a>
                </li>
                <li class="nav-header text-md">SURAT</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/category/read'); ?>" class="nav-link <?= $i == 'category' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-filter"></i>
                        <p>
                            Kategori Surat
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/suratkeluar/read'); ?>" class="nav-link <?= $i == 'suratkeluar' ? 'active' : ''; ?> <?= $i == 'suratmasuk' ? 'active' : ''; ?><?= $i == 'surattugas' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Surat
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= site_url('admin/suratmasuk/read'); ?>" class="nav-link <?= $i == 'suratmasuk' && $x == 'read' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Surat Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/suratkeluar/read'); ?>" class="nav-link <?= $i == 'suratkeluar' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Surat Keluar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= site_url('admin/surattugas/read'); ?>" class="nav-link <?= $i == 'surattugas' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon" style="font-size: 12px;"></i>
                                <p>Surat Tugas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header text-md">KEUANGAN</li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/invoice/read'); ?>" class="nav-link <?= $i == 'invoice' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Invoice
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= site_url('admin/kwitansi/read'); ?>" class="nav-link <?= $i == 'kwitansi' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            kwitansi
                        </p>
                    </a>
                </li>
                <?php $level =  $this->session->userdata('level'); ?>
                <li class="nav-header text-md <?= $level == 2 ? 'd-none' : '' ?> ">SYSTEM</li>
                <li class="nav-item <?= $level == 2 ? 'd-none' : '' ?> ">
                    <a href="<?= base_url('admin/user/read'); ?>" class="nav-link <?= $i == 'user' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Access Management
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= $level == 2 ? 'd-none' : '' ?> ">
                    <a href="<?= site_url('admin/log/read'); ?>" class="nav-link <?= $i =='log' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Log Activity
                        </p>
                    </a>
                </li>
                <li class="nav-item <?= $level == 2 ? 'd-none' : '' ?> ">
                    <a href="<?= site_url('admin/setting/read'); ?>" class="nav-link <?= $i =='setting' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>
            </ul>
        </nav>


    </div>
    <!-- /.sidebar -->

</aside>
<?php endforeach ?>