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

$stmt = $product->read_page(1,10);
$num = $stmt->rowCount();

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

}

?>