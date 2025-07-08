<?php

session_start();
include "../additions/db.php";
?>

<h1 style='color:green'>Lungu Hills</h1>
<hr/>
<?php
if(isset($_GET['message'])){
    echo "<p style='color:green'>" . $_GET['message'] . "</p>";
}
if(array_key_exists("submit", $_POST)){
    $error = array();
    if(empty($_POST['email'])){
        $error['email'] = "Enter Email";
    }
    if(empty($_POST['password'])){
        $error['password'] = "Enter Password";
    }
    if(empty($error)){
       $state = $conn -> prepare("SELECT * FROM user WHERE email = :em");
       $state -> bindParam(":em", $_POST['email']);
       $state -> execute();

       $record = $state->fetch(PDO::FETCH_BOTH);
       if($state -> rowCount() > 0 && password_verify($_POST['password'], $record['password']) ){
        $_SESSION['id'] = $record['user_id'];
        $_SESSION['name'] = $record['name'];

        header("location:dashboard.php");
        exit();
       }else{
        echo "<p style='color:red'>". "Either Email or Password Incorrect" ."</p>";
       }

      
    }
}

?> 

<form action="" method="POST">
    <input type="email" name="email" placeholder="Email"/>
    <br/>
    <input type="password" name="password" placeholder="Password"/>
    <br/>
    <input type="submit" name="submit" value="Login"/>
</form>
<p>You don't have an account? <a href="signup.php">Click here</a> to Signup</p>