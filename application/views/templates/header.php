<!DOCTYPE HTML>
<html>
<head>
<title> R&E reservas</title>

<!--style -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- <link href="<?php echo base_url();?>assets/css/bootstrap-theme.min.css" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' />-->
<link href="<?php echo base_url();?>assets/css/style.css" rel='stylesheet' type='text/css' /> 
<link href="<?php echo base_url(); ?>assets/css/form.css" rel="stylesheet" >
<link href="<?php echo base_url(); ?>assets/css/theme.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/structure.css" rel="stylesheet" >
<link href="<?php echo base_url(); ?>assets/sweetalert/dist/sweetalert.css" rel="stylesheet" >

 <link href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,800' rel='stylesheet' type='text/css'> 

<!-- script -->
<script type="application/x-javascript"> 
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
function hideURLbar(){ window.scrollTo(0,1); } 
</script>
<script src="<?php echo base_url();?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/hover_pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js"></script>		      
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/responsive-nav.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/move-top.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/easing.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/js/wufoo.js"></script>-->
<script src="<?php echo base_url(); ?>assets/sweetalert/dist/sweetalert.min.js"></script>
<!-- DataTable-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/datatable/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>assets/js/datatable/jquery.dataTables.js"></script> 


</head>
<script>
	function cerrarSesion(){
		window.location = "<?php echo base_url();?>controladorUsuarios/logout"
	}
	function miCuenta(){
		$em = "<?php echo $this->session->userdata("mail"); ?>";
		window.location = "<?php echo base_url();?>controladorUsuarios/cuentaUs/"+$em;
	}
	function reporte(){
		window.location = "<?php echo base_url();?>controladorReservas/view/reporte"
	}
	
</script>															

<body>

<div class="header">
	  <div class="header-top">
		<div class="container">
			<div class="logo">
			  <a href="index.php"><img src="<?php echo base_url();?>assets/images/logo1.png" alt=""/></a>
			</div>
			<div class="menu">
			 <!-- <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /></a> -->
				<ul class="nav" id="nav">

				   <li><a id="index" class="scrol" href="<?php echo base_url(); ?>controladorReservas/view">Home</a></li>
				   <li><a id="buscar" class="scrol" href="<?php echo base_url(); ?>controladorReservas/view/buscarSala">Buscar</a></li>
				   <?php if (!$this->session->userdata("mail")) { ?> 
				   <li><a id="iniciar" class="scrol" href="<?php echo base_url(); ?>controladorReservas/view/iniciar">Iniciar Sesión</a></li>
				   <?php } ?>
				   <?php if ($this->session->userdata("mail")) {  
				   		if ($this->session->userdata("tipo") == '2'){
				   			?> <li><a id="verReservas" class="scrol" href="<?php echo base_url(); ?>controladorReservas/verReservas">Ver Reservas</a></li>  <?php
				   			echo	'<li> Bienvenido/a '.$this->session->userdata("mail").'<a onclick="miCuenta();">Mi cuenta</a></li>  <a onclick="cerrarSesion()" class="glyphicon glyphicon-off"></a>';
				   		} else {
				   			?> <li><a id="verClientes" class="scrol" href="<?php echo base_url(); ?>controladorUsuarios/verClientes">Ver Clientes</a></li>  <?php
				   			echo '<li> Bienvenido/a Encargado: '.$this->session->userdata("mail").'<a onclick="reporte();">Ver Reportes</a></li>  <a onclick="cerrarSesion()" class="glyphicon glyphicon-off"></a>';	
				   		}
				   	   } ?>					

				   <div class="clear"></div>
			    </ul>
			</div>				
		    <div class="clear"></div>
		 </div>
	    </div>
	</div>