<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <a href="<?= base_url('admin/skema/insert'); ?>" class=""> <i class="fas fa-plus"></i> Tambah</a>
                            </div>
                            <div class="col-6 text-right">
                                <a href="<?= base_url('admin/skema/export_excel'); ?>" class="text-success p-3" title="Export excel"><i class="fas fa-file-export"></i> Excel</a>
                                <!-- |
                                <a href="<?= base_url('admin/skema/export_excel'); ?>" class="text-success p-3" title="Export excel"><i class="fas fa-file-export"></i> Excel</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive-xs" id="table" width="100%" cellspacing="0">
                            <thead class="">
                                <tr>
                                    <th> # </th>
                                    <th> Skema </th>
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
				"url": "<?php echo site_url('admin/skema/datatables') ?>",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [0, 1],
				"className": 'dt-center',
				"orderable": false,
			}],
		});

	});
</script>