<?php
$statement = $conn -> prepare("SELECT * FROM customer WHERE customer_id = :cid");
$statement -> bindParam(":cid", $_SESSION['id']);
$statement -> execute();

if($statement -> rowCount() < 1){
    header("location:login.php?error=The record does not exist in our system");
    exit();
}
$user_data = $statement->fetch(PDO::FETCH_BOTH);
?>

<p>Account balance: <?=$user_data['account_bal']?></p>
<p>Account Number: <?=$user_data['account_number']?></p>