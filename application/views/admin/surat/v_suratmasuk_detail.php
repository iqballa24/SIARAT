<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <?php foreach ($dt_suratmasuk as $data) : ?>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>No surat: </b>
                                    <p href="" class=""><?= $data['no_surat']; ?></p>
                                </li>
                                <li class="list-group-item">
                                    <b>Perihal: </b>
                                    <p href="" class=""><?= $data['perihal']; ?></p>
                                </li>
                                <li class="list-group-item">
                                    <b>Tanggal surat: </b>
                                    <p href="" class=""><?= date('d F Y', strtotime($data['tgl_surat'])); ?></p>
                                </li>
                                <li class="list-group-item">
                                    <b>Jenis surat: </b>
                                    <p href="" class=""><?= $data['jenis_surat']; ?></p>
                                </li>
                                <li class="list-group-item">
                                    <b>Tanggal terima: </b>
                                    <p href="" class=""><?= date('d F Y', strtotime($data['tgl_terima'])); ?></p>
                                </li>
                                <li class="list-group-item">
                                    <b>Keterangan: </b>
                                    <p href="" class=""><?= $data['keterangan']; ?></p>
                                </li>
                            </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <object data="<?= base_url('upload_folder/pdf/'.$data['lampiran']); ?>" type="application/pdf" width="100%" height="500px">
                    <p>
                        This browser does not support PDFs. Please download the PDF to
                        view it
                    </p>
                </object>
                    <a href="<?= base_url('upload_folder/pdf/'.$data['lampiran']); ?>" class="btn btn-primary mt-3 float-right" download target="_blank"> <i class="fas fa-download nav-icon"></i> Download file</a>
                        <?php endforeach ?>
            </div>
        </div>
    </div>
</div>