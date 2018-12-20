<?php
require_once('functions/connection.php');
session_start();
$sql="SELECT 
    `mail`
FROM 
    `result`
;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':mail', $_SESSION['mail']);
$stmt->execute();
errorHandler($stmt);
$res=null;
while(false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)){
$res[]=$row;
}  

foreach($res as $in){
    if($res['mail'] == $_POST['email']){
        $_SESSION["mail"] = $_POST["email"];
        header('location:/valid_form.php');
    }else{
        header('location:/index.php');
    }
}
