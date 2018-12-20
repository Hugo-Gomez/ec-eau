<?php
require_once('connection.php');
session_start();
$sql="SELECT 
    `mail`
FROM 
    `result`
;";
$stmt = $conn->prepare($sql);
$stmt->execute();
errorHandler($stmt);
$res=null;
while(false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)){
$res[]=$row;
}  

foreach($res as $in){
    
    //var_dump($_SESSION["mail"]);
    //var_dump($_POST["email"]);
    if($in["mail"] == $_POST['email']){
        $_SESSION["mail"] = $_POST["email"];
        header('location:/valid_form.php');
        break;
    }else{
        header('location:/index.php');
    }
}
