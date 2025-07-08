<?php 
            $stmt = $conn -> prepare("SELECT * FROM customer WHERE email = :em");
            $stmt -> bindParam(":em", $_SESSION['email']);
            $stmt -> execute();
            
            if($stmt -> rowCount() < 1){
                header("location:admin_transfer.php?This account does not exist in our database");
            }
            $user_data = $stmt-> fetch(PDO::FETCH_BOTH);

            $service = $user_data['customer_id']
?>            


   