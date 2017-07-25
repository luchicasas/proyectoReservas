<?php
/**
* 
*/
class Recurso extends DataMapper
{
	var $table = 'recursos';
	var $has_one = array('sala');
	var $has_many = array('reserva');
	
		function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}