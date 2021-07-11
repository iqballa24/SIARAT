<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/surattugas/update_submit/'.$data_surattugas_single['id_surat']); ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Tanggal surat</label>
                                            <input type="date" name="tgl_surat" class="form-control" value="<?= $data_surattugas_single['tgl_surat'];?>">
                                            <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Skema</label>
                                            <select name="skema" class="form-control" value="<?= set_value('skema'); ?>">
                                            <?php foreach ($skema as $data) : ?>
                                                <?php if ($data['skema'] == $data_surattugas_single['skema']) : ?>
                                                    <option value="<?= $data['skema']; ?>" selected><?= $data['skema']; ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $data['skema']; ?>"><?= $data['skema']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            </select>
                                            <?= form_error('jenis_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Tanggal pelaksanaan</label>
                                            <input type="date" name="tgl_pelaksanaan" class="form-control" value="<?= $data_surattugas_single['tgl_pelaksanaan'];?>">
                                            <?= form_error('tgl_pelaksanaan', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Batch</label>
                                            <input type="text" name="batch" class="form-control" value="<?= $data_surattugas_single['batch'];?>">
                                            <?= form_error('batch', '<small class="text-danger pl-3">', '</small>'); ?>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Asesor</label>
                                            <select name="asesor" class="form-control" value="<?= set_value('asesor'); ?>">
                                                <?php foreach ($data_asesor as $data) : ?>
                                                    <?php if ($data['id'] == $data_surattugas_single['asesor']) : ?>
                                                        <option value="<?= $data['id']; ?>" selected><?= $data['nama']; ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $data['id']; ?>"><?= $data['nama']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?= form_error('asesor', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Asesi 1</label>
                                            <input type="text" name="asesi1" class="form-control" value="<?= $data_surattugas_single['asesi1'];?>">
                                            <?= form_error('asesi1', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Asesi 2</label>
                                            <input type="text" name="asesi2" class="form-control" value="<?= $data_surattugas_single['asesi2'];?>">
                                            <?= form_error('asesi1', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <label>Asesi 3</label>
                                            <input type="text" name="asesi3" class="form-control" value="<?= $data_surattugas_single['asesi3'];?>">
                                            <?= form_error('asesi3', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                    </div>
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