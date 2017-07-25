<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {


    public function logout() {
        $this->session->sess_destroy();
        $this->index();
    }

    public function autenticar($user,$password) {

        $varUsuarios = new Usuario();
        $array = array('mail' => $user , 'contrasenia' => $password);
        $encontrado = $varUsuarios->where($array)->get();
        echo $encontrado->nombre;
        if ($encontrado->activo == 1){
            echo "encontro";
        } else {
            echo "no encontro";
        }

    }
}