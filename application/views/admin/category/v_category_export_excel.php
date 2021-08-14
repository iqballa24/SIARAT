<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Kategori Surat.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="3" rowspan="3">DATA KATEGORI SURAT LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Jenis Surat</th>
            <th>Kode</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_category as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['jenis_surat']; ?></td>
                <td>'<?= $data['kd_surat']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>