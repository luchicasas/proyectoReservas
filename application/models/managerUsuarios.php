<?php
defined('BASEPATH') or exit('No direct script access allowed');

 class ManagerUsuarios extends CI_Model{

	static function mostrarClientes(){
		$varUsers = new Usuario();
 		$list = $varUsers->where('rol_id','2')->get();
 		$varRes = new Reserva();
		$data = array();
			foreach ($list as $user) { //recorre todos los usuarios
	 		$row =  array();
	 		$row[] =  $user->dniUsuario;
	 		$row[] =  $user->nombre;
			$row[] =  $user->apellido;
	 		$row[] =  $user->mail;
	 		$row[] =  $user->telefono;
	 		$row[] = $user->rol->get()->tipoRol;
	 			$reservas =$user->reserva->get();
	 			if ($reservas->id != null){
	 				//Tiene reservas
	 				$row[] =  "<a class='btn btn-info btnVerReservas' data-mailUser='$user->mail' id='$user->id'><span>  Ver reservas </span> </a>";
	 				$resActivas = $varRes->db->query("SELECT * FROM reservas WHERE estado_id IN ('1','2') AND fechaReserva > NOW() AND usuario_id = '".$user->id."'")->result();
		 				if($resActivas != null){
		 					//tiene reservas proximas activas
		 					$row[] = "";
		 				} else {
		 					if ($user->activo =='1'){
		 					$row[] = "<a class='btn btn-danger btnDarDeBaja' data-mailuser='$user->mail'><span>  Dar de baja </span> </a>";
		 					} else {$row[]= "usuario inactivo";}
		 				}
	 			} else {
	 				//No tiene reservas
	 				$row[] = "";
	 				if ($user->activo =='1'){
		 					$row[] = "<a class='btn btn-danger btnDarDeBaja' data-mailuser='$user->mail'><span>  Dar de baja </span> </a>";
		 					} else {$row[]= "usuario inactivo";}
	 			}
	 		$data[] = $row; //Arma array data con todos los usuarios
			}

		$output= array (
		"data" => $data,
		);
		return $output;
		// echo json_encode($output);
	}
  		

	public function buscarCliente($mail){
        $varUsers = new Usuario();
        $user = $varUsers->where('mail',$mail)->get();
        if ($user->activo == '1' and $user->rol->get()->tipoRol == 'cliente'){
        	return 'encontro';
        } else {
        	return 'no encontro';
        }
    }

    public function darDeBaja($mail){
    	$varUsers = new Usuario();
        $user = $varUsers->where('mail',$mail)->get();
    	$user->activo = "0";
    	return $user->skip_validation()->save();
    }

    static function getUsuario($mailUser){
 		$varUser = new Usuario();
 		return $varUser->where('mail',$mailUser)->get();
 	}
 	
 	public function getTarjetas($mail){
        $varUser = new Usuario();
        $user = $varUser->where('mail',$mail)->get();
        $list = $user->tarjeta->get();

        $data = array();
	        foreach ($list as $tarjeta) {
	        	$row =  array();
	        	$id = $tarjeta->id;
	        	$row[] = $id;
	        	$row[] = $tarjeta->numTarjeta;
	        	$row[] = $tarjeta->descripcion;
	        	$row[] = "<a class='btn btn-success btnPagarConTarjeta' data-idTarj='$id'>Pagar</a>";

	        	$data[] = $row;
	        }
        $output= array (
		"data" => $data,
		);
		return $output;

    }

	
}