<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah data</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= site_url('admin/surattugas/insert2/'); ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Perihal</label>
                                            <input type="text" name="perihal" class="form-control" value="<?= set_value('perihal');?>" >
                                            <?= form_error('perihal', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Tanggal surat</label>
                                            <input type="date" name="tgl_surat" class="form-control" value="<?= set_value('tgl_surat');?>">
                                            <?= form_error('tgl_surat', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Tanggal pelaksanaan</label>
                                            <input type="date" name="tgl_pelaksanaan" class="form-control" value="<?= set_value('tgl_pelaksanaan');?>">
                                            <?= form_error('tgl_pelaksanaan', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-12">
                                            <input type="hidden" class="form-control" name="no_urut" value="<?= sprintf("%03s", $no_urut) ?>" >
                                            <?= form_error('no_urut', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p>&nbsp;</p>
                                <a class="btn btn-danger" href="<?= base_url('admin/surattugas/read/'); ?>">Batal</a>
                                <input type="submit" name="submit" value="Simpan" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const btnAsesi1 = document.querySelector('.btn-asesi1');
    const btnAsesi2 = document.querySelector('.btn-asesi2');
    const btnaddAsesi3 = document.querySelector('.btnadd-asesi3');
    const btnAsesi3 = document.querySelector('.btn-asesi3');

    function addAsesi2() {
        btnAsesi1.style.display = 'none';
        btnAsesi2.style.display = 'block';
        btnaddAsesi3.style.display= 'block';
    }

    function addAsesi3() {
        btnAsesi3.style.display = 'block';
        btnaddAsesi3.style.display = 'none';
    }
</script>