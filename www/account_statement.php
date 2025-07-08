<?php
session_start();
include "database.php";
include "admin_authentication.php";
include "admin_auth.php";

    $transact = $conn -> prepare("SELECT * FROM transactions WHERE customer = :cid");
    $transact -> bindParam(":cid", $service);
    $transact -> execute();

    $transaction = array();
    while($row = $transact->fetch(PDO::FETCH_BOTH)){
        $transaction[] = $row;
    }
    ?>
    <link rel="stylesheet" href="style.css?v=2"/>
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

<p>Account Statement</p>
<?php
if(isset($_GET['success'])){
        echo "<p style='color:green'>".$_GET['message'] . "<br></p>";
    }
    ?>
<table border = '2'>
    <tr>
        <th>Transaction Date</th>
        <th>Transaction Time</th>
        <th>Bank Accounts</th>
        <th>Transaction Type</th>
        <th>Amount</th>
        <th>Previous Balance</th>
        <th>Current Balance</th>
    </tr>

    <?php foreach($transaction as $value): ?>
    <tr>
        <td><?=$value['date_created']?></td>
        <td><?=$value['time_created']?></td>
        <td><?=$value['receivers_account']?></td>
        <td><?=$value['transaction_type']?></td>
        <td><?=$value['transaction_amount']?></td>
        <td><?=$value['previous_balance']?></td>
        <td><?=$value['final_balance']?></td>
    </tr>
    <?php endforeach; ?>

</table>
   </div>