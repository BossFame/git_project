<?php
include "../database.php";


$json = file_get_contents("php://input");
$array = json_decode($json,true);

$statement = $conn ->prepare("SELECT * FROM customer WHERE email = :em");
$statement ->bindParam(':em', $array['email']);
$statement ->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);


if($array){
    $account = trim($array['account'] ?? '');
    $amount = trim($array['amount'] ?? '');
    $pin = $array['pin'] ?? '';
    $error = array();

$state = $conn ->prepare("SELECT * FROM customer WHERE account_number = :an");
$state ->bindParam(":an", $account);
$state -> execute();

$receivers_data = $state ->fetch(PDO::FETCH_ASSOC);

if($state -> rowCount() < 1){
    $error[] = "Account Does not exist in our Database";
}
 if($account == $user['account_number']){
            $error[] = "You cannot transfer funds to yourself";
        }


    if(empty($account)){
        $error['account'] = "Enter account Number";
    }elseif(!is_numeric($account)){
        $error['account'] = "Enter numeric value only";
    }elseif(strlen($account) < 10){
        $error['account'] = "Enter 10 digits only";
    }

    if(empty($amount)){
        $error['amount'] = "Enter Amount";
    }elseif(!is_numeric($amount)){
        $error['amount'] = "Enter digit value only";
    }elseif($amount > $user['account_balance']){
        $error['amount'] = "Enter Valid Amount";
    }

    if(empty($pin)){
        $error['pin'] = "Enter Pin";
    }elseif(!is_numeric($pin)){
        $error['pin'] = "Enter numeric value only";
    }elseif(strlen($pin) > 4){
        $error['pin'] = "Enter appropriate account pin";
    }

    $response = [];

    $stmt = $conn ->prepare("SELECT * FROM customer WHERE hash = :hs");
    $stmt ->bindParam(":hs", $pin);
    $stmt -> execute();

    if($stmt -> rowCount() < 1){
        $response['pin'] = "Incorrect Pin";
    }


    if(empty($error)){
        $response['pass'] = true;
        $response['message'] = "Validation Passed Succesfully";

        $receivers_current_balance = $receivers_data['account_balance'];
        $receivers_final_balance = $receivers_current_balance + $amount;

        $credit_transaction = $conn ->prepare("UPDATE customer SET account_balance = :ab WHERE account_number = :an");
        $credit_transaction ->bindParam(":an", $account);
        $credit_transaction ->bindParam(":ab", $receivers_final_balance);
        $credit_transaction ->execute();

        $credit = $conn ->prepare("INSERT INTO transactions VALUES(NULL, :sa, :ra, :ta, :pb, :fb, :tt, :cid, NOW(), NOW())");
        $credit_data = array(
            ":sa" => $user['account_number'],
            ":ra" => $receivers_data['account_number'],
            ":ta"=> $amount,
            ":pb"=> $receivers_current_balance,
            ":fb" => $receivers_final_balance,
            ":tt" => "Credit",
            ":cid" => $receivers_data['customer_id']
        );
        $credit ->execute($credit_data);
        
        $senders_current_balance = $user['account_balance'];
        $senders_final_balance = $senders_current_balance - $amount;

        $debit_transaction = $conn ->prepare("UPDATE customer SET account_balance = :sab WHERE account_number = :san");
        $debit_transaction -> bindParam(":san", $user['account_number']);
        $debit_transaction ->bindParam(":sab", $senders_final_balance);
        $debit_transaction -> execute();

        $debit = $conn->prepare("INSERT INTO transactions VALUES(NULL, :sa, :ra, :ta, :pb, :fb, :tt, :cid, NOW(), NOW())");
        $debit_data = array(
            ":sa" => $user['account_number'],
            ":ra" => $receivers_data['account_number'],
            ":ta" => $amount,
            ":pb" => $senders_current_balance,
            ":fb" => $senders_final_balance,
            ":tt" => "Debit",
            ":cid" => $user['customer_id']
        );
        $debit ->execute($debit_data);
        $response['current_balance'] = "$senders_final_balance";
        $response['success'] = "Your transaction was successful";



    }else{
        foreach ($error as $value){
            $response['error'] = $value;
        }
    }
}
echo $res = json_encode($response);


// $statement = $conn -> prepare("SELECT customer_id FROM customer WHERE account_number = :an");
// $statement ->bindParam(":an", $_POST['account']);
// $statement -> execute();

// $row = $statement -> fetch(PDO::FETCH_ASSOC);
// $customer_id = $row;
?>