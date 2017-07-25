<script type="text/javascript">
	var tipoBusqueda;
	$(document).ready(function($){

		$('.btn-buscar').on('click',function(){
			tipoBusqueda = $(this).data('tipo');
			$('#parametro').html(tipoBusqueda);
			$('#fechas').show();
		});
		$('#buscarReservas').on('click',function(){
			var fechaDesde = $('#fechaDesde').val();
			var fechaHasta = $('#fechaHasta').val();
			var url = '<?php echo base_url(); ?>ControladorPDF/generarReporte/'+tipoBusqueda+'/'+fechaDesde+'/'+fechaHasta;
			
			window.open('<?php echo base_url(); ?>ControladorPDF/generarReporte/'+tipoBusqueda+'/'+fechaDesde+'/'+fechaHasta);
			
		});
	});
</script>
<style type="text/css" media="screen">
	input[type=date]::-webkit-outer-spin-button,
 	input[type=date]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}
</style>
<div id="container">
	<div class="container">

	<div  class="col-sm-5" >
		<br>
		<input type="button" class="btn btn-buscar" data-tipo="salas" value="Reporte de Salas m&aacute;s reservadas"><br><br>
		<input type="button" class="btn btn-buscar" data-tipo="recursos" value="Reporte de Recursos m&aacute;s reservados"><br><br>
		<input type="button" class="btn btn-buscar" data-tipo="servicios" value="Reporte de Servicios m&aacute;s reservados"><br><br>
	</div>
	
	<div class="col-sm-5" id="fechas" hidden="">
		<h4>Reporte de <span id="parametro"></span> más utlizados/as en las próximas fechas</h4>
		<br>
		Desde:
		<input type="date" class="input-medium search-query formPart" onkeypress="return false" id="fechaDesde" /><br><br>
		Hasta:
		<input type="date" class="input-medium search-query formPart" onkeypress="return false" id="fechaHasta" required/>
		<br><br>
		<button type="button" id="buscarReservas" class="btn">Solicitar Reporte</button> <br><br>
	</div>

	</div>
</div>
<br>
<div class="container">
	<h5>Se generará reporte con los cinco valores más significativos</h5>
	
</div>