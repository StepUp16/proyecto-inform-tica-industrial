<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

$products = ProductData::getAll();

class PDF extends FPDF {
    function Header() {
        // Título principal
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0,10,'REPORTE DE INVENTARIO Y BODEGA',0,1,'C');
        
        // Subtítulo
        $this->SetFont('Arial','I',12);
        $this->SetTextColor(108, 117, 125);
        $this->Cell(0,6,'Agencia de Publicidad - WareStock',0,1,'C');
        $this->Ln(10);

        // Encabezados de la tabla
        $this->SetFillColor(52, 58, 64);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial','B',10);
        $this->Cell(30, 8, utf8_decode('Código'), 1, 0, 'C', true);
        $this->Cell(100, 8, 'Nombre del Insumo / Producto', 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('Mínimo Ideal'), 1, 0, 'C', true);
        $this->Cell(30, 8, 'Stock Actual', 1, 1, 'C', true);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb} - Fecha de corte: '.date('d/m/Y h:i A'),0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

if(count($products)>0){
    foreach($products as $product){
        $q = OperationData::getQYesF($product->id);
        
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(30, 8, $product->barcode, 1, 0, 'C');
        $pdf->Cell(100, 8, " ".utf8_decode($product->name), 1, 0, 'L');
        $pdf->Cell(30, 8, $product->inventary_min, 1, 0, 'C');
        
        // Lógica para pintar de colores las alertas en el PDF
        if($q == 0) {
            $pdf->SetTextColor(220, 53, 69); // Rojo (Agotado)
            $pdf->SetFont('Arial','B',10);
        } else if ($q <= $product->inventary_min) {
            $pdf->SetTextColor(210, 105, 30); // Naranja (Nivel crítico)
            $pdf->SetFont('Arial','B',10);
        } else {
            $pdf->SetTextColor(40, 167, 69); // Verde (Saludable)
            $pdf->SetFont('Arial','B',10);
        }
        
        $pdf->Cell(30, 8, $q, 1, 1, 'C');
    }
} else {
    $pdf->Cell(190, 10, 'No hay productos registrados en el inventario.', 1, 1, 'C');
}

$pdf->Output();
?>