<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/kwitansi/update_submit/'.$data_kwitansi_single['id_kwitansi']); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control" name="no_urut" value="<?= $data_kwitansi_single['no_kwitansi']; ?>" readonly>
                                    <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>No Invoice</label>
                                    <input type="text" class="form-control" name="invoice" value="<?= $data_kwitansi_single['no_invoice']; ?>" readonly>
                                    <?= form_error('invoice', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan</label>
                                    <input type="text" class="form-control" value="<?= $data_kwitansi_single['tujuan']; ?>" readonly>
                                    <?= form_error('invoice', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Untuk pembayaran</label>
                                    <input type="text" class="form-control" name="tujuan_pembayaran" value="<?= $data_kwitansi_single['tujuan_pembayaran']; ?>">
                                    <?= form_error('tujuan_pembayaran', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Tanggal terima</label>
                                    <input type="date" name="tgl_terima" class="form-control" value="<?= $data_kwitansi_single['tgl_terima']; ?>">
                                    <?= form_error('tgl_terima', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <label>Lampiran file</label>
                                <div class="custom-file">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data_kwitansi_single['lampiran']; ?>">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data_kwitansi_single['lampiran']; ?>">
                                    <!--response setelah upload-->
                                    <?php if (!empty($response)) : ?>
                                        <small class="text-danger pl-3">
                                            <?= $response; ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                           </div>
                        <div class="text-right">
                            <p>&nbsp;</p>
                            <a class="btn btn-danger" href="<?= base_url('admin/kwitansi/read/'); ?>">Batal</a>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>