<?php
/**
* 
*/
class Sala extends DataMapper
{
	var $table = 'salas';

	var $has_many = array('reserva', 'recurso');

	function __construct($id = NULL)
	{
	parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}