<?php
if(isset($_GET["product_id"])):
$product = ProductData::getById($_GET["product_id"]);
$operations = OperationData::getAllByProductId($product->id);

$itotal = OperationData::GetInputQYesF($product->id);
$total = OperationData::GetQYesF($product->id);
$ototal = -1*OperationData::GetOutputQYesF($product->id);
?>
<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="fw-bold text-primary"><i class="bi bi-clock-history"></i> Kardex: <?php echo $product->name; ?></h2>
    <p class="text-muted">Historial detallado de movimientos, entradas y salidas de bodega.</p>
    
    <div class="mb-4 text-end">
      <a href="report/history-pdf.php?id=<?php echo $product->id; ?>" target="_blank" class="btn btn-danger text-white fw-bold shadow-sm">
        <i class="bi bi-file-earmark-pdf"></i> Descargar Kardex PDF
      </a>
    </div>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-success">
          <div class="card-body p-3 d-flex align-items-center">
            <div class="bg-success text-white p-3 me-3 rounded"><i class="bi bi-box-arrow-in-right fs-2"></i></div>
            <div>
              <div class="fs-4 fw-bold text-success"><?php echo $itotal; ?></div>
              <div class="text-muted text-uppercase fw-bold small">Total Ingresos</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-primary">
          <div class="card-body p-3 d-flex align-items-center">
            <div class="bg-primary text-white p-3 me-3 rounded"><i class="bi bi-boxes fs-2"></i></div>
            <div>
              <div class="fs-4 fw-bold text-primary"><?php echo $total; ?></div>
              <div class="text-muted text-uppercase fw-bold small">Stock Disponible</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-danger">
          <div class="card-body p-3 d-flex align-items-center">
            <div class="bg-danger text-white p-3 me-3 rounded"><i class="bi bi-box-arrow-right fs-2"></i></div>
            <div>
              <div class="fs-4 fw-bold text-danger"><?php echo $ototal; ?></div>
              <div class="text-muted text-uppercase fw-bold small">Total Salidas</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm border-dark">
      <div class="card-header bg-dark text-white fw-bold">REGISTRO DE MOVIMIENTOS</div>
      <div class="card-body p-0">
        <?php if(count($operations)>0):?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle text-center">
              <thead class="bg-light">
                <tr>
                  <th>Cantidad</th>
                  <th>Tipo de Movimiento</th>
                  <th>Fecha y Hora</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($operations as $operation): 
                $tipo = strtolower($operation->getOperationType()->name);
                $badge = ($tipo == 'entrada') ? 'bg-success' : 'bg-danger';
              ?>
                <tr>
                  <td class="fw-bold fs-5"><?php echo $operation->q; ?></td>
                  <td><span class="badge <?php echo $badge; ?> px-3 py-2 fs-6"><?php echo ucfirst($tipo); ?></span></td>
                  <td><?php echo date("d/m/Y h:i A", strtotime($operation->created_at)); ?></td>
                  <td style="width:80px;">
                    <a href="index.php?view=deleteoperation&ref=history&pid=<?php echo $operation->product_id;?>&opid=<?php echo $operation->id;?>" 
                       class="btn btn-sm btn-outline-danger" 
                       onclick="return confirm('¿Está seguro que desea eliminar este movimiento? Esto afectará el stock.');">
                       <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="p-4 text-center text-muted">No hay movimientos registrados para este producto.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>