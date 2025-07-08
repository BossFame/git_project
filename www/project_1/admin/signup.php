<?php
include "../additions/db.php";


if(isset($_POST['submit'])){
    $error = array();
    if(empty($_POST['username'])){
        $error['username'] = "Please Enter Username";
    }
    if(empty($_POST['email'])){
        $error['email'] = "Please Enter Email";
    }
    if(empty($_POST['password'])){
        $error['password'] = "Please Enter Password";
    }
    if(empty($_POST['confirm_password'])){
        $error['confirm_password'] = "Please Enter Correct Password";
    }elseif($_POST['password'] !== $_POST['confirm_password']){
        $error['confirm_password'] = "Password Mismatch";
    }
    if(empty($error)){

        $encryption = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt = $conn -> prepare("INSERT INTO admin VALUES(NULL, :us, :em, :ps, NOW(), NOW())");
        $stmt -> bindParam(":us", $_POST['username']);
        $stmt -> bindParam(":em", $_POST['email']);
        $stmt -> bindParam(":ps", $encryption);
        $stmt -> execute();

        header("location:login.php?message=Congratulations, Your sign up was sucessful");
        exit();
    }
}
?>
<h1 style="color:Green">The Lungu Hills</h1>
<p>You're welcome to Lungu Hills, Kindly signup to Continue</p>

<form action="" method="POST">
    <?php if(isset($error['username'])){
        echo "<p style='color:red'>".$error['username']."</p>";
    }
    ?>
    <input type="text" name="username" placeholder="Username"/>
    <br/>
    <?php if(isset($error['email'])){
        echo "<p style='color:red'>".$error['email']."</p>";
    }
    ?>
    <input type="email" name="email" placeholder="Email"/>
    <br/>
    <input type="password" name="password" placeholder="Password"/>
    <br/>
    <?php 
        if(isset($error['confirm_hash'])){
        echo "<p style='color:red'>". $error['confirm_hash']. "<p>";
        }?>
    <input type="password" name="confirm_password" placeholder="Confirm_Password" required/>
    <br/>
    <input type="submit" name="submit" value="Signup"/>
</form>

<p>Already signed up, click on <a href="login.php">Login</a> to Login in your details</p>