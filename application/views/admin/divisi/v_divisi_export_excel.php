<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Divisi.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="3" rowspan="3">DATA DIVISI LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Divisi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_divisi as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['kode']; ?></td>
                <td><?= $data['divisi']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>