<?php
if(count($_POST)>0){
    $product = ProductData::getById($_POST["product_id"]);

    $product->barcode = $_POST["barcode"];
    $product->name = $_POST["name"];
    $product->price_in = $_POST["price_in"];
    $product->price_out = isset($_POST["price_out"]) && $_POST["price_out"] != "" ? $_POST["price_out"] : 0;
    $product->unit = $_POST["unit"];
    $product->description = $_POST["description"];
    
    // 1. Atrapamos el campo del MVP
    $product->es_materia_prima = isset($_POST["es_materia_prima"]) ? $_POST["es_materia_prima"] : 0;

    // 2. Neutralizamos los campos eliminados
    $product->presentation = "";
    $product->category_id = "NULL";
    $product->inventary_min = $_POST["inventary_min"] != "" ? $_POST["inventary_min"] : "\"\"";

    $is_active=0;
    if(isset($_POST["is_active"])){ $is_active=1;}
    $product->is_active=$is_active;

    $product->user_id = $_SESSION["user_id"];
    $product->update();

    if(isset($_FILES["image"])){
        $image = new Upload($_FILES["image"]);
        if($image->uploaded){
            $image->Process("storage/products/");
            if($image->processed){
                $product->image = $image->file_dst_name;
                $product->update_image();
            }
        }
    }

    $_SESSION["updated"] = "El registro se ha actualizado correctamente en el inventario.";
    print "<script>window.location='index.php?view=products';</script>";
}
?>