<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/notadinas/insert/'); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="hidden" class="form-control" name="no_urut" value="<?= sprintf("%03s", $no_urut) ?>">
                                    <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Perihal</label>
                                    <input type="text" class="form-control" name="perihal" value="<?= set_value('perihal'); ?>">
                                    <?= form_error('perihal', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>                                
                                <div class="form-group col-6">
                                    <label>Tujuan</label>
                                    <input type="text" name="tujuan" class="form-control" value="<?= set_value('tujuan');?>">
                                    <?= form_error('tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Dari</label>
                                    <input type="text" name="dari" class="form-control" value="<?= set_value('dari');?>">
                                    <?= form_error('dari', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal</label>
                                    <input type="date" name="tgl" class="form-control" value="<?= set_value('tgl');?>">
                                    <?= form_error('tgl', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Divisi/bagian</label>
                                    <select name="divisi" class="form-control" value="<?= set_value('divisi'); ?>">
                                    <option name="" selected disabled>-- Pilih --</option>
                                        <?php foreach ($data_divisi as $divisi) : ?>
                                            <option value="<?= $divisi['kode']; ?>"><?= $divisi['divisi']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('divisi', '<small class="text-danger pl-3">', '</small>'); ?>
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