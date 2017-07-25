<script>
	$(document).ready( function () {
		
	$('body').on('click','.btn-serv',function(){
		idReserva = $(this).data('id');
		$('.modal-title').html('Servicios reservados');
		var url = '<?php echo base_url() ?>controladorReservas/mostrarServiciosDeReserva/'+idReserva;
		table.ajax.url(url).load();
	});		
	$('body').on('click','.btn-rec',function(){
		idReserva = $(this).data('id');
		$('.modal-title').html('Recursos reservados');
		var url = '<?php echo base_url() ?>controladorReservas/mostrarRecursosDeReserva/'+idReserva;
		table.ajax.url(url).load();
	});	

		 
		table = $('#tablaServicios').DataTable({
			columns: [
			{title: "ID"},
			{title: "Nombre"},
			{title: "Descripcion"},
			{title: "Precio"}
			],
			 "responsive":		true,
			 "retrieve":			true
		});
	});
</script>



<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title"></h4>
	      </div>
	      <div class="modal-body">
	        <table class="display" id="tablaServicios">						
			</table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>