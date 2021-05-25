<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data invoice</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-md" id="table" width="100%" cellspacing="0">
                            <thead class="">
                                <tr>
                                    <th> # </th>
                                    <th> No Invoice </th>
                                    <th> Tanggal </th>
                                    <th> Jatuh Tempo </th>
                                    <th> Tujuan </th>
                                    <th> Lokasi </th>
                                    <th> Status </th>
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
				"url": "<?php echo site_url('admin/invoice/datatables') ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0, 8],
				"className": 'dt-center',
				"orderable": false,
			}],
		});
	});
</script>