<?php

session_start();
include "../additions/db.php";
include "../additions/user_header.php";
include "../additions/check.php";
include "../additions/user_authentication.php";
?>
<a href="dashboard.php">Home</a>
<a href="bank.php">Banking Service</a>
<br/>

<p style='color:green'>Input your Account Number to Login</p>

<?php
if(isset($_POST['login'])){
    $error = array();
    if(empty($_POST['account_number'])){
        $error[] = "Please input Account Number";
    }elseif(!is_numeric($_POST['account_number'])){
        $error['account_number'] = "Please Enter numeric Value";
    }
    if(empty($error)){
        $okay = $conn -> prepare("SELECT * FROM customer WHERE account_number = :an");
        $okay -> bindParam(":an", $_POST['account_number']);
        $okay -> execute();

        if($okay -> rowCount() > 0){
            $record = $okay ->fetch(PDO::FETCH_BOTH);
            $_SESSION['id'] = $record['customer_id'];
            $_SESSION['name'] = $record['account_name'];
            header("location:bank_dashboard.php");
            exit();
        }else{
            echo "<p style='color:red'>"."Enter Correct Account number". "<p>";
        }
    }
}

?>



<form action="" method="POST">
    <input type="text" name="account_number" placeholder="Account Number"/>
    <br/>
    <input type="submit" name="login" value="Login"/>
</form>
