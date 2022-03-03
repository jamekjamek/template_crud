$(document).ready(function() {
 $('#crud-table').DataTable({
		"processing": true,
		"serverSide": true,
		"searching": true,
		"paging": true,
		"lengthMenu": [
			[10, 25, 50 - 1],
			[10, 25, 50, 'Semua']
		],
		"ordering": [
			[1, 'desc']
		],
		"ajax": {
			"url": `${base_url}crud/datatable`,
			"type": "POST",
		},
		
		"language": {
			"search": "Cari Email:",
			"processing": "Mohon Tunggu ..."
		}
	});

 
});