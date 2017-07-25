<?php
defined('BASEPATH') or exit('No direct script access allowed');

 class ManagerRecursos extends CI_Model{

 	public function __construct()
        {
                parent::__construct();
                $this->load->model('ManagerReservas');
         }

 	static function buscarRecursos($fecha,$hora,$duracion){
 		$varRecursos = new Recurso();
 		$list = $varRecursos->get();

 		$data = array();
 		$tipo = 'recurso';
 		
 		foreach ($list as $recurso) {
 			
 			$disponible = ManagerReservas::buscarDisponibilidad($fecha,$hora,$duracion,$tipo,$recurso);

 			if ($disponible == '1'){
 				$row = array();
 				$id = $recurso->id;
 				$row['id'] = $id;
 				$row['nombre'] = $recurso->nombre;
 				$row['precio'] = $recurso->precio;
 				$row['descripcion'] = $recurso->descripcion;
 				$data[] = $row;
 			}
 		}	

 		$output = array (
		'data' => $data
		);
 		
		return $output;
	}

	static function mostrarRecursosDeReserva($idRes){
 		$varReservas = new Reserva();
 		$reserva = $varReservas->where('id',$idRes)->get();

 		$recursos = $reserva->recurso->get();

 		$data = array();
	 		foreach ($recursos as $rec) {
	 			$row =  array();
	 			$row[] = $rec->id;
		 		$row[] = $rec->nombre;
		 		$row[] = $rec->descripcion;
		 		$row[] = $rec->precio;
		 		$data[] = $row;
	 		}
 		$output= array (
		"data" => $data,
		);
		return $output;
 	}


}
?>