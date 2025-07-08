<?php
session_start();
include "database.php";
include "admin_authentication.php";

    $stmt = $conn -> prepare("SELECT * FROM customer");
    $stmt -> execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $info[] = $row;
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
            <li><a href="admin_view.php">View Registry</a></li>
            <li id=""><a href="admin_transfer.php">Transfer</a></li>
            <li id=""><a href="admin_deposit.php">Deposit</a></li>
            <li id=""><a href="account_statement.php">Account Statement</a></li>
            <li id=""><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
    <table border='2'>
        <tr>
            <th>Account Name</th>
            <th>Account Number</th>
            <th>Account type</th>
            <th>Account Balance</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Date_Created</th>
            <th>Time_Created</th>
        </tr>

        <?php foreach($info as $value): ?>
        <tr>
            <td><?=$value['account_name']?></td>
            <td><?=$value['account_number']?></td>
            <td><?=$value['account_type']?></td>
            <td><?=$value['account_balance']?></td>
            <td>Edit</td>
            <td>Delete</td>
            <td><?=$value['date_created']?></td>
            <td><?=$value['time_created']?></td>

        </tr>
        <?php endforeach; ?>
    </table>
</div>
   
