<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/suratmasuk/insert/'); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>No surat</label>
                                    <input type="text" class="form-control" name="no_surat" value="<?= set_value('no_surat'); ?>">
                                    <?= form_error('no_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Perihal</label>
                                    <input type="text" class="form-control" name="perihal" value="<?= set_value('perihal'); ?>">
                                    <?= form_error('perihal', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Tanggal terima</label>
                                    <input type="date" name="tgl_terima" class="form-control" value="<?= set_value('tgl_terima');?>">
                                    <?= form_error('tgl_terima', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Jenis surat</label>
                                    <select name="jenis_surat" class="form-control" value="<?= set_value('jenis_surat'); ?>">
                                    <option name="" selected disabled>-- Pilih --</option>
                                        <?php foreach ($data_category as $category) : ?>
                                            <option value="<?= $category['jenis_surat']; ?>"><?= $category['jenis_surat']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('tgl_terima', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Tanggal surat</label>
                                    <input type="date" name="tgl_surat" class="form-control" value="<?= set_value('tgl_surat');?>">
                                    <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" name="ket" value="<?= set_value('ket'); ?>">
                                    <?= form_error('ket', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <label>Lampiran file</label>
                                <div class="custom-file">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" required>
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
                                <a class="btn btn-danger" href="<?= base_url('admin/category/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>