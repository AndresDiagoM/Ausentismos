function show_alert(icon1, message){
	Swal.fire({
		position: 'center',
		icon: icon1,
		title: message,
		showConfirmButton: true,
		confirmButtonText: 'Aceptar',
		//timer: 2500
		//text: 'El ausentismo se ha registrado correctamente',
		allowOutsideClick: false
	});
}
function show_alert_reload(icon1, message){
	Swal.fire({
		position: 'center',
		icon: icon1,
		title: message,
		showConfirmButton: true,
		confirmButtonText: 'Aceptar',
		//timer: 2500
		//confirmButtonColor: "#be3838",
		allowOutsideClick: false
	}).then((result) => {
		if (result.isConfirmed) {
			location.reload();
		}
	});
}
function show_alert_redirect(icon1, message, url){
	Swal.fire({
		icon: icon1,
		title: message,
		showConfirmButton: true,
		confirmButtonText: 'Aceptar',
		//timer: 1500
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = url;
		}
	});
}
function show_alert_reset_form(icon1, message, id_form){
	Swal.fire({
		position: 'center',
		icon: icon1,
		title: message,
		showConfirmButton: true,
		confirmButtonText: 'Aceptar',
		//timer: 2500
		allowOutsideClick: false
	}).then((result) => {
		if (result.isConfirmed) {
			//location.reload();
			//clean the form
			document.getElementById(id_form).reset();
		}
	});
}

/*
Swal.fire({
	title: "TITULO",
	text: "WEB",
	html: "<b class='rojo'>WEB 1 </b>",
	// icon:
	// confirmButtonText:
	// footer:
	// width:
	// padding:
	// background:
	// grow:
	// backdrop:
	// timer:
	// timerProgressBar:
	// toast:
	// position:
	// allowOutsideClick:
	// allowEscapeKey:
	// allowEnterKey:
	// stopKeydownPropagation:

	// input:
	// inputPlaceholder:
	// inputValue:
	// inputOptions:
	
	//  customClass:
	// 	container:
	// 	popup:
	// 	header:
	// 	title:
	// 	closeButton:
	// 	icon:
	// 	image:
	// 	content:
	// 	input:
	// 	actions:
	// 	confirmButton:
	// 	cancelButton:
	// 	footer:	

	// showConfirmButton:
	// confirmButtonColor:
	// confirmButtonAriaLabel:

	// showCancelButton:
	// cancelButtonText:
	// cancelButtonColor:
	// cancelButtonAriaLabel:
	
	// buttonsStyling:
	// showCloseButton:
	// closeButtonAriaLabel:


	// imageUrl:
	// imageWidth:
	// imageHeight:
	// imageAlt:
});*/

/*
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!',
    footer: '<a href="">Why do I have this issue?</a>'
  })*/