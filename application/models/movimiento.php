<?php

class Movimiento extends DataMapper
{
	var $table = 'movimientos';

	var $has_one = array('usuario');

	function __construct($id = NULL)
	{
	parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}
?>