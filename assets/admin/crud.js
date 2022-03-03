$(function() {
  const flashdata = $(".flashdata").data("flashdata");
	const type = $(".flashdata").data("type");
  if(flashdata){
    Swal.fire({
      icon: type,
      text: flashdata,
    })
  };

  function deleteQuestion(url, text) {
		Swal.fire({
			text: text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yakin'
		}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = url;
			}
		})
	};

  $('#crud-table').DataTable({
      "processing": true,
      "serverSide": true,
      "searching": true,
      "paging": true,
      "lengthMenu": [
        [10, 25, 50 - 1],
        [10, 25, 50, 'Semua']
      ],
      "order": [
        [1, 'desc']
      ],
      "ajax": {
        "url": `${base_url}crud/datatable`,
        "type": "POST",
      },
      
      "language": {
        "search": "Cari Email : ",
        "processing": "Mohon Tunggu ..."
      }
  });

  $(document).on('click', '.delete-data', function () {
		var id = $(this).data('id');
    var url = `${base_url}home/hapus/${id}`
    deleteQuestion(url, "Yakin akan menghapus data ini ?");
	});
});