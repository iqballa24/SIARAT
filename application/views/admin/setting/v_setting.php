<section class="content">
    <div class="container-fluid">
    <?php foreach ($data_setting as $data) : ?>
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-<?= $data['theme'] ;?> card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class=" img-fluid img-circle" src="<?= base_url('upload_folder/img/'.$data['logo']); ?>" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center"><?= $data['owner']; ?></h3>

                        <p class="text-muted text-center">Owner</p>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/setting/update_submit/'.$data['id']); ?>" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Owner</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name" name="owner" value="<?= $data['owner'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">theme</label>
                                <div class="col-sm-10">
                                    <select name="theme" class="form-control" value="<?= set_value('theme'); ?>">
                                        <option name="" selected value="<?= $data['theme'] ?>"><?= $data['theme'] ?></option>
                                        <option value="blue">blue</option>
                                        <option value="hijau">green</option>
                                        <option value="yellow">yellow</option>
                                        <option value="red">red</option>
                                        <option value="indigo">indigo</option>
                                        <option value="purple">purple</option>
                                        <option value="pink">pink</option>
                                        <option value="orange">orange</option>
                                        <option value="maroon">maroon</option>
                                        <option value="navy">navy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Nav style</label>
                                <div class="col-sm-10">
                                    <select name="sidebar" class="form-control" value="<?= set_value('sidebar'); ?>">
                                        <option name="" selected value="<?= $data['sidebar'] ?>"><?= $data['sidebar'] ?></option>
                                        <option value="default">default</option>
                                        <option value="nav-flat">nav flat</option>
                                        <option value="nav-legacy">nav legacy</option>
                                        <option value="nav-compact">nav compact</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Mode</label>
                                <div class="col-sm-10">
                                    <select name="mode" class="form-control" value="<?= set_value('mode'); ?>">
                                        <option name="" selected value="<?= $data['mode'] ?>"><?= $data['mode'] ?></option>
                                        <option value="dark">dark</option>
                                        <option value="light">light</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Logo</label>
                                <div class="custom-file col-sm-10">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data['logo']; ?>">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data['logo']; ?>">
                                    <!--response setelah upload-->
                                    <?php if (!empty($response)) : ?>
                                        <small class="text-danger pl-3">
                                            <?= $response; ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10 text-right">
                                    <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    <?php endforeach ?>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->