<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/notadinas/update_submit/'.$data_notadinas_single['id']); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="hidden" class="form-control" name="no_urut" value="<?= $data_notadinas_single['no_urut'] ?>">
                                </div>
                                <div class="form-group col-12">
                                    <input type="hidden" class="form-control" name="no_notadinas" value="<?= $data_notadinas_single['no_notadinas'] ?>">
                                </div>
                                <div class="form-group col-12">
                                    <label>Perihal</label>
                                    <input type="text" class="form-control" name="perihal" value="<?= $data_notadinas_single['perihal']; ?>">
                                    <?= form_error('perihal', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tujuan</label>
                                    <input type="text" name="tujuan" class="form-control" value="<?= $data_notadinas_single['tujuan'];?>">
                                    <?= form_error('tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Dari</label>
                                    <input type="text" name="dari" class="form-control" value="<?= $data_notadinas_single['dari'];?>">
                                    <?= form_error('dari', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal</label>
                                    <input type="date" name="tgl" class="form-control" value="<?= $data_notadinas_single['tanggal'];?>">
                                    <?= form_error('tanggal', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Divisi/bagian</label>
                                    <select name="divisi" class="form-control" value="<?= set_value('divisi'); ?>" required>
                                        <?php foreach ($data_divisi as $divisi) : ?>
                                            <?php if ($divisi['kode'] == $data_notadinas_single['kd_divisi']) : ?>
                                                <option value="<?= $divisi['kode']; ?>" selected><?= $divisi['divisi']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $divisi['kode']; ?>"><?= $divisi['divisi']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('divisi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <input type="hidden" class="form-control" name="tahun" value="<?= $data_notadinas_single['tahun']; ?>">
                                <label>Lampiran file</label>
                                <div class="custom-file">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data_notadinas_single['lampiran']; ?>">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data_notadinas_single['lampiran']; ?>">
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
                                <a class="btn btn-danger" href="<?= base_url('admin/notadinas/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>