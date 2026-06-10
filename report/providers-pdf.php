<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0,10,'DIRECTORIO DE PROVEEDORES',0,1,'C');
        
        $this->SetFont('Arial','I',12);
        $this->SetTextColor(108, 117, 125);
        $this->Cell(0,6,'Agencia de Publicidad - WareStock',0,1,'C');
        $this->Ln(10);

        // Encabezados de tabla globales
        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial','B',10);
        $this->Cell(70,8,'Nombre de Empresa / Contacto',1,0,'C',true);
        $this->Cell(80,8,'Direccion',1,0,'C',true);
        $this->Cell(40,8,'Telefono',1,1,'C',true);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$providers = PersonData::getProviders();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);

foreach($providers as $provider){
    $pdf->Cell(70,8," ".utf8_decode($provider->name." ".$provider->lastname),1,0,'L');
    $pdf->Cell(80,8," ".utf8_decode($provider->address1),1,0,'L');
    $pdf->Cell(40,8,$provider->phone1,1,1,'C');
}

$pdf->Output();
?>