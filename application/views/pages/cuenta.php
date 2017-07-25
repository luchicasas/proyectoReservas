
<div id="container">

	<div class="container">
	<div  class="col-sm-4 well"  style="margin-left:30%;">
	<h3> MI CUENTA </h3>
		
	<ul>
		<li> Apellido : <?php echo $usuario->apellido; ?> </li> 
		<li> Nombre: <?php echo $usuario->nombre; ?> </li> 
		<li> DNI: <?php echo $usuario->dniUsuario; ?> </li> 
		<li> Teléfono: <?php echo $usuario->telefono; ?></li> 
		<hr>
		<li> DATOS DE LA CUENTA </li>
		<li> Email: <?php echo $usuario->mail; ?> </li>
		<li> Contrase&ntilde;a: <?php echo $usuario->contrasenia; ?> </li> 
		<hr>
		<input type="button" id="modificar" value="Modificar datos" data-toggle="modal" data-target="#myModal">
	</ul>
	</div>
	
	</div>
</div>