<?php

session_start();
include "../additions/db.php";
include "../additions/authentication.php";
include "../additions/header.php";
?>


<?php
if(isset($_POST['create'])){
    $error = array();
    if(empty($_POST['account_name'])){
        $error['account_name'] = "Enter Account Name";
    }
    if(empty($_POST['email'])){
        $error['email'] = "Enter Email";
    }
    if(empty($_POST['account_bal'])){
        $error['account_bal'] = "Enter Account Balance";
    }
    if(empty($_POST['account_type'])){
        $error['account_type'] = "Enter Account type";
        }
    if(empty($error)){
        $account_no = "30".rand(10000000, 99999999);
        $stmt = $conn -> prepare("INSERT INTO customer VALUES(NULL, :an, :ano, :em, :at, :ab, NOW(), NOW())");
        $data = array(
            ":an" => $_POST['account_name'],
            ":ano" => $account_no,
            ":em" =>  $_POST['email'],
            ":at" => $_POST['account_type'],
            ":ab" => $_POST['account_bal']
        );
        $stmt -> execute($data);

        header("location:view.php");
        exit();
    }else{
        header("location:");
    }
    }
?>
<form action="" method="POST">
    <p>Account Name: <input type="text" name="account_name" placeholder="Firstname  Lastname"/></p>
    <p>Email: <input type="email" name="email" placeholder="temidayo123@gmail.com"/></p>
    <p>Account Balance: <input type="text" name="account_bal" placeholder="10,0000"/>
    <p>Account Type:
    <?php 
        $state = $conn -> prepare("SELECT * FROM account");
        $state -> execute();

        echo "<select name='account_type'>";
        while($row = $state -> fetch(PDO::FETCH_BOTH)){
        echo "<option value=".$row['account_type'].">".$row['account_type']."</option>";
        }
        echo "</select>";
    ?>
    </p>
    <input type="submit" name="create" value="Create Account"/>
</form>