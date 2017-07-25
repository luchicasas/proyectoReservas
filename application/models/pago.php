<?php

			function calculo(){
				if (rand(0,10)>7){
					?>
					<script type='text/javascript'>
						alert('Pago realizado con exito!');
						window.location.href = 'verReservas.php?p=1';
					</script> 
					<?php
				}
				else{
					?>
					<script type='text/javascript'>
						alert('Pago denegado.');
						window.location.href = 'verReservas.php?p=0';
					</script> 
					<?php
				}
			}

?>