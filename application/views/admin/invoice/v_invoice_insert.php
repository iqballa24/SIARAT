<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/invoice/insert/'); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>No Invoice</label>
                                    <input type="text" class="form-control" name="no_urut" value="LSP-Invoice-<?= sprintf("%03s", $no_urut) ?>" readonly>
                                    <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal Invoice</label>
                                    <input type="date" class="form-control" name="date" value="<?= set_value('date'); ?>">
                                    <?= form_error('date', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-6">
                                    <label>Jatuh tempo</label>
                                    <input type="text" class="form-control" name="jatuh_tempo" value="<?= set_value('jatuh_tempo'); ?>">
                                    <?= form_error('jatuh_tempo', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan</label>
                                    <input type="text" name="tujuan" class="form-control" value="<?= set_value('tujuan');?>">
                                    <?= form_error('tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="<?= set_value('lokasi');?>">
                                    <?= form_error('lokasi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group row col-12">
                                    <label for="inputName" class="col-md-1 col-form-label">Table</label>
                                    <div class="col-md-6">
                                        <textarea id="editor" type="text" class="form-control" name="uraian" value="" rows="5" placeholder="uraian"><?= set_value('uraian'); ?></textarea>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" id="inputName" placeholder="Qty" name="kuantitas" value="<?= set_value('kuantitas'); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="txtharga" placeholder="Harga" name="harga" value="<?= set_value('harga'); ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" id="inputName" placeholder="Diskon" name="diskon" value="<?= set_value('diskon'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Status</label>
                                    <select name="status" class="form-control" value="<?= set_value('status'); ?>">
                                        <option selected disabled>-- Pilih --</option>
                                        <option value="1">Lunas</option>
                                        <option value="2">Belum lunas</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Terbilang</label>
                                    <input type="text" name="terbilang" class="form-control" value="<?= set_value('terbilang');?>">
                                    <?= form_error('terbilang', '<small class="text-danger pl-3">', '</small>'); ?>
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
    ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                    console.log( editor );
            } )
            .catch( error => {
                    console.error( error );
            } );

    const txtharga = document.getElementById('txtharga');
    txtharga.addEventListener('keyup', function(e){
        txtharga.value = formatRupiah(this.value, 'Rp. ');
    });

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