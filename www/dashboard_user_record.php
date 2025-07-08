<?php
    //session_start();
    //include "database.php";
define("DBNAME", "git_project");
define("DBUSER", "root");
define("DBPASS", "vagrant");

try{
    $conn = new PDO("mysql:host=localhost;dbname=". DBNAME, DBUSER, DBPASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e -> getMessage();
}

    $response = [];
    try{
    $stmt = $conn->prepare("SELECT name, email, id FROM admin_login WHERE id = :uid");
    $stmt -> bindParam(":uid", $_POST['user_id']);
    $stmt -> execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stmt-> rowCount() > 0){
            $response['pass'] = true;
            $response['data'] = $row;
        }else{
            $response['message'] = "This User doesn't exist on our record";
        }

    $response['success'] = true;

    }catch(Exception $e){
        $response['failed'] = "Something went wrong";
    }
    //print_r($response);
    $res = json_encode($response);
    echo $res;
?>