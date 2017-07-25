<?php
/**
* 
*/
class Reserva extends DataMapper
{
	var $table = 'reservas';
	var $has_one = array('sala', 'usuario','estado');
	var $has_many = array('recurso', 'servicio');


	public function generar_reserva($sala, $usuario){
		

	}

	function __construct($id = NULL)
	{
	parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}