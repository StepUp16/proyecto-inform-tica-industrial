<div class="row">
  <div class="col-md-12">
    <h2 class="text-warning fw-bold"><i class="bi bi-industry"></i> Cola de Producción en Taller</h2>
    <p class="text-muted">Vista exclusiva para operarios e instaladores. Las órdenes urgentes aparecen primero.</p>
    <div class="clearfix"></div>

<?php
// Consulta directa para evadir límites del framework original y leer nuestras columnas nuevas
$con = Database::getCon();
$sql = "SELECT * FROM sell WHERE estado_produccion != 'Listo para Instalacion' AND estado_produccion IS NOT NULL ORDER BY FIELD(prioridad, 'Alta', 'Media', 'Baja'), fecha_entrega ASC";
$query = $con->query($sql);
$ordenes = array();
if($query){
    while($r = $query->fetch_array()){
        $ordenes[] = $r;
    }
}

if(count($ordenes)>0){
?>
<div class="card shadow-sm border-warning">
  <div class="card-header bg-dark text-white fw-bold">
    ÓRDENES ACTIVAS
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0 align-middle">
        <thead class="bg-light">
          <tr>
            <th># Orden</th>
            <th>Entrega</th>
            <th>Prioridad</th>
            <th class="text-center">Cant. Items</th>
            <th class="text-center">Diseño</th>
            <th>Estado Actual</th>
            <th>Actualizar</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($ordenes as $sell):
            // Colores visuales para prioridad
            $badge_prio = "bg-secondary";
            if($sell['prioridad'] == 'Alta') $badge_prio = "bg-danger";
            if($sell['prioridad'] == 'Media') $badge_prio = "bg-warning text-dark";
            if($sell['prioridad'] == 'Baja') $badge_prio = "bg-info text-dark";

            // Colores visuales para estado
            $color_estado = "text-muted";
            if($sell['estado_produccion'] == 'Pendiente') $color_estado = "text-danger fw-bold";
            if($sell['estado_produccion'] == 'En Prensa') $color_estado = "text-primary fw-bold";
            if($sell['estado_produccion'] == 'Terminado') $color_estado = "text-success fw-bold";
        ?>
        <tr>
          <td class="fw-bold">ORD-<?php echo $sell['id']; ?></td>
          <td class="fw-bold text-danger">
            <?php echo ($sell['fecha_entrega']) ? date("d/m/Y", strtotime($sell['fecha_entrega'])) : 'N/A'; ?>
          </td>
          <td><span class="badge <?php echo $badge_prio; ?>"><?php echo $sell['prioridad']; ?></span></td>
          <td class="text-center">
            <?php
              $operations = OperationData::getAllProductsBySellId($sell['id']);
              echo count($operations) . " items";
            ?>
          </td>
          <td class="text-center">
            <?php if($sell['diseno_url']): ?>
              <a href="<?php echo $sell['diseno_url']; ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-link-45deg"></i> Ver Arte</a>
            <?php else: ?>
              <span class="small text-muted">Sin enlace</span>
            <?php endif; ?>
          </td>
          <td class="<?php echo $color_estado; ?>">
            <i class="bi bi-circle-fill small"></i> <?php echo $sell['estado_produccion']; ?>
          </td>
          <td style="width: 250px;">
            <form method="post" action="./?action=updatetaller" class="d-flex m-0">
              <input type="hidden" name="sell_id" value="<?php echo $sell['id']; ?>">
              <select name="nuevo_estado" class="form-select form-select-sm me-1">
                <option value="Pendiente" <?php if($sell['estado_produccion']=='Pendiente') echo 'selected';?>>Pendiente</option>
                <option value="En Prensa" <?php if($sell['estado_produccion']=='En Prensa') echo 'selected';?>>En Prensa</option>
                <option value="Terminado" <?php if($sell['estado_produccion']=='Terminado') echo 'selected';?>>Terminado</option>
                <option value="Listo para Instalacion">Listo / Instalación</option>
              </select>
              <button type="submit" class="btn btn-sm btn-success" title="Guardar Cambio"><i class="bi bi-check2"></i></button>
            </form>
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
    <i class="bi bi-check2-circle text-success" style="font-size: 4rem;"></i>
    <h3 class="mt-3">El taller está al día</h3>
    <p class="text-muted">No hay órdenes pendientes de producción o instalación.</p>
  </div>
<?php
}
?>
  </div>
</div>