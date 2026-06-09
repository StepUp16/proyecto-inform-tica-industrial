<?php
if(isset($_SESSION["cart"])){
    $cart = $_SESSION["cart"];
    if(count($cart)>0){
        $num_succ = 0;
        $process=false;
        $errors = array();
        foreach($cart as $c){
            $q = OperationData::getQYesF($c["product_id"]);
            if($c["q"]<=$q){
                $num_succ++;
            }else{
                $error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
                $errors[count($errors)] = $error;
            }
        }

        if($num_succ==count($cart)){
            $process = true;
        }

        if($process==false){
            $error_msg = "";
            foreach($errors as $e){
                $error_msg .= $e["message"] . " ";
            }
            $_SESSION["error"] = $error_msg;
            print "<script>window.location='index.php?view=sellpos';</script>";
        }

        if($process==true){
            $sell = new SellData();
            $sell->user_id = $_SESSION["user_id"];
            $sell->total = $_POST["total"];
            $sell->discount = $_POST["discount"];
            if(isset($_POST["client_id"]) && $_POST["client_id"]!=""){
                $sell->person_id=$_POST["client_id"];
                $s = $sell->add_with_client();
            }else{
                $s = $sell->add();
            }

            // --- INICIO DE CÓDIGO MVP PRODUCCIÓN ---
            $sell_id = $s[1];

            $prioridad = isset($_POST["hidden_prioridad"]) && $_POST["hidden_prioridad"] != "" ? $_POST["hidden_prioridad"] : 'Media';
            $fecha_entrega = isset($_POST["hidden_fecha_entrega"]) && $_POST["hidden_fecha_entrega"] != "" ? $_POST["hidden_fecha_entrega"] : '';
            $diseno_url = isset($_POST["hidden_diseno_url"]) ? $_POST["hidden_diseno_url"] : '';

            $fecha_sql = ($fecha_entrega != '') ? "'".$fecha_entrega."'" : "NULL";

            $sql_produccion = "UPDATE sell SET estado_produccion='Pendiente', prioridad='$prioridad', fecha_entrega=$fecha_sql, diseno_url='$diseno_url' WHERE id=$sell_id";
            Executor::doit($sql_produccion);
            // --- FIN DE CÓDIGO MVP PRODUCCIÓN ---

            foreach($cart as  $c){
                // 1. Salida normal del producto vendido (Ej: "Taza Sublimada")
                $op = new OperationData();
                $op->product_id = $c["product_id"] ;
                $op->operation_type_id=OperationTypeData::getByName("salida")->id;
                $op->sell_id=$sell_id;
                $op->q= $c["q"];
                $op->add();                 

                // 2. AUTOMATIZACIÓN DE INVENTARIO INTELIGENTE (Descuento de Materia Prima)
                // Busca si el producto vendido tiene una receta asociada en la base de datos
                $sql_recipe = "SELECT * FROM product_recipe WHERE product_parent_id = ".$c["product_id"];
                $query_recipe = Executor::doit($sql_recipe);
                
                if($query_recipe[0]){
                    while($ingrediente = $query_recipe[0]->fetch_array()){
                        $op_mat = new OperationData();
                        $op_mat->product_id = $ingrediente['material_id'];
                        $op_mat->operation_type_id = OperationTypeData::getByName("salida")->id;
                        $op_mat->sell_id = $sell_id;
                        
                        // Descuenta la cantidad vendida multiplicada por lo que exige la receta
                        $op_mat->q = $c["q"] * $ingrediente['quantity_to_discount'];
                        $op_mat->add();
                    }
                }
            }
            unset($_SESSION["cart"]);
            
            $_SESSION["success"] = "Orden procesada correctamente. Insumos descontados de bodega.";
            print "<script>window.location='index.php?view=onesell&id=$sell_id';</script>";
        }
    }
}
?>