<?php
defined('BASEPATH') or exit('No direct script access allowed');

 class ManagerServicios extends CI_Model{


 	static function buscarServicios(){
 		$varServicios = new Servicio();
 		$list = $varServicios->get();

		$data = array();
		
			foreach ($list as $servicio) { //recorre todos los servicios
	 		$row =  array();
	 
	 		$row['id'] = $servicio->id;
	 		$row['nombre'] = $servicio->nombre;
	 		$row['descripcion'] = $servicio->descripcion;
	 		$row['precio'] = $servicio->precio;
	  		$data[] = $row; //Arma array data con todos los servicios
			}

		$output= array (
		"data" => $data,
		);
		return $output;
		// echo json_encode($output);
 	}

 	static function mostrarServiciosDeReserva($idRes){
 		$varReservas = new Reserva();
 		$reserva = $varReservas->where('id',$idRes)->get();

 		$servicios = $reserva->servicio->get();

 		$data = array();
	 		foreach ($servicios as $serv) {
	 			$row =  array();
	 			$row[] = $serv->id;
		 		$row[] = $serv->nombre;
		 		$row[] = $serv->descripcion;
		 		$row[] = $serv->precio;
		 		$data[] = $row;
	 		}
 		$output= array (
		"data" => $data,
		);
		return $output;
 	}


 }
?>