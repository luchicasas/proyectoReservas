<?php
/**
* 
*/
class Estado extends DataMapper
{
	var $table = 'estados';
	var $has_many = array('reserva');


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