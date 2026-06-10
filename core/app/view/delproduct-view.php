<?php
$product_id = $_GET["id"];

// 1. Eliminamos el producto de cualquier receta (ya sea como producto final o como insumo) para que no choque la base de datos
$sql_recipe = "DELETE FROM product_recipe WHERE product_parent_id = $product_id OR material_id = $product_id";
Executor::doit($sql_recipe);

// 2. Eliminamos el historial de entradas/salidas para que no quede huérfano
$operations = OperationData::getAllByProductId($product_id);
foreach ($operations as $op) {
    $op->del();
}

// 3. Eliminamos el producto del catálogo
$product = ProductData::getById($product_id);
$product->del();

$_SESSION["deleted"] = "El registro y sus dependencias han sido eliminados correctamente del inventario.";
Core::redir("./index.php?view=products");
?>