<?php
 
 if(!isset($_SESSION['id']) && !isset($_SESSION['name'])){
    header("location:login.php?error=You are not logged in");
    exit();
 }
 ?>