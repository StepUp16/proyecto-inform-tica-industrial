<div class="row mb-3 align-items-center">
  <div class="col-md-8">
    <h2 class="fw-bold text-primary"><i class="bi bi-file-earmark-text"></i> Orden de Producción: ORD-<?php echo $_GET["id"]; ?></h2>
    <p class="text-muted">Detalles completos de la venta y requerimientos para el taller.</p>
  </div>
  <div class="col-md-4 text-end">
    <a href="report/onesell-pdf.php?id=<?php echo $_GET["id"]; ?>" target="_blank" class="btn btn-danger text-white fw-bold shadow-sm">
      <i class="bi bi-file-earmark-pdf"></i> Imprimir Orden (PDF)
    </a>
  </div>
</div>

<?php if(isset($_GET["id"]) && $_GET["id"]!=""):
  $sell = SellData::getById($_GET["id"]);
  $operations = OperationData::getAllProductsBySellId($_GET["id"]);
  $total = 0;

  // Lógica de colores para los estados
  $estado = isset($sell->estado_produccion) && $sell->estado_produccion != "" ? $sell->estado_produccion : 'Pendiente';
  $prio = isset($sell->prioridad) && $sell->prioridad != "" ? $sell->prioridad : 'Media';
  
  $badge_estado = "bg-secondary";
  if($estado == 'Pendiente') $badge_estado = "bg-danger";
  if($estado == 'En Prensa') $badge_estado = "bg-primary";
  if($estado == 'Terminado') $badge_estado = "bg-success";
  if($estado == 'Listo para Instalacion') $badge_estado = "bg-info text-dark";

  $badge_prio = "bg-secondary";
  if($prio == 'Alta') $badge_prio = "bg-danger";
  if($prio == 'Media') $badge_prio = "bg-warning text-dark";
  if($prio == 'Baja') $badge_prio = "bg-info text-dark";
?>

<?php
if(isset($_COOKIE["selled"])){
    foreach ($operations as $operation) {
        $qx = OperationData::getQYesF($operation->product_id);
        $p = $operation->getProduct();
        if($qx==0){
            echo "<div class='alert alert-danger shadow-sm'><i class='bi bi-exclamation-triangle-fill'></i> ¡Atención! El insumo/producto <b>$p->name</b> se ha agotado por completo tras esta venta.</div>";
        }else if($qx<=$p->inventary_min){
            echo "<div class='alert alert-warning shadow-sm'><i class='bi bi-exclamation-circle-fill'></i> El insumo <b>$p->name</b> ha entrado en nivel crítico de escasez (Quedan $qx).</div>";
        }
    }
    setcookie("selled","",time()-18600);
}
?>

<div class="row mb-4">
  <div class="col-md-6">
    <div class="card shadow-sm border-warning h-100">
      <div class="card-header bg-warning text-dark fw-bold">
        <i class="bi bi-tools"></i> REQUERIMIENTOS DEL TALLER
      </div>
      <div class="card-body bg-light">
        <table class="table table-borderless mb-0">
          <tr>
            <td class="text-muted fw-bold" style="width: 150px;">Estado Actual:</td>
            <td><span class="badge <?php echo $badge_estado; ?> fs-6"><?php echo $estado; ?></span></td>
          </tr>
          <tr>
            <td class="text-muted fw-bold">Prioridad:</td>
            <td><span class="badge <?php echo $badge_prio; ?> fs-6"><?php echo $prio; ?></span></td>
          </tr>
          <tr>
            <td class="text-muted fw-bold">Fecha Entrega:</td>
            <td class="fw-bold text-danger">
              <?php echo (isset($sell->fecha_entrega) && $sell->fecha_entrega != "") ? date("d/m/Y", strtotime($sell->fecha_entrega)) : 'No especificada'; ?>
            </td>
          </tr>
          <tr>
            <td class="text-muted fw-bold">Diseño / Arte:</td>
            <td>
              <?php if(isset($sell->diseno_url) && $sell->diseno_url != ""): ?>
                <a href="<?php echo $sell->diseno_url; ?>" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-link-45deg"></i> Ver Archivo</a>
              <?php else: ?>
                <span class="text-muted fst-italic">Sin enlace proporcionado</span>
              <?php endif; ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm border-success h-100">
      <div class="card-header bg-success text-white fw-bold">
        <i class="bi bi-person-lines-fill"></i> DATOS COMERCIALES
      </div>
      <div class="card-body bg-light">
        <table class="table table-borderless mb-0">
          <tr>
            <td class="text-muted fw-bold" style="width: 150px;">Cliente:</td>
            <td class="fw-bold text-dark">
              <?php 
                if($sell->person_id != ""){
                  $client = $sell->getPerson();
                  echo $client->name." ".$client->lastname;
                } else {
                  echo "Cliente Mostrador";
                }
              ?>
            </td>
          </tr>
          <tr>
            <td class="text-muted fw-bold">Atendido por:</td>
            <td>
              <?php 
                if($sell->user_id != ""){
                  $user = $sell->getUser();
                  echo $user->name." ".$user->lastname;
                }
              ?>
            </td>
          </tr>
          <tr>
            <td class="text-muted fw-bold">Fecha Creada:</td>
            <td><?php echo date("d/m/Y h:i A", strtotime($sell->created_at)); ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm border-primary">
  <div class="card-header bg-dark text-white fw-bold">
    <i class="bi bi-cart-check"></i> DETALLE DE LA ORDEN
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0 align-middle">
        <thead class="bg-light text-center">
          <tr>
            <th>Código</th>
            <th>Producto / Servicio</th>
            <th>Cantidad</th>
            <th>Precio Unit.</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
        <?php
          foreach($operations as $operation){
            $product  = $operation->getProduct();
            $subt = $operation->q * $product->price_out;
            $total += $subt;
        ?>
          <tr class="text-center">
            <td class="text-muted"><?php echo $product->barcode ;?></td>
            <td class="text-start fw-bold"><?php echo $product->name ;?></td>
            <td class="fw-bold fs-5"><?php echo $operation->q ;?></td>
            <td>$ <?php echo number_format($product->price_out, 2, ".", ",") ;?></td>
            <td class="text-success fw-bold">$ <?php echo number_format($subt, 2, ".", ","); ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer bg-light p-4">
    <div class="row justify-content-end">
      <div class="col-md-4">
        <?php 
          $total_pagar = $total - $sell->discount;
          $subtotal_iva = $total_pagar / 1.13;
          $iva = $total_pagar - $subtotal_iva;
        ?>
        <table class="table table-borderless table-sm mb-0 text-end">
          <tr>
            <td class="text-muted fs-5">Descuento:</td>
            <td class="fs-5 text-danger fw-bold">- $ <?php echo number_format($sell->discount, 2, '.', ','); ?></td>
          </tr>
          <tr class="border-top">
            <td class="text-muted fw-bold mt-2 pt-2">Subtotal:</td>
            <td class="fw-bold mt-2 pt-2">$ <?php echo number_format($subtotal_iva, 2, '.', ','); ?></td>
          </tr>
          <tr>
            <td class="text-muted fw-bold">IVA (13%):</td>
            <td class="fw-bold">$ <?php echo number_format($iva, 2, '.', ','); ?></td>
          </tr>
          <tr class="border-top">
            <td class="text-dark fs-4 fw-bold pt-2">TOTAL:</td>
            <td class="text-success fs-4 fw-bold pt-2">$ <?php echo number_format($total_pagar, 2, '.', ','); ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>

<?php else:?>
  <div class="alert alert-danger shadow-sm mt-4 text-center">
    <h3><i class="bi bi-x-circle"></i> Error 501</h3>
    <p>No se encontró la orden solicitada o el ID es inválido.</p>
  </div>
<?php endif; ?>