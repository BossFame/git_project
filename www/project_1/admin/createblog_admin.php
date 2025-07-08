<?php
    session_start();
    include "../additions/db.php";
    include "../additions/authentication.php";
    include "../additions/blog_header.php";

    $stmt = $conn -> prepare('SELECT * FROM category');
    $stmt -> execute();

    if(isset($_POST['submit'])){
        $error = array();
        if(empty($_POST['title'])){
            $error[] = "Input Blog Title";
        }
        if(empty($_POST['author'])){
            $error[] = "Input Author's name";
        }
        if(empty($_POST['read_time'])){
            $error[] = "Input read time";
        }
        if(empty($_POST['category'])){
            $error[] = "Select Category";
        }
        if(empty($_POST['content'])){
            $error[] = "Write Content";
        }
       
        if(empty($error)){
            $stem = $conn -> prepare("INSERT INTO blog VALUES(NULL, :tt, :au, :rt, :cat, :cnt, NOW(), NOW())");
            $data = array(
                ":tt" => $_POST['title'],
                ":au" => $_POST['author'],
                ":rt" => $_POST['read_time'],
                ":cat" => $_POST['category'],
                ":cnt" => $_POST['content']
            );
            $stem -> execute($data);

            header("location:view_blog.php");
        }else{
            foreach($error as $value){
                echo "<p style='color:red'>".$value . "<br>" ."</p>";
            }
        }
    }
?>


<form action="" method="POST">
    <p>Title: <input type="text" name="title" placeholder="Title"/></p>
    <p>Author: <input type="text" name="author" placeholder="Author Name"/></p>
    <p>Estimated Read time: <input type="text" name="read_time" required/></p>
    <p>Select Category: 
        <?php
        echo "<select name='category'>";
        while($row = $stmt ->fetch(PDO::FETCH_BOTH)){
            echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
        }

        echo "</select>";
        ?>
    </p>
    <p>Content: <textarea name="content"> </textarea></p>
    <input type="submit" name="submit" value="Publish"/>
</form>

<p>To add to the existing categories <a href="view_cat.php">Click here</a></p>