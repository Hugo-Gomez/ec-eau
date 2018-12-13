<?php

try {
    $conn = new PDO('mysql:dbname=bpkv63f8h;host=bpkv63f8h-mysql.services.clever-cloud.com', 'u2f8geen9z3bboig', '6VY7wvq935hYveWADCm');
} catch (PDOException $exception) {
    die($exception->getMessage());
}

function errorHandler(PDOStatement $stmt)
{
    if ($stmt->errorCode() !== '00000') {
        var_dump($stmt->errorInfo());
        die();
    }
}