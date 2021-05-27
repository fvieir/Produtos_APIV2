<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; chasert=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../config/Database.php";
require "../objects/Product.php";

$database = new Database();
$con = $database->getConnection();

$product = new Product($con);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->category_id))
{
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    if ($product->created()) 
    {
        http_response_code(201);

        echo json_encode(array('mensagem' => 'Product was created'));
    } else {
        http_response_code(503);

        echo json_encode(array('mensagem' => 'Não foi possível criar o produto'));
    }
} else { 
    http_response_code(400);

    echo json_encode(array('mensagem' => 'Não foi possível criar o produto. Os dados estão incompletos'));
}








?>