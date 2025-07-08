<?php
session_start();
include "../additions/db.php";
include "../additions/check.php";


$category = $conn -> prepare("SELECT * FROM blog WHERE category=:cid");
$category -> bindParam(":cid", $_GET['category_id']);
$category -> execute();

$blog_record = array();

while($category_row = $category -> fetch(PDO::FETCH_BOTH)){
    $blog_record[] = $category_row;
}


include "../additions/blog_head1.php";
?>

<?php foreach($blog_record as $value): ?>
    <a href="view_blog.php?id=<?=$value['blog_id']?>"><p><?= $value['title']?></p></a>
<?php endforeach; ?>