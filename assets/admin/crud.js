$(document).ready(function() {
  const flashdata = $(".flashdata").data("flashdata");
	const type = $(".flashdata").data("type");
  if(flashdata){
    Swal.fire({
      icon: type,
      text: flashdata,
    })
  };

  
  //Datatable Servr-side
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

  //SELECT2
  $('.level').select2({
    placeholder: "Pilih Level",
    allowClear: true
  }); 
});