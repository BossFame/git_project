<?php
session_start();

include "../additions/db.php";
include "../additions/authentication.php";
include "../additions/header.php";

if(isset($_GET['id'])){
    $customer_id = $_GET['id'];
}else{
    header("location:view.php");
    exit();
}

$stmt = $conn -> prepare("SELECT * FROM account");
$stmt -> execute();

while($row=$stmt->fetch(PDO::FETCH_BOTH)){
    $select[] = $row;
}


$statement = $conn -> prepare("SELECT * FROM customer WHERE customer_id = :cid");
$statement -> bindParam(":cid", $customer_id);
$statement -> execute();

$update = $statement -> fetch(PDO::FETCH_BOTH);
if( $statement -> rowCount() < 1){
    header("location:view.php");
    exit();
}




if(array_key_exists('submit', $_POST)){
    $issue = array();
    if(empty($_POST['account_name'])){
        $issue[] = "Enter Name";
    }else{
        $account_name = $_POST['account_name'];
    }
    if(empty($_POST['account_type'])){
        $issue[] = "Select account Type";
    }else{ 
        $account_type = $_POST['account_type'];
    }
    if(empty($issue)){
        $statement = $conn -> prepare("UPDATE customer SET account_name= :an, account_type=:at WHERE customer_id = :cid");
        $statement -> bindParam(":an", $_POST['account_name']);
        $statement -> bindParam(":at", $_POST['account_type']);
        $statement -> bindParam(":cid", $customer_id);
        $statement -> execute();

        header("location:view.php?message=Account Updated Sucessfully");
        exit();
    }else{
        foreach ($issue as $val){
            echo "<p style='color:red'>".$val . "<br>" ."</p>";
        }
    }
}
?>

<form action="" method="POST">
    <p>Update Account Name: <input type="text" name="account_name" value="<?=$update['account_name']?>"/></p>
    <p>Change Account Type: 
    <select name="account_type">
        <?php foreach($select as $value):?>
            <option value="<?=$value['account_type']?>"><?=$value['account_type']?></option>
        <?php endforeach; ?>
        </select>
    <br/>
     </p>
    <input type="submit" name="submit" value="Update"/>
</form>