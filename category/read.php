<?php

header("Access-Control-Allow_Origin: *");
header("Content-Type: application/json, charsert=UTF-8");

require_once "../config/Database.php";
require_once "../objects/Category.php";

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$stmt = $category->read();
$num = $stmt->rowCount();

$category_arr = array();
$category_arr['records'] = array();

//var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));

if ($num > 0) 
{    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
        extract($row);

        $category_item = array(
            "id" => $id,
            "name" => $name,
            "description" =>$description,
            "created" => $created
        );

        array_push($category_arr['records'],$category_item);
    }

   http_response_code(200);

   echo json_encode($category_arr);
}else{

    http_response_code(404);

    echo json_encode(array('mensagem' => 'Aconteceu algum erro'));
}

?>