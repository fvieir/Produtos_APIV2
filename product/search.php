<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json, charsert=UTF-8');

require_once "../config/Database.php";
require_once "../objects/Product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$keyworks = isset($_GET['s']) ? $_GET['s'] : "";
$stmt = $product->search($keyworks);
$num = $stmt->rowCount();

$product_arr = array();
$product_arr['records'] = array();

if ($num > 0)
{
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => htmlspecialchars($description),
            "category_id" => $category_id
        );

        array_push($product_arr['records'],$product_item);
    }
    
    http_response_code(200);
    echo json_encode($product_arr);

}else{

    http_response_code(503);
    echo json_encode(array('mensagem' => 'Produto não encontrado'));
}


?>