<script type="text/javascript">
var mailUser;

$(document).ready( function () {
	$("body").on('click','.btnDarDeBaja',function(){
		var mail = $(this).data('mailuser');
		mailUser = mail;
    	darDeBaja();
	});
	$("body").on('click','.btnVerReservas',function(){
		var mail = $(this).data('mailuser');
		urlDestino = '<?php echo base_url() ?>controladorReservas/verReservas/'+mail;
		window.location = urlDestino;
	});

function darDeBaja(){
			swal({
	  		title: "¿Estas seguro?",
	  		text: "Estas a punto de dar de baja al usuario:  "+mailUser,
	 		 type: "warning",
	  		showCancelButton: true,
	 	 	confirmButtonClass: "btn-danger",
	  		confirmButtonText: "Dar de baja",
	  		cancelButtonText: "Cancelar",
	 		closeOnConfirm: false
		},
		function(){
			url = '<?php echo base_url() ?>controladorUsuarios/darDeBaja/'+mailUser;
			$.ajax({
				dataType: "json",
	            url: url
			}).done(function(response){
				if (response){
					swal("Listo!", "El usuario se ha dado de baja", "success");
					tableClientes.ajax.url('<?php echo base_url() ?>controladorUsuarios/mostrarClientes').load(); 
				} else {
					swal("Ups", "No se pudo realizar la baja","warning");
				}
			});
	  		
		});
}
tableClientes = $('#tablaClientes').DataTable({
	columns: [
	{title: "DNI"},
	{title: "Nombre"},
	{title: "Apellido"},
	{title: "Email"},
	{title: "Telefono"},
	{title: "rol"},
	{title: "Reservas"},
	{title: "Opciones"},
	],
	 "responsive":		true,
	 "retrieve":			true,
	 "ajax":	'<?php echo base_url() ?>controladorUsuarios/mostrarClientes'			
	
});
});

</script>
<div class="container" id="contTablaClientes">
<table class="display" id="tablaClientes">
								
</table>
</div>


			
