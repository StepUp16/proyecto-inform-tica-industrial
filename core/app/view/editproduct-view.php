<?php
$product = ProductData::getById($_GET["id"]);
if($product!=null):
?>
<div class="row">
  <div class="col-md-12">
    <h2 class="text-primary fw-bold"><i class="bi bi-pencil-square"></i> Editar: <?php echo $product->name; ?></h2>
    
    <div class="card shadow-sm border-warning mt-3">
      <div class="card-header bg-dark text-white fw-bold">ACTUALIZAR DATOS DEL REGISTRO</div>
      <div class="card-body bg-light">
        <form method="post" enctype="multipart/form-data" action="index.php?view=updateproduct">
          <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
          
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">Tipo de Registro*</label>
              <select name="es_materia_prima" class="form-select border-primary" required>
                <option value="1" <?php if($product->es_materia_prima == 1) echo 'selected'; ?>>Materia Prima / Insumo</option>
                <option value="0" <?php if($product->es_materia_prima == 0) echo 'selected'; ?>>Producto Terminado</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Código*</label>
              <input type="text" name="barcode" class="form-control" value="<?php echo $product->barcode; ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Nombre del Insumo/Producto*</label>
              <input type="text" name="name" class="form-control" value="<?php echo $product->name; ?>" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold text-danger">Costo (Precio de Compra)*</label>
              <input type="number" step="0.01" name="price_in" class="form-control border-danger" value="<?php echo $product->price_in; ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold text-success">Precio de Venta</label>
              <input type="number" step="0.01" name="price_out" class="form-control border-success" value="<?php echo $product->price_out; ?>">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Unidad de Medida*</label>
              <input type="text" name="unit" class="form-control" value="<?php echo $product->unit; ?>" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold text-warning">Stock Mínimo (Alerta)*</label>
              <input type="number" name="inventary_min" class="form-control border-warning" value="<?php echo $product->inventary_min; ?>" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Actualizar Imagen</label>
              <input type="file" name="image" class="form-control">
              <?php if($product->image!=""):?>
                <div class="mt-2 text-center">
                  <img src="storage/products/<?php echo $product->image;?>" class="img-thumbnail" style="max-height: 80px;">
                </div>
              <?php endif;?>
            </div>
            <div class="col-md-4 d-flex align-items-center">
              <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" <?php if($product->is_active){ echo "checked";}?>>
                <label class="form-check-label fw-bold" for="isActiveCheck">Catálogo Activo</label>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Descripción / Detalles adicionales</label>
            <textarea name="description" class="form-control" rows="2"><?php echo $product->description; ?></textarea>
          </div>

          <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm"><i class="bi bi-arrow-repeat"></i> Actualizar Registro</button>
        </form>
      </div>
    </div>

    <!-- Motor de Costos — solo visible para Productos Terminados -->
    <?php if($product->es_materia_prima == 0): ?>
    <div class="card shadow-sm border-info mt-4">
      <div class="card-header bg-info text-white fw-bold">
        <i class="bi bi-calculator"></i> Motor de Costos — Calcular Precio de Venta
      </div>
      <div class="card-body bg-light">
        <p class="text-muted small mb-3">
          Calcula el precio de venta sugerido sumando el costo de los insumos de la receta, la mano de obra y el margen de ganancia deseado.
          Requiere que el producto tenga una <a href="index.php?view=b&id=<?php echo $product->id; ?>">receta (BOM)</a> configurada.
        </p>

        <div id="motor-costos-resultado" class="mb-3"></div>

        <div class="row g-3 align-items-end">
          <div class="col-md-3">
            <label class="form-label fw-bold small">Mano de Obra ($)</label>
            <input type="number" id="mc_labor" step="0.01" min="0" value="0" class="form-control border-secondary" placeholder="Ej: 2.50">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-bold small">Margen de Ganancia (%)</label>
            <input type="number" id="mc_margin" step="1" min="0" value="30" class="form-control border-secondary" placeholder="Ej: 30">
          </div>
          <div class="col-md-3">
            <button type="button" id="btn_calcular" class="btn btn-info text-white w-100 fw-bold">
              <i class="bi bi-calculator-fill"></i> Calcular
            </button>
          </div>
          <div class="col-md-3">
            <button type="button" id="btn_aplicar" class="btn btn-success w-100 fw-bold d-none">
              <i class="bi bi-check-circle"></i> Aplicar al formulario
            </button>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<?php if($product->es_materia_prima == 0): ?>
<script>
(function(){
  var productId = <?php echo intval($product->id); ?>;
  var suggestedPrice = 0;

  $("#btn_calcular").on("click", function(){
    $.get("./?action=calculatecost", { product_id: productId }, function(data){
      var res = typeof data === "string" ? JSON.parse(data) : data;

      if(res.error || res.ingredients.length === 0){
        $("#motor-costos-resultado").html(
          '<div class="alert alert-warning"><i class="bi bi-exclamation-triangle"></i> Este producto no tiene receta configurada. ' +
          '<a href="index.php?view=b&id=' + productId + '">Agregar receta</a></div>'
        );
        $("#btn_aplicar").addClass("d-none");
        return;
      }

      var labor  = parseFloat($("#mc_labor").val())  || 0;
      var margin = parseFloat($("#mc_margin").val()) || 0;

      var costMaterials = parseFloat(res.total_cost);
      var costTotal     = costMaterials + labor;
      suggestedPrice    = costTotal * (1 + margin / 100);

      var rows = "";
      res.ingredients.forEach(function(ing){
        rows += "<tr>" +
          "<td>" + ing.name + "</td>" +
          "<td class='text-center'>" + parseFloat(ing.quantity_to_discount) + " " + ing.unit + "</td>" +
          "<td class='text-end'>$ " + parseFloat(ing.price_in).toFixed(4) + "</td>" +
          "<td class='text-end fw-bold'>$ " + parseFloat(ing.subtotal).toFixed(4) + "</td>" +
          "</tr>";
      });

      var html = '<table class="table table-sm table-bordered mb-2">' +
        '<thead class="bg-light"><tr><th>Insumo</th><th class="text-center">Cantidad</th><th class="text-end">Costo Unit.</th><th class="text-end">Subtotal</th></tr></thead>' +
        '<tbody>' + rows + '</tbody>' +
        '<tfoot class="bg-light fw-bold">' +
          '<tr><td colspan="3" class="text-end text-danger">Costo Materiales</td><td class="text-end text-danger">$ ' + costMaterials.toFixed(2) + '</td></tr>' +
          '<tr><td colspan="3" class="text-end text-secondary">Mano de Obra</td><td class="text-end text-secondary">$ ' + labor.toFixed(2) + '</td></tr>' +
          '<tr><td colspan="3" class="text-end text-dark">Costo Total</td><td class="text-end text-dark">$ ' + costTotal.toFixed(2) + '</td></tr>' +
          '<tr class="table-success"><td colspan="3" class="text-end text-success">Precio Sugerido (+ ' + margin + '% margen)</td><td class="text-end text-success fs-5">$ ' + suggestedPrice.toFixed(2) + '</td></tr>' +
        '</tfoot>' +
        '</table>';

      $("#motor-costos-resultado").html(html);
      $("#btn_aplicar").removeClass("d-none");
    });
  });

  $("#btn_aplicar").on("click", function(){
    $("input[name='price_out']").val(suggestedPrice.toFixed(2));
    Swal.fire({
      icon: "success",
      title: "Precio aplicado",
      text: "El precio de venta fue actualizado a $ " + suggestedPrice.toFixed(2) + ". Guarda el formulario para confirmar el cambio.",
      timer: 3000,
      showConfirmButton: false
    });
  });
})();
</script>
<?php endif; ?>
<?php endif; ?>