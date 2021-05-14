<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/category/update/'.$data_category_single['kd_surat']); ?>">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Kode surat</label>
                                    <input type="text" class="form-control" name="kode" value="<?php echo $data_category_single['kd_surat']; ?>" readonly>
                                    <?= form_error('kode', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Jenis surat</label>
                                    <input type="text" class="form-control" name="jenis" value="<?php echo $data_category_single['jenis_surat']; ?>">
                                    <?= form_error('jenis', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                                <a class="btn btn-danger" href="<?= base_url('admin/category/read/'); ?>">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>