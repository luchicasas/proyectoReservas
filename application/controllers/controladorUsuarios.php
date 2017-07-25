<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ControladorUsuarios extends CI_Controller {
        public function __construct()
        {
                parent::__construct();
                $this->load->model('ManagerUsuarios');
                $this->load->library('session');
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
            $this->load->view('templates/footer', $data);
        }


        public function verClientes(){
            $this->load->view('templates/header');
            $this->load->view('pages/verClientes');
            $this->load->view('templates/footer');
        }
        public function buscarCliente($mail){
            $output = ManagerUsuarios::buscarCliente($mail);
            echo json_encode($output);
        }
        public function mostrarClientes (){
           $output = ManagerUsuarios::mostrarClientes();
           echo json_encode($output);
        }

        public function autenticar($user,$password) {

            $varUsuarios = new Usuario();
            $array = array('mail' => $user , 'contrasenia' => $password);
            $encontrado = $varUsuarios->where($array)->get();
            
                if ($encontrado->activo == 1){
                    $rol = $encontrado->rol->get();
                    $response['resp'] =  "encontro";
                    $array = array ( 'mail'     => $user,
                                     'tipo'     => $rol->id,
                                     'logged_in' => TRUE );
                    $this->session->set_userdata($array);
                } else {
                    $response['resp'] = "no encontro";
                }

            echo json_encode($response);

        }

        public function logout() {
            $this->session->sess_destroy();
            $this->view();
        }

        public function cuentaUs($mailUser){
          $usuario = ManagerUsuarios::getUsuario($mailUser);
          $data['usuario'] = $usuario;
          $data['tipo'] = 'modif';
          $this->load->view('templates/header');
          $this->load->view('modals/modalUsuario',$data);
          $this->load->view('pages/cuenta', $data);
          $this->load->view('templates/footer');
        }

        public function registrarCliente(){
        $user = new Usuario();
        $user->dniUsuario = $this->input->post('dni');
        $user->mail = $this->input->post('mail');
        $user->nombre = $this->input->post('nombre');
        $user->telefono = $this->input->post('telefono');
        $user->apellido = $this->input->post('apellido');
        $user->contrasenia = $this->input->post('pass');
        $user->confirm_password = $this->input->post('confPass');
        $user->rol_id = '2';
        $user->activo = '1';


            if ($user->save()) {
                echo "Registrado";
            } else {
               echo $user->error->string;
            }
        }
        

        public function modificarUsuario(){

            $usuario = ManagerUsuarios::getUsuario($this->input->post('mail'));
            $usuario->dniUsuario = $this->input->post('dni');
            $usuario->nombre = $this->input->post('nombre');
            $usuario->telefono = $this->input->post('telefono');
            $usuario->apellido = $this->input->post('apellido');
            $usuario->contrasenia = $this->input->post('pass');
            $usuario->confirm_password = $this->input->post('confPass');
            if ($usuario->save()) {
                echo "Registrado";
            } else {
               echo $usuario->error->string;
            }
        }

        public function darDeBaja($mail){
            $output = ManagerUsuarios::darDeBaja($mail);
            echo json_encode($output);
        }

        public function getTarjetas($mail){
            $output = ManagerUsuarios::getTarjetas($mail);
            echo json_encode($output);
        }
        public function agregarTarjeta(){
            $tarj = new Tarjeta();
            $tarj->numTarjeta = $this->input->post('numT');
            $tarj->codSeguridad = $this->input->post('codSeg');
            $tarj->descripcion = $this->input->post('descrip');
            $tarj->usuario_id = $this->input->post('idUs');

                return $tarj->save();
            }
       
	}
?>