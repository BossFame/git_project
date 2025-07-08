<?php
session_start();
include "../additions/db.php";
include "../additions/user_authentication.php";
include "../additions/check.php";
?>
<h1 style='color:green'>Lungu Hills</h1>
<?php 
echo  "Hi ".($_SESSION['name']);
?>
<p style='color:brown'>Welcome to Lungu Hills. What service would you like to Perform...</p>
<hr/>
<a href="dashboard.php">Home</a>
<a href="bank.php">Banking Service</a>
<a href="home.php">Read Blog</a>


