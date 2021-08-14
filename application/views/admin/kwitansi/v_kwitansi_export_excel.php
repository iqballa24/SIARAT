<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Kwitansi LSP HCMI.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="7" rowspan="3">DATA KWITANSI LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>No kwitansi</th>
            <th>Diterima dari</th>
            <th>Terbilang</th>
            <th>Tujuan</th>
            <th>Jumlah</th>
            <th>Tanggal terima</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_kwitansi as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['no_kwitansi']; ?></td>
                <td><?= $data['tujuan']; ?></td>
                <td><?= $data['terbilang']; ?></td>
                <td><?= $data['tujuan_pembayaran']; ?></td>
                <td><?= $data['total']; ?></td>
                <td><?= $data['tgl_terima']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>