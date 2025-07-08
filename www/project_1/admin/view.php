<?php
session_start();
include "../additions/db.php";
include "../additions/authentication.php";
include "../additions/header.php";
?>
<!--<a href="type.php">Account_type</a>-->

<?php
$select = $conn -> prepare("SELECT * FROM customer");
$select -> execute();

while($row = $select->fetch(PDO::FETCH_BOTH)){
    $info[] = $row;
}
?>

<table border="2">
    <tr>
        <th>S/N</th>
        <th>Account Name</th>
        <th>Account Number</th>
        <th>Email</th>
        <th>Account Type</th>
        <th>Account Balance</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Date</th>
        <th>Time</th>
    </tr>

<?php foreach($info as $value): ?>
    <tr>
        <td><?=$value['customer_id']?></td>
        <td><?=$value['account_name']?></td>
        <td><?=$value['account_number']?></td>
        <td><?=$value['email']?></td>
        <td><?=$value['account_type']?></td>
        <td><?=$value['account_bal']?></td>
        <td><a href="edit.php?id=<?=$value['customer_id']?>">Edit</a></td>
        <td><a href="delete.php?id=<?=$value['customer_id']?>">Delete</a></td>
        <td><?=$value['date_created']?></td>
        <td><?=$value['time_created']?></td>
    </tr>

<?php endforeach; ?>

</table>