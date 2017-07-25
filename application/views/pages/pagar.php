<?php $sala = $reserva->sala->get(); ?>

<script>
var idRes = '<?php echo $reserva->id; ?>';
var montoAPagar = '<?php echo $precio; ?>';
jQuery(document).ready(function($) {
	var mailUser = '<?php echo $usuario->mail; ?>';
	var url = '<?php echo base_url(); ?>controladorUsuarios/getTarjetas/'+mailUser;
	tableTarjetas = $('#tablaTarjetas').DataTable({
				columns: [
				{title: "ID"},
				{title: "Numero de tarjeta"},
				{title: "Descripcion"},
				{title: ""}
				],
				"responsive":		true,
				"retrieve":			true,
				"ajax" : url
			});
	$('body').on('click','.btnPagarConTarjeta',function(){
		var idTarj = $(this).data('idTarj');
		var urlPago = '<?php echo base_url(); ?>controladorReservas/pagarConTarjeta/'+idRes+'/'+idTarj+'/'+montoAPagar;
		$.ajax({
			dataType: "json",
	        url: urlPago
		}).done(function(response){
			if (response){
				$('.btnPagarConTarjeta').remove();
				swal({
				title:	"Listo!",
				text:	"La reserva fué pagada con éxito",
				type:	"success"
				},function(){
					window.location = '<?php echo base_url(); ?>controladorReservas/verReservas';
				});

				window.open('<?php echo base_url(); ?>controladorPDF/generarFactura/'+idRes+'/factura');
			}else{
				swal("Ups", "No se pudo realizar el pago, intentelo nuevamente","warning");
			}
		});
	});
	
});

</script>
<div class="container">
	<div style="width:50%; margin-left:30%;">
		<h3>Datos de reserva: </h3>
		<ul>
			<li>Fecha: <?php echo $reserva->fechaReserva;  ?></li>
			<li>Sala: <?php echo $sala->nombre; ?></li>
			<li>Dirección: <?php echo $sala->direccion; ?></li>
			<li>Monto a pagar: <?php echo $precio; ?></li>

		</ul>
	</div>
	<div>
	<br><br>
	<hr>
		<h3>Tarjetas cargadas: </h3>
			<input type="button" id="agregarTarj" value="Agregar tarjeta" data-toggle="modal" data-target="#ModalTarj"><br>
		<div class="container">
			<table id="tablaTarjetas" class="table table-striped table-bordered dt-responsive nowrap display"  width="100%"  >
		
		</table>
		</div>
	</div>
</div>