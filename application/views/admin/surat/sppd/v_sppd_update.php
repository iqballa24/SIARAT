<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/sppd/update_submit/'.$data_sppd_single['id']); ?>" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" name="no_surat" value="<?= $data_sppd_single['no_surat'] ?>">
                            <input type="hidden" class="form-control" name="no_urut" value="<?= $data_sppd_single['no_urut'] ?>">
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">Tanggal Surat</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="tgl_surat" value="<?= $data_sppd_single['tanggal_surat'] ?>">
                                    <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">1. Pejabat yang berwenang memberi perintah</label>
                                <div class="col-sm-7">
                                    <select name="pemberi_perintah" class="form-control" value="<?= set_value('pemberi_perintah'); ?>" required>
                                        <?php foreach ($data_pegawai as $pegawai) : ?>
                                            <?php if ($pegawai['nama'] == $data_sppd_single['pemberi_perintah']) : ?>
                                                <option value="<?= $pegawai['nama']; ?>" selected><?= $pegawai['nama']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $pegawai['nama']; ?>"><?= $pegawai['nama']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('pemberi_perintah', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">2. Nama pejabat yang diperintahkan</label>
                                <div class="col-sm-7">
                                    <select name="penerima_perintah" class="form-control" value="<?= set_value('penerima_perintah'); ?>" required>
                                        <?php foreach ($data_pegawai as $pegawai) : ?>
                                            <?php if ($pegawai['nama'] == $data_sppd_single['penerima_perintah']) : ?>
                                                <option value="<?= $pegawai['nama']; ?>" selected><?= $pegawai['nama']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $pegawai['nama']; ?>"><?= $pegawai['nama']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('penerima_perintah', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">3 a. Pangkat dan golongan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="golongan" value="<?= $data_sppd_single['golongan'] ?>">
                                    <?= form_error('golongan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp b. Jabatan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="jabatan" value="<?= $data_sppd_single['jabatan'] ?>">
                                    <?= form_error('jabatan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp c. Gaji Pokok</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="gaji" value="<?= $data_sppd_single['gaji'] ?>">
                                    <?= form_error('gaji', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp d. Tingkat menurut peraturan perjalanan dinas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tingkat_perjalanan" value="<?= $data_sppd_single['tingkat_perjalanan'] ?>">
                                    <?= form_error('tingkat_perjalanan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">4. Maksud perjalanan dinas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tujuan_perjalanan" value="<?= $data_sppd_single['tujuan_perjalanan'] ?>">
                                    <?= form_error('tujuan_perjalanan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">5. Alat angkut yang dipergunakan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="kendaraan" value="<?= $data_sppd_single['kendaraan'] ?>">
                                    <?= form_error('kendaraan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">6. a Tempat berangkat</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tempat_berangkat" value="<?= $data_sppd_single['tempat_berangkat'] ?>">
                                    <?= form_error('tempat_berangkat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp b Tempat Tujuan</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="tempat_tujuan" value="<?= $data_sppd_single['tempat_tujuan'] ?>">
                                    <?= form_error('tempat_tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">7 a. Lamanya perjalanan dinas</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="lama_perjalanan" value="<?= $data_sppd_single['lama_perjalanan'] ?>">
                                    <?= form_error('lama_perjalanan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp b. Tanggal berangkat</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="tanggal_berangkat" value="<?= $data_sppd_single['tanggal_berangkat'] ?>">
                                    <?= form_error('tanggal_berangkat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">&nbsp &nbsp c. Tanggal harus kembali</label>
                                <div class="col-sm-7">
                                    <input type="date" class="form-control" name="tanggal_kembali" value="<?= $data_sppd_single['tanggal_kembali'] ?>">
                                    <?= form_error('tanggal_kembali', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">8. Pembebanan Anggaran</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="pembebanan_anggaran" value="<?= $data_sppd_single['pembebanan_anggaran'] ?>">
                                    <?= form_error('pembebanan_anggaran', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-5 col-form-label">9. Keterangan Lain Lain</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="keterangan" value="<?= $data_sppd_single['keterangan'] ?>">
                                    <?= form_error('keterangan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label>Lampiran file</label>
                                <div class="custom-file">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data_sppd_single['lampiran']; ?>">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data_sppd_single['lampiran']; ?>">
                                    <!--response setelah upload-->
                                    <?php if (!empty($response)) : ?>
                                        <small class="text-danger pl-3">
                                            <?= $response; ?>
                                        </small>
                                    <?php endif; ?>
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