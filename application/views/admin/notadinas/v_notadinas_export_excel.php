<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Nota Dinas.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="7" rowspan="3">DATA NOTA DINAS LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Nomor</th>
            <th>Tujuan</th>
            <th>Dari</th>
            <th>Perihal</th>
            <th>Tanggal Surat</th>
            <th>Divisi/bagian</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_notadinas as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['no_notadinas']; ?></td>
                <td><?= $data['tujuan']; ?></td>
                <td><?= $data['dari']; ?></td>
                <td><?= $data['perihal']; ?></td>
                <td><?= $data['tanggal']; ?></td>
                <td><?= $data['divisi']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>