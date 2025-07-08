<?php
    session_start();
    
    unset ($_SESSION['id']);
    unset ($_SESSION['name']);
    session_destroy();

    // header("Location:admin_signin.html");
    // exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        localStorage.removeItem('mq==');
        sessionStorage.clear();
        window.location.href = "admin_signin.html";
    </script>
</head>
<body>
    
</body>
</html>