
$(document).ready(function() {

$('.scrol').click(function(){		
				var id= $(this).attr("id");
				window.location.href = id+".php";
			});



		
$('.thumbnail').click(function(){
			// mandar a la pagina de reservar
			var id= $(this).attr("id"); 
			
			window.location.href ="reservar.php";
		});


});

// Validaciones de la pagina buscar


// $('#btnBuscarSalas').click(function () {
// 			var datos = $(this).closest('#form1').serialize();

// 			$.ajax({
// 					url:'php/prueba.php',
// 					type: 'POST',
// 					dataType: 'json',
// 					data: datos
// 				}).done(function(response){
// 					if (response.fallo){
// 						alert (no se pudo)
// 					}else {
// 					//mostramos las salas disponibles para esa hora
// 					}
// 		});
// });	
//});



