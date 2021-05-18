<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/suratmasuk/update_submit/'.$data_suratmasuk_single['id_surat']); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>No surat</label>
                                    <input type="text" class="form-control" name="no_surat" value="<?= $data_suratmasuk_single['no_surat'] ?>">
                                    <?= form_error('no_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Perihal</label>
                                    <input type="text" class="form-control" name="perihal" value="<?= $data_suratmasuk_single['perihal'] ?>">
                                    <?= form_error('perihal', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Tanggal terima</label>
                                    <input type="date" name="tgl_terima" class="form-control" value="<?= $data_suratmasuk_single['tgl_terima'] ?>">
                                    <?= form_error('tgl_terima', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Jenis surat</label>
                                    <select name="jenis_surat" class="form-control" value="<?= set_value('jenis_surat'); ?>" required>
                                        <?php foreach ($data_category as $kategori) : ?>
                                            <?php if ($kategori['kd_surat'] == $data_suratmasuk_single['kd_jenis_surat']) : ?>
                                                <option value="<?= $kategori['kd_surat']; ?>" selected><?= $kategori['jenis_surat']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $kategori['kd_surat']; ?>"><?= $kategori['jenis_surat']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('tgl_terima', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Tanggal surat</label>
                                    <input type="date" name="tgl_surat" class="form-control" value="<?= $data_suratmasuk_single['tgl_surat'] ?>">
                                    <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" name="ket" value="<?= $data_suratmasuk_single['keterangan'] ?>">
                                    <?= form_error('ket', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <label>Lampiran file</label>
                                <div class="custom-file">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data_suratmasuk_single['lampiran']; ?>">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data_suratmasuk_single['lampiran']; ?>">
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
                                <a class="btn btn-danger" href="<?= base_url('admin/suratmasuk/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>