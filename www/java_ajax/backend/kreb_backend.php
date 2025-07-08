<?php

define ("DBNAME", "java_ajax");
define ("DBUSER", "root");
define ("DBPASS", "");

try{
    $conn = new PDO("mysql:host=localhost;dbname=".DBNAME,DBUSER,DBPASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e -> getMessage();
}

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$response = [];
try{
    $pass= password_hash($data['hash'], PASSWORD_BCRYPT);
    $kreb = $conn -> prepare("INSERT INTO user_login VALUES(NULL, :nm, :em, :hsh, NOW(), NOW())");
    $kreb -> bindParam(":nm", $data["name"]);
    $kreb -> bindParam(":em", $data["email"]);
    $kreb -> bindParam("hsh", $pass);
    $kreb -> execute();

    $response['success'] = "Your Login was successful";

}catch(PDOException $e){
    $response['failed'] = "Something went wrong";
}
$response = json_encode($response);
echo $response;
    
?>
