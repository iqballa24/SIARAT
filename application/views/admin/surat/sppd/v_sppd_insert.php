<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/sppd/insert/'); ?>" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" name="no_urut" value="<?= sprintf("%03s", $no_urut) ?>">
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">Tanggal Surat</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="tgl_surat" value="<?= set_value('tgl_surat'); ?>">
                                    <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">1. Pejabat yang berwenang memberi perintah</label>
                                <div class="col-sm-7">
                                    <select name="pemberi_perintah" class="form-control" value="<?= set_value('pemberi_perintah'); ?>">\
                                        <option name="" selected disabled>-- Pilih --</option>
                                        <?php foreach ($data_pegawai as $data) : ?>
                                            <option value="<?= $data['nama']; ?>"><?= $data['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('pemberi_perintah', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">2. Nama pejabat yang diperintahkan</label>
                                <div class="col-sm-7">
                                    <select name="penerima_perintah" class="form-control" value="<?= set_value('penerima_perintah'); ?>">\
                                        <option name="" selected disabled>-- Pilih --</option>
                                        <?php foreach ($data_pegawai as $data) : ?>
                                            <option value="<?= $data['nama']; ?>"><?= $data['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('penerima_perintah', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">3 a. Pangkat dan golongan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="golongan" value="<?= set_value('golongan'); ?>">
                                    <?= form_error('golongan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp b. Jabatan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="jabatan" value="<?= set_value('jabatan'); ?>">
                                    <?= form_error('jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp c. Gaji Pokok</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="gaji" value="<?= set_value('gaji'); ?>">
                                    <?= form_error('gaji', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp d. Tingkat menurut peraturan perjalanan dinas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tingkat_perjalanan" value="<?= set_value('tingkat_perjalanan'); ?>">
                                    <?= form_error('tingkat_perjalanan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">4. Maksud perjalanan dinas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tujuan_perjalanan" value="<?= set_value('tujuan_perjalanan'); ?>">
                                    <?= form_error('tujuan_perjalanan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">5. Alat angkut yang dipergunakan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="kendaraan" value="<?= set_value('kendaraan'); ?>">
                                    <?= form_error('kendaraan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">6. a Tempat berangkat</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tempat_berangkat" value="<?= set_value('tempat_berangkat'); ?>">
                                    <?= form_error('tempat_berangkat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp b Tempat Tujuan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tempat_tujuan" value="<?= set_value('tempat_tujuan'); ?>">
                                    <?= form_error('tempat_tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">7 a. Lamanya perjalanan dinas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="lama_perjalanan" value="<?= set_value('lama_perjalanan'); ?>">
                                    <?= form_error('lama_perjalanan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp b. Tanggal berangkat</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="tanggal_berangkat" value="<?= set_value('tanggal_berangkat'); ?>">
                                    <?= form_error('tanggal_berangkat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp c. Tanggal harus kembali</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="tanggal_kembali" value="<?= set_value('tanggal_kembali'); ?>">
                                    <?= form_error('tanggal_kembali', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">8. Pembebanan Anggaran</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="pembebanan_anggaran" value="<?= set_value('pembebanan_anggaran'); ?>">
                                    <?= form_error('pembebanan_anggaran', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">9. Keterangan Lain Lain</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="keterangan" value="<?= set_value('keterangan'); ?>">
                                    <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <a class="btn btn-danger" href="<?= base_url('admin/sppd/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>