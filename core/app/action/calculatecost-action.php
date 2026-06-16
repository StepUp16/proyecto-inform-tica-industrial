<?php
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

header('Content-Type: application/json');

if(!$product_id){
    echo json_encode(['error' => 'ID de producto requerido.']);
    exit;
}

$con = Database::getCon();
$sql = "SELECT pr.quantity_to_discount, p.name, p.price_in, p.unit,
               (pr.quantity_to_discount * p.price_in) as subtotal
        FROM product_recipe pr
        JOIN product p ON p.id = pr.material_id
        WHERE pr.product_parent_id = $product_id";

$query = $con->query($sql);
$ingredients = [];
$total_cost = 0;

if($query){
    while($r = $query->fetch_assoc()){
        $ingredients[] = $r;
        $total_cost += floatval($r['subtotal']);
    }
}

echo json_encode([
    'ingredients' => $ingredients,
    'total_cost'  => round($total_cost, 4)
]);
?>
