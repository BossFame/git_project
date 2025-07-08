<?php
session_start();
    //include "admin_authentication.php";
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
            <li id=""><a href="admin_transfer.php">Transfer</a></li>
            <li id=""><a href="admin_deposit.php">Deposit</a></li>
            <li id=""><a href="account_statement.php">Account Statement</a></li>
            <li id=""><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
</div>
   