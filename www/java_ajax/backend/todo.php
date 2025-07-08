<?php

define ("DBNAME", "java_ajax");
define ("DBUSER", "root");
define ("DBPASS", "");

try{
    $conn = new PDO("mysql:host=localhost;dbname=".DBNAME, DBUSER, DBPASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e -> getMessage();
}

$json = file_get_contents("php://input");
$data = json_decode($json,true);

$response = [];
try{
$stmt = $conn -> prepare("INSERT INTO todo_list VALUES(NULL, :nm, :dt, :tm, :uid, NOW(), NOW())");
$stmt -> bindParam(":nm", $data['title']);
$stmt -> bindParam(":dt", $data['date']);
$stmt -> bindParam(":tm", $data['time']);
$stmt -> bindParam(":uid", $data['user_id']);
$stmt -> execute();

$response['success'] = true;
}catch(Exception $e){
    $response['failed'] = "Something went wrong";
}

$res = json_encode($response);
echo $res;
?>