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
$array = json_decode($json,true);

//     $response = [];
try{
$state = $conn ->prepare("SELECT * FROM user_login WHERE email = :em");
    $state -> bindParam(":em", $array['email']);
    $state -> execute();

    $row = $state ->fetch(PDO::FETCH_ASSOC);
    if($state->rowCount() > 0 && password_verify($array['hash'], $row['hash'])){
        $response['pass'] = true;
        $response['user_id'] = $row['id'];
        $response['name'] = $row['name'];
    }else{
        $response['error'] = "You Entered an incorrect Data";
    }

     $response["success"] = true;
}catch(Exception $e){
    $response['failed'] = "Something went wrong, do well to reach out to the Admin";
}

//print_r($response);
 $res= json_encode($response);
 echo $res;