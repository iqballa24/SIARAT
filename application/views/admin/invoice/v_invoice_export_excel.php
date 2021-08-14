<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Invoice LSP HCMI.xls");
?>

<table border="1">
    <thead>
        <tr>
            <th colspan="12" rowspan="3">DATA INVOICE LSP HCMI</th>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <th>No</th>
            <th>No invoice</th>
            <th>Tanggal</th>
            <th>Jatuh Tempo</th>
            <th>Tujuan</th>
            <th>Lokasi</th>
            <th>Uraian</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Diskon</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data_invoice as $data) : ?>
            <?php $total = $data['kuantitas'] * $data['harga'] - (($data['diskon'] * 0.01) * $data['harga'] * $data['kuantitas'])?>
            <!--cetak data per baris-->
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $data['no_invoice']; ?></td>
                <td><?= $data['tgl_invoice']; ?></td>
                <td><?= $data['jatuh_tempo']; ?></td>
                <td><?= $data['tujuan']; ?></td>
                <td><?= $data['lokasi']; ?></td>
                <td><?= $data['uraian']; ?></td>
                <td><?= $data['kuantitas']; ?></td>
                <td><?= $data['harga']; ?></td>
                <td><?= $data['diskon'] == '0' ? '-' : $data['diskon'] ."%"; ?></td>
                <td><?= $total; ?></td>
                <td><?= $data['status']  ==  1 ? "Lunas" : "Belum lunas" ; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>