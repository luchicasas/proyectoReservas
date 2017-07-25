<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reporte extends CI_Controller 
{
 
  public function index()
  {
    $this->load->model('generarFactura');
    $this->load->model('ManagerSalas');
    $this->load->library('pdf');
 
    $salaRes = $this->generarFactura->obtieneDatosSala();    // Se obtienen la sala Reservada de la base de datos

 
    // Crea PDF
    $this->pdf = new Pdf();
    $this->pdf->AddPage();
 
    $this->pdf->SetTitle("Datos de la sala");
    $this->pdf->SetLeftMargin(15);
    $this->pdf->SetRightMargin(15);
    $this->pdf->SetFillColor(200,200,200);
     $this->pdf->SetFont('Arial', 'B', 14);
    /*
     * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
     */
 
    $this->pdf->Cell(15,7,'ID','TBL',0,'C','1');
    $this->pdf->Cell(25,7,'Nombre','TB',0,'L','1');
    $this->pdf->Cell(25,7,'Precio','TB',0,'L','1');
    $this->pdf->Cell(25,7,'Capacidad','TB',0,'L','1');
    $this->pdf->Cell(40,7,'Direccion','TB',0,'C','1');
    $this->pdf->Ln(7);

      $this->pdf->Cell(15,5,$salaRes->id,'BL',0,'C',0);
      $this->pdf->Cell(25,5,$salaRes->nombre,'B',0,'L',0);
      $this->pdf->Cell(25,5,$salaRes->precio,'B',0,'L',0);
      $this->pdf->Cell(25,5,$salaRes->capacidad,'B',0,'L',0);
      $this->pdf->Cell(40,5,$salaRes->direccion,'B',0,'C',0);
      $this->pdf->Ln(5);

    $this->pdf->Output("Factura.pdf", 'I');
  }
}
?>