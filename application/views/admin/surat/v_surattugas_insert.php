<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/surattugas/insert/'); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="hidden" class="form-control" name="no_urut" value="<?= sprintf("%03s", $no_urut) ?>">
                                    <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal surat</label>
                                    <input type="date" name="tgl_surat" class="form-control" value="<?= set_value('tgl_surat');?>">
                                    <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Skema</label>
                                    <select name="skema" class="form-control" value="<?= set_value('skema'); ?>">
                                        <option name="" selected disabled>-- Pilih --</option>
                                        <option value="">Skema Perencanaan Human Capital</option>
                                        <option value="">Skema Pengembangan Human Capital</option>
                                        <option value="">Skema Pengelolaan Hubungan Industrial</option>
                                    </select>
                                    <?= form_error('skema', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal pelaksanaan</label>
                                    <input type="date" name="tgl_pelaksanaan" class="form-control" value="<?= set_value('tgl_surat');?>">
                                    <?= form_error('tgl_pelaksanaan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Batch</label>
                                    <input type="number" name="batch" class="form-control" value="<?= set_value('batch');?>">
                                    <?= form_error('batch', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Batch</label>
                                    <input type="number" name="batch" class="form-control" value="<?= set_value('batch');?>">
                                    <?= form_error('batch', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <a class="btn btn-danger" href="<?= base_url('admin/suratkeluar/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>