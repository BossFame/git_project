<?php
define ('DBNAME', 'git_project');
define ('DBUSER', 'root');
define ('DBPASS', 'vagrant');

try{
    $conn = new PDO("mysql:host=localhost;dbname=".DBNAME, DBUSER, DBPASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
echo $e -> getMessage();
}

$json = file_get_contents("php://input");
$array = json_decode($json,true);


$response = [];

try{
    $statement =  $conn->prepare("SELECT * FROM admin_login WHERE email = :em");
    $statement -> bindParam(":em", $array['email']);
    $statement -> execute();

    $row = $statement -> fetch(PDO::FETCH_ASSOC);
    if($statement ->rowCount() > 0 && password_verify($array['hash'], $row['password'])){
        $response['pass'] = true;
        $response['user_id'] = $row['id'];
        $response['name'] = $row['name'];
    }else{
        $response['error'] = "Kindly enter correct Email or Password";
    }
    $response['success'] = true;
}catch(Exception $e){
    $response['failed'] ="something went wrong, kindly reach out to the admin...";
}

//print_r($response);
$res = json_encode($response);
echo $res;
?>