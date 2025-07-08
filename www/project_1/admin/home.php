<?php
session_start();
include "../additions/db.php";

?>
<h1 style='color:green'>Lungu Hills</h1>
<p> Hi <?=ucwords($_SESSION['name'])?> </p>
<p style="color:brown"> Welcome to Lungu Hills. What would you like to do <p>
<hr/>

<a href="bank_admin.php">Banking Service</a>
<a href="createblog_admin.php">Create Blog</a>
<a href=''>Read Blog</a>