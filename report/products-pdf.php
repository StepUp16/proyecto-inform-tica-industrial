<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0,10,'CATALOGO DE INSUMOS Y SERVICIOS',0,1,'C');
        
        $this->SetFont('Arial','I',12);
        $this->SetTextColor(108, 117, 125);
        $this->Cell(0,6,'Agencia de Publicidad - WareStock',0,1,'C');
        $this->Ln(10);

        // Cabecera de la tabla
        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial','B',10);
        $this->Cell(30, 8, utf8_decode('Código'), 1, 0, 'C', true);
        $this->Cell(80, 8, 'Nombre del Articulo', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Tipo', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Precio U.', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Activo', 1, 1, 'C', true);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$products = ProductData::getAll();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

foreach($products as $product){
    $pdf->Cell(30, 8, $product->barcode, 1, 0, 'C');
    $pdf->Cell(80, 8, " ".utf8_decode($product->name), 1, 0, 'L');
    
    $tipo = ($product->es_materia_prima == 1) ? 'Insumo' : 'Servicio/Final';
    $pdf->Cell(30, 8, $tipo, 1, 0, 'C');
    
    $pdf->Cell(25, 8, "$ ".number_format($product->price_out,2), 1, 0, 'R');
    
    $active = $product->is_active ? "Si" : "No";
    $pdf->Cell(25, 8, $active, 1, 1, 'C');
}

$pdf->Output();
?>