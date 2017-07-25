<?php
/**
* 
*/
class Servicio extends DataMapper
{
	var $table = 'servicios';
	var $has_many = array('reserva');

	function __construct($id = NULL)
	{
	parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}