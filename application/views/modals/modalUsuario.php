<script>
function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
        alert("Error: La dirección de correo " + email + " es incorrecta.");
        return false
    } else return true;
}
	$(document).ready( function () {


    <?php if($tipo == 'modif') { ?>
      $('#nombre').val('<?php echo $usuario->nombre; ?>');
      $('#apellido').val('<?php echo $usuario->apellido; ?>');
      $('#dni').val('<?php echo $usuario->dniUsuario; ?>');
      $('#mail').val('<?php echo $usuario->mail; ?>');
      $('#mail').prop("disabled",true);
      $('#password').val('<?php echo $usuario->contrasenia; ?>');
      $('#confirm-password').val('<?php echo $usuario->contrasenia; ?>');
      $('#telefono').val('<?php echo $usuario->telefono; ?>');

      $('body').on('click','#btn-registrar',function(){
  		mail = $('#mail').val();
  		pass = $('#password').val();
  		confPass = $('#confirm-password').val();
  		nombre = $('#nombre').val();
  		apellido = $('#apellido').val();
  		dni = $('#dni').val();
  		if (validarEmail(mail)){
  			$.post( "<?php echo base_url() ?>controladorUsuarios/modificarUsuario" ,
  			{mail: mail, pass: pass ,  confPass : confPass ,  nombre : nombre ,  apellido : apellido, dni : dni}
  			).done(function(response){
  				if (response == "Registrado"){
  					$('#btn-registrar').attr('disabled',true);
  					$('#resultado').html('El registró se realizó con éxito!');
  				}
  				$('#resultado').html(response);
  			});
  		}
  		});
      <?php } else { ?>
        $('body').on('click','#btn-registrar',function(){
		pass = $('#password').val();
    mail = $('#mail').val();
		confPass = $('#confirm-password').val();
		nombre = $('#nombre').val();
		apellido = $('#apellido').val();
		dni = $('#dni').val();
		if (validarEmail(mail)){
			$.post( "<?php echo base_url() ?>controladorUsuarios/registrarCliente" ,
			{mail: mail, pass: pass ,  confPass : confPass ,  nombre : nombre ,  apellido : apellido, dni : dni}
			).done(function(response){
				if (response == "Registrado"){
					$('#btn-registrar').attr('disabled',true);
					$('#resultado').html('El registró se realizó con éxito!');
				}
				$('#resultado').html(response);
			});
		}
		});


      <?php } ?>


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
	        	<form id="register-form"  role="form" >
					<div class="form-group">
						<input type="text" id="nombre" tabindex="1" class="form-control" placeholder="Nombre" value="">
					</div>
					<div class="form-group">
						<input type="text" id="apellido" tabindex="1" class="form-control" placeholder="Apellido" value="">
					</div>
					<div class="form-group">
						<input type="int" id="dni" tabindex="1" class="form-control" placeholder="Dni" value="">
					</div>

					<div class="form-group">
						<input type="text" id="telefono" tabindex="1" class="form-control" placeholder="Telefono" value="">
					</div>
					<div class="form-group">
						<input type="email" id="mail" tabindex="1" class="form-control" placeholder="Email" value="">
					</div>
					<div class="form-group">
						<input type="password" id="password" tabindex="2" class="form-control" placeholder="Contraseña">
					</div>
					<div class="form-group">
						<input type="password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirmar contraseña">
					</div>
					<div class="form-group">
					<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
					<input type="button" id="btn-registrar" tabindex="4" class="form-control btn btn-register" value="Guardar">
					</div>
					<div class="col-sm-6 col-sm-offset-3">
					<span id="resultado"></span>
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
