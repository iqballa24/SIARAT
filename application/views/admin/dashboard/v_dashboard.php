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
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?php foreach ($allInvoice as $data) : ?>
                                <?= $data['total']; ?>
                            <?php endforeach ?></h3>

                        <p>Invoice</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <a href="<?= site_url('admin/invoice/read'); ?>" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- Table data Detail Peminjaman -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4 table collapsed-card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Invoice unpaid status</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> No Invoice </th>
                                        <th> Tanggal </th>
                                        <th> Jatuh Tempo </th>
                                        <th> Tujuan </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($invoice as $data) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $data['no_invoice']; ?></td>
                                            <td><?= date('d F Y', strtotime($data['tgl_invoice'])); ?></td>
                                            <td><?= $data['jatuh_tempo']; ?></td>
                                            <td><?= $data['tujuan']; ?></td>
                                            <td><?= $data['status'] == '2' ? '<div class="btn btn-danger btn-xs disabled">Belum Lunas</div>' : '<div class ="btn btn-success btn-xs disabled">Lunas</div>'; ?></td>
                                            <td>
                                                <a href="<?= site_url('admin/invoice/update/'.$data['id']); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i> 
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Datatables -->
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "pageLength": 5,
            "lengthChange": false,
        });
    });
</script>