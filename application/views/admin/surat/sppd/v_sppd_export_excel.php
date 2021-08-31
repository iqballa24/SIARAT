<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Surat Perintah Perjalanan Dinas LSP HCMI.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="18" rowspan="3">DATA SURAT PERINTAH PERJALANAN DINAS LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>No surat</th>
            <th>Tanggal surat</th>
            <th>1. Pejabat yang berwenang memberi perintah</th>
            <th>2. Nama pejabat yang diperintahkan</th>
            <th>3 a. Pangkat dan golongan</th>
            <th>3 b. Jabatan</th>
            <th>3 c. Gaji Pokok</th>
            <th>3 d. Tingkat menurut peraturan perjalanan dinas</th>
            <th>4. Maksud perjalanan dinas</th>
            <th>5. Alat angkut yang dipergunakan</th>
            <th>6 a Tempat berangkat</th>
            <th>6 b Tempat Tujuan</th>
            <th>7 a. Lamanya perjalanan dinas</th>
            <th>7 b. Tanggal berangkat</th>
            <th>7 c. Tanggal harus kembali</th>
            <th>8. Pembebanan Anggaran</th>
            <th>9. Keterangan Lain Lain</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_sppd as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['no_surat']; ?></td>
                <td><?= $data['tanggal_surat']; ?></td>
                <td><?= $data['pemberi_perintah']; ?></td>
                <td><?= $data['penerima_perintah']; ?></td>
                <td><?= $data['golongan']; ?></td>
                <td><?= $data['jabatan']; ?></td>
                <td><?= $data['gaji']; ?></td>
                <td><?= $data['tingkat_perjalanan']; ?></td>
                <td><?= $data['tujuan_perjalanan']; ?></td>
                <td><?= $data['kendaraan']; ?></td>
                <td><?= $data['tempat_berangkat']; ?></td>
                <td><?= $data['tempat_tujuan']; ?></td>
                <td><?= $data['lama_perjalanan']; ?></td>
                <td><?= $data['tanggal_berangkat']; ?></td>
                <td><?= $data['tanggal_kembali']; ?></td>
                <td><?= $data['pembebanan_anggaran']; ?></td>
                <td><?= $data['keterangan']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>