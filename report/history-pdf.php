<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

if(isset($_GET["id"]) && $_GET["id"]!=""){
    $product = ProductData::getById($_GET["id"]);
    $operations = OperationData::getAllByProductId($product->id);
    $entradas = OperationData::GetInputQYesF($product->id);
    $disponibles = OperationData::GetQYesF($product->id);
    $salidas = -1*OperationData::GetOutputQYesF($product->id);

    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial','B',20);
            $this->SetTextColor(33, 37, 41);
            $this->Cell(0,10,'KARDEX Y MOVIMIENTOS',0,1,'C');
            
            $this->SetFont('Arial','I',12);
            $this->SetTextColor(108, 117, 125);
            $this->Cell(0,6,'Agencia de Publicidad - WareStock',0,1,'C');
            $this->Ln(10);
        }
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->SetTextColor(150, 150, 150);
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb} - Generado el: '.date('d/m/Y h:i A'),0,0,'C');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTextColor(0,0,0);
    
    // Título del Producto
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,utf8_decode('Historial del Insumo/Producto: '.$product->name),0,1,'C');
    $pdf->Ln(5);

    // Resumen de Stock
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(63,8,'Total Ingresos (Compras)',1,0,'C',true);
    $pdf->Cell(63,8,'Total Salidas (Consumo)',1,0,'C',true);
    $pdf->Cell(64,8,'Stock Disponible',1,1,'C',true);
    
    $pdf->SetFont('Arial','B',12);
    $pdf->SetTextColor(40, 167, 69); // Verde
    $pdf->Cell(63,10,$entradas,1,0,'C');
    $pdf->SetTextColor(220, 53, 69); // Rojo
    $pdf->Cell(63,10,$salidas,1,0,'C');
    $pdf->SetTextColor(0, 123, 255); // Azul
    $pdf->Cell(64,10,$disponibles,1,1,'C');
    $pdf->Ln(10);

    // Tabla de Movimientos
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor(52, 58, 64);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,8,'Cantidad',1,0,'C',true);
    $pdf->Cell(60,8,'Tipo de Movimiento',1,0,'C',true);
    $pdf->Cell(90,8,'Fecha y Hora',1,1,'C',true);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',10);
    foreach($operations as $operation){
        $tipo = $operation->getOperationType()->name;
        $pdf->Cell(40,8,$operation->q,1,0,'C');
        $pdf->Cell(60,8,utf8_decode(ucfirst($tipo)),1,0,'C');
        $pdf->Cell(90,8,date("d/m/Y h:i A", strtotime($operation->created_at)),1,1,'C');
    }

    $pdf->Output();
}
?>