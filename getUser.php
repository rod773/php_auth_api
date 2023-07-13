<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$allHeaders = getallheaders();

echo json_encode($allHeaders);

$db_connection = new Database();

$conn = $db_connection->dbConnection();

$auth = new AuthMiddleware($conn, $allHeaders);

echo json_encode($auth->isValid());
