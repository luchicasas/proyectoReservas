<style type="text/css">
	#cont{
		color: #687882;
	}
</style>

<div class="footer-bottom">
	  	<div class="container">
	  		<ul class="footer-nav">
	  			<li><a href="<?php echo base_url(); ?>controladorReservas/view">Home</a></li> |
	  			<li><a href="<?php echo base_url(); ?>controladorReservas/view/buscarSala">Buscar</a></li> |



	  			<?php if (!$this->session->userdata("mail")) { ?> 
						<li><a href="<?php echo base_url(); ?>controladorReservas/view/iniciar">Iniciar Sesión</a></li> |				   
				<?php } ?>
				<?php if ($this->session->userdata("mail")) {  
				   		if ($this->session->userdata("tipo") == '2'){
				   			?> <li><a href="<?php echo base_url(); ?>controladorReservas/verReservas">Ver Reservas</a></li> | 
				   			   <li> <a onclick="miCuenta();">Mi cuenta</a></li> 
				<?php } else { ?> 
					<li><a href="<?php echo base_url(); ?>controladorUsuarios/verClientes">Ver Clientes</a></li> |  
					<li><a href="<?php echo base_url();?>controladorReservas/view/reporte">Ver Reportes</a></li>
				<?php  } 	
				   	   } ?>	
	  			
	  		</ul>
	  		<br>
	  		<div id="cont">
	  		<h5>Contacto</h5>
	  		Email: reservasRyE@gmail.com <br><br>
	  		<p align="right">Abadie - Casas - Pailahueque</p>

	  		</div>
	  </div>
	  </div>
	  <!--end contact-->
      <script type="text/javascript">
			$(document).ready(function() {
			
				var defaults = {
		  			containerID: 'toTop', // fading element id
					containerHoverID: 'toTopHover', // fading element hover id
					scrollSpeed: 1200,
					easingType: 'linear' 
		 		};
				
				
				$().UItoTop({ easingType: 'easeOutQuart' });
				
			});
		</script>
        <a href="#" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"></span></a>

</body>
</html>