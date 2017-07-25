<?php
	require_once APPPATH.'/third_party/fpdf/fpdf.php');
	
	class PDF extends FPDF{
		function Header(){
			//logo
			$b=base_url();
			$this->Image($b.'assets/images/logo1.png',10);
			$this->SetFont('Arial', 'B', 16);
			$this->Cell(60);

			$this->Cell(70,15,'Factura de Reserva', 1, 0, 'C');
			$this->Ln(20);
		}

		function Footer(){
			$this->SetY(-15);
			$this->SetFont('Arial', 'I', 9);
			$this->Cell(0,10,'Page '.$this->PageNo(), 0 , 0, 'C');
		}
	}

?>