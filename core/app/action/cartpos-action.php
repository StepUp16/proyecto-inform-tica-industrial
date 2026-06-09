<?php
$total = 0;
$cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : array();
?>
<div class="card shadow-sm border-success">
  <div class="card-header bg-success text-white fw-bold">
    <div class="row align-items-center">
      <div class="col-8"><i class="bi bi-receipt"></i> RESUMEN DE ORDEN</div>
      <div class="col-4 text-end">
        <a href="index.php?view=clearcartpos" class="btn btn-danger btn-sm" title="Vaciar Carrito"><i class="bi bi-trash"></i></a>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    <?php if(count($cart)>0): ?>
      <table class="table table-sm table-hover mb-0">
        <thead>
          <tr class="bg-light">
            <th>Cant.</th>
            <th>Producto/Servicio</th>
            <th class="text-end">Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($cart as $p):
            $product = ProductData::getById($p["product_id"]);
          ?>
          <tr>
            <td class="text-center fw-bold"><?php echo $p["q"]; ?></td>
            <td class="small"><?php echo $product->name; ?></td>
            <td class="text-end fw-bold text-dark">$ <?php 
              $pt = $product->price_out * $p["q"]; 
              $total += $pt; 
              echo number_format($pt, 2); 
            ?></td>
            <td class="text-end">
              <button class="btn btn-link btn-sm text-danger p-0" onclick="deleteFromCart(<?php echo $product->id; ?>)">
                <i class="bi bi-x-circle-fill"></i>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      
      <div class="p-3 bg-light border-top">
        <div class="d-flex justify-content-between mb-1">
          <span class="text-muted">Subtotal:</span>
          <span>$ <?php echo number_format($total / 1.13, 2); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <span class="text-muted">IVA (13%):</span>
          <span>$ <?php echo number_format($total - ($total / 1.13), 2); ?></span>
        </div>
        <div class="d-flex justify-content-between h5 mt-2 pt-2 border-top">
          <span class="fw-bold">TOTAL A COBRAR:</span>
          <span class="fw-bold text-success">$ <?php echo number_format($total, 2); ?></span>
        </div>
      </div>

      <div class="p-3">
        <form method="post" id="processsellpos" action="index.php?view=processsellpos">
          <div class="mb-3">
            <label class="form-label small fw-bold text-primary">Cliente (Contribuyente)</label>
            <?php $clients = PersonData::getClients(); ?>
            <select name="client_id" class="form-select form-select-sm border-primary">
              <option value="">-- CLIENTE MOSTRADOR --</option>
              <?php foreach($clients as $client):?>
                <option value="<?php echo $client->id;?>"><?php echo $client->name." ".$client->lastname;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label class="form-label small">Descuento ($)</label>
              <input type="number" name="discount" class="form-control form-control-sm" value="0" id="discount_pos" step="0.01">
            </div>
            <div class="col-6">
              <label class="form-label small text-success fw-bold">Efectivo Recibido</label>
              <input type="number" name="money" required class="form-control form-control-sm border-success" id="money_pos" step="0.01">
            </div>
          </div>
          
          <input type="hidden" name="total" value="<?php echo $total; ?>">
          
          <input type="hidden" name="hidden_prioridad" id="hidden_prioridad">
          <input type="hidden" name="hidden_fecha_entrega" id="hidden_fecha_entrega">
          <input type="hidden" name="hidden_diseno_url" id="hidden_diseno_url">

          <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm mt-2 btn-lg">
            <i class="bi bi-check-circle me-1"></i> ENVIAR A PRODUCCIÓN Y COBRAR
          </button>
        </form>
      </div>
    <?php else: ?>
      <div class="p-5 text-center text-muted bg-light">
        <i class="bi bi-cart-x" style="font-size: 4rem; color:#ccc;"></i>
        <h5 class="mt-3">La orden está vacía</h5>
        <p class="small">Busque productos a la izquierda para agregarlos.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  $("#processsellpos").submit(function(e){
    e.preventDefault(); // Detenemos el envío automático

    // 1. Validar que el usuario haya llenado los campos de Producción en la otra tarjeta
    var prio = $("#prod_prioridad").val();
    var fecha = $("#prod_fecha_entrega").val();
    var diseno = $("#prod_diseno_url").val();

    if(!fecha || fecha.trim() === ""){
        Swal.fire('Falta Información', 'Debe seleccionar una Fecha de Entrega obligatoria para el Taller.', 'warning');
        return false;
    }

    // Pasamos los valores visuales a los inputs ocultos de este formulario
    $("#hidden_prioridad").val(prio);
    $("#hidden_fecha_entrega").val(fecha);
    $("#hidden_diseno_url").val(diseno);

    // 2. Lógica de cobro y vuelto
    var discount = $("#discount_pos").val();
    var money = $("#money_pos").val();
    var total = <?php echo $total; ?>;
    
    if(discount==""){ discount=0; }
    
    var totalConDescuento = total - parseFloat(discount);

    if(parseFloat(money) < totalConDescuento){
      Swal.fire('Error de Cobro', 'El efectivo recibido es insuficiente para cubrir la orden.', 'error');
      return false;
    }else{
      var cambio = parseFloat(money) - totalConDescuento;
      
      Swal.fire({
        title: '¿Confirmar Orden?',
        html: '<b>Vuelto para el cliente:</b> <span class="text-success fs-3">$' + cambio.toFixed(2) + '</span><br><br>La orden pasará inmediatamente a la cola de Producción.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-check-lg"></i> Sí, procesar orden',
        cancelButtonText: 'Revisar detalles'
      }).then((result) => {
        if (result.isConfirmed) {
          // Si todo está bien, enviamos el formulario
          this.submit();
        }
      });
    }
  });
</script>