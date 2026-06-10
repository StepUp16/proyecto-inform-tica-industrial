<?php
include "../core/autoload.php";
include "../core/app/autoload.php";
Core::$root="../";

require('../fpdf/fpdf.php');

if(isset($_GET["id"]) && $_GET["id"]!=""){
    $sell = SellData::getById($_GET["id"]);
    $operations = OperationData::getAllProductsBySellId($_GET["id"]);
    $total = 0;

    class PDF extends FPDF {
        function Header() {
            // Título de la Agencia
            $this->SetFont('Arial','B',22);
            $this->SetTextColor(33, 37, 41);
            $this->Cell(0,10,'ORDEN DE PRODUCCION',0,1,'C');
            
            $this->SetFont('Arial','I',12);
            $this->SetTextColor(108, 117, 125);
            $this->Cell(0,6,'Agencia de Publicidad - WareStock',0,1,'C');
            $this->Ln(10);
        }
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->SetTextColor(150, 150, 150);
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb} - Sistema MVP WareStock',0,0,'C');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTextColor(0,0,0);

    // Variables de Producción
    $estado = isset($sell->estado_produccion) && $sell->estado_produccion != "" ? $sell->estado_produccion : 'Pendiente';
    $prio = isset($sell->prioridad) && $sell->prioridad != "" ? $sell->prioridad : 'Media';
    $fecha_ent = (isset($sell->fecha_entrega) && $sell->fecha_entrega != "") ? date("d/m/Y", strtotime($sell->fecha_entrega)) : 'No especificada';
    $diseno = (isset($sell->diseno_url) && $sell->diseno_url != "") ? $sell->diseno_url : 'Sin enlace proporcionado';

    // 1. BLOQUE: DATOS DE PRODUCCIÓN
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 8, ' REQUERIMIENTOS DEL TALLER', 1, 1, 'L', true);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(35, 8, ' No. Orden:', 'L', 0); 
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 8, 'ORD-'.$sell->id, 0, 0);
    
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(35, 8, ' Estado Actual:', 0, 0); 
    $pdf->Cell(60, 8, utf8_decode($estado), 'R', 1);

    $pdf->Cell(35, 8, ' Prioridad:', 'L', 0); 
    $pdf->Cell(60, 8, utf8_decode($prio), 0, 0);
    
    $pdf->Cell(35, 8, ' Fecha Entrega:', 0, 0); 
    $pdf->Cell(60, 8, $fecha_ent, 'R', 1);

    $pdf->Cell(35, 8, ' Link de Arte:', 'L,B', 0); 
    $pdf->SetFont('Arial','I',9);
    $pdf->Cell(155, 8, utf8_decode($diseno), 'R,B', 1);
    $pdf->Ln(5);

    // 2. BLOQUE: DATOS COMERCIALES
    $pdf->SetFillColor(230, 230, 230);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(0, 8, ' DATOS COMERCIALES', 1, 1, 'L', true);
    
    $cliente_name = "Cliente Mostrador";
    if($sell->person_id!=""){
        $client = $sell->getPerson();
        $cliente_name = $client->name." ".$client->lastname;
    }
    $vendedor_name = "Administrador";
    if($sell->user_id!=""){
        $user = $sell->getUser();
        $vendedor_name = $user->name." ".$user->lastname;
    }

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(35, 8, ' Cliente:', 'L', 0); 
    $pdf->Cell(155, 8, utf8_decode($cliente_name), 'R', 1);
    $pdf->Cell(35, 8, ' Atendido por:', 'L', 0); 
    $pdf->Cell(60, 8, utf8_decode($vendedor_name), 0, 0);
    $pdf->Cell(35, 8, ' Fecha Emitida:', 0, 0); 
    $pdf->Cell(60, 8, date("d/m/Y h:i A", strtotime($sell->created_at)), 'R', 1);
    
    // Cerramos el borde
    $pdf->Cell(190, 0, '', 'T', 1);
    $pdf->Ln(8);

    // 3. BLOQUE: TABLA DE PRODUCTOS
    $pdf->SetFillColor(52, 58, 64);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(25, 8, 'Codigo', 1, 0, 'C', true);
    $pdf->Cell(20, 8, 'Cant.', 1, 0, 'C', true);
    $pdf->Cell(85, 8, 'Producto / Servicio', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Precio U.', 1, 0, 'C', true);
    $pdf->Cell(30, 8, 'Total', 1, 1, 'C', true);

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','',10);
    foreach($operations as $operation){
        $product = $operation->getProduct();
        $pdf->Cell(25, 8, $product->barcode, 1, 0, 'C');
        $pdf->Cell(20, 8, $operation->q, 1, 0, 'C');
        $pdf->Cell(85, 8, " ".utf8_decode($product->name), 1, 0, 'L');
        $pdf->Cell(30, 8, "$ ".number_format($product->price_out,2), 1, 0, 'R');
        $op_total = $operation->q * $product->price_out;
        $pdf->Cell(30, 8, "$ ".number_format($op_total,2), 1, 1, 'R');
        $total += $op_total;
    }

    $pdf->Ln(5);

    // 4. BLOQUE: CÁLCULOS FINANCIEROS (IVA 13%)
    $total_pagar = $total - $sell->discount;
    $subtotal_iva = $total_pagar / 1.13;
    $iva = $total_pagar - $subtotal_iva;

    $pdf->SetFont('Arial','B',10);
    
    if($sell->discount > 0){
        $pdf->Cell(160, 8, 'Descuento: ', 0, 0, 'R');
        $pdf->SetTextColor(220, 53, 69);
        $pdf->Cell(30, 8, "- $ ".number_format($sell->discount,2), 1, 1, 'R');
        $pdf->SetTextColor(0, 0, 0);
    }
    
    $pdf->Cell(160, 8, 'Subtotal: ', 0, 0, 'R');
    $pdf->Cell(30, 8, "$ ".number_format($subtotal_iva,2), 1, 1, 'R');

    $pdf->Cell(160, 8, 'IVA (13%): ', 0, 0, 'R');
    $pdf->Cell(30, 8, "$ ".number_format($iva,2), 1, 1, 'R');

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(160, 10, 'TOTAL ORDEN: ', 0, 0, 'R');
    $pdf->SetFillColor(212, 237, 218); // Verde clarito
    $pdf->Cell(30, 10, "$ ".number_format($total_pagar,2), 1, 1, 'R', true);

    $pdf->Output();
}
?>