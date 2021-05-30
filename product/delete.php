<?php

header('Access-Control-Allow-Oringin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

require_once "../config/Database.php";
require_once "../objects/Product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = json_decode(file_get_contents('php://input'));

$product->id = $data->id;

if ($product->delete()) 
{    
    http_response_code(200);

    echo json_encode(array('mensagem' => 'Deletado com sucesso'));
}else{
    http_response_code(503);

    echo json_encode(array('mensagem' => 'nenhum registro encontrado'));
}

