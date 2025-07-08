<?php

session_start();
include "../additions/db.php";

if(isset($_POST['submit'])){
    $error = array();
    if(empty($_POST['fullname'])){
        $error['fullname'] = "Please Enter Fullname";
    }
    if(empty($_POST['email'])){
        $error['email'] = "Please Input your Email";
    }
    if(empty($_POST['password'])){
        $error['password'] = "Please Enter Password";
    }
    if(empty($_POST['confirm_password'])){
        $error['confirm_password'] = "Please confirm Password";
    }elseif($_POST['password'] !== $_POST['confirm_password']){
        $error['confirm_password'] = "Password Mismatch";
    }
    if(empty($error)){

        $encrypted = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $state = $conn -> prepare("INSERT INTO user VALUES (NULL, :fn, :em, :ps, NOW(), NOW())");
        $state -> bindParam(":fn", $_POST['fullname']);
        $state -> bindParam (":em", $_POST['email']);
        $state -> bindParam(":ps", $encrypted);
        $state -> execute();

        header("location:login.php?message=Congratulations, Your Signup was successful");
        exit();
    }else{
        header("location:signup.php?error=Password Mismatch");
        exit();
    }
}
?>

<h1 style='color:green'>Lungu Hills</h1>
<p>You are welcome to Lungu Hills; Do well to signup to access our services</p>
<hr/>
<?php
if(isset($_GET['error'])){
    echo "<p style='color:red'>".$_GET['error']."</p>";
}
?>
<form action="" method="POST">
    <input type="text" name="fullname" placeholder="Firstname    Lastname" required/>
    <br/>
    <input type="email" name="email" placeholder="Email" required/>
    <br/>
    <input type="password" name="password" placeholder="Password"/>
    <br/>
    <input type="password" name="confirm_password" placeholder="Confirm Password"/>
    <br/>
    <input type="submit" name="submit" value="Sign Up"/>

</form>

<p>Already logged in, Click <a href="login.php">Login</a> to access you account</p>