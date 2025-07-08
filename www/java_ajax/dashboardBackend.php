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

try{
$statement = $conn -> prepare("SELECT name, email, id FROM user_login WHERE id = :uid");
$statement -> bindParam(":uid", $_POST['user_id']);
$statement -> execute();

$row = $statement->fetch(PDO::FETCH_ASSOC);

if($statement->rowCount() > 0){
    $response["success"] = true;
    $response["data"] = $row;
}else{
    $response['error'] = "This user doesn't exist in our database";
}
    $response["message"] = true;

}catch(Exception $e){
    $response["failed"] = "Something went wrong, Contact the admin";
}

$res = json_encode($response);
echo $res;

?>