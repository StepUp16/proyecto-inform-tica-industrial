<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',20);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0,10,'REPORTE FINANCIERO DE VENTAS',0,1,'C');
        
        $this->SetFont('Arial','I',12);
        $this->SetTextColor(108, 117, 125);
        $this->Cell(0,6,'Agencia de Publicidad - WareStock',0,1,'C');
        $this->Ln(5);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$operations = array();

if(isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"]!="" && $_GET["ed"]!=""){
    if(isset($_GET["client_id"]) && $_GET["client_id"]==""){
        $operations = SellData::getAllByDateOp($_GET["sd"],$_GET["ed"],2);
    } else if(isset($_GET["client_id"])){
        $operations = SellData::getAllByDateBCOp($_GET["client_id"],$_GET["sd"],$_GET["ed"],2);
    } 
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);

if(isset($_GET["sd"]) && isset($_GET["ed"])){
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0,8,'Periodo: '.$_GET["sd"].' al '.$_GET["ed"],0,1,'C');
}

$pdf->Ln(5);

if(count($operations)>0){
    $pdf->SetFillColor(52, 58, 64);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(25,8,'No. Orden',1,0,'C',true);
    $pdf->Cell(45,8,'Fecha y Hora',1,0,'C',true);
    $pdf->Cell(40,8,'Subtotal',1,0,'C',true);
    $pdf->Cell(40,8,'Descuento',1,0,'C',true);
    $pdf->Cell(40,8,'Total Cobrado',1,1,'C',true);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',10);
    $supertotal = 0;
    
    foreach($operations as $operation){
        $pdf->Cell(25,8,'ORD-'.$operation->id,1,0,'C');
        $pdf->Cell(45,8,date("d/m/Y H:i", strtotime($operation->created_at)),1,0,'C');
        $pdf->Cell(40,8,"$ ".number_format($operation->total,2),1,0,'R');
        $pdf->Cell(40,8,"$ ".number_format($operation->discount,2),1,0,'R');
        $total = $operation->total - $operation->discount;
        $pdf->Cell(40,8,"$ ".number_format($total,2),1,1,'R');
        $supertotal += $total;
    }
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',14);
    $pdf->SetFillColor(212, 237, 218);
    $pdf->Cell(130,10,'',0,0); // Espacio en blanco
    $pdf->Cell(60,10,'TOTAL: $ '.number_format($supertotal,2),1,1,'R',true);
} else {
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(0,10,'No se encontraron ventas para el rango y cliente seleccionados.',0,1,'C');
}

$pdf->Output();
?>