<?php
session_start();
include "database.php";
include "admin_authentication.php";

            $stmt = $conn -> prepare("SELECT * FROM customer WHERE email = :em");
            $stmt -> bindParam(":em", $_SESSION['email']);
            $stmt -> execute();

            $service = $stmt ->fetch(PDO::FETCH_BOTH);
            
            if($stmt -> rowCount() < 1){
                header("location:admin_transfer.php?Account does not exist in our database");
                exit();
            }


    ?>
    <link rel="stylesheet" type="text/css" href="style.css?v=2"/>
<div id="container">
<h1 id='header' style="color:green" >WELCOME TO LUNGU HILLS</h1>
<p>Hi, <?php echo $_SESSION['name'] ?></p>
<p>Your ID is <?php echo $_SESSION['id'] ?></p>
<hr/>

    <div id="first-panel">
        <ul id="panel">
            <li id=""><a href="admin_header.php">Dashboard</a></li>
            <li id=""><a href="admin_create.php">Create</a></li>
            <li id=""><a href="admin_transfer.php">Transfer</a></li>
            <li id=""><a href="admin_deposit.php">Deposit</a></li>
            <li id=""><a href="account_statement.php">Account Statement</a></li>
            <li id=""><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
    <div id="">
        <div id="act">
        <p>Account Name: <?=$service['account_name']?></p>
        <p>Account Number: <?=$service['account_number']?></p>

        <?php
            // $tab = $conn ->prepare("SELECT final_balance FROM transactions WHERE customer = :acn ORDER BY time_created DESC LIMIT 1");
            // $tab -> bindParam(":acn", $customerId['customer_id']);
            // $tab -> execute();

            // $last = $tab ->fetch(PDO::FETCH_ASSOC);
            // if($tab -> rowCount() < 1){
            //     echo 'An error Occured';
            //     //header("Location:admin_transfer.php?error=No transaction yet");
            //     exit();
            // }else{
            //     echo "<p>Account Balance:" . $last['final_balance']. "</p>";
            // }
        ?>
        
        </div>
<?php

    //$post = array_map('TRIM', $_POST);
    if(array_key_exists('transfer', $_POST)){
        $error = array();
        if(empty($_POST['account_number'])){
            $error['account_number'] = "Enter Valid Account Number";
        }elseif(!is_numeric($_POST['account_number'])){
            $error['account_number'] = "Input account number correct format";
        }
        if(empty($_POST['amount'])){
            $error['amount'] = "Input Amount";
        }elseif(!is_numeric($_POST['amount'])){
            $error['amount'] = "Amount must be entered in numeric Values only";
        }
        if(empty($error)){
            //$post = array_map('TRIM', $_POST);
            if($_POST['amount'] > $service['account_balance']){
                header("Location:admin_transfer.php?error=Insufficient balance");
                exit();
            }
            
            $stmt = $conn -> prepare("SELECT * FROM customer WHERE account_number =:an");
            $stmt -> bindParam(":an", $_POST['account_number']);
            $stmt -> execute();

                if($stmt -> rowCount() < 1){
                    header("location:admin_transfer.php?error=Account does not exist...");
                    exit();
                }
                $beneficiary_record = $stmt ->fetch(PDO::FETCH_BOTH);

                if($beneficiary_record['account_number'] == $service['account_number']){
                    header("Location:admin_transfer.php?error=You cannot transfer funds to yourself");
                    exit();
                }

                $sender_current_balance = $service['account_balance'];
                $sender_closing_balance = $service['account_balance'] - $_POST['amount'];

                $debit = $conn -> prepare('UPDATE customer SET account_balance = :ab WHERE account_number = :an');
                $debit -> bindParam(":ab", $sender_closing_balance);
                $debit -> bindParam(":an", $user_data['account_number']);
                $debit -> execute();

                $debit_transaction = $conn -> prepare("INSERT INTO transactions VALUES(NULL, :sa, :ra, :ta, :pb, :fb, :tt, :cid, NOW(), NOW())");
                $data = array(
                    ":sa" => $service['account_number'],
                    ":ra" => $beneficiary_record['account_number'],
                    ":ta" => $_POST['amount'],
                    ":pb" => $sender_current_balance,
                    ":fb" => $sender_closing_balance,
                    ":tt" => "debit",
                    ":cid" => $service['customer_id']
                );
                $debit_transaction -> execute($data);

                $beneficiary_current_balance = $beneficiary_record['account_balance'];
                $beneficiary_closing_balance = $beneficiary_record['account_balance'] + $_POST['amount'];

                $credit = $conn ->prepare("UPDATE customer SET account_balance = :ab WHERE account_number = :ban");
                $credit ->bindParam(":ab", $beneficiary_closing_balance);
                $credit ->bindParam(":ban", $beneficiary_record['account_number']);

                try{
                $credit_transaction = $conn -> prepare("INSERT INTO transactions VALUES(NULL, :sa, :ra, :ta, :pb, :fb, :tt, :cid, NOW(), NOW())");
                $credit_data = array(
                    ":sa" => $service['account_number'],
                    ":ra" => $beneficiary_record['account_number'],
                    ":ta" => $_POST['amount'],
                    ":pb" => $beneficiary_current_balance,
                    ":fb" => $beneficiary_closing_balance,
                    ":tt" => "credit",
                    ":cid" => $beneficiary_record['customer_id']
                );
                $credit_transaction -> execute($credit_data);
                }catch(Exception $e){
                    die($e -> getMessage());
                }
                header("Location:account_statement.php?message=Your Transaction was succesful");
                exit();



            }else{
            foreach ($error as $value){
                echo "<p style='color:red'>". $value ."</p>";
            }
        }
    }
    if(isset($_GET['error'])){
        echo "<p style='color:red'>".$_GET['error'] . "<br></p>";
    }
?>
            <div id="">
            <form method="POST">
            <p>Account Number: <input type="text" name="account_number"/></p>
            <p>Amount: <input type="text" name="amount"/></p>
            <p>Purpose: <textarea placeholder="Optional"></textarea></p>
            <input type="submit" name="transfer" value="Transfer"/>
            </form>
            </div>
    </div>
</div>
   