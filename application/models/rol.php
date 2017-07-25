<?php
/**
* 
*/
class Rol extends DataMapper
{
	var $table = 'roles';

	var $has_many = array('usuario');

	function __construct($id = NULL)
	{
	parent::__construct($id);
	}

	function post_model_init($from_cache = FALSE)
	{
	}
}