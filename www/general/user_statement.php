<?php
include "../database.php";

$json = file_get_contents("php://input");
$array = json_decode($json, true);

$account = $array['number'];

$response = [];

$stmt = $conn->prepare("SELECT * FROM customer WHERE account_number = :an");
$stmt->bindParam(":an", $account);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $customerId = $row['customer_id'];

    $stmtBal = $conn->prepare("SELECT final_balance FROM transactions WHERE customer = :cid ORDER BY transaction_id DESC LIMIT 1");
    $stmtBal->bindParam(":cid", $customerId);
    $stmtBal->execute();
    
    if ($bal = $stmtBal->fetch(PDO::FETCH_ASSOC)) {
        $response['acc'] = $bal['final_balance'];
    } else {
        $response['acc'] = "Zero Balance";
    }

    $stmtTrans = $conn->prepare("SELECT * FROM transactions WHERE customer = :cid ORDER BY date_created DESC, time_created DESC");
    $stmtTrans->bindParam(":cid", $customerId);
    $stmtTrans->execute();

    if ($stmtTrans->rowCount() > 0) {
        $response['pass'] = true;
        $response['details'] = $stmtTrans->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $response['error'] = "No Transaction was Found";
    }

} else {
    $response['error'] = "Account not registered";
}

echo json_encode($response);
?>

