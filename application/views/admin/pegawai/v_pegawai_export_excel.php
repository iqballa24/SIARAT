<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Pegawai LSP HCMI.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="3" rowspan="3">DATA PEGAWAI LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1?>
        <?php foreach ($data_pegawai as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['jabatan']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>