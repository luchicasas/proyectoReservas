	<style type="text/css">
		#tablaReporte{
			border-collapse: collapse;
			width: 80%;
			}
		td, tr{
			text-align: left;
			vertical-align: top;
	   		border-spacing: 0;
		}
		.graph {
			position: relative; /* IE is dumb */
			width: 200px;
			border: 1 solid green;
			padding: 2px;
		}
		.graph .bar {
			display: block;
			position: relative;
			background: green;
			text-align: center;
			color: #333;
			height: 2em;
			line-height: 2em;
		}
		.graph .bar span { 
			position: absolute; 
			left: 1em; 
		}

		#cab{
			background-color: gray;
		}
		h2 {
			color: white;
		}
	</style>
		

		<?php 

			$fechaD = date_format(new DateTime($fechaDesde),'d-m-Y');
			$fechaH = date_format(new DateTime($fechaHasta),'d-m-Y');
			$total=0;
		foreach ($data as $d){
		$total=$d['cantidad']+$total;}


		?>
	<!-- Como sacar datos de $data
		nombre: $data[indice]['nombre'];
		o en iteracion: foreach ($data as $dato){nombre= $dato['nombre']; }
	-->
	<div id="cab">
	<h3 align="center"> REPORTES </h3>
	<img src="<?php echo base_url();?>assets/images/logo1.png" alt=""/>
	</div>

	<br><br>
	<table id="tablaReporte" align="center" border="1">

	<div>
		<tr>
			<td colspan="3">Reporte de <?php echo $tipo; ?> con mayor uso</td>
			<td  colspan="2">Fecha del reporte: <?php echo date("d-m-Y");?></td>
		</tr>
		<tr>
			<td id="datos" colspan="5" align="center"> DATOS DEL REPORTE</td>
		</tr>
		<tr>
			<td align="center" colspan="5">Calculado entre <?php echo $fechaD;?> y <?php echo $fechaH; ?> </td>
		</tr>
		<tr>
			<td> ID </td>
			<td colspan="2">Descripción</td>
			<td> Cantidad de veces reservado </td>
			<td> Porcentaje de reserva </td>
		</tr>
			<?php 
			foreach ($data as $d){
				$prom=($d['cantidad']/$total)*100;
			?>
				<tr>
					<td><?php echo $d['id']; ?></td>
					<td colspan="2"><?php echo $d['nombre']; ?> - <?php echo $d['descripcion'];?></td>
					<td><?php echo $d['cantidad']; 	?> </td>
					<td><?php echo round($prom,2);?>%</td>
				</tr>
			<?php } ?>					
	</div>
	</table>