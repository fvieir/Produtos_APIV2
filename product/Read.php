<?php

header("Access-Control-Allow-Origin");
header("Content-Type: application/json; chasert=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stm = $product->read();
$num = $stm->rowCount();

if($num > 0)
{
    $products_arr = array();
    $products_arr['records'] = array();
    
    while($row = $stm->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $product_item = array(
            "id"            => $id,
            "name"          => $name,
            "description"   => $description,
            "price"         => $price,
            "category_id"   => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr['records'],$product_item);
    }

    http_response_code(200);

    echo json_encode($products_arr);   
}else{
    http_response_code(404);

    echo json_encode(array('message' => 'Produtos não encontrados'));
}

?>