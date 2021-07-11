<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="<?= base_url('admin/kwitansi/insert'); ?>"><i class="fas fa-plus"></i> Tambah</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-lg" id="table" width="100%" cellspacing="0">
                            <thead class="">
                                <tr>
                                    <th> # </th>
                                    <th> No kwitansi </th>
                                    <th> Diterima dari </th>
                                    <th> Terbilang </th>
                                    <th> Tujuan </th>
                                    <th> Jumlah </th>
                                    <th> tanggal terima </th>
                                    <th> Lampiran </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- content table -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Js -->
<script type="text/javascript">
	$(document).ready(() => {
		$('#table').DataTable({
			"responsive": true,
			"processing": true,
			"language": {
				"processing": '<i class="fas fa-circle-notch fa-spin fa-1x fa-fw"></i><span>Loading...</span> '
			},
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "<?php echo site_url('admin/kwitansi/datatables') ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0, 7],
				"className": 'dt-center',
				"orderable": false,
			}],
		});
	});
</script>