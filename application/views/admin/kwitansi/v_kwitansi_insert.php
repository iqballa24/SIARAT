<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/kwitansi/insert/'); ?>" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control" name="no_urut" value="No.<?= sprintf("%05s", $no_urut) ?>/KW/LSPHCMI/<?= $year; ?>" readonly>
                                    <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>No Invoice</label>
                                    <select id="invoice" name="invoice" class="form-control" required>
                                        <?php foreach ($data_invoice as $data) : ?>
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="<?php echo $data['id']; ?>"><?= $data['no_invoice']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan</label>
                                    <input id="txttujuan" type="text" class="form-control" value="" readonly>
                                </div>
                                <div class="form-group col-12">
                                    <label>Untuk pembayaran</label>
                                    <textarea id="txtpembayaran" type="text" class="form-control" name="tujuan_pembayaran" value="<?= set_value('tujuan_pembayaran'); ?>" rows="1"></textarea>
                                    <?= form_error('tujuan_pembayaran', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Tanggal terima</label>
                                    <input type="date" name="tgl_terima" class="form-control" value="<?= set_value('tgl_terima');?>">
                                    <?= form_error('tgl_terima', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                           </div>
                        <div class="text-right">
                            <p>&nbsp;</p>
                            <a class="btn btn-danger" href="<?= base_url('admin/kwitansi/read/'); ?>">Batal</a>
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
// baseURL variable
const baseURL= "<?php echo base_url();?>";

$(document).ready(function(){
    $('#invoice').change(function(){
        const invoice = $(this).val();
        const txtpembayaran = $(this).val();

        // Ajax request
        $.ajax({
            url:'<?= base_url();?>admin/kwitansi/getInvoice',
            method:'post',
            data:{id:invoice},
            dataType:'json',
            success:function(response){

                // Remove option
                $('#txtpembayaran').find('option').not(':first').remove();
                $('#txttujuan').find('option').not(':first').remove();

                // Add option
                $.each(response,function(index,data){
                    $('#txttujuan').val(data['tujuan']);
                    $('#txtpembayaran').val(data['uraian']);
                });
            }
        })
    });
});
</script>