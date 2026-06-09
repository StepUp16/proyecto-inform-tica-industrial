<?php
if(count($_POST)>0){
  $product = new ProductData();
  $product->barcode = $_POST["barcode"];
  $product->name = $_POST["name"];
  $product->price_in = $_POST["price_in"];
  $product->price_out = isset($_POST["price_out"]) && $_POST["price_out"] != "" ? $_POST["price_out"] : 0;
  $product->unit = $_POST["unit"];
  $product->description = $_POST["description"];
  
  // 1. Capturamos el nuevo campo de Materia Prima
  $product->es_materia_prima = isset($_POST["es_materia_prima"]) ? $_POST["es_materia_prima"] : 0;

  // 2. Neutralizamos los campos que quitamos del formulario para el MVP
  $product->presentation = "";
  $product->category_id = "NULL";

  $inventary_min="\"\"";
  if($_POST["inventary_min"]!=""){ $inventary_min=$_POST["inventary_min"];}
  $product->inventary_min=$inventary_min;
  $product->user_id = $_SESSION["user_id"];

  if(isset($_FILES["image"])){
    $image = new Upload($_FILES["image"]);
    if($image->uploaded){
      $image->Process("storage/products/");
      if($image->processed){
        $product->image = $image->file_dst_name;
        $prod = $product->add_with_image();
      }
    }else{
      $prod= $product->add();
    }
  }
  else{
    $prod= $product->add();
  }

  // 3. Registrar el inventario inicial si pusieron una cantidad mayor a 0
  if(isset($_POST["q"]) && $_POST["q"]!="" && $_POST["q"]!="0"){
   $op = new OperationData();
   $op->product_id = $prod[1] ;
   $op->operation_type_id=OperationTypeData::getByName("entrada")->id;
   $op->q= $_POST["q"];
   $op->sell_id="NULL";
   $op->add();
  }

  $_SESSION["success"] = "Insumo/Producto registrado correctamente en el catálogo.";
  print "<script>window.location='index.php?view=products';</script>";
}
?>