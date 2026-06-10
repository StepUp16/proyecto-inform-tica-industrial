<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="fw-bold text-primary"><i class="bi bi-boxes"></i> Inventario y Stock Actual</h2>
    <p class="text-muted">Monitoreo en tiempo real de la disponibilidad de materia prima e insumos en bodega.</p>
    
    <div class="mb-3 text-end">
      <a href="report/inventary-pdf.php" target="_blank" class="btn btn-danger text-white fw-bold shadow-sm">
        <i class="bi bi-file-earmark-pdf"></i> Descargar Reporte PDF
      </a>
    </div>

    <div class="card shadow-sm border-primary">
      <div class="card-header bg-dark text-white fw-bold">
        EXISTENCIAS EN BODEGA
      </div>
      <div class="card-body p-0">
        <?php
        $products = ProductData::getAll();
        if(count($products)>0){
        ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0 align-middle">
            <thead class="bg-light text-center">
              <tr>
                <th>Código</th>
                <th class="text-start">Nombre del Artículo</th>
                <th>Tipo</th>
                <th>Mínimo Ideal</th>
                <th>Stock Disponible</th>
                <th>Kardex</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($products as $product):
              $q = OperationData::getQYesF($product->id);
              
              // Lógica de colores actualizada para Bootstrap 5
              $row_class = "";
              $text_class = "text-success";
              if($q <= 0){ 
                $row_class = "table-danger"; 
                $text_class = "text-danger";
              } else if($q <= $product->inventary_min){ 
                $row_class = "table-warning"; 
                $text_class = "text-warning text-dark";
              }
            ?>
            <tr class="text-center <?php echo $row_class; ?>">
              <td class="text-muted fw-bold"><?php echo $product->barcode ?: $product->id; ?></td>
              <td class="text-start fw-bold"><?php echo $product->name; ?></td>
              <td>
                <?php if($product->es_materia_prima == 1): ?>
                  <span class="badge bg-secondary">Materia Prima</span>
                <?php else: ?>
                  <span class="badge bg-info text-dark">Producto Final</span>
                <?php endif; ?>
              </td>
              <td class="text-muted"><?php echo $product->inventary_min; ?></td>
              <td class="fw-bold fs-5 <?php echo $text_class; ?>"><?php echo $q; ?></td>
              <td style="width:120px;">
                <a href="index.php?view=history&product_id=<?php echo $product->id; ?>" class="btn btn-sm btn-success fw-bold shadow-sm">
                  <i class="bi bi-clock-history"></i> Historial
                </a>
              </td>
            </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        </div>
        <?php
        }else{
        ?>
          <div class="p-5 text-center bg-light">
            <i class="bi bi-box-seam text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3 text-dark">Inventario Vacío</h4>
            <p class="text-muted">No hay productos registrados en el sistema. Agregue insumos desde el catálogo para visualizar su stock.</p>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>