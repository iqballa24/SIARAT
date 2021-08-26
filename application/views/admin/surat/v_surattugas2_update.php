<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/surattugas/update_submit/' . $data_surattugas_single['id_surat']); ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Perihal</label>
                                    <input type="text" name="perihal" class="form-control" value="<?= $data_surattugas_single['perihal']; ?>">
                                    <?= form_error('perihal', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal surat</label>
                                    <input type="date" name="tgl_surat" class="form-control" value="<?= $data_surattugas_single['tgl_surat']; ?>">
                                    <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal pelaksanaan</label>
                                    <input type="date" name="tgl_pelaksanaan" class="form-control" value="<?= $data_surattugas_single['tgl_pelaksanaan']; ?>">
                                    <?= form_error('tgl_pelaksanaan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <label>Lampiran file</label>
                                <div class="custom-file">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data_surattugas_single['lampiran']; ?>">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data_surattugas_single['lampiran']; ?>">
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
                                <a class="btn btn-danger" href="<?= base_url('admin/surattugas/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>