<?php
include "../additions/includes.php";

    if(isset($_POST['submit'])){
        $error = array();
        if(empty($_POST['category_name'])){
            $error['category_name'] = "Input Category Name";
        }
        if(empty($error)){
            
            $state = $conn -> prepare("INSERT INTO category VALUES(NULL, :cn, :cb, NOW(), NOW() )");
            $state -> bindParam(":cn", $_POST['category_name']);
            $state -> bindParam(":cb", $_SESSION['id']);
            $state -> execute();

            header("location:view_cat.php");
            exit();
        }else{
            echo "<p style='color:red'>"."Input Category"."</p>";
        }
    }
?>


<form action="" method="POST">
<br/>
<input type="text" name="category_name" placeholder="Category"/>
<br/>
<input type="submit" name="submit" value="Submit"/>
</form>


<table border="2">
    <tr>
        <th>S/N</th>
        <th>Admin Id</th>
        <th>Category</th>
        <th>Date</th>
        <th>Time</th>
    </tr>
    <?php
        $stmt = $conn -> prepare("SELECT * FROM category");
            $stmt -> execute();
        
        while($row = $stmt->fetch(PDO::FETCH_BOTH)){
            echo "<tr>";
                echo "<td>".$row['category_id']."</td>";
                echo "<td>".$row['created_by']."</td>";
                echo "<td>".$row['category_name']."</td>";
                echo "<td>".$row['date_created']."</td>";
                echo "<td>".$row['time_created']."</td>";
            echo "</tr>";
        }

    ?>
</table>

<p style="color:blue"><a href="createblog_admin.php">Back<a></p>


