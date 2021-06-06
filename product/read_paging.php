<?php

header('Access-Control-Allow_Origin: *');
header('Content-Type: application/json, charset=UTF-8');

require_once "../config/Core.php";
require_once "../config/Database.php";
require_once "../shared/Utilities.php";
require_once "../objects/Product.php";

$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read_page($from_record_num,$record_per_page);
$num = $stmt->rowCount();

//var_dump($from_record_num,$record_per_page);

if ($num > 0)
{
    $product_arr = array();
    $product_arr['records'] = array();
    $product_arr['paging'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
       extract($row);
       
       $product_item = array(
           "category_name" => $category_name,
           "id" => $id,
           "name" => $name,
           "description" => $description,
           "category_id" => $category_id,
           "created" => $created
       );

       array_push($product_arr['records'],$product_item);

    }

    $total_rows = $product->count();
    $page_url = "{$home_url}/product/read.paging.php";
    $paging = $utilities->getPaging($page, $total_rows, $record_per_page,$page_url);

    $product_arr['paging'] = $paging;

    http_response_code(200);

    echo json_encode($product_arr);
}else{

    http_response_code(404);

    echo json_encode(array('mensagem' => 'Página não encontrada'));
}

?>