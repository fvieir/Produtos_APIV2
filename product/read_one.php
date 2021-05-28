<?php

header("Access-Control-Allow-Oringin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Acess-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once "../config/Database.php";
require_once "../objects/Product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->id = isset($_GET['id']) ? $_GET['id']: die();

$product->readOne();

if ($product->name != null)
{
    $product_arr = array(
        'id'            => $product->id,
        'name'          => $product->name,
        'description'   => $product->description,
        'price'         => $product->price
    );

    http_response_code(200);

    echo json_encode(array('mensagem' => $product_arr));
}else{

    http_response_code(404);

    echo json_encode(array('mensagem' => 'Produto não existe'));
}
?>