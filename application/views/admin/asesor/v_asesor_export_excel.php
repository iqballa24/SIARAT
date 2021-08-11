<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Asesor.xls");
?>


<table border="1">
    <thead>
        <tr>
            <th colspan="3" rowspan="3">DATA ASESOR LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>Nama</th>
            <th>No Reg/MET</th>
            <th>Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        <!--looping data peminjaman-->
        <?php foreach ($data_asesor as $data) : ?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['Noreg']; ?></td>
                <td><?= $data['Kompetensi']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>