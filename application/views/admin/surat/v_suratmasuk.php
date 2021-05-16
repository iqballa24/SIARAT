<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data surat masuk</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="table" width="100%" cellspacing="0">
                            <thead class="">
                                <tr>
                                    <th> # </th>
                                    <th> Surat masuk </th>
                                    <th> Tanggal terima </th>
                                    <th> Jenis surat </th>
                                    <th> keterangan </th>
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
				"url": "<?php echo site_url('admin/suratmasuk/datatables') ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0, 5],
				"className": 'dt-center',
				"orderable": false,
			}],
		});

	});
</script>