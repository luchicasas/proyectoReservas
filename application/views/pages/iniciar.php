   <script type="text/javascript">
	function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) ){
        alert("Error: La dirección de correo " + email + " es incorrecta.");
        return false
    } else return true;
}
		jQuery(document).ready(function($) {


    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

	$('body').on('click','#btn-login',function(){
		user = $('#mailUser').val();
		pass = $('#passwordUser').val();
		urlFormada = "<?php echo base_url() ?>controladorUsuarios/autenticar/"+user+"/"+pass;
		var ajaxRequest = $.ajax({
			type: "POST",
			url: urlFormada,
			contentType: "application/json; charset=utf-8",
			dataType: "json",
			
			});
		ajaxRequest.done(function(response){
			if (response.resp == 'encontro') {
				window.location= "<?php echo base_url() ?>controladorReservas/view";
			} else {
				$('#resultadoBusqueda').html('Usuario o contraseña erróneos');
			}
		});
			}); 

	$('body').on('click','#btn-registrar',function(){
		mail = $('#mail').val();
		pass = $('#password').val();
		confPass = $('#confirm-password').val();
		nombre = $('#nombre').val();
		telefono = $('#telefono').val();
		apellido = $('#apellido').val();
		dni = $('#dni').val();
		if (validarEmail(mail)){
			$.post( "<?php echo base_url() ?>controladorUsuarios/registrarCliente" ,
			{mail: mail, pass: pass ,  confPass : confPass ,  nombre : nombre ,  apellido : apellido, dni : dni, telefono : telefono}
		).done(function(response){
			if (response == "Registrado"){
				$('#btn-registrar').attr('disabled',true);
				$('#resultado').html('El registró se realizó con éxito!');
			}
			$('#resultado').html(response);
		});
		}
		});
});
	</script>	
	<div id="container" class="ltr">
			<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Iniciar Sesion</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Registrar</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
							<!-- Loguearse __________________________________-->
								<form id="login-form"  role="form" style="display: block;">
									<div class="form-group">
										<input type="email" id="mailUser" tabindex="1" class="form-control" placeholder="Email" value="">
									</div>
									<div class="form-group">
										<input type="password" id="passwordUser" tabindex="2" class="form-control" placeholder="Contraseña" value="">
									</div>
									
									<div class="form-group">
									<span id="resultadoBusqueda"></span>
										<div class="row">
											
												<input type="button" id="btn-login" tabindex="4" class="form-control btn btn-login" value="Iniciar">
											
										</div>
									</div>
									
								</form>
								<!-- Registrar __________________________________-->
								<form id="register-form"  role="form" style="display: none;">
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
												<input type="button" id="btn-registrar" tabindex="4" class="form-control btn btn-register" value="Registrarme">
											</div>
											<div class="col-sm-6 col-sm-offset-3">
					<span id="resultado"></span>
					</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>


