<?php
session_start();
include "../additions/db.php";
include "../additions/check.php";
include "../additions/blog_head1.php";

$blog_type = $conn -> prepare("SELECT * FROM blog WHERE blog_id = :bid");
$blog_type ->bindParam(":bid", $_GET['id']);
$blog_type -> execute();

$single = $blog_type->fetch(PDO::FETCH_BOTH);


?>
<style>
    .center{
        text-align: center;
        color:purple;
    }
</style>

<body style="background:#f2f2f2">
<h2 style="text-align: center"><?=$single['title']?></h2>
<p style="text-align: center"><?=$single['author']?></p>
<p class="center">Posted on:<?=$single['date_created']?></p>
<hr/>
<p><?=$single['content']?></p>
</body>
