<?php
defined('BASEPATH') or exit('No direct script access allowed');

 class ManagerSalas extends CI_Model{

 	public function __construct()
        {
                parent::__construct();
                $this->load->model('ManagerReservas');
                $this->load->library('session');
         }

 	static function buscarSalas($fecha,$hora,$duracion,$log){
 		$varSalas = new Sala();
 		$list = $varSalas->get();

 		$data = array();
 		$tipo = 'sala';
 		foreach ($list as $sala) {
 			$disponible = ManagerReservas::buscarDisponibilidad($fecha,$hora,$duracion,$tipo,$sala);

 			if ($disponible == '1'){
 				$row = array();
 				$id = $sala->id;
 				$row[] = $id;
 				$row[] = $sala->nombre;
 				$row[] = $sala->precio;
 			    $row[] = $sala->capacidad;
 			    $base = base_url();
 				$row[] = "<img src='".$base."assets/images/p".$id.".jpg'>";
 				if ($log == '1') {  
 				$row[] = "<a id='$sala->id' class='btn btn-info btn-lg btnReservar' >Reservar</a>";
 				}else {
 					$row[] = "";
 				}
 				$data[] = $row;
 			}
 		}	

 		$output = array (
		"data" => $data
		);
 		
		return $output;
	}

	static function mostrarSalas($idSl){
		$varSalas = new Sala();
 		$sala = $varSalas->where('id',$idSl)->get();
 		return $sala;
 	}
}
?>