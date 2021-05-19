<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php foreach ($divisi as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?></h3>

                        <p>Divisi / bagian</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= site_url('admin/divisi/read'); ?>" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php foreach ($category as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?></h3>

                        <p>Jenis surat</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-filter"></i>
                    </div>
                    <a href="<?= site_url('admin/category/read'); ?>" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php foreach ($suratmasuk as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?></h3>

                        <p>Surat masuk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <a href="<?= site_url('admin/suratmasuk/read'); ?>" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php foreach ($suratkeluar as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?></h3>

                        <p>Surat keluar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <a href="<?= site_url('admin/suratkeluar/read'); ?>" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>