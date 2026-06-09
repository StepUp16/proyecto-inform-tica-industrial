<div class="row">
    <div class="col-md-12">
        <h2 class="text-primary fw-bold"><i class="bi bi-boxes"></i> Catálogo de Insumos y Productos</h2>
        <p class="text-muted">Administre la materia prima (tazas, vinil, tintas) y los productos terminados. <b>El sistema resaltará en rojo</b> cuando se alcance el nivel de alerta para evitar quiebres de inventario en bodega.</p>

        <div class="mb-3 d-flex justify-content-between">
            <a href="index.php?view=newproduct" class="btn btn-primary fw-bold"><i class="bi bi-plus-circle"></i> Agregar Nuevo Insumo / Producto</a>
            <a href="report/products-pdf.php" target="_blank" class="btn btn-danger text-white fw-bold"><i class="bi bi-file-earmark-pdf"></i> Reporte de Costos PDF</a>
        </div>

        <div class="card shadow-sm border-primary">
            <div class="card-header bg-dark text-white fw-bold">
                EXISTENCIAS ACTUALES Y ESTRUCTURA DE COSTOS
            </div>
            <div class="card-body p-0">
                <?php
                $products = ProductData::getAll();
                if(count($products)>0){
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 align-middle text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Código</th>
                                <th class="text-start">Descripción del Insumo / Producto</th>
                                <th>Costo Proveedor</th>
                                <th>Precio Venta</th>
                                <th class="text-warning bg-dark">Stock Mínimo</th>
                                <th class="text-success bg-dark">Stock Actual</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($products as $product):
                            // Calculamos el stock actual en tiempo real sumando entradas y restando salidas
                            $q = OperationData::getQYesF($product->id);
                            // Verificamos si está en alerta roja
                            $is_low = ($q <= $product->inventary_min);
                        ?>
                        <tr class="<?php echo $is_low ? 'table-danger' : ''; ?>">
                            <td class="text-start fw-bold"><?php echo $product->barcode; ?></td>
                            <td class="text-start">
                                <?php if($product->image!=""):?>
                                    <img src="storage/products/<?php echo $product->image;?>" style="width:40px; border-radius:5px;" class="me-2">
                                <?php endif;?>
                                <?php echo $product->name; ?>
                            </td>
                            <td class="text-danger fw-bold" title="Lo que le pagamos al proveedor">
                                $ <?php echo number_format($product->price_in, 2, '.', ','); ?>
                            </td>
                            <td class="text-success fw-bold" title="Lo que le cobramos al cliente">
                                <?php if($product->price_out > 0): ?>
                                    $ <?php echo number_format($product->price_out, 2, '.', ','); ?>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Uso Interno</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold"><?php echo $product->inventary_min; ?></td>
                            <td>
                                <?php if($is_low): ?>
                                    <span class="badge bg-danger fs-6"><i class="bi bi-exclamation-triangle"></i> <?php echo $q; ?> (URGE COMPRAR)</span>
                                <?php else: ?>
                                    <span class="badge bg-success fs-6"><?php echo $q; ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-warning" title="Editar Ficha"><i class="bi bi-pencil"></i></a>
                                <a href="index.php?view=delproduct&id=<?php echo $product->id; ?>" class="btn btn-sm btn-danger" title="Eliminar"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php
                }else{
                ?>
                <div class="p-5 text-center text-muted bg-light">
                    <i class="bi bi-boxes" style="font-size: 4rem; color:#ccc;"></i>
                    <h4 class="mt-3">El catálogo de insumos está vacío</h4>
                    <p>Haga clic en "Agregar Nuevo Insumo / Producto" para comenzar a registrar su materia prima (ej. rollos de vinil, tazas blancas, tinta) o los productos terminados.</p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>