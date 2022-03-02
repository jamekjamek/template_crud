$(function(){
  const flashdata = $(".flashdata").data("flashdata");
	const type = $(".flashdata").data("type");
  if(flashdata){
    Swal.fire({
      icon: type,
      text: flashdata,
    })
  }
});