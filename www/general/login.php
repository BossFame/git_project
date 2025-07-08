<?php

include "../database.php";

$json = file_get_contents("php://input");
$array = json_decode($json,true);

try{
$statement = $conn ->prepare("SELECT * FROM user_login WHERE email = :em");
$statement ->bindParam(":em", $array['email']);
$statement -> execute();

$row = $statement -> fetch(PDO::FETCH_ASSOC);

if($statement->rowCount() > 0 && password_verify($array['hash'], $row['password'])){
    $response['pass'] = true;
    $response['email'] = $row['email'];
    $response['name'] = $row['fullname'];
}else{
    $response['error'] = "Either Email or Password incorrect";
}
    $response['success'] = true;
}catch(Exception $e){
    $response['failed'] = "Somethiong went wrong, kindly contact the admin for retification";
}

//print_r($response);
echo $res = json_encode($response);

?>