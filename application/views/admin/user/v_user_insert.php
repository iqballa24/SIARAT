<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mr-auto ml-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/user/insert/'); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= set_value('username'); ?>">
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" value="<?= set_value('name'); ?>">
                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" value="<?= set_value('password'); ?>">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Level</label>
                                    <select name="level" class="form-control" value="<?= set_value('level'); ?>">
                                        <option name="" selected disabled>-- Pilih --</option>
                                        <option value="1">user</option>
                                        <option value="2">admin</option>
                                    </select>
                                    <?= form_error('level', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Active</label>
                                    <select name="is_active" class="form-control" value="<?= set_value('is_active'); ?>">
                                        <option name="" selected disabled>-- Pilih --</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                    <?= form_error('is_active', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <a class="btn btn-danger" href="<?= base_url('admin/user/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>