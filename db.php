<?php
    $pdo = new PDO("mysql:host=localhost;dbname=webdev;chaset=utf8","root","");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
