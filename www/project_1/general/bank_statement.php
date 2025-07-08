<?php
session_start();
include "../additions/db.php";
include "../additions/bank_header.php";
include "../additions/check.php";

$dot = $conn -> prepare('SELECT * FROM transactions WHERE customer_id = :cid');
$dot -> bindParam(":cid", $user_data['customer_id']);
$dot -> execute();

$transact = array();
while($catch = $dot->fetch(PDO::FETCH_BOTH)){
    $transact[] = $catch;
}
?>
<table border='2px'>
    <tr>
        <th>Senders Account</th>
        <th>Receivers Account</th>
        <th>Transaction Amount</th>
        <th>Previous Balance</th>
        <th>Current Balance</th>
        <th>Transaction Type</th>
        <th>Date</th>
        <th>Time</th>
    </tr>
    <?php foreach($transact as $key): ?>
    <tr>
        <td><?=$key['senders_account']?></td>
        <td><?=$key['receivers_account']?></td>
        <td><?=$key['transaction_amount']?></td>
        <td><?=$key['previous_balance']?></td>
        <td><?=$key['final_balance']?></td>
        <td><?=$key['transaction_type']?></td>
        <td><?=$key['date_created']?></td>
        <td><?=$key['time_created']?></td>
    </tr>
    <?php endforeach; ?>
</table>