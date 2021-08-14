<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Surat Keluar.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="8" rowspan="3">DATA SURAT KELUAR LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>No surat</th>
            <th>Perihal</th>
            <th>Tanggal Surat</th>
            <th>Jenis Surat</th>
            <th>Tujuan</th>
            <th>Divisi/bagian</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_suratkeluar as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['no_surat']; ?></td>
                <td><?= $data['perihal']; ?></td>
                <td><?= $data['tgl_surat']; ?></td>
                <td><?= $data['jenis_surat']; ?></td>
                <td><?= $data['tujuan']; ?></td>
                <td><?= $data['divisi']; ?></td>
                <td><?= $data['keterangan']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>