<?php

session_start();
include "../additions/db.php";
include "../additions/check.php";
include "../additions/blog_head.php";
include "../additions/blog_class.php";

$state = $conn -> prepare("SELECT * FROM blog");
$state -> execute();

$read = array();

while($row = $state -> fetch(PDO::FETCH_BOTH)){
    $read[] = $row;
}
?>


<?php foreach($read as $key): ?>
    <br/>
    <br/>
    <a href="view_blog.php?id=<?=$key['blog_id']?>"><?=$key['title']?> by <?=$key['author']?></a>
<?php endforeach; ?>
