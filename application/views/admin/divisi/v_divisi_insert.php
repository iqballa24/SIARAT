<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/divisi/insert/'); ?>">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" name="Kode" value="<?= set_value('Kode'); ?>">
                                    <?= form_error('Kode', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Divisi</label>
                                    <input type="text" class="form-control" name="divisi" value="<?= set_value('divisi'); ?>">
                                    <?= form_error('divisi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                                <a class="btn btn-danger" href="<?= base_url('admin/divisi/read/'); ?>">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>