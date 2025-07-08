<?php
session_start();
include "../additions/db.php";
include "../additions/blog_header.php";

if(isset($_GET['id'])){
    $blog_id = $_GET['id'];
}else{
    header("location:view_blog");
}

$statement = $conn -> prepare("SELECT * FROM category");
$statement -> execute();
$select = array();
while($row=$statement->fetch(PDO::FETCH_BOTH)){
    $select[] = $row;
}

$stmt = $conn -> prepare("SELECT * FROM blog WHERE blog_id=:bid");
$stmt -> bindParam(":bid", $blog_id);
$stmt -> execute();

$fetch = $stmt ->fetch(PDO::FETCH_BOTH);
if($stmt ->rowCount() < 1){
    header("location:view_blog.php");
    exit();
}


if(isset($_POST['submit'])){
    $error = array();
    if(empty($_POST['title'])){
        $error[] = "Please Enter Title";
    }
    if(empty($_POST['author'])){
        $error[] = "Enter Author's name";
    }
    if(empty($_POST['read_time'])){
        $error[] = "Drop the Time Estimate";
    }
    if(empty($_POST['category'])){
        $error[] = "Specify Category";
    }
    if(empty($_POST['content'])){
        $error[] = "Write / Edit Content";
    }
    if(empty($error)){
        $stmt = $conn -> prepare("UPDATE blog SET title=:tt, author=:au, read_time=:rt, category =:cat, content=:cnt WHERE blog_id = :bid");
        $data = array(
            ":tt" => $_POST['title'],
            ":au" => $_POST['author'],
            ":rt" => $_POST['read_time'],
            ":cat" => $_POST['category'],
            ":cnt" => $_POST['content'],
            ":bid" => $blog_id,
        );
        $stmt ->execute($data);

        header("location:view_blog.php?message=Your Update was Succesful");
        exit();
    }
}
?>

<form action="" method="POST">
    <p>Title: <input type="text" name="title" placeholder="Title", value="<?=$fetch['title']?>"/></p>
    <p>Author: <input type="text" name="author" placeholder="Author" value="<?=$fetch['author']?>" required/></p>
    <p>Estimated Read Time: <input type="text" name="read_time" placeholder="Read Time" value="<?=$fetch['read_time']?>"required/></p>
    <p>Category:
         <select name='category'>
        <?php foreach($select as $value): ?>
            <option value="<?=$value['category_id']?>"><?=$value['category_name']?></option>
        <?php endforeach; ?>
        </select>
    </p>
    <p>Content: <textarea name="content"><?=$fetch['content']?></textarea></p>
    <input type="submit" name="submit" value="Update"/>
</form>