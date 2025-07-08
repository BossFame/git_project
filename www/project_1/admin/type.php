<?php
session_start();
include "../additions/db.php";
include "../additions/authentication.php";
include "../additions/header.php";

if(array_key_exists('submit', $_POST)){
    $error = array();
    if(empty($_POST['account_type'])){
        $error[] = "Specify account type";
    }
    if(empty($error)){
        $state = $conn -> prepare("INSERT INTO account VALUES(NULL, :at, NOW(), NOW())");
        $state -> bindParam(":at", $_POST['account_type']);
        $state -> execute();
        
    }else{
        echo "No account type specified";
    }
}
?>


<form action="" method="POST">
<input type="text" name="account_type"/>
<br/>
<br/>
<input type="submit" name="submit" value="Submit"/>
</form>

