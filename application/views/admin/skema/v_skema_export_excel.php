<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Skema.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="2" rowspan="3">DATA SKEMA LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>Skema</th>
        </tr>
    </thead>
    <tbody>
        <!--looping data peminjaman-->
        <?php $i = 1; ?>
        <?php foreach ($data_skema as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['skema']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>