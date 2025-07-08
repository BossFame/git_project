<?php
session_start();
include "../additions/db.php";
?>
<h1 style="color:green">Lungu Hills</h1>
<?php
if(isset($_GET['message'])){
    echo "<p style='color:green'>". $_GET['message']."</p>";
}

if(isset($_POST['login'])){
    $issue = array();
    if(empty($_POST['email'])){
        $issue['email'] = "Enter Email";
    }
    if(empty($_POST['password'])){
        $issue['password'] = "Enter Password";
    }
    if(empty($issue)){
        $statement = $conn -> prepare("SELECT * FROM admin WHERE email = :em");
        $statement -> bindParam(":em", $_POST['email']);
        $statement -> execute();

        $record = $statement -> fetch(PDO::FETCH_BOTH);
        if($statement ->rowCount() > 0 && password_verify($_POST['password'], $record['password'])){

            $_SESSION['id'] = $record['admin_id'];
            $_SESSION['name']=$record['username'];
            header("location:home.php");
            exit();
        }else{
            echo "<p style='color:red'>"."Either Email or Password incorrect". "</p>";
        }
    }

}

?>

<?php
if(isset($_GET['error'])){
    echo "<p style='color:red'>".$_GET['error']."</p>";
}
?>

<form action="" method="POST">
    <p>Email: <input type="email" name="email" required/><p>
    <p>Password: <input type="password" name="password" required/></p>
    <input type="submit" name="login" value="Login"/>
</form>

