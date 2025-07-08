<?php
session_start();
include "../additions/db.php";
include "../additions/authentication.php";
include "../additions/blog_header.php";

if(isset($_GET['message'])){
    echo "<p style='color:green'>".$_GET['message']."</p>";
}

$stmt = $conn -> prepare("SELECT * FROM blog");
$stmt -> execute();

while($record=$stmt->fetch(PDO::FETCH_BOTH)){
    $ease []= $record;
}
?>



<table border = "2">
    <tr>
        <th>S/N</th>
        <th>Title</th>
        <th>Author</th>
        <th>Estimated Read Time</th>
        <th>Category</th>
        <th>Content</th>
        <th>Edit</th>
        <th>Delete</th>
        <th>Date</th>
        <th>Time<th>
    </tr>

    <?php foreach($ease as $up): ?>
        <tr>
            <td><?=$up['blog_id']?></td>
            <td><?=$up['title']?></td>
            <td><?=$up['author']?></td>
            <td><?=$up['read_time']?></td>
            <td><?=$up['category']?></td>
            <td><?=$up['content']?></td>
            <td><a href="edit_blog.php?id=<?=$up['blog_id']?>">Edit</a></td>
            <td><a href="delete_blog.php?id=<?=$up['blog_id']?>">Delete</a></td>
            <td><?=$up['time_created']?></td>
            <td><?=$up['time_created']?></td>
        </tr>

    <?php endforeach; ?>

</table>