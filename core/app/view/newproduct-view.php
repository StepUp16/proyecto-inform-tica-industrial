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
    })
  });
</script>