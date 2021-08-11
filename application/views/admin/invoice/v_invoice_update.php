<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/invoice/update_submit/'.$data_invoice_single['id']); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control" name="no_urut" value="<?= $data_invoice_single['no_invoice'] ?>" readonly>
                                    <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Invoice</label>
                                    <input type="date" class="form-control" name="date" value="<?= $data_invoice_single['tgl_invoice'] ?>">
                                    <?= form_error('date', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jatuh tempo</label>
                                    <input type="text" class="form-control" name="jatuh_tempo" value="<?= $data_invoice_single['jatuh_tempo'] ?>">
                                    <?= form_error('jatuh_tempo', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan</label>
                                    <input type="text" name="tujuan" class="form-control" value="<?= $data_invoice_single['tujuan'] ?>">
                                    <?= form_error('tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="<?= $data_invoice_single['lokasi'] ?>">
                                    <?= form_error('lokasi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <label for="inputName" class="col-md-1 col-form-label">Table</label>
                                <div class="form-group col-md-12">
                                    <textarea id="editor" type="text" class="form-control" name="uraian" value="" rows="1" placeholder="uraian"><?= $data_invoice_single['uraian'] ?></textarea>
                                </div>
                                <div class="form-group col-md-2">
                                    <input id="txtqty" type="text" class="form-control" id="inputName" placeholder="Qty" name="kuantitas" value="<?= $data_invoice_single['kuantitas'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <input id="txtharga" type="text" class="form-control" placeholder="Harga" name="harga" value="<?= $data_invoice_single['harga'] ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <input id="txtdiskon" type="text" class="form-control" id="inputName" placeholder="Diskon" name="diskon" value="<?= $data_invoice_single['diskon'] == '0' ? '' : $data_invoice_single['diskon'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <input id="txttotal" class="form-control" type="text" value="total" readonly>
                                </div>
                                <div class="row col-md-6">
                                    <div class="form-group col-md-12">
                                        <label>Status</label>
                                        <select name="status" class="form-control" value="<?= set_value('status'); ?>">
                                            <option name="" selected value="<?= $data_invoice_single['status'] ?>"><?= $data_invoice_single['status'] == 'Lunas' ? '1' : 'Belum lunas' ?></option>
                                            <option value="1">Lunas</option>
                                            <option value="2">Belum lunas</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Terbilang</label>
                                        <input type="text" name="terbilang" class="form-control" value="<?= $data_invoice_single['terbilang'] ?>">
                                        <?= form_error('terbilang', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                </div>
                                <label class="col-12">Lampiran file</label>
                                <div class="custom-file col-12">
                                    <input type="hidden" class="" name="userfileold" id="validatedInputGroupCustomFile" value="<?= $data_invoice_single['lampiran']; ?>">
                                    <input type="file" class="" name="userfile" id="validatedInputGroupCustomFile" value="<?= $data_invoice_single['lampiran']; ?>">
                                    <!--response setelah upload-->
                                    <?php if (!empty($response)) : ?>
                                        <small class="text-danger pl-3">
                                            <?= $response; ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <div class="text-right">
                            <p>&nbsp;</p>
                            <a class="btn btn-danger" href="<?= base_url('admin/invoice/read/'); ?>">Batal</a>
                            <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    //Init variable 
    const txtqty = document.getElementById('txtqty');
    const txtharga = document.getElementById('txtharga');
    const txttotal = document.getElementById('txttotal');
    const txtdiskon = document.getElementById('txtdiskon');
    let total = '';
    
    document.addEventListener('DOMContentLoaded', function(){
        let diskon = txtdiskon.value == '' ? 0 : txtdiskon.value;
        let harga = txtharga.value.replace(/\./g,'')
        total = txtqty.value * harga - (diskon * 0.01 * txtqty.value * harga);

        txttotal.value = formatRupiah(total.toString());
    });
    
    // Event untuk menghitung total ketika field qty di input
    txtqty.addEventListener('keyup', ()=>{
        let diskon = txtdiskon.value == '' ? 0 : txtdiskon.value;
        let harga = txtharga.value.replace(/\./g,'')
        total = txtqty.value * harga - (diskon * 0.01 * txtqty.value * harga);

        txttotal.value = formatRupiah(total.toString());
    });

    // Event untuk menghitung total ketika field harga di input
    txtharga.addEventListener('keyup', function(e){
        txtharga.value = formatRupiah(this.value);
        let diskon = txtdiskon.value == '' ? 0 : txtdiskon.value;
        let harga = txtharga.value.replace(/\./g,'')
        total = txtqty.value * harga - (diskon * 0.01 * txtqty.value * harga);

        txttotal.value = formatRupiah(total.toString());
    });

    // Event untuk menghitung total ketika field diskon di input
    txtdiskon.addEventListener('keyup', function(e){
        let diskon = txtdiskon.value == '' ? 0 : txtdiskon.value;
        let harga = txtharga.value.replace(/\./g,'')
        total = txtqty.value * harga - (diskon * 0.01 * txtqty.value * harga);

        txttotal.value = formatRupiah(total.toString());
    });

    // Mengubah string menjadi format rupiah
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>