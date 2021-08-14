<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Surat Masuk.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="7" rowspan="3">DATA SURAT MASUK LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>No surat</th>
            <th>Perihal</th>
            <th>Pengirim</th>
            <th>Tanggal Surat</th>
            <th>Jenis Surat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_suratmasuk as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['no_surat']; ?></td>
                <td><?= $data['perihal']; ?></td>
                <td><?= $data['pengirim']; ?></td>
                <td><?= $data['tgl_surat']; ?></td>
                <td><?= $data['jenis_surat']; ?></td>
                <td><?= $data['keterangan']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>