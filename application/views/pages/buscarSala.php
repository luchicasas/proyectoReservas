<script type="text/javascript">
function comprobarFechas(fecha1,fecha2){ //Si las fechas coinciden se pone un horario minimo igual al de hoy + 2 horas

	if (fecha1 == fecha2 ){
	 	$('.horas').each(function(index,element){
			var val = parseInt(element.value);
	 		var horaActual = new Date();
			var hora=horaActual.getHours();
			$('#horaIngreso').val(hora+2);
			var tiempoRestante = hora+2;
			
			if (val < hora+2){
				element.disabled = true;
			}
			$('#horaDePago').html($('#horaIngreso').val());
			$('#avisoFecha').show();
	 	});
	 }else {
	 	$('#avisoFecha').hide();
	 	$('.horas').each(function(index,value){
	 		value.disabled = false;	
	 	});
	 }
}
$(document).ready(function() {
	
	 var fecha = $('#fecha').val();
	 var fechamin = $('#fecha').attr('min'); 
	 comprobarFechas(fecha,fechamin);
	 $('#fecha').on('change',function(){
	 	var fecha = $('#fecha').val();
	 	comprobarFechas(fecha,fechamin);
	 });
	 $('#horaIngreso').on('change',function(){
	 	$('#horaDePago').html($('#horaIngreso').val());
	 });

	 var hora = $('#horaIngreso').val()+':'+$('#minIngreso').val();
	 var duracion = $('#duracion').val();
 	 var url = '<?php echo base_url() ?>controladorReservas/buscarSalas/'+fecha+'/'+hora+'/'+duracion;
 	table = $('#tablaSalas').DataTable({
	columns: [
	{title: "ID"},
	{title: "Nombre"},
	{title: "Precio por hora"},
	{title: "Capacidad"},
	{title: "Foto"},
	{title: ""},

	],
	 "responsive":		true,
	 "retrieve":		true,
	 "ajax":	url			
	
});
 	
	$('body').on('click','#btnBuscarSalas',function(){
		$('#avisoFecha').show();
	 	var fecha = $('#fecha').val();
	 	var fechamin = $('#fecha').attr('min');
	 	
	 	var hora = $('#horaIngreso').val()+':'+$('#minIngreso').val();
	 	var duracion = $('#duracion').val();
	 	url = '<?php echo base_url() ?>controladorReservas/buscarSalas/'+fecha+'/'+hora+'/'+duracion;
	 	table.ajax.url(url).load();

	}).on('click','.btnReservar',function(){
		var idSala = $(this).attr('id');
		var fecha = $('#fecha').val();
	 	var hora = $('#horaIngreso').val()+':'+$('#minIngreso').val();
	 	var duracion = $('#duracion').val();
		window.location='<?php echo base_url()?>controladorReservas/reservar/'+idSala+'/'+fecha+'/'+hora+'/'+duracion;
	}).on('change','.formPart',function(){
		$('.btnReservar').remove();
	});



});
</script> 
<!-- este codigo le saca los botones y deshabilita la escritura en el campo date-->
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
        <div class="container"> 

	  <div id="containerF" class="col-sm-6">

		<form id="form1" name="form1" class="wufoo topLabel page" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" method="post" >
		  
			<header id="header" class="info">
			<h2>Reservas Online</h2>
			</header>
			
			<label class="desc" id="title1" for="Field1">
			Fecha de Reserva
			</label>
			<?php $diaSiguiente = date('d');
				$diaSiguiente = $diaSiguiente +1;  ?>	
			<input type="date"  min="<?php echo date('Y-m');?>-<?php echo $diaSiguiente; ?>" value="<?php echo date('Y-m');?>-<?php echo $diaSiguiente; ?>" class="input-medium search-query formPart" onkeypress="return false" id="fecha" required/>
			
			<label class="desc" id="title2" for="Field2">
			Hora Ingreso
			</label>
			<select name="horaIngreso" class="horaIngreso formPart" id="horaIngreso" >
				
				<option value="07" class="horas">07</option>	<option value="08" class="horas">08</option>	<option value="09" class="horas">09</option>	<option value="10" class="horas">10</option>
				<option value="11" class="horas">11</option>  <option value="12" class="horas">12</option>  <option value="13" class="horas">13</option>  <option value="14" class="horas">14</option>  <option value="15" class="horas">15</option>  <option value="16" class="horas">16</option>  <option value="17" class="horas">17</option>  <option value="18" class="horas">18</option>  <option value="19" class="horas">19</option>  <option value="20" class="horas">20</option>  <option value="21" class="horas">21</option>  
			</select>
			<select name="horaIngreso" class="horaIngreso formPart" id="minIngreso" >
				<option value="00:00">00</option>
				<option value="30:00">30</option>
			</select>

			
			<label class="desc formPart" id="title3" for="Field3">
			Duración
			</label>
			<select name="duracion" id="duracion" class="formPart">
				<option value="1">Media hora</option>
				<option value="2">1 Hora</option>
				<option value="3">1 Hora y media</option>
				<option value="4">2 Dos horas</option>
				<option value="5">2 Horas y media</option>
				<option value="6">3 Horas</option>
				<option value="7">3 Horas y media</option>
				<option value="8">4 Horas</option>
				<option value="9">4 Horas y media</option>
				<option value="10">5 Horas</option>
				<option value="11">5 Horas y media</option>
				<option value="12">6 Horas</option>
				<option value="13">6 Horas y media</option>
				<option value="14">7 Horas</option>
				<option value="15">7 Horas y media</option>
				<option value="16">8 Horas</option>
				<option value="17">8 Horas y media</option>
				<option value="18">9 Horas</option>
				<option value="19">9 Horas y media</option>
				<option value="20">10 Horas</option>
				<option value="21">10 Horas y media</option>
				<option value="22">11 Horas</option>
				<option value="23">11 Horas y media</option>
			</select>

			<hr>
			<input id="btnBuscarSalas" class="btn btn-primary" type="button" value="Buscar" /> <!-- Cuando clickea busca -->
			

			<li class="hide">
			<textarea name="comment" id="comment" rows="1" cols="1"></textarea>
			<input type="hidden" id="idstamp" name="idstamp" value="vMCl3Fr3wF6SZmJVhlIgrHhEtjeKkD3fJSbnjr3Mndc=" />
			</li>
			</ul>
		</form>
 </div>  

<div class="container col-sm-6" id="contTablaSalas">
<br>

	<h4><span id="avisoFecha">Si reserva para el día <?php echo $diaSiguiente; ?>-<?php echo date('m-Y');?> tendrá hasta las <span id="horaDePago"></span> hs para pagar</span></h4>

<br><br>
<table class="display" id="tablaSalas">
</table>
</div><br><br><hr>
</div>
    

