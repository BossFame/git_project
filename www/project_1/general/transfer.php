<?php
session_start();
include '../additions/db.php';
include '../additions/bank_header.php';
include '../additions/check.php';

if(isset($_POST['submit'])){
    $error = array();
    if(empty($_POST['account_number'])){
        $error['account_number'] = "Please input Account Number";
    }elseif(!is_numeric($_POST['account_number'])){
        $error['account_number'] = "Kindly input numeric Values";
    }
    if(empty($_POST['amount'])){
        $error['amount'] = "Kindly Specify Amount";
    }elseif(!is_numeric($_POST['amount'])){
        $error['amount'] = "Kindly input numeric Values";
    }
    if(empty($error)){

        $post = array_map('TRIM', $_POST);
        if($_POST['amount'] > $user_data['account_bal']){
            header("location:transfer.php?error1=Insufficient Balance");
        exit();
        }

        $statement = $conn -> prepare("SELECT * FROM customer WHERE account_number=:an");
        $statement -> bindParam(":an", $_POST['account_number']);
        $statement -> execute();
    
    
        if($statement ->rowCount() < 1){
            header("location:transfer?error=Account does not exist");
        }

        $beneficiary_record= $statement ->fetch(PDO::FETCH_BOTH);

        if($beneficiary_record['account_number'] == $user_data['account_number']){
            header("location:transfer.php?error=You cannot send funds to yourself");
            exit();
        }
    
        $senders_current_bal = $user_data['account_bal'];
        $senders_closing_bal = $senders_current_bal - $_POST['amount'];

        $debit = $conn -> prepare("UPDATE customer SET account_bal= :ab WHERE account_number = :cua");
        $debit -> bindParam(":ab", $senders_closing_bal);
        $debit -> bindParam(":cua", $user_data['account_number']);
        $debit -> execute();

        $debit_transaction = $conn -> prepare("INSERT INTO transactions VALUES(NULL, :sa, :ra, :ta, :pb, :fb, :tt, :cn, NOW(), NOW())");
        $data = array(
            ":sa" => $user_data['account_number'],
            ":ra" => $beneficiary_record['account_number'],
            ":ta" => $_POST['amount'],
            ":pb" => $senders_current_bal,
            ":fb" => $senders_closing_bal,
            ":tt" => "Debit",
            ":cn" => $user_data['customer_id']
        );
        $debit_transaction -> execute($data);

        $beneficiary_current_bal = $beneficiary_record['account_bal'];
        $beneficiary_closing_bal = $beneficiary_record['account_bal'] + $_POST['amount'];

        $credit = $conn -> prepare ("UPDATE customer SET account_bal = :ab WHERE account_number = :ban");
        $credit -> bindParam(":ab", $beneficiary_closing_bal);
        $credit -> bindParam(":ban", $beneficiary_record['account_number']);
        $credit -> execute();

        try{
        $credit_transaction = $conn -> prepare("INSERT INTO transactions VALUES(NULL, :sa, :ra, :ta, :pb, :fb, :tt, :cn, NOW(), NOW())");
        $credit_data = array(
            ":sa" => $user_data['account_number'],
            ":ra" => $beneficiary_record['account_number'],
            ":ta" => $_POST['amount'],
            ":pb" => $beneficiary_current_bal,
            ":fb" => $beneficiary_closing_bal,
            ":tt" => "Credit",
            ":cn" => $beneficiary_record['customer_id']
        );
            $credit_transaction -> execute($credit_data);
        }catch(Exception $e){
           die($e -> getMessage());
        }
        header("location:transfer.php?sucess=Your Transfer was successful");
        exit();
    }
}

if(isset($_GET['sucess'])){
    echo "<p style='color:green'>". $_GET['sucess']."</p>";
}s
if(isset($_GET['error'])){
    echo "<p style='color:red'>". $_GET['error']."</p>";
}
if(isset($_GET['error1'])){
    echo "<p style='color:red'>". $_GET['error1']."</p>";
}
if(isset($_GET['message'])){
    echo "<p style='color:red'>". $_GET['message']."</p>";
}
if(isset($error['amount'])){
    echo "<p style='color:red'>". $error['amount']."</p>";
}
if(isset($error['account_number'])){
    echo "<p style='color:red'>". $error['account_number']."</p>";
}
?>
<form action="" method="POST">
    <br/>
    <input type='text' name='account_number' placeholder='Account Number'/>
    <br/>
    <input type='text' name='amount' placeholder='Amount'/>
    <br/>
    <input type='submit' name='submit' value="Transfer"/>
</form>