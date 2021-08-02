<?php foreach ($data_invoice as $data) : ?>
<div class="content">
    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-12">
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <?= $data['no_invoice'] ?>
                                <small class="float-right">Tanggal : <?= date('d F Y', strtotime($data['tgl_invoice'])); ?></small>
                            </h4>
                        </div>
                        <div class="col-12">
                            <h4>
                                <small class="float-right">Jatuh tempo : <?= $data['jatuh_tempo']; ?></small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Tujuan
                            <address>
                                <strong><?= $data['tujuan'] ?></strong><br>
                                <?= $data['lokasi'] ?><br>
                            </address>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Uraian</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $total = $data['kuantitas'] * $data['harga'] - (($data['diskon'] * 0.01) * $data['harga'] * $data['kuantitas'])?>
                                    <tr>
                                        <td>1</td>
                                        <td><?= $data['uraian'] ?></td>
                                        <td><?= $data['kuantitas'] ?></td>
                                        <td><?= 'Rp. '.number_format($data['harga']) ?></td>
                                        <td><?= $data['diskon'] == '1' ? '-' : $data['diskon'] ?></td>
                                        <td><?= 'Rp. '.number_format($total) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p><b>Terbilang:</b> <?= $data['terbilang']; ?></p>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>
