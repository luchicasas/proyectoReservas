
   <script type="text/javascript">
   //Datos de la busqueda
    var usuario;
    var idSala = '<?php echo $idSala; ?>';
    var fecha = '<?php echo $fecha;?>';
	var hora = '<?php echo $hora;?>';
	var duracion = '<?php echo $duracion;?>';
	var tipoUsuario = '<?php echo $this->session->userdata('tipo');?>';



	if (tipoUsuario = '2'){
		usuario = '<?php echo $this->session->userdata('mail');?>';
	} 
	jQuery(document).ready(function($) {
	$.ajax({
        dataType: "json",
        url: '<?php echo base_url() ?>controladorReservas/buscarServicios'
    	}).done(function(response){
    		$('#conteinerServicios').html('');
    		var j;
            for(var i=0; i<response.data.length; i++){
            	j= i+1;
            $('#conteinerServicios').append('<input type="checkbox" class="claseServicio" data-idserv="'+j+'"id="servicio'+j+'" value="1"> Servicio: '+ response.data[i].nombre +'<br> Precio: '+response.data[i].precio);
            $('#conteinerServicios').append('<br>Descripcion: '+response.data[i].descripcion);
            $('#conteinerServicios').append('<br><br>');
        }
	});

   	//Ver sala 
	$.ajax({
        dataType: "json",
        url: '<?php echo base_url() ?>controladorReservas/verSala/'+idSala
    	}).done(function(response){
    		$('#contSala').html('');
            $('#contSala').append('<br> Precio: '+response.data[idSala].precio);
            $('#contSala').append('<br> Capacidad: '+response.data[idSala].capacidad);
            $('#contSala').append('<br> Direccion: '+response.data[idSala].direccion);

        });


    	//Busqueda de usuario
    	$('body').on('keyup','#busquedaUsuario',function(){
    		var cadena = $('#busquedaUsuario').val();
    		urlABuscar = '<?php echo base_url() ?>controladorUsuarios/buscarCliente/'+cadena;
    		$.ajax({
    			dataType: "json",
        		url: urlABuscar
    		}).done(function(response){
    			if (response == 'encontro'){
    				$('#resultBusqueda').html('Usuario válido!');
    				$('#btnReservar').attr("disabled", false);
    				usuario = cadena;
    			} else {
					$('#resultBusqueda').html('No se ha encontrado usuario');
					$('#btnReservar').attr("disabled", true);
    			}
    		});
    	});
		$('#btnReservar').click(function(){
			swal({
	  		title: "Confirmar reserva",
	  		text: "¿Desea confirmar esta reserva?",
	 		 type: "warning",
	  		showCancelButton: true,
	 	 	confirmButtonClass: "btn-danger",
	  		confirmButtonText: "Si, reservar",
	  		cancelButtonText: "Cancelar",
	 		closeOnConfirm: false
			},
			function(){
				var recursos = [];
				var servicios = [];
				// Se arman los arrays con los id de los servicios y recursos seleccionados para la reserva
				$('.claseRecurso:checkbox:checked').each(function(index){
					recursos[index] = $(this).data('idrec');
				});
				$('.claseServicio:checkbox:checked').each(function(index){
					servicios[index] = $(this).data('idserv');
				});
			 	$.post(
			 		'<?php echo base_url() ?>controladorReservas/crearReserva',
			 		{sala: idSala, fechaRes: fecha, horaRes: hora, duracionRes: duracion, user : usuario, servs: servicios, recs: recursos},
			 		function(response){
			 			if (response == 'true'){
			 				swal({
			 				title:	'Perfecto!',
			 				text: 'La reserva se cargó con éxito',
			 				type: 'success'
			 				},function(){
			 					window.location = '<?php echo base_url(); ?>controladorReservas/view/buscarSala';
			 					
			 				});
			 			} else {
			 				swal('Ups', 'No se pudo realizar la reserva, intentalo nuevamente', 'warning');
			 			}
			 		});
			 });
		 });
			
			$("#checkRecursos").click(function() {  
	        	if($("#checkRecursos").is(':checked')) {  
	              	$.ajax({
	              	dataType: "json",
	              	url: '<?php echo base_url() ?>controladorReservas/buscarRecursos/'+fecha+'/'+hora+'/'+duracion

	              	}).done(function(response){
	              		$('#conteinerRecursos').html('');
	              		var j;
	              		for(var i=0; i<response.data.length; i++){
	              			j = i+1;
	              		$('#conteinerRecursos').append('<input type="checkbox" class="claseRecurso" data-idrec="'+j+'" id="recurso'+j+'" value="1"> Recurso: '+ response.data[i].nombre +'<br> Precio: '+response.data[i].precio);
	              		$('#conteinerRecursos').append('<br>Descripción: '+response.data[i].descripcion);
	              		$('#conteinerRecursos').append('<br><br>');
	              	}
	              	});
	              	$('#conteinerRecursos').show();
	        	} else {  
	              $('#conteinerRecursos').hide();
	        	}  
   			 }); 	
			$("#checkServicios").click(function() {  
	        	if($("#checkServicios").is(':checked')) {  
	              $('#conteinerServicios').show();
	        	} else {  
	              $('#conteinerServicios').hide();
	        	}  
   			 }); 

   			$('#registrar').on('click',function(){
   				window
   			});
		});
	</script>
</head>
<body>

<?php 
 
if(($duracion%2)==0){	
	$horas="".$duracion/2;  	
} else {
	$horas="".($duracion/2)-0.5.":30";
}
?>
	
	<div class="container">
	<div  class="col-sm-5 well" >
	
	    <img src="<?php echo base_url(); ?>assets/images/p<?php echo $idSala;?>.jpg">
	    <div>
	    <hr>
	    <h4>La sala seleccionada es: </h4>
 		<?php echo "Sala ".$idSala."<br>";
 		$fechaFormateada = date_format(new DateTime($fecha),'d-m-Y');
 		echo "Dia: ".$fechaFormateada."<br>";
 		$horaFormateada = date_format(new DateTime($hora),'H:i');
 		echo "Horario de ".$horaFormateada." <br>";  
 		echo "Por ".$horas." horas";?>	

 		<?php if ($this->session->userdata('tipo') == '1') { 
		echo 'Usuario: <br><input type="text" id="busquedaUsuario" >';
		echo '<input type="button" value="Registrar nuevo" id="registrar" data-toggle="modal" data-target="#myModal"><br>';
		echo '<span id="resultBusqueda"> </span>';
		 } ?>
		
		<div id="contSala">

		</div>

		</div>
	</div>
	<div class="1">
	<div class="col-sm-5 well">     
	<h4> Adicionales:</h4>
	
	<form id="form1" name="form1" class="wufoo topLabel page" accept-charset="UTF-8" enctype="multipart/form-data" method="post" novalidate
		      action="">
		
		<input type="checkbox" id="checkRecursos" value="1"> Recursos</input> 
			<div id="conteinerRecursos" hidden class="form-group">
			</div><br>

		<input type="checkbox"  id="checkServicios" value="2"> Servicios </input>
			<div id="conteinerServicios" hidden class="form-group">
			</div><br>
			<hr>
		<input type="button" class="btn btnConfirm" id="btnReservar" value="Reservar" align="center" <?php if ($this->session->userdata('tipo') == '1') {  echo 'disabled'; } ?>>
		    </form>
     </div>
     </div>
     </div>

