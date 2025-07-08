<h1 style='color:green'>Lungu Hills</h1>
<?php 
echo "<p style='color:black'>". "Hi ".($_SESSION['name'])."</p>"
?>
<p style='color:brown'>Welcome to Lungu Hills. What service would you like to Perform...</p>
<?php
include "../additions/bank_authentication.php";
?>
<hr/>
<a href="dashboard.php">Home</a>
<a href="bank.php">Dashboard</a>
<a href="transfer.php">Transfer</a>
<a href= "bank_statement.php">Account Statement</a>
<a href="bank_logout.php">Logout</a>