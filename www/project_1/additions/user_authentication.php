<?php
$statement = $conn -> prepare("SELECT * FROM user WHERE user_id = :usid");
$statement -> bindParam(":usid", $_SESSION['id']);
$statement -> execute();

if($statement -> rowCount() < 1){
    header("location:login.php?error=The record does not exist in our system");
    exit();
}



?>