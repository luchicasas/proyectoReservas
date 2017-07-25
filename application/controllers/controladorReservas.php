<?php
defined('BASEPATH') or exit('No direct script access allowed');

//$url = base_url().'managers/managerUsuarios.php';
// require_once($url);

class ControladorReservas extends CI_Controller {


        public function __construct()
        {
                parent::__construct();
                $this->load->model('ManagerUsuarios');
                $this->load->model('ManagerReservas');
                $this->load->model('ManagerServicios');
                $this->load->model('ManagerSalas');
                $this->load->model('ManagerRecursos');
         }

        public function index(){
                $this->load->view('pages/index.php');
        }

        public function view($page = 'index')
		   {
         if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
                 // Whoops, we don't have a page for that!
                 show_404();
         }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
          // if ($page == 'buscarSala'){
          // $this->load->view('templates/formBuscar');
          // }
        $this->load->view('templates/footer', $data);
        }

        
        public function verReservas($mailUser = null){
          $data['mailUser'] = $mailUser;
          $this->load->view('templates/header');
          $this->load->view('modals/modal');
          $this->load->view('pages/verReservas',$data);
        $this->load->view('templates/footer');
        }
        public function verSala($idS){
           $sala = ManagerSalas::mostrarSalas($idS);
           $data['sala'] = $sala;
           $this->load->view('templates/header');
           $this->load->view('pages/verSala',$data);
          $this->load->view('templates/footer');
        }

        public function reservar($id,$fecha,$hora,$duracion){
          $data['idSala'] = $id;
          $data['fecha'] = $fecha;
          $data['hora'] = $hora;
          $data['duracion'] = $duracion;
          $data['tipo'] = 'nuevo';
          $this->load->view('templates/header');
          $this->load->view('modals/modalUsuario',$data);
          $this->load->view('pages/reservar', $data);
          $this->load->view('templates/footer');
        }
        public function pagar($idRes,$mailUser){
          $reserva = ManagerReservas::getReserva($idRes);
          $precio = ManagerReservas::getPrecioTotal($idRes);
          $usuario = ManagerUsuarios::getUsuario($mailUser);
          $data['reserva'] = $reserva;
          $data['usuario'] = $usuario;
          $data['precio'] = $precio;
          $this->load->view('templates/header');
          $this->load->view('modals/modalTarjeta',$data);
          $this->load->view('pages/pagar', $data);
          $this->load->view('templates/footer');
        }
        //---------------------------------------------------------------
        //-------------------Manejos de Reserva--------------------------
        public function crearReserva(){
          $idSala = $this->input->post('sala');
          $fechaRes = $this->input->post('fechaRes');
          $horaRes = $this->input->post('horaRes');
          $duracionRes = $this->input->post('duracionRes');
          $mailUser = $this->input->post('user');
          $servicios = $this->input->post('servs');
          $recursos = $this->input->post('recs');
          
          $output = ManagerReservas::crearReserva($idSala,$fechaRes,$horaRes,$duracionRes,$mailUser,$servicios,$recursos);
          echo json_encode($output);
        }
        public function anularReserva($idRes){
          $output = ManagerReservas::anularReserva($idRes);
          echo json_encode($output);
        }
        public function pagarReserva($idRes){
          $output = ManagerReservas::pagarReserva($idRes);
          $varAux = ManagerReservas::registrarMovimiento($idRes,'factura');
           echo json_encode($output);
          }
        public function pagarConTarjeta($idRes,$idTarjeta,$monto){
          if ($this->realizarPago($idTarjeta,$monto)){
            $output = ManagerReservas::pagarReserva($idRes);
            $varAux = ManagerReservas::registrarMovimiento($idRes,'factura');
            echo json_encode($output);
          } else {
            $output = false;
            echo json_encode($output);
          }
        }

          
        //---------------------------------------------------------------
        //----------------------Muestras---------------------------------
         public function mostrarReservas ($mailUser){
           $output = ManagerReservas::mostrarReservas($mailUser);
           echo json_encode($output);
        }
        public function mostrarServicios(){
           $output = ManagerServicios::mostrarServicios();
           echo json_encode($output);
        }
        public function mostrarServiciosDeReserva($idRes){
           $output = ManagerServicios::mostrarServiciosDeReserva($idRes);
           echo json_encode($output);
        }
        public function mostrarRecursosDeReserva($idRes){
           $output = ManagerRecursos::mostrarRecursosDeReserva($idRes);
           echo json_encode($output);
        }
        //---------------------------------------------------------------
        //----------------------Busquedas--------------------------------
        public function buscarSalas($fecha,$hora,$duracion){
            $fec = $fecha;
            $h = $hora;
            $dur = $duracion;
            if ($this->session->userdata("mail")) {  
              $log = '1';
            }else {
              $log = '0';
            }
            $output = ManagerSalas::buscarSalas($fec,$h,$dur,$log);
            echo json_encode($output);
        }
        public function buscarRecursos($fecha,$hora,$duracion){
            $fec = $fecha;
            $h = $hora;
            $dur = $duracion;

            $output = ManagerRecursos::buscarRecursos($fec,$h,$dur);
            echo json_encode($output);
        }
        public function buscarServicios(){
            $output = ManagerServicios::buscarServicios();
            echo json_encode($output);
        }         
        //-------------------------------------------------------------------
        public function realizarPago($idTarj,$monto){
          // Se simula el pago a un sistema externa, con probabilidad de exito de 90%
            if (rand(0,10) < 8){
              return true;
            } else {
              return false;
            }
        } 
        
	}
?>