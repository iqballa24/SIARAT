<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mr-auto ml-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/user/update/'.$data_user_single['id_user']); ?>">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo $data_user_single['username']; ?>">
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $data_user_single['name']; ?>">
                                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Level</label>
                                    <select name="level" class="form-control" value="<?= set_value('level'); ?>" required>
                                        <option selected disabled>-- select --</option>
                                        <option value="1">admin</option>
                                        <option value="2">user</option>
                                    </select>
                                    <?= form_error('level', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Status</label>
                                    <select name="status" class="form-control" value="<?= set_value('status'); ?>" required>
                                        <option selected disabled>-- select --</option>
                                        <option value="y">active</option>
                                        <option value="n">inactive</option>
                                    </select>
                                    <?= form_error('status', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                                <a class="btn btn-danger" href="<?= base_url('admin/user/read/'); ?>">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>