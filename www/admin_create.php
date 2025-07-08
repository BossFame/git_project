<?php
session_start();
    include "database.php";
    include "admin_authentication.php";

    if(isset($_POST['submit'])){
        $error = array();
        if(empty($_POST['account_name'])){
            $error['account_name'] = "Kindly input your Name ";
        }
        if(empty($_POST['email'])){
            $error['email'] = "Input valid Email";
        }
        if(empty($_POST['hash'])){
            $error['hash'] = "Input Password";
        }elseif(!is_numeric($_POST['hash'])){
            $error['hash'] = "Enter Numeric values only";
        }elseif(strlen($_POST['hash']) > 4){
            $error['hash'] = "You can only input 4 digits";
        }
        if(empty($_POST['account_type'])){      
            $error['account_type'] = "Select account Type";  
        }
        if(empty($_POST['account_balance'])){
            $error['account_balance'] = "Input account type";
        }elseif(!is_numeric($_POST['account_balance'])){
            $error['account_balance'] = "Enter Numeric values only";
        }

        if(empty($error)){

            $hash = password_hash($_POST['hash'], PASSWORD_BCRYPT);

            $account_num = "22".rand(10000000, 99999999);
            $stmt = $conn -> prepare("INSERT INTO customer VALUES(NULL, :an, :ano, :em, :hs, :at, :ab, NOW(), NOW())");
            $data = array(
                ":an" => $_POST['account_name'],
                ":ano" => $account_num,
                ":em" => $_POST['email'],
                ":hs" => $hash,
                ":at" => $_POST['account_type'],
                ":ab" => $_POST['account_balance']
            );
            $stmt -> execute($data);

            header("location:admin_view.php");
            exit();
        }else{
            foreach($error as $value){
                $err = $value;
            }
            }
    }

    
?>

<link rel="stylesheet" href="style.css"/>
<div id="container">
<h1 id='header' style="color:green" >WELCOME TO LUNGU HILLS</h1>
<p>Hi, <?php echo $_SESSION['name'] ?></p>
<p>Your ID is <?php echo $_SESSION['id'] ?></p>
<hr/>

<div id="first-panel">
        <ul id="panel">
            <li id=""><a href="admin_header.php">Dashboard</a></li>
            <li id=""><a href="admin_create.php">Create</a></li>
            <li id=""><a href="admin_view.php">View Registry</a></li>
            <li id=""><a href="admin_transfer.php">Transfer</a></li>
            <li id=""><a href="admin_deposit.php">Deposit</a></li>
            <li id=""><a href="account_statement.php">Account Statement</a></li>
            <li id=""><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
    <div id="">
    <form action="" method="POST">
       <?php if(isset($err)){
            echo "<p style='color:red'>".$err."</p>";
        } ?>
        <p>Account Name: <input type="text" name="account_name" placeholder="Account Name"/></p>
        <!-- <p>Account Number: <input type="text" name="account_number" placeholder="Account Number"/></p> -->
        <p>Email: <input type="email" name="email" placeholder="Email"/></p>
        <p>Pin: <input type="password" name="hash" placeholder="Password"/>
        <p>Account Type: 
        <select name="account_type">
            <option disabled selected >--Select Acc. Type--</option>
            <option value="Savings">Savings</option>
            <option value="Current">Current</option>
            <option value="Fixed">Fixed</option>
        </select>
                <!-- //     $stmt = $conn -> prepare("SELECT * FROM account_type");
                //     $stmt -> execute();
                // echo "<select name='account_type'>";
                //     while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                //         echo "<option value=".$row['account_type'].">".$row['account_type']."<option>";
                //     }
                // echo "</select>"; -->
        </p>
        <p>Account Balance: <input type="text" name="account_balance" placeholder="Account Balance" required/></p>
        <input type="submit" name="submit" value="Create Account"/>
    </form>
    </div>
</div>
   