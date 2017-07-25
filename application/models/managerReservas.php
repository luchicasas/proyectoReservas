<?php
defined('BASEPATH') or exit('No direct script access allowed');

 class ManagerReservas extends CI_Model{

 	static function mostrarReservas($mailUser){
        date_default_timezone_set('America/Buenos_Aires');
 		$varReservas = new Reserva();
 		$varUsers = new Usuario();
 		$user = $varUsers->where('mail',$mailUser)->get();
 		$list = $varReservas->where('usuario_id',$user->id)->get();

		$data = array();
		
		foreach ($list as $reserva) { //recorre todos los usuarios
 		$row =  array();
 		
 		$user = $reserva->usuario->get(); //consigue el user
 		$id = $reserva->id;
 		$row[] = $id;
 		$row[] = $reserva->estado->get()->tipoEstado;
 		$row[] = $reserva->sala->get()->nombre;
 		$row[] = $reserva->precioSala;
        $fechaReserva = new DateTime($reserva->fechaReserva);
 		$row[] = date_format($fechaReserva, 'd-m-Y H:i')."hs";
 		$duracion = $reserva->duracion * 30;
 		$row[] = $duracion." minutos";
 		$row[] = ManagerReservas::getPrecioTotal($id);
 		$row[] = "<a class='btn btn-default btn-serv' data-id='$id' data-toggle='modal' data-target='#myModal'>Ver Servicios</a>
 				  <a class='btn btn-default btn-rec' data-id='$id' data-toggle='modal' data-target='#myModal'>Ver Recursos</a>";
 			if ($reserva->estado_id == '1'){
 				$row[] = "<a class='btn btn-success btnPagar' data-id='$id' data-user='$mailUser'>Pagar </a>   
 						  <a class='btn btn-danger btn-anular' data-id='$id'>Anular</a>";
 			}else {
 				if ($reserva->estado_id == '2'){ 
                    $fecRes = new DateTime($reserva->fechaReserva);
                    $hoy = new DateTime(date('Y-m-d H:i:s'));
                        if ($fechaReserva > $hoy){
     					$row[] = "<a class='btn btn-danger btn-anular' data-id='$id'>Anular</a>";
                        }else {
                        $row[] =  "Realizada";
                        }
 				} else {
 					$row[] = "Anulada";
 				}
 			}
  		$data[] = $row; //Arma array data con todos las reservas
  		
		}
		$output = array (
		"data" => $data,
		);
		return $output;
 	}

 	static function buscarDisponibilidad($fecha,$hora,$duracion,$tipo,$elemento){ //Tipo dice si es sala o recurso
 	 	$varReservas = new Reserva();
 	 	$idElemento = $elemento->id;
 	 	$list = array();
 	 	if ($tipo == 'sala') {
 	 		$array = array('sala_id' => $idElemento , 'estado_id !=' => 3);
 	 		$list = $varReservas->where($array)->get();
 	 	}  
 	 	else {
 	 		$reservas = $varReservas->get();
 	 		foreach ($reservas as $res) { //recorre reservas
 	 			$recursos = $res->recurso->get();
 	 				foreach ($recursos as $rec) { //recorre recursos en reserva

 	 					if ($rec->id == $elemento->id){
 	 						$list[] = $res;
 	 					}
 	 				}
 	 		}
 	 	}
 	 	$fechaBuscada = $fecha." ".$hora;
 	 	
 	 	$fechaBuscadaDesde = strtotime($fechaBuscada);
 	 	$minutos1 = $duracion *30; // a partir del integer duracion, obtengo la duracion en minutos
 	 	
 	 	$fechaBuscadaHasta = strtotime($fechaBuscada.' + '.$minutos1.' minutes'); // Se suman los minutos para obtener la hora de finalizacion
 	 		foreach ($list as $reserva) {
 	 		$fechaDBDesde= strtotime($reserva->fechaReserva);	
 	 		$minutos2 = $reserva->duracion *30;
 	 		
 	 		$fechaDBHasta = strtotime($reserva->fechaReserva.' + '.$minutos2.' minutes');
 	 			if (($fechaDBHasta >=  $fechaBuscadaDesde) && ($fechaDBDesde <=  $fechaBuscadaDesde)){
 	 			 	return '0';
 	 			}		elseif (($fechaDBDesde <= $fechaBuscadaHasta) &&  ($fechaDBHasta >= $fechaBuscadaHasta)){
 	 						return '0';
 	 					} elseif (($fechaBuscadaDesde < $fechaDBDesde) && ($fechaBuscadaHasta > $fechaDBHasta)){
                            return '0';
                        }
 	 		}
		return '1';
 	}

 	static function crearReserva($idSala,$fechaRes,$horaRes,$duracionRes,$mailUser,$servicios,$recursos){
 		$reserva = new Reserva(); 
 		$fecha = $fechaRes." ".$horaRes; //se arma fecha con hora
 		$sala = new Sala();
 		$user = new Usuario();
 		$rec = new Recurso();
 		$serv = new Servicio();


 		$reserva->estado_id = '1'; 
 		$reserva->sala_id = $idSala; 
 		$reserva->fechaReserva = $fecha; 
 		$reserva->duracion = $duracionRes;
 		$reserva->precioSala = $sala->where('id',$idSala)->get()->precio;
 		$reserva->usuario_id = $user->where('mail',$mailUser)->get()->id;

 		$reserva->save();
 		$idRes = $reserva->id;
 		if ($servicios != null){
 		foreach ($servicios as $idServ) {
 			$precio = $serv->where('id',$idServ)->get()->precio;
 			$reserva->db->query("INSERT INTO `reservasdb`.`reservas_servicios` (`id`, `reserva_id`, `servicio_id`, `precio`) VALUES (NULL, '$idRes', '$idServ', '$precio');");
 		}
 		}
 		if ($recursos != null){
 		foreach ($recursos as $idRec) {
 			$precio = $rec->where('id',$idRec)->get()->precio;
 			$reserva->db->query("INSERT INTO `reservasdb`.`recursos_reservas` (`id`, `recurso_id`, `reserva_id`, `precio`) VALUES (NULL, '$idRec', '$idRes', '$precio');");
 		}
 		}
 		return true;

 	}

 	static function anularReserva($idRes){
 		$varReservas = new Reserva();
 		$reserva = $varReservas->where('id',$idRes)->get();
 		$output = array();
        $reintegro = 0;
 		if ($reserva->estado_id == '2'){ // si estaba pagada
			$reintegro = ManagerReservas::registrarMovimiento($idRes,'notaCredito');
		} 		
 		$reserva->estado_id = '3'; // Se pasa a anulada
 		$output['anulacion'] = $reserva->skip_validation()->save();
 		$output['reintegro'] = $reintegro;
 		return $output;
 	}

 	static function pagarReserva($idRes){
        $varReservas = new Reserva();
 		$reserva = $varReservas->where('id',$idRes)->get();

 		$reserva->estado_id = '2';
 		$reserva->fechaActualizacion = date('Y-m-d H:i:s');
 		return $reserva->save();
    }
    static function registrarMovimiento($idRes,$tipoMovimiento){
    	$varMovimiento = new Movimiento();
    	$varReservas = new Reserva();
 		$reserva = $varReservas->where('id',$idRes)->get();	
		$precioTotal = ManagerReservas::getPrecioTotal($idRes);
		$reintegro = 0;
    	if ($tipoMovimiento == 'factura'){
    		$varMovimiento->tipo_movimiento_id = '1';
    		$varMovimiento->monto = $precioTotal;
    		
    		
    	} else {
    		$varMovimiento->tipo_movimiento_id = '2';
    		$fecha = $reserva->fechaReserva;
    		$reintegro = ManagerReservas::calcularReintegro($fecha,$precioTotal);
    		$varMovimiento->monto = $reintegro;
    	}
    	$varMovimiento->usuario_id = $reserva->usuario_id;
    	$varMovimiento->fecha = $reserva->fechaActualizacion;
    	$varMovimiento->skip_validation()->save();
    	return $reintegro;
    }
   //  static function pagarConTarjeta($idRes,$idTarjeta,$monto){
   //  	$varReservas = new Reserva();
 		// $reserva = $varReservas->where('id',$idRes)->get();

   //  }

 	static function getReserva($idRes){
 		$varRes = new Reserva();
 		return $varRes->where('id',$idRes)->get();
 	}

 	static function getPrecioTotal($idRes){
 		$varRes = new Reserva();
 		$res =  $varRes->where('id',$idRes)->get();

 		$duracion = $res->duracion;
        $sala = $res->sala->get();
 		$monto = $sala->precio;

 		$recursos = $res->recurso->get();
 		if ($recursos != null){
 			foreach ($recursos as $rec) {
 			  	$monto = $monto + $rec->precio;
 			}  
 		}
 		$servicios = $res->servicio->get();
 		if ($servicios != null){
 			foreach ($servicios as $serv) {
 			  	$monto = $monto + $serv->precio;
 			}  
 		}
 		return $monto * $duracion;
 	}
 	static function calcularReintegro($fecha,$monto){
 		$fechaReserva = new DateTime($fecha);
 		date_default_timezone_set('America/Buenos_Aires'); 
 		$fechaActual = new DateTime(date('d-m-Y H:i:s'));
 		$intervalo = $fechaReserva->diff($fechaActual); //Se obtiene la diferencia entre las fechas
		 
 		if ($intervalo->format('%a') < 2){ //Si faltan menos de dos dias..
 			$montoADevolver = $monto * 0.5;
 		} else {
 			$montoADevolver = $monto * 0.8;
 		}
 		return $montoADevolver * -1;
 	}

 	// static function reservasDeUsuario($idUser){
 	// 	$varReservas = new Reserva();
 	// 	$ = $varReservas->where('usuario_id',$idUser)->get();
 	// 		foreach ($list as $reserva) {

 	// 		}
 	// }


}
?>