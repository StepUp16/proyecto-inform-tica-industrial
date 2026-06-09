<?php
$product = ProductData::getById($_GET["id"]);
$categories = CategoryData::getAll();

if($product!=null):
?>
<div class="row">
	<div class="col-md-12">
	<h1><?php echo $product->name ?> <small>Editar Producto</small></h1>
  <?php if(isset($_COOKIE["prdupd"])):?>
    <p class="alert alert-info">La informacion del producto se ha actualizado exitosamente.</p>
  <?php setcookie("prdupd","",time()-18600); endif; ?>

<div class="card">
  <div class="card-header">
    EDITAR PRODUCTO
  </div>
    <div class="card-body">

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
		<form class="form-horizontal" method="post" id="addproduct" enctype="multipart/form-data" action="index.php?view=updateproduct" role="form">

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Imagen*</label>
    <div class="col-md-8">
      <input type="file" name="image" id="name" placeholder="">
<?php if($product->image!=""):?>
  <br>
        <img src="storage/products/<?php echo $product->image;?>" class="img-fluid">

<?php endif;?>
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Codigo de barras*</label>
    <div class="col-md-8">
      <input type="text" name="barcode" class="form-control" id="barcode" value="<?php echo $product->barcode; ?>" placeholder="Codigo de barras del Producto">
    </div>
  </div>
    <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Nombre*</label>
    <div class="col-md-8">
      <input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Nombre del Producto">
    </div>
  </div>
    <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Categoria</label>
    <div class="col-md-8">
    <select name="category_id" class="form-control">
    <option value="">-- NINGUNA --</option>
    <?php foreach($categories as $category):?>
      <option value="<?php echo $category->id;?>" <?php if($product->category_id!=null&& $product->category_id==$category->id){ echo "selected";}?>><?php echo $category->name;?></option>
    <?php endforeach;?>
      </select>    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Descripcion</label>
    <div class="col-md-8">
      <textarea name="description" class="form-control" id="description" placeholder="Descripcion del Producto"><?php echo $product->description;?></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Precio de Entrada*</label>
    <div class="col-md-8">
      <input type="text" name="price_in" class="form-control" value="<?php echo $product->price_in; ?>" id="price_in" placeholder="Precio de entrada">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Precio de Salida*</label>
    <div class="col-md-8">
      <input type="text" name="price_out" class="form-control" id="price_out" value="<?php echo $product->price_out; ?>" placeholder="Precio de salida">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Unidad*</label>
    <div class="col-md-8">
      <input type="text" name="unit" class="form-control" id="unit" value="<?php echo $product->unit; ?>" placeholder="Unidad del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Presentacion</label>
    <div class="col-md-8">
      <input type="text" name="presentation" class="form-control" id="inputEmail1" value="<?php echo $product->presentation; ?>" placeholder="Presentacion del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Minima en inventario:</label>
    <div class="col-md-8">
      <input type="text" name="inventary_min" class="form-control" value="<?php echo $product->inventary_min;?>" id="inputEmail1" placeholder="Minima en Inventario (Default 10)">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label" >Esta activo</label>
    <div class="col-md-8">
<div class="checkbox">
    <label>
      <input type="checkbox" name="is_active" <?php if($product->is_active){ echo "checked";}?>> 
    </label>
  </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-8">
    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
      <button type="submit" class="btn btn-success">Actualizar Producto</button>
    </div>
  </div>
</form>
    </div>
</div>

<br><br>
	</div>
</div>
<?php endif; ?>
