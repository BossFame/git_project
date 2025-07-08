<?php
include "../database.php";
$json = file_get_contents("php://input");
$array = json_decode($json,true);

if($array){
    $fullname = trim($array['fullname'] ?? '');
    $email = trim($array['email'] ?? '');
    $hash = $array['hash'] ?? '';

    $error = [];

    if(empty($fullname)){
        $error['fullname'] = 'Enter your Fullname';
    }
    if(empty($email)){
        $error['email'] = 'Enter Email';
    }
    if(empty($hash)){
        $error['hash'] = "Enter Password";
    }
    if(empty($error)){

        $response = array();
        try{

            $row = $conn -> prepare('SELECT email FROM user_login WHERE email = :em');
            $row -> bindParam(":em", $email);
            $row -> execute();

            if($row -> rowCount() > 0){
                $response['email_exist'] = true;
                $response['error'] = "Email already exist on our database";
                echo json_encode($response);
                exit();
            }
        $hashed = password_hash($hash, PASSWORD_BCRYPT);
        $stmt = $conn -> prepare("INSERT INTO user_login VALUES (NULL, :fn, :em, :hsh, NOW(), NOW())");
        $data = array (
            ":fn" => $fullname,
            ":em" => $email,
            ":hsh" => $hashed
        );
        $stmt -> execute($data);
            $response['success'] = true;
            $response['message'] = "Registration Successful";
        }catch(Exception $e){
            $response['failed'] = "Something went wrong";
        }
    }else{
        foreach ($error as $value){
            echo $value . "<br>";
        }
    }
}

//header('Content-Type', 'application/json');
echo $res = json_encode($response);

?>

