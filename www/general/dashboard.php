<?php
header('Content-Type", application/json');
include "../database.php";

$response = [];
try{
$state = $conn ->prepare("SELECT * FROM customer WHERE email = :em");
$state ->bindParam(":em", $_POST['email']);
$state -> execute();
$row = $state->fetch(PDO::FETCH_ASSOC);

if($state ->rowCount() > 0){
    $response['pass'] = true;
    $stmt = $conn ->prepare("SELECT final_balance FROM transactions WHERE senders_account = :an ORDER BY transaction_id DESC LIMIT 1");
    $stmt ->bindParam(":an", $row['account_number']);
    $stmt ->execute();

    $bal = $stmt->fetch(PDO::FETCH_ASSOC);

if ($bal) {
    $balance = $bal['final_balance'];
} else {
    $stmt2 = $conn->prepare("SELECT account_balance FROM customer WHERE account_number = :an");
    $stmt2->bindParam(':an', $row["account_number"]);
    $stmt2->execute();
    $customer = $stmt2->fetch(PDO::FETCH_ASSOC);

    $balance = $customer['account_balance'];
}

    $response['account_number'] = $row['account_number'];
    $response['account_name'] = $row['account_name'];
    $response['account_balance'] = $balance;
}
    $response['success'] = true;
}catch(Exception $e){
    $response['failed'] = "Something went wrong";
}
//print_r($response);
echo $res = json_encode($response);

