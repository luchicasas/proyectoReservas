<?php
defined('BASEPATH') or exit('No direct script access allowed');


class ControladorPDF extends CI_Controller {


        public function __construct()
        {
                parent::__construct();
                $this->load->model('ManagerUsuarios');
                $this->load->model('ManagerReservas');
                $this->load->model('ManagerServicios');
                $this->load->model('ManagerSalas');
                $this->load->model('ManagerRecursos');
         }

         //-------------------------------------------------------------------
         //------------Generacion de reportes---------------------------------
        public function config_PDFreporte($tipo,$fechaDesde,$fechaHasta){
          $datos = $this->ajax_list($tipo,$fechaDesde,$fechaHasta);
          $html = $this->load->view('includes/pdfReportes',$datos,true);
          //load mPDF library
          $this->load->library('M_pdf');
          //generate the PDF from the given html
          $this->m_pdf->pdf->WriteHTML($html);
        }
        public function generarReporte($tipo,$fechaInicial,$fechaFinal){
          
          $this->config_PDFreporte($tipo,$fechaInicial,$fechaFinal);
          $pdfFilePath = "Reporte_".$idRes.".pdf";
          $this->m_pdf->pdf->Output($pdfFilePath, "I");
        }

        public function ajax_list($tipo,$fechaDesde, $fechaHasta)
        {
            $data = array();
            $varRes= new Reserva();
            if ($tipo == 'salas'){
             $list = $varRes->db->query("SELECT COUNT(*) as cantidad,sala_id FROM (SELECT * FROM reservas WHERE fechaReserva BETWEEN '".$fechaDesde."' AND '".$fechaHasta."' ) as res GROUP BY sala_id HAVING count( `sala_id`) >=1 ORDER BY cantidad DESC LIMIT 5")->result();

             //RECORRIDO PARA SALAS 
              foreach ($list as $res) {
              $varSala = new Sala();
              $sala = $varSala->where('id',$res->sala_id)->get();
              $row = array();
               $row['id'] = $sala->id;
               $row['cantidad'] = $res->cantidad;
               $row['nombre'] = $sala->nombre;
               $row['descripcion'] = '';
               
              $data[] = $row;
              }
            } else {
                if ($tipo == 'servicios'){
                  $list = $varRes->db->query("SELECT servicio_id as num,nombre,descripcion, COUNT(*) as cantidad FROM(SELECT id as idRes FROM reservas WHERE fechaReserva BETWEEN '".$fechaDesde."' AND '".$fechaHasta."') as res INNER JOIN reservas_servicios ON idRes = reserva_id INNER JOIN servicios ON servicio_id = servicios.id GROUP BY servicio_id ORDER BY cantidad DESC LIMIT 5")->result();
                  
                } else {
                    $list = $varRes->db->query("SELECT recurso_id as num,nombre,descripcion, COUNT(*) as cantidad FROM(SELECT id as idRes FROM reservas WHERE fechaReserva BETWEEN '".$fechaDesde."' AND '".$fechaHasta."') as res INNER JOIN recursos_reservas ON idRes = reserva_id INNER JOIN recursos ON recurso_id = recursos.id GROUP BY recurso_id ORDER BY cantidad DESC LIMIT 5")->result();
                }
                 foreach ($list as $res) {
                    $row = array();
                    $row['id'] = $res->num;
                    $row['cantidad'] = $res->cantidad ;
                    $row['nombre'] = $res->nombre;
                    $row['descripcion'] = $res->descripcion;
                    $data[] = $row;
                  }           
            }
            $output= array (
            "data" => $data,
            "tipo" => $tipo,
            "fechaDesde" => $fechaDesde,
            "fechaHasta" => $fechaHasta
            );
             return $output;
        }

        //-------------------------------------------------------------------
         //------------Generacion de facturas---------------------------------
        public function config_PDFfactura($idRes,$tipo,$reintegro){
         $data= array();
         $servi = array();
         $rec= array();

         $varReserva = new Reserva();
         $varUsuario = new Usuario();
         $varSala = new Sala();
         $total = ManagerReservas::getPrecioTotal($idRes);
         $reserva = $varReserva->where('id',$idRes)->get();

         $usuario = $varUsuario->where('id',$reserva->usuario_id)->get();
         $sala = $varSala->where('id',$reserva->sala_id)->get();
         $servi = $reserva->servicio->get();
         $rec = $reserva->recurso->get();
          
         $data['reserva'] = $reserva;
         $data['usuario'] = $usuario;
         $data['sala'] = $sala;
         $data['tipo'] = $tipo;
         $data['servicio'] = $servi;
          $data['recurso'] = $rec;  
          $data['total'] = $total;
          $data['reintegro'] = $reintegro;
          $html = $this->load->view('includes/pdfFactura',$data,true);
          //load mPDF library
          $this->load->library('M_pdf');
          //generate the PDF from the given html
          $this->m_pdf->pdf->WriteHTML($html);
        }

        public function generarFactura($idRes,$tipo,$reintegro){
          $this->config_PDFfactura($idRes,$tipo,$reintegro);
          //this the the PDF filename that user will get to download
          $pdfFilePath = "Factura_".$idRes.".pdf";
          // $pdfFilePath = "application/cache/Contrato_".$id.".pdf";

          //download it. I -> Solo imprimir en pdf - D -> imprimi pero descarga automaticamente 
          $this->m_pdf->pdf->Output($pdfFilePath, "I");
          // $this->m_pdf->pdf->Output($pdfFilePath, "F");
     }
 }
    ?>