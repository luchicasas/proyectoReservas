<style type="text/css">
	.uno{
		width: 50%;
		float:left;
	}

	#unCont{
		border: 1;
		border-color: gray;
	}

	.der{
		text-align: right;
	}

	table{
		width:50%;
	}
</style>

<?php 
$fecha = $reserva->fechaReserva;
$date = date_create($fecha);
$fechaReservada = date_format($date, 'd-m-Y'); //$fecha ahora contiene el dia de la reserva en un formato como para mostrar
$horaReservada = date_format($date,'H:i');

$n=rand(1000,9999);

$cant=$reserva->duracion;
?>

<div id="unCont">
	<div>
	<?php 
	if($tipo=='factura') { 
		$pagar = $total; ?>
		<h3> Factura de Pago de Reserva </h3>
		<?php 
	} 
	if(!($tipo=="factura")) { 
			$pagar= $reintegro; ?>
		<h3> Nota de credito</h3>
			<?php } ?>
			</div>
		<div align="right">
			N&uacute;mero: <?php echo $n; ?> </span><br>

			Fecha: <?php echo $fechaReservada; ?> <br>
			Hora : <?php echo $horaReservada; ?>
		</div>
	<hr>
		<h4> Datos del cliente: </h4>
		<div class="uno">
		Apellido : <?php echo $usuario->apellido; ?> <br>
		Nombre :  <?php echo $usuario->nombre; ?>
		</div>
		<div class="2">
		DNI : <?php echo $usuario->dniUsuario; ?> <br>
		Telefono : <?php echo $usuario->telefono; ?>
		</div>

	<hr>
		<h4> Detalles de reserva: </h4>
		<table border="1" align="center">
			<tr>
				<th>Descripcion</th>
				<th>Precio por media hora</th>
				<th>Precio</th>
			</tr>
			<tr>
				<td><?php echo $sala->nombre; ?> </td>
				<td class="der">$ <?php echo $sala->precio; ?></td>
				<td class="der">$ <?php echo ($reserva->precioSala)*$cant; ?></td>
			</tr>
			<?php foreach ($recurso as $r) {
			?>
			<tr>
				<td><?php echo $recurso->nombre." - ".$recurso->descripcion; ?></td>
				<td class="der">$<?php echo $recurso->precio; ?></td>
				<td class="der">$<?php echo ($recurso->precio)*$cant; ?></td>
			</tr>
			<?php 
			}
			foreach ($servicio as $s) {
			?>
			<tr>
				<td><?php echo $servicio->nombre." - ".$servicio->descripcion; ?></td>
				<td class="der"><?php echo $servicio->precio;?></td>
				<td class="der">$<?php echo ($servicio->precio)*$cant; ?></td>
			</tr>
			<?php 
		}
			?>	
			<tr>
				<td colspan="2"><h4>TOTAL $</h4></td>
				<td class="der">$<?php echo $pagar; ?></td>
			</tr>	
		</table>
		<?php if(!($tipo=="factura")) { 
			echo "<br>Si se anulo la reserva con más dos días de anticipación, se le reintegrara el 80% del total de la reserva.";
			echo "<br>En caso contrario, se reintegrara el 50% del total de la reserva,";
		} ?>
</div>