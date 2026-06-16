<div class="row">
  <div class="col-md-12">
    <h2 class="text-primary fw-bold"><i class="bi bi-box-seam"></i> Registrar Nuevo Insumo / Producto</h2>
    <p class="text-muted">Agregue materia prima (ej. tazas, rollos de vinil) o productos terminados. Defina su stock mínimo para activar las alertas en bodega.</p>
    
    <div class="card shadow-sm border-primary">
      <div class="card-header bg-dark text-white fw-bold">DATOS DEL REGISTRO</div>
      <div class="card-body bg-light">
        <form method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=addproduct">
          
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">Tipo de Registro*</label>
              <select name="es_materia_prima" class="form-select border-primary" required>
                <option value="1">Materia Prima / Insumo (Para producir)</option>
                <option value="0">Producto Terminado (Para vender directo)</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Código*</label>
              <input type="text" name="barcode" id="product_code" class="form-control" placeholder="Ej: MAT-001" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Nombre del Insumo/Producto*</label>
              <input type="text" name="name" class="form-control" placeholder="Ej: Taza Blanca 11oz" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold text-danger">Costo (Precio de Compra)*</label>
              <input type="number" step="0.01" name="price_in" class="form-control border-danger" placeholder="$ 0.00" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold text-success">Precio de Venta</label>
              <input type="number" step="0.01" name="price_out" class="form-control border-success" placeholder="$ 0.00 (Dejar 0 si es solo insumo)" value="0">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Unidad de Medida*</label>
              <input type="text" name="unit" class="form-control" placeholder="Ej: Unidades, Metros, Mililitros" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label fw-bold text-warning">Stock Mínimo (Alerta)*</label>
              <input type="number" name="inventary_min" class="form-control border-warning" placeholder="Ej: 10" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold text-info">Inventario Inicial</label>
              <input type="number" name="q" class="form-control border-info" placeholder="Cantidad actual en bodega" value="0">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">Imagen (Opcional)</label>
              <input type="file" name="image" id="image" class="form-control">
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">Descripción / Detalles adicionales</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Marca del insumo, proveedor sugerido, especificaciones técnicas..."></textarea>
          </div>

          <!-- Calculadora de Margen — solo visible cuando es Producto Terminado -->
          <div id="calculadora-margen" class="card border-info mb-4 d-none">
            <div class="card-header bg-info text-white fw-bold small">
              <i class="bi bi-calculator"></i> Calculadora de Precio de Venta
            </div>
            <div class="card-body bg-light py-2">
              <p class="text-muted small mb-2">Calcula el precio de venta a partir del costo de compra y el margen de ganancia deseado. El resultado se aplica automáticamente al campo de arriba.</p>
              <div class="row g-2 align-items-end">
                <div class="col-md-4">
                  <label class="form-label small fw-bold">Mano de Obra ($)</label>
                  <input type="number" id="calc_labor" step="0.01" min="0" value="0" class="form-control form-control-sm" placeholder="Ej: 2.50">
                </div>
                <div class="col-md-4">
                  <label class="form-label small fw-bold">Margen de Ganancia (%)</label>
                  <input type="number" id="calc_margin" step="1" min="0" value="30" class="form-control form-control-sm" placeholder="Ej: 30">
                </div>
                <div class="col-md-4">
                  <button type="button" id="btn_calc_new" class="btn btn-info text-white btn-sm w-100 fw-bold">
                    <i class="bi bi-calculator-fill"></i> Calcular y Aplicar
                  </button>
                </div>
              </div>
              <div id="calc_result" class="mt-2"></div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm"><i class="bi bi-save"></i> Guardar Registro en Inventario</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $("#product_code").keydown(function(e){
        if(e.which==17 || e.which==74 ){
            e.preventDefault();
        }
    });

    // Mostrar/ocultar calculadora según tipo de registro
    $("select[name='es_materia_prima']").on("change", function(){
      if($(this).val() === "0"){
        $("#calculadora-margen").removeClass("d-none");
      } else {
        $("#calculadora-margen").addClass("d-none");
      }
    });

    $("#btn_calc_new").on("click", function(){
      var costIn  = parseFloat($("input[name='price_in']").val()) || 0;
      var labor   = parseFloat($("#calc_labor").val()) || 0;
      var margin  = parseFloat($("#calc_margin").val()) || 0;

      if(costIn <= 0){
        $("#calc_result").html('<span class="text-danger small"><i class="bi bi-exclamation-circle"></i> Ingrese primero el Costo de Compra.</span>');
        return;
      }

      var costTotal      = costIn + labor;
      var suggestedPrice = costTotal * (1 + margin / 100);

      $("input[name='price_out']").val(suggestedPrice.toFixed(2));

      $("#calc_result").html(
        '<span class="text-success small fw-bold"><i class="bi bi-check-circle"></i> ' +
        'Costo ($' + costIn.toFixed(2) + ') + Mano de obra ($' + labor.toFixed(2) + ') × ' +
        (1 + margin/100).toFixed(2) + ' = <b>Precio sugerido: $' + suggestedPrice.toFixed(2) + '</b>' +
        ' — aplicado al formulario.</span>'
      );
    });
  });
</script>