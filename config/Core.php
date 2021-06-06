<?php

ini_set('display_error',1);
error_reporting(E_ALL);

$home_url = 'http://localhost/api-produtos';

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$record_per_page = 5;

$from_record_num = ($record_per_page * $page) - $record_per_page;

?>