<?php
    if(!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['email'])){
        header("location:admin_signin.html?error=You are no logged in");
        exit();
    }
?>