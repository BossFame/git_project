<h1 style='color:green'> LUNGU HILLS </h1>
<?php

define("DBNAME", "git_project");
define("DBUSER", "root");
define("DBPASS", "vagrant");

try{
    $conn = new PDO("mysql:host=localhost;dbname=".DBNAME, DBUSER, DBPASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    var_dump($e ->getmessage());
}

if(isset($_POST['submit'])){
    $error = array();
    if(empty($_POST['name'])){
        $error['name'] = "Enter Fullname";
    }
    if(empty($_POST['email'])){
        $error['email'] = "Enter Email";
    }
    if(empty($_POST['password'])){
        $error['password'] = "Input Password";
    }

    if(empty($_POST['confirm_password'])){
        $error['confirm_password'] = "Confirm Password";
    }elseif($_POST['confirm_password'] !== $_POST['password']){
        $error['confirm_password'] = "Password Mismatch";
    }
    if(empty($error)){

        $state = $conn -> prepare("SELECT email FROM admin_login WHERE email = :em");
        $state -> bindParam(":em", $_POST['email']);
        $state -> execute();
        
        $row = $state->fetch(PDO::FETCH_BOTH);

        if($state -> rowCount() > 0){
            header("location:admin_signup.php?error=This Email already exist in our database");
            exit();
        };
    
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn -> prepare("INSERT INTO admin_login VALUES(NULL,:nm, :em, :ps, NOW(), NOW())");
        $stmt -> bindParam(":nm", $_POST['name']);
        $stmt -> bindParam(":em", $_POST['email']);
        $stmt -> bindParam(":ps", $hash);
        $stmt -> execute();

        
        
        

        header("location:admin_signin.html?message=Dear ". $_POST['name']. " , you are welcome to Lungu Hills Bank, Kindly login your details to have full access to our services");
        exit();
    }else{
        foreach($error as $value){
            echo "<p style='color:red'>".$value . "<br>". "</p>";
        }
    }

}
?>

<form action="" method="POST">
    <?php
     if(isset($_GET['error'])){
         echo "<p style='color:indigo'>". $_GET['error'] . "</p>";
    }
    ?>
    <p>Fullname: <input type="text" name="name" placeholder="Firstname   Othername"/></p>
    <p>Email: <input type="text" name="email" placeholder="Email"/></p>
    <p>Password: <input type="password" name="password"/></p>
    <p>Confirm Password: <input type="password" name="confirm_password"/>
    <br/>
    <br/>
    <input type="submit" name="submit" value="Submit" />
</form>
<p>Already have and account? Click <a href="admin_signin.html"> Sign in</a> </p>