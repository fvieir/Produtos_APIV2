<?php

/*header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600'); // Número máximo de segundos que os resultados podem ser cacheados.
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');//indicar quais cabeçalhos HTTP podem ser utilizados*/

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../config/Database.php";
require_once "../objects/Product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = json_decode(file_get_contents("php://input"));

$fuso = new DateTimeZone('America/Sao_Paulo');
$date = new Datetime();
$date->setTimeZone($fuso);

$product->id          = $data->id;
$product->name        = $data->name;
$product->description = $data->description;
$product->category_id = $data->category_id;
$product->price       = $data->price;
$product->modified    = $date->format('Y-m-d H:i:s');

try {

    $product->update();
    http_response_code(200);
    echo json_encode(array('mensagem' => 'Usuario atualizado com sucesso'));
 
} catch (Exception $e) {
    
    http_response_code(503);
    echo json_encode(array('mensagem' => $e->getMessage()));
}

?>