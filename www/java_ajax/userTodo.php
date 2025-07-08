 <?php

define ("DBNAME", "java_ajax");
define ("DBUSER", "root");
define ("DBPASS", "");

try{
    $conn = new PDO("mysql:host=localhost;dbname=".DBNAME, DBUSER, DBPASS);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e -> getMessage();
}

    $response = [];
try{
    $stmt = $conn ->prepare("SELECT * FROM todo_list WHERE user_id = :uid ORDER BY date");
    $stmt -> bindParam(":uid", $_POST['user_id']);
    $stmt -> execute();

    $result = [];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $result[] = $row;
    }

    $response['message'] = true;
    $response['data'] = $result;
}catch(Exception $e){
    $response['failed'] = "Something went wrong";
}

$res = json_encode($response);
echo $res;


?>