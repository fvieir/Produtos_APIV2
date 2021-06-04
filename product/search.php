<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json, charsert=UTF-8');

require_once "../config/Database.php";
require_once "../objects/Product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$keyworks = isset($_GET['url']) ? $_GET['url']: null;
$stmt = $product->search($keyworks);
$num = $stmt->rowCount();

if ($num > 0) {
    
}else{

}


?>