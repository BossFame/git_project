<?php
include "../database.php";

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$email = $data['email'];

$response = [];
$stmt = $conn->prepare("SELECT email FROM customer WHERE email = :em");
$stmt->bindParam(":em", $email);
$stmt->execute();

if ($stmt->rowCount() < 1) {
    $response['error'] = "This email does not exist in our database";
} else {
    $response['pass'] = true;
    $response['success'] = "A reset link has been sent to your email"; // You can later add mail() function here
}

echo json_encode($response);
?>
