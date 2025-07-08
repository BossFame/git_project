<?php
session_start();
include "../additions/db.php";
include "../additions/blog_header.php";
include "../additions/authentication.php";

if(!isset($_GET['id'])){
    header("location:view_blog.php");
    exit();
}

$del = $conn ->prepare("DELETE FROM blog WHERE blog_id=:bid");
$del -> bindParam(":bid", $_GET['id']);
$del -> execute();
header("location:view_blog.php");
exit();
?>