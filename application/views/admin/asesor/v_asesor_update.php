<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/asesor/update/'.$data_asesor_single['id']); ?>">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?php echo $data_asesor_single['nama']; ?>">
                                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>No.Reg/MET</label>
                                    <input type="text" class="form-control" name="noreg" value="<?php echo $data_asesor_single['Noreg']; ?>">
                                    <?= form_error('noreg', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Kompetensi</label>
                                    <select name="kompetensi" class="form-control" value="<?= set_value('kompetensi'); ?>">
                                        <?php foreach ($skema as $data) : ?>
                                            <?php if ($data['skema'] == $data_asesor_single['Kompetensi']) : ?>
                                                <option value="<?= $data['skema']; ?>" selected><?= $data['skema']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $data['skema']; ?>"><?= $data['skema']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                                <a class="btn btn-danger" href="<?= base_url('admin/asesor/read/'); ?>">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>