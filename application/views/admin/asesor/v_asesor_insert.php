<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/asesor/insert/'); ?>">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?= set_value('nama'); ?>">
                                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>No.Reg./MET</label>
                                    <input type="text" class="form-control" name="noreg" value="<?= set_value('noreg'); ?>">
                                    <?= form_error('noreg', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Kompetensi</label>
                                    <select name="kompetensi" class="form-control" value="<?= set_value('kompetensi'); ?>">\
                                        <option name="" selected disabled>-- Pilih --</option>
                                        <?php foreach ($skema as $data): ?>
                                            <option value="<?= $data['skema']; ?>"><?= $data['skema']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('kompetensi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <a class="btn btn-danger" href="<?= base_url('admin/asesor/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>