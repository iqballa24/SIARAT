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
                                <div class="form-group col-12">
                                    <label>Tanggal Invoice</label>
                                    <input type="date" class="form-control" name="date" value="<?= $data_invoice_single['tgl_invoice'] ?>">
                                    <?= form_error('date', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-12">
                                    <label>Jatuh tempo</label>
                                    <input type="text" class="form-control" name="jatuh_tempo" value="<?= $data_invoice_single['jatuh_tempo'] ?>">
                                    <?= form_error('jatuh_tempo', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Tujuan</label>
                                    <input type="text" name="tujuan" class="form-control" value="<?= $data_invoice_single['tujuan'] ?>">
                                    <?= form_error('tujuan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control" value="<?= $data_invoice_single['lokasi'] ?>">
                                    <?= form_error('lokasi', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group row col-12">
                                    <label for="inputName" class="col-md-1 col-form-label">Table</label>
                                    <div class="col-md-6">
                                        <textarea id="editor" type="text" class="form-control" name="uraian" value="" rows="5" placeholder="uraian"><?= $data_invoice_single['uraian'] ?></textarea>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" id="inputName" placeholder="Qty" name="kuantitas" value="<?= $data_invoice_single['kuantitas'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" id="txtharga" placeholder="Harga" name="harga" value="<?= $data_invoice_single['harga'] ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" id="inputName" placeholder="Diskon" name="diskon" value="<?= $data_invoice_single['diskon'] == '1' ? '' : $data_invoice_single['diskon'] ?>">
                                    </div>
                                </div>
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
                                <label>Lampiran file</label>
                                <div class="custom-file">
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
    ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .then( editor => {
                    console.log( editor );
            } )
            .catch( error => {
                    console.error( error );
            } );

    
</script>