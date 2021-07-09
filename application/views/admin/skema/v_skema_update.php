<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/skema/update/'.$data_skema['id']); ?>">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="skema" value="<?php echo $data_skema['skema']; ?>">
                                    <?= form_error('skema', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                                <a class="btn btn-danger" href="<?= base_url('admin/skema/read/'); ?>">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>