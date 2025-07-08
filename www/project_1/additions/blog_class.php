<?php
   //"../additions/db.php";

    $category = $conn -> prepare("SELECT * FROM category");
    $category -> execute();

    $category_records= array();

    while($row = $category->fetch(PDO::FETCH_BOTH)){
        $category_records[]= $row;
    }
?>
<a href="dashboard.php">Home</a>
<a href="home.php">Dashboard</a>
<?php foreach($category_records as $value): ?>

    <a href="blog_category.php?category_id=<?=$value['category_id']?>"><?=$value['category_name']?></a>
<?php endforeach; ?>
<a href="bank_logout.php">Logout</a>
<br/>
