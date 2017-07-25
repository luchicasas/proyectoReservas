
<script>
	$(document).ready( function () {
		var mailUser = '<?php echo $usuario->mail; ?>';

		$('body').on('click','#btn-agregar',function(){
		$(this).prop('disabled',true);
		numT = $('#numTarjeta').val();
		codSeg = $('#codSeg').val();
		descrip = $('#descrip').val();
		idUs = '<?php echo $usuario->id;?>';

		$.post( "<?php echo base_url() ?>controladorUsuarios/agregarTarjeta" ,
			{numT: numT ,  codSeg : codSeg ,  descrip : descrip , idUs: idUs}
		).done(function(response){
			if(response){
				$('#respuesta').html('No se pudo registrar la tarjeta. Revise los datos e intente nuevamente');
			} else {
				var url = '<?php echo base_url(); ?>controladorUsuarios/getTarjetas/'+mailUser;
				tableTarjetas.ajax.url(url).load();
				$('#respuesta').html('Se registro la tarjeta con exito');
			}
		});
		
	});
		
	});
</script>
<div id="ModalTarj" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"></h4>
	      </div>
	      <div class="modal-body">
	        	<form id="register-form"  role="form" >
					<div class="form-group">
						<input type="number" id="numTarjeta" tabindex="1" class="form-control" placeholder="Número de la Tarjeta" value="">
					</div>
					<div class="form-group">
						<input type="number" id="codSeg" tabindex="1" class="form-control" placeholder="Codigo de Seguridad" value="">
					</div>
					<div class="form-group">
						<input type="text" id="descrip" tabindex="1" class="form-control" placeholder="Descripción" value="">
					</div>
					<div class="form-group">
					<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
					<input type="button" id="btn-agregar" tabindex="4" class="form-control btn btn-agregar" value="Agregar">
					</div>
					<div class="col-sm-6 col-sm-offset-3">
					<span id="respuesta"></span>
					</div>
					</div>
					</div>
				</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>