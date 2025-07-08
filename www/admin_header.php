<?php
    session_start();
    include "database.php";
    if(isset($_COOKIE['user_id'])){
        $user_id= $_COOKIE['user_id'];
    }
    $state = $conn -> prepare("SELECT * FROM admin_login WHERE id = :uid");
    $state ->bindParam(":uid", $user_id);
    $state -> execute();


    $row = $state->fetch(PDO::FETCH_ASSOC);
    if($state -> rowCount() > 0){
        $_SESSION['name'] = $row['name'];
        $_SESSION['id']= $row['id'];
        $_SESSION['email'] = $row['email'];
        
    }else{
        header("location:admin_signin.html");
        exit();
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
            <li id=""><a href="admin_dashboard.html">Home</a></li>
            <li id=""><a href="admin_create.php">Create</a></li>
            <li id=""><a href="admin_transfer.php">Transfer</a></li>
            <li id=""><a href="admin_deposit.php">Deposit</a></li>
            <li id=""><a href="account_statement.php">Account Statement</a></li>
            <li id=""><a href="admin_logout.php">Logout</a></li>
        </ul>
    </div>
</div>
