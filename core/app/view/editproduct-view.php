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
  </div>
</div>
<?php endif; ?>