<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="fw-bold text-primary"><i class="bi bi-receipt-cutoff"></i> Historial de Órdenes y Ventas</h2>
    <p class="text-muted">Registro histórico de todas las ventas procesadas. Aquí puede monitorear el estado global de los pedidos que ya pasaron por Recepción.</p>
    <div class="clearfix"></div>

<?php
$products = SellData::getSells();

if(count($products)>0){
?>
<div class="card shadow-sm border-primary">
  <div class="card-header bg-dark text-white fw-bold">
    ÓRDENES REGISTRADAS
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0 align-middle">
        <thead class="bg-light">
          <tr>
            <th class="text-center">Detalles</th>
            <th>N° Orden</th>
            <th>Fecha de Venta</th>
            <th class="text-center">Cant. Items</th>
            <th>Estado Producción</th>
            <th class="text-end">Total Cobrado</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($products as $sell): ?>
        <tr>
          <td class="text-center" style="width:50px;">
            <a href="index.php?view=onesell&id=<?php echo $sell->id; ?>" class="btn btn-sm btn-outline-primary" title="Ver Ticket"><i class="bi bi-eye"></i></a>
          </td>
          <td class="fw-bold text-dark">ORD-<?php echo $sell->id; ?></td>
          <td><?php echo date("d/m/Y h:i A", strtotime($sell->created_at)); ?></td>
          <td class="text-center">
            <?php
              $operations = OperationData::getAllProductsBySellId($sell->id);
              echo count($operations);
            ?>
          </td>
          <td>
            <?php 
              // Validamos si la propiedad existe para evitar que el sistema colapse mientras lo arreglamos en el siguiente paso
              $estado = isset($sell->estado_produccion) ? $sell->estado_produccion : 'Sin estado';
              $badge_color = "bg-secondary";
              if($estado == 'Pendiente') $badge_color = "bg-danger";
              if($estado == 'En Prensa') $badge_color = "bg-primary";
              if($estado == 'Terminado') $badge_color = "bg-success";
              if($estado == 'Listo para Instalacion') $badge_color = "bg-info text-dark";
            ?>
            <span class="badge <?php echo $badge_color; ?>"><?php echo $estado; ?></span>
          </td>
          <td class="text-end fw-bold text-success">
            <?php
              $total = $sell->total - $sell->discount;
              echo "$ " . number_format($total, 2);
            ?>          
          </td>
          <td class="text-center" style="width:50px;">
            <a href="index.php?view=delsell&id=<?php echo $sell->id; ?>" class="btn btn-sm btn-danger" title="Eliminar Venta"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
}else{
?>
  <div class="p-5 text-center bg-light border rounded mt-3">
    <i class="bi bi-receipt text-muted" style="font-size: 4rem;"></i>
    <h3 class="mt-3 text-dark">No hay historial de ventas</h3>
    <p class="text-muted">Aún no se ha procesado ninguna orden en el sistema. Vaya a "Nueva Orden" para comenzar.</p>
  </div>
<?php
}
?>
  </div>
</div>