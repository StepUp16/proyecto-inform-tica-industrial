<?php
// 1. Lógica de Alertas de Inventario
$products = ProductData::getAll();
$products_array = array();
foreach($products as $product){
  $q=OperationData::getQYesF($product->id); 
  if($q<=$product->inventary_min){
    $products_array[]  = $product;
  }
}

// 2. Lógica para Métricas de la Agencia (Facturación Mensual)
$con = Database::getCon();
$mes_actual = date("m");
$ano_actual = date("Y");
$meta_mensual = 15000; // Meta de $15K establecida en la rúbrica

// Facturación del mes
$sql_ventas = "SELECT SUM(total - discount) as total_mes FROM sell WHERE MONTH(created_at) = '$mes_actual' AND YEAR(created_at) = '$ano_actual'";
$query_ventas = $con->query($sql_ventas);
$ventas_data = $query_ventas->fetch_assoc();
$total_facturado = ($ventas_data['total_mes']) ? $ventas_data['total_mes'] : 0;
$porcentaje_meta = ($total_facturado / $meta_mensual) * 100;

// Órdenes activas en taller
$sql_taller = "SELECT COUNT(*) as activas FROM sell WHERE estado_produccion != 'Listo para Instalacion' AND estado_produccion IS NOT NULL";
$query_taller = $con->query($sql_taller);
$taller_data = $query_taller->fetch_assoc();
$ordenes_activas = $taller_data['activas'];
?>

<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="fw-bold text-dark"><i class="bi bi-speedometer"></i> Panel de Control - Gerencia</h2>
    <p class="text-muted">Resumen operativo y financiero del mes en curso.</p>
  </div>
</div>

<div class="row mb-4">
  
  <div class="col-6 col-lg-3">
    <div class="card border-success shadow-sm">
      <div class="card-body p-3 d-flex align-items-center">
        <div class="bg-success text-white p-3 me-3 rounded">
          <i class="bi bi-currency-dollar" style="font-size: 2rem;"></i>
        </div>
        <div>
          <div class="fs-4 fw-bold text-success">$<?php echo number_format($total_facturado, 2); ?></div>
          <div class="text-medium-emphasis text-uppercase fw-semibold small">Ventas del Mes</div>
        </div>
      </div>
      <div class="card-footer px-3 py-2 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-1">
          <span class="small fw-semibold text-muted">Meta: $15K</span>
          <span class="small fw-bold text-dark"><?php echo number_format($porcentaje_meta, 1); ?>%</span>
        </div>
        <div class="progress" style="height: 6px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $porcentaje_meta; ?>%;"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card border-primary shadow-sm">
      <div class="card-body p-3 d-flex align-items-center">
        <div class="bg-primary text-white p-3 me-3 rounded">
          <i class="bi bi-tools" style="font-size: 2rem;"></i>
        </div>
        <div>
          <div class="fs-4 fw-bold text-primary"><?php echo $ordenes_activas; ?></div>
          <div class="text-medium-emphasis text-uppercase fw-semibold small">En Producción</div>
        </div>
      </div>
      <div class="card-footer px-3 py-2 bg-light">
        <a class="btn-block text-primary d-flex justify-content-between align-items-center text-decoration-none" href="./?view=taller">
          <span class="small fw-bold">VER TALLER</span>
          <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card border-danger shadow-sm">
      <div class="card-body p-3 d-flex align-items-center">
        <div class="bg-danger text-white p-3 me-3 rounded">
          <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
        </div>
        <div>
          <div class="fs-4 fw-bold text-danger"><?php echo count($products_array); ?></div>
          <div class="text-medium-emphasis text-uppercase fw-semibold small">Alertas de Stock</div>
        </div>
      </div>
      <div class="card-footer px-3 py-2 bg-light">
        <a class="btn-block text-danger d-flex justify-content-between align-items-center text-decoration-none" href="#alertas">
          <span class="small fw-bold">VER ALERTAS</span>
          <i class="bi bi-arrow-down-circle-fill"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3">
    <div class="card border-warning shadow-sm">
      <div class="card-body p-3 d-flex align-items-center">
        <div class="bg-warning text-dark p-3 me-3 rounded">
          <i class="bi bi-truck" style="font-size: 2rem;"></i>
        </div>
        <div>
          <div class="fs-4 fw-bold text-dark"><?php echo count(PersonData::getProviders());?></div>
          <div class="text-medium-emphasis text-uppercase fw-semibold small">Proveedores</div>
        </div>
      </div>
      <div class="card-footer px-3 py-2 bg-light">
        <a class="btn-block text-warning d-flex justify-content-between align-items-center text-decoration-none text-dark" href="./?view=providers">
          <span class="small fw-bold">CONTACTAR PROVEEDOR</span>
          <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
      </div>
    </div>
  </div>

</div>

<div class="row" id="alertas">
  <div class="col-md-12">
    <div class="card shadow-sm border-danger">
      <div class="card-header bg-danger text-white fw-bold">
        <i class="bi bi-bell-fill"></i> ALERTAS CRÍTICAS DE INVENTARIO (MATERIA PRIMA)
      </div>
      <div class="card-body p-0">
        <?php if(count($products_array)>0){ ?>
        
        <div class="p-3 bg-light border-bottom d-flex justify-content-end">
          <a href="report/alerts-pdf.php" target="_blank" class="btn btn-outline-danger btn-sm fw-bold"><i class="bi bi-file-earmark-pdf"></i> Generar Orden de Compra (PDF)</a>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle text-center">
            <thead class="bg-light">
              <tr>
                <th>Código</th>
                <th class="text-start">Insumo / Producto</th>
                <th>Stock Actual</th>
                <th>Mínimo Requerido</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product):
              $q = OperationData::getQYesF($product->id);
              if($q <= $product->inventary_min):
            ?>
              <tr class="<?php echo ($q==0) ? 'table-danger' : 'table-warning'; ?>">
                <td class="fw-bold text-muted"><?php echo $product->barcode; ?></td>
                <td class="text-start fw-bold"><?php echo $product->name; ?></td>
                <td class="fs-5 fw-bold <?php echo ($q==0) ? 'text-danger' : 'text-warning text-dark'; ?>"><?php echo $q; ?></td>
                <td class="text-muted"><?php echo $product->inventary_min; ?></td>
                <td>
                  <?php if($q==0){ ?>
                    <span class='badge bg-danger p-2'><i class="bi bi-x-circle"></i> Agotado por completo</span>
                  <?php } else { ?>
                    <span class='badge bg-warning text-dark p-2'><i class="bi bi-exclamation-circle"></i> Bajo nivel (Comprar pronto)</span>
                  <?php } ?>
                </td>
              </tr>
            <?php endif; endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php } else { ?>
        <div class="p-5 text-center bg-light">
          <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
          <h4 class="mt-3 text-dark">Inventario Saludable</h4>
          <p class="text-muted">Por el momento, no hay escasez de materia prima ni productos terminados. La bodega está abastecida por encima de los niveles mínimos.</p>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>