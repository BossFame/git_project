<?php
include "database.php";

echo "<h1 style='color:green'>Welcome to Lungu Hills</h1>";

if(array_key_exists('submit', $_POST)){
    $error = [];
    if(empty($_POST['account_type'])){
        $error['account_type'] = "Please Input account type";
    }
    if(empty($error)){
        $stmt = $conn -> prepare("INSERT INTO account_type VALUES(NULL, :at, NOW(), NOW())");
        $stmt -> bindParam(":at", $_POST['account_type']);
        $stmt -> execute();


        $state = $conn -> prepare("SELECT * FROM account_type");
        $state -> execute();
        
        while($record = $state->fetch(PDO::FETCH_BOTH)){
            $type[] = $record;
        }
    }else{
        echo "<p style='color:red'>" .($error['account_type'])."</p>";
    }
}
    

?>

<form action="" method="POST">
    <input type="text" name="account_type" placeholder="Account type" />
    <br>
    <input type="submit" name="submit" value="Submit"/>
</form>

<table border='2'>
    <tr>
        <th>S/N</th>
        <th>Account Type</th>
        <th>Date</th>
        <th>Time</th>
    </tr>

    <?php foreach($type as $value): ?>
        <tr>
            <td><?=$value['account_id']?></td>
            <td><?=$value['account_type']?></td>
            <td><?=$value['date_created']?></td>
            <td><?=$value['time_created']?></td>
        </tr>

    <?php endforeach; ?>

</table>