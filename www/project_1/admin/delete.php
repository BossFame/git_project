<?php
session_start();
include "../additions/db.php";
include "../additions/authentication.php";
include "../additions/header.php";

if(!isset($_GET['id'])){
    header("location:view.php");
    exit();
}

$del = $conn -> prepare("DELETE FROM customer WHERE  customer_id = :cid");
$del -> bindParam(":cid", $_GET['id']);
$del -> execute();

header("location:view.php");
exit();

?>
