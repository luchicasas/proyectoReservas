
   <script type="text/javascript">
   var tipoUsuario = '<?php echo $this->session->userdata('tipo');?>';
	if (tipoUsuario == '2'){
		var usuario = '<?php echo $this->session->userdata('mail');?>';
	} else {
		var usuario = '<?php echo $mailUser; ?>';
	}
	var idReserva;
		jQuery(document).ready(function($) {
			$('#clienteRecibido').html(usuario);
			var urlRes = '<?php echo base_url();?>controladorReservas/mostrarReservas/'+usuario;
			tableReservas = $('#grid').DataTable({
				columns: [
				{title: "ID"},
				{title: "Estado"},
				{title: "Sala"},
				{title: "Precio sala"},
				{title: "Fecha"},
				{title: "Duración"},
				{title: "Precio Total"},
				{title: "Adicionales"},
				{title: "Opciones"}
				],
				"responsive":		true,
				"retrieve":			true,
				"ajax" : urlRes
			});


			$('body').on('click','.btn-anular',function(){
				idReserva = $(this).data('id'); 
				swal({
		  		title: "¿Estas seguro?",
		  		text: "Estas a punto de anular una reserva",
		 		 type: "warning",
		  		showCancelButton: true,
		 	 	confirmButtonClass: "btn-danger",
		  		confirmButtonText: "Si, anular",
		  		cancelButtonText: "Cancelar",
		 		closeOnConfirm: false
				},
				function(){
					var urlAnular = '<?php echo base_url() ?>controladorReservas/anularReserva/'+idReserva;
					$.ajax({
						dataType: "json",
	        			url: urlAnular
					}).done(function(response){
						if (response.anulacion){
							if(response.reintegro != 0) {
								var reintegro = response.reintegro * -1;
								//Generar nota de credito
								window.open('<?php echo base_url(); ?>controladorPDF/generarFactura/'+idReserva+'/notaCredito/'+reintegro);
		  						swal("Anulado!", "La reserva ha sido anulada. Se generó una nota de crédito por "+reintegro+" pesos", "success");
		  					} else {
		  						swal("Anulado!", "La reserva ha sido anulada", "success");
		  					}
		  					var urlRes = '<?php echo base_url();?>controladorReservas/mostrarReservas/'+usuario;
		  					tableReservas.ajax.url(urlRes).load();
		  				} else {
		  					swal("Ups", "No pudo realizarse la acción", "warning");
		  				}
		  			});
				});
			});
			// Si es un cliente lo lleva a realizar el pago por tarjeta, caso contrario, el encargado solemente presiona pagar y se carga el pago
			<?php if ($this->session->userdata('tipo') == '2' ){ ?>
			$('body').on('click','.btnPagar',function(){
				idReserva = $(this).data('id');
				var urlDestino = '<?php echo base_url(); ?>controladorReservas/pagar/'+idReserva+'/'+usuario;
				window.location = urlDestino;
			});
			<?php } else { ?>
			$('body').on('click','.btnPagar',function(){
				idReserva = $(this).data('id');
				swal({
		  		title: "¿Estas seguro?",
		  		text: "Estas a punto de pagar una reserva",
		 		type: "warning",
		  		showCancelButton: true,
		 	 	confirmButtonClass: "btn-danger",
		  		confirmButtonText: "Si, pagar",
		  		cancelButtonText: "Cancelar",
		 		closeOnConfirm: false
				},function(){
					var urlPagar = '<?php echo base_url() ?>controladorReservas/pagarReserva/'+idReserva;
					$.ajax({
						dataType: "json",
	        			url: urlPagar
					}).done(function(response){
						if(response){
							swal("Listo!", "La reserva ha sido pagada", "success");
		  					var urlRes = '<?php echo base_url();?>controladorReservas/mostrarReservas/'+usuario;
		  					tableReservas.ajax.url(urlRes).load();
		  					window.open('<?php echo base_url(); ?>controladorPDF/generarFactura/'+idReserva+'/factura');
						} else {
							swal("Ups", "No pudo realizarse la acción", "warning");
						}
					});
				});
			});	
			<?php }  ?>
		});
	</script>

	
	<div class="container" >
	<div  class="container">
	<h2> Reservas realizadas </h2>
	<h3>Cliente: <span id="clienteRecibido"> </span></h3>
	</div>


	<hr>
	<div class="container" >
		<table id="grid" class="table table-striped table-bordered dt-responsive nowrap display"  width="100%"  >
		
		</table>
	
	</div>
	</div>
	
    